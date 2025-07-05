<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;

class OrderController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        if ($user) {
            $orders = Order::where('user_id', $user->id)->orderBy('created_at', 'desc')->get();
        } else {
            $orders = collect();
        }
        return view('orders.index', compact('orders'));
    }

    public function confirmPayment($id)
    {
        // Hanya admin yang bisa konfirmasi pembayaran
        if (!auth()->check() || auth()->user()->role !== 'admin') {
            return redirect()->back()->with('error', 'Akses ditolak!');
        }

        $order = Order::findOrFail($id);
        if ($order->payment_status === 'unpaid' && $order->status === 'menunggu pembayaran') {
            $order->payment_status = 'paid';
            $order->status = 'siap antar';
            $order->confirmed_at = now();
            $order->save();
            return redirect()->back()->with('success', 'Pembayaran berhasil dikonfirmasi!');
        }
        return redirect()->back()->with('error', 'Pesanan tidak valid untuk konfirmasi pembayaran.');
    }

    public function dashboardKurir()
    {
        if (!auth()->check() || auth()->user()->role !== 'kurir') {
            return redirect('/login')->with('error', 'Akses hanya untuk kurir!');
        }
        
        // Pesanan yang siap diantar (sudah dibayar)
        $activeOrders = Order::where('status', 'siap antar')
                            ->where('payment_status', 'paid')
                            ->orderBy('created_at', 'desc')
                            ->get();
        
        // Pesanan yang sedang dalam pengiriman
        $deliveringOrders = Order::where('status', 'dalam pengiriman')
                                ->orderBy('created_at', 'desc')
                                ->get();
        
        // Pesanan yang sudah selesai
        $finishedOrders = Order::where('status', 'selesai')
                              ->orderBy('created_at', 'desc')
                              ->get();
        
        return view('kurir.dashboard', compact('activeOrders', 'deliveringOrders', 'finishedOrders'));
    }

    public function updateStatusKurir(Request $request, $id)
    {
        if (!auth()->check() || auth()->user()->role !== 'kurir') {
            return redirect('/login')->with('error', 'Akses hanya untuk kurir!');
        }
        
        $order = Order::findOrFail($id);
        $status = $request->input('status');
        
        // Ambil pesanan yang siap antar
        if ($status === 'ambil' && $order->status === 'siap antar' && $order->payment_status === 'paid') {
            $order->status = 'dalam pengiriman';
            $order->save();
            return back()->with('success', 'Pesanan berhasil diambil!');
        }
        
        // Selesaikan pengiriman
        if ($status === 'selesai' && $order->status === 'dalam pengiriman') {
            $order->status = 'selesai';
            $order->delivered_at = now();
            $order->save();
            return back()->with('success', 'Pesanan berhasil diselesaikan!');
        }
        
        return back()->with('error', 'Aksi tidak valid untuk pesanan ini.');
    }

    public function destroy($id)
    {
        $order = Order::findOrFail($id);
        $user = auth()->user();
        // Hanya user yang punya pesanan & status belum bayar yang bisa hapus
        if ($order->user_id == $user->id && ($order->status == 'menunggu pembayaran' || $order->payment_status == 'unpaid')) {
            $order->delete();
            return redirect()->route('orders.index')->with('success', 'Pesanan berhasil dihapus.');
        }
        return redirect()->route('orders.index')->with('error', 'Pesanan tidak bisa dihapus.');
    }

    public function update(Request $request, $id)
    {
        $order = Order::findOrFail($id);
        $user = auth()->user();
        if ($order->user_id == $user->id && ($order->status == 'menunggu pembayaran' || $order->payment_status == 'unpaid')) {
            $request->validate([
                'qty' => 'required|integer|min:1',
                'alamat' => 'required|string|max:255',
            ]);
            $qty = $request->qty;
            $order->alamat = $request->alamat;

            // Update qty di kolom orders jika ada
            if (isset($order->qty)) {
                $order->qty = $qty;
            }

            // Update qty di items dan total_harga
            $items = is_array($order->items) ? $order->items : json_decode($order->items, true);
            if (is_array($items) && isset($items[0])) {
                $items[0]['qty'] = $qty;
                $order->items = json_encode($items);
                // Update total_harga
                $order->total_harga = $items[0]['harga'] * $qty;
            }
            $order->save();
            return redirect()->route('orders.index')->with('success', 'Pesanan berhasil diupdate.');
        }
        return redirect()->route('orders.index')->with('error', 'Pesanan tidak bisa diedit.');
    }

    public function uploadBuktiTransfer(Request $request, $id)
    {
        $order = \App\Models\Order::findOrFail($id);
        $user = auth()->user();
        if ($order->user_id != $user->id || $order->payment_method != 'transfer') {
            return back()->with('error', 'Akses tidak diizinkan.');
        }
        $request->validate([
            'bukti_transfer' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ]);
        $path = $request->file('bukti_transfer')->store('bukti_transfer', 'public');
        $order->bukti_transfer = $path;
        $order->save();
        return back()->with('success', 'Bukti transfer berhasil diupload!');
    }
}
