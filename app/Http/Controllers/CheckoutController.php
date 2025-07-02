<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use Midtrans\Snap;
use Midtrans\Config as MidtransConfig;

class CheckoutController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Keranjang kosong!');
        }
        $total = collect($cart)->reduce(function($carry, $item) {
            return $carry + ($item['harga'] * $item['qty']);
        }, 0);
        return view('checkout.index', compact('cart', 'total'));
    }

    public function store(Request $request)
    {
        \Log::info('Checkout store called', [
            'user' => auth()->user() ? auth()->user()->toArray() : null,
            'cart' => session()->get('cart', []),
            'request' => $request->all()
        ]);
        $cart = session()->get('cart', []);
        if (empty($cart)) {
            \Log::warning('Cart kosong saat checkout', ['user' => auth()->user() ? auth()->user()->toArray() : null]);
            return redirect()->route('cart.index')->with('error', 'Keranjang kosong!');
        }
        $total = collect($cart)->reduce(function($carry, $item) {
            return $carry + ($item['harga'] * $item['qty']);
        }, 0);
        $request->validate([
            'nama_pemesan' => 'required',
            'alamat' => 'required',
        ]);
        \Log::info('Checkout validation passed');
        $order = Order::create([
            'nama_pemesan' => $request->nama_pemesan,
            'alamat' => $request->alamat,
            'total_harga' => $total,
            'status' => 'pending',
            'items' => json_encode($cart),
            'tracking_number' => 'TRK' . strtoupper(uniqid()),
            'estimated_delivery' => now()->addMinutes(45),
            'payment_method' => 'midtrans',
            'payment_status' => 'unpaid',
        ]);
        \Log::info('Order created', ['order_id' => $order->id]);
        session()->forget('cart');
        // Redirect ke pembayaran Midtrans
        return redirect()->route('checkout.pay', ['order_id' => $order->id]);
    }

    public function payWithMidtrans(Request $request)
    {
        $order = Order::find($request->order_id);
        if (!$order) {
            abort(404, 'Order tidak ditemukan');
        }
        $params = [
            'transaction_details' => [
                'order_id' => 'ORDER-' . $order->id,
                'gross_amount' => $order->total_harga,
            ],
            'customer_details' => [
                'first_name' => $order->nama_pemesan,
                'email' => auth()->user()->email ?? 'guest@example.com',
            ],
        ];
        $snapToken = Snap::getSnapToken($params);
        return view('checkout.midtrans', compact('snapToken'));
    }
}
