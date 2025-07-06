<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Food;

class FoodController extends Controller
{
    public function index(Request $request)
    {
        $query = Food::query();
        
        // Search by name
        if ($request->has('search') && $request->search != '') {
            $query->where('nama', 'like', '%' . $request->search . '%')
                  ->orWhere('deskripsi', 'like', '%' . $request->search . '%');
        }
        
        // Filter by price range
        if ($request->has('min_price') && $request->min_price != '') {
            $query->where('harga', '>=', $request->min_price);
        }
        
        if ($request->has('max_price') && $request->max_price != '') {
            $query->where('harga', '<=', $request->max_price);
        }
        
        // Sort by
        $sort = $request->get('sort', 'nama');
        $order = $request->get('order', 'asc');
        
        switch ($sort) {
            case 'harga':
                $query->orderBy('harga', $order);
                break;
            case 'nama':
            default:
                $query->orderBy('nama', $order);
                break;
        }
        
        $foods = $query->get();
        return view('food.index', compact('foods'));
    }

    public function orderNow(Request $request, $id)
    {
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu untuk memesan makanan!');
        }
        $food = Food::findOrFail($id);

        $request->validate([
            'qty' => 'required|integer|min:1',
            'alamat' => 'required|string|max:255',
        ]);

        // Simpan alamat ke profil user jika berbeda
        if (auth()->user()->alamat !== $request->alamat) {
            auth()->user()->alamat = $request->alamat;
            auth()->user()->save();
        }

        $qty = $request->qty;
        $total = $food->harga * $qty;

        // Tentukan status dan payment_status sesuai metode pembayaran
        if ($request->payment_method === 'cash' || $request->payment_method === 'cod') {
            $status = 'siap antar';
            $payment_status = 'paid';
        } else {
            $status = 'menunggu pembayaran';
            $payment_status = 'unpaid';
        }

        // Buat order langsung
        $order = \App\Models\Order::create([
            'user_id' => auth()->id(),
            'nama_pemesan' => auth()->user()->name,
            'alamat' => $request->alamat,
            'catatan' => $request->catatan,
            'total_harga' => $total,
            'status' => $status,
            'items' => json_encode([
                [
                    'nama' => $food->nama,
                    'harga' => $food->harga,
                    'qty' => $qty
                ]
            ]),
            'tracking_number' => 'TRK' . strtoupper(uniqid()),
            'estimated_delivery' => now()->addMinutes(45),
            'payment_method' => $request->payment_method,
            'payment_status' => $payment_status,
        ]);

        return redirect()->route('orders.index')->with('success', 'Pesanan berhasil dibuat!');
    }
}
