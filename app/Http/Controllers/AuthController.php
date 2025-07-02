<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;
use App\Models\Food;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        // Cek apakah email terdaftar
        $userExists = \App\Models\User::where('email', $credentials['email'])->exists();
        if (!$userExists) {
            return back()->with('error', 'Email tidak terdaftar.')->withInput($request->only('email'));
        }

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            
            // Redirect berdasarkan role
            if (Auth::user()->role === 'admin') {
                return redirect()->route('admin.dashboard')->with('success', 'Selamat datang Admin!');
            } elseif (Auth::user()->role === 'kurir') {
                return redirect()->route('kurir.dashboard')->with('success', 'Selamat datang Kurir!');
            } else {
                return redirect()->route('user.dashboard')->with('success', 'Selamat datang!');
            }
        }

        return back()->with('error', 'Email atau password salah.')->withInput($request->only('email'));
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect()->route('login')->with('success', 'Anda berhasil logout!');
    }

    public function userDashboard()
    {
        $user = Auth::user();
        $recentOrders = Order::where('nama_pemesan', $user->name)
                            ->orderBy('created_at', 'desc')
                            ->take(5)
                            ->get();
        $lastOrder = Order::where('nama_pemesan', $user->name)
                          ->orderBy('created_at', 'desc')
                          ->first();
        $totalOrders = Order::where('nama_pemesan', $user->name)->count();
        $totalSpent = Order::where('nama_pemesan', $user->name)->sum('total_harga');
        return view('user.dashboard', compact('user', 'recentOrders', 'totalOrders', 'totalSpent', 'lastOrder'));
    }

    public function showRegister()
    {
        $adminCount = \App\Models\User::where('role', 'admin')->count();
        return view('auth.register', compact('adminCount'));
    }

    public function register(Request $request)
    {
        $adminCount = \App\Models\User::where('role', 'admin')->count();
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|in:user,admin,kurir',
        ]);
        if ($request->role === 'admin' && $adminCount > 0) {
            return back()->withInput()->with('admin_limit', 'Akun admin hanya boleh satu!');
        }
        $user = \App\Models\User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role' => $request->role,
        ]);
        \Auth::login($user);
        if ($request->role === 'admin') {
            return redirect()->route('admin.dashboard')->with('success', 'Akun admin berhasil dibuat!');
        } elseif ($request->role === 'kurir') {
            return redirect()->route('kurir.dashboard')->with('success', 'Akun kurir berhasil dibuat!');
        } else {
            return redirect()->route('user.dashboard')->with('success', 'Akun berhasil dibuat!');
        }
    }
}
