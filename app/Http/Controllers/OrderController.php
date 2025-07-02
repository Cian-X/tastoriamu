<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;

class OrderController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        if ($user && $user->role === 'admin') {
            $orders = Order::orderBy('created_at', 'desc')->get();
        } else if ($user) {
            $orders = Order::where('user_id', $user->id)->orderBy('created_at', 'desc')->get();
        } else {
            $orders = collect();
        }
        return view('orders.index', compact('orders'));
    }

    public function confirmPayment($id)
    {
        $order = Order::findOrFail($id);
        if ($order->payment_status === 'unpaid') {
            $order->payment_status = 'paid';
            $order->status = 'siap antar';
            $order->save();
        }
        return redirect()->route('orders.index')->with('success', 'Pembayaran berhasil dikonfirmasi!');
    }

    public function dashboardKurir()
    {
        if (!auth()->check() || auth()->user()->role !== 'kurir') {
            return redirect('/login')->with('error', 'Akses hanya untuk kurir!');
        }
        $activeOrders = Order::where(function($q){
            $q->where('status', 'dikonfirmasi')->where('payment_status', 'paid')
              ->orWhere('status', 'dalam pengiriman');
        })->orderBy('created_at', 'desc')->get();
        $finishedOrders = Order::where('status', 'selesai')->orderBy('created_at', 'desc')->get();
        return view('kurir.dashboard', compact('activeOrders', 'finishedOrders'));
    }

    public function updateStatusKurir(Request $request, $id)
    {
        if (!auth()->check() || auth()->user()->role !== 'kurir') {
            return redirect('/login')->with('error', 'Akses hanya untuk kurir!');
        }
        $order = Order::findOrFail($id);
        $status = $request->input('status');
        // Hanya bisa ambil pesanan yang sudah dikonfirmasi/lunas
        if ($status === 'dalam perjalanan' && $order->status === 'dikonfirmasi' && $order->payment_status === 'paid') {
            $order->status = 'dalam pengiriman';
            $order->save();
            return back()->with('success', 'Pesanan berhasil diambil!');
        }
        // Hanya bisa selesai jika status dalam pengiriman
        if ($status === 'selesai' && $order->status === 'dalam pengiriman') {
            $order->status = 'selesai';
            $order->delivered_at = now();
            $order->save();
            return back()->with('success', 'Pesanan berhasil diselesaikan!');
        }
        return back()->with('error', 'Aksi tidak valid untuk pesanan ini.');
    }
}
