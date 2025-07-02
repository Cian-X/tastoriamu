<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Food;

class Review extends Model
{
    protected $fillable = [
        'food_id', 'nama_reviewer', 'rating', 'komentar'
    ];

    public function food()
    {
        return $this->belongsTo(Food::class);
    }
}
