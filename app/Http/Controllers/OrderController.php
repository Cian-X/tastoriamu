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
            $orders = Order::where('nama_pemesan', $user->name)->orderBy('created_at', 'desc')->get();
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
        $activeOrders = Order::whereIn('status', ['siap antar', 'dalam perjalanan'])->orderBy('created_at', 'desc')->get();
        $finishedOrders = Order::where('status', 'selesai')->orderBy('created_at', 'desc')->get();
        return view('kurir.dashboard', compact('activeOrders', 'finishedOrders'));
    }
}
