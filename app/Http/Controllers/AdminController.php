<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Food;
use App\Models\Review;
use App\Models\User;

class AdminController extends Controller
{
    public function dashboard()
    {
        $totalOrders = Order::count();
        $totalRevenue = Order::where('payment_status', 'paid')->sum('total_harga');
        $totalFoods = Food::count();
        $totalReviews = Review::count();
        $totalUsers = User::count();
        
        $recentOrders = Order::with('user')->orderBy('created_at', 'desc')->take(5)->get();
        $topFoods = Food::withCount('reviews')->orderBy('reviews_count', 'desc')->take(5)->get();
        $users = User::orderBy('created_at', 'desc')->get();
        $foods = Food::orderBy('created_at', 'desc')->get();
        $orders = Order::with('user')->orderBy('created_at', 'desc')->get();
        return view('admin.dashboard', compact(
            'totalOrders', 'totalRevenue', 'totalFoods', 'totalReviews', 'totalUsers',
            'recentOrders', 'topFoods', 'users', 'foods', 'orders'
        ));
    }

    public function users()
    {
        $users = User::orderBy('created_at', 'desc')->get();
        return view('admin.users.index', compact('users'));
    }

    public function createUser()
    {
        return view('admin.users.create');
    }

    public function storeUser(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|in:admin,user,kurir'
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role' => $request->role
        ]);

        return redirect()->route('admin.users')->with('success', 'User berhasil ditambahkan!');
    }

    public function editUser($id)
    {
        $user = User::findOrFail($id);
        return view('admin.users.edit', compact('user'));
    }

    public function updateUser(Request $request, $id)
    {
        $user = User::findOrFail($id);
        
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $id,
            'password' => 'nullable|string|min:8|confirmed',
            'role' => 'required|in:admin,user,kurir'
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role
        ]);

        if ($request->password) {
            $user->update(['password' => bcrypt($request->password)]);
        }

        return redirect()->route('admin.users')->with('success', 'User berhasil diupdate!');
    }

    public function deleteUser($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        
        return redirect()->route('admin.users')->with('success', 'User berhasil dihapus!');
    }

    public function confirmPaymentCash($orderId)
    {
        $order = Order::findOrFail($orderId);
        if ($order->payment_method === 'cash' && $order->status === 'menunggu pembayaran') {
            $order->status = 'siap antar';
            $order->payment_status = 'paid';
            $order->confirmed_at = now();
            $order->save();
            return redirect()->route('admin.dashboard')->with('success', 'Pembayaran cash berhasil dikonfirmasi!');
        }
        return redirect()->route('admin.dashboard')->with('error', 'Pesanan tidak valid untuk konfirmasi pembayaran.');
    }

    public function orders()
    {
        $orders = Order::with('user')->orderBy('created_at', 'desc')->get();
        return view('admin.orders.index', compact('orders'));
    }
}
