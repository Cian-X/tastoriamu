<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'nama_pemesan', 'alamat', 'total_harga', 'status', 'items', 
        'tracking_number', 'estimated_delivery', 'payment_method', 'payment_status',
        'payment_attempts', 'confirmed_at', 'delivered_at'
    ];

    protected $casts = [
        'items' => 'array',
        'estimated_delivery' => 'datetime'
    ];
}
