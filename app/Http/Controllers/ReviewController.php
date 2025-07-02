<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Review;
use App\Models\Food;

class ReviewController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'food_id' => 'required|exists:food,id',
            'nama_reviewer' => 'required|string|max:255',
            'rating' => 'required|integer|between:1,5',
            'komentar' => 'nullable|string|max:1000'
        ]);

        Review::create([
            'food_id' => $request->food_id,
            'nama_reviewer' => $request->nama_reviewer,
            'rating' => $request->rating,
            'komentar' => $request->komentar
        ]);

        return redirect()->back()->with('success', 'Review berhasil ditambahkan!');
    }
}
