<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Promo extends Model
{
    protected $fillable = [
        'kode', 'nama', 'deskripsi', 'tipe', 'nilai', 'min_order', 
        'max_usage', 'used_count', 'valid_until', 'is_active'
    ];

    protected $casts = [
        'valid_until' => 'datetime',
        'is_active' => 'boolean'
    ];

    public function isValid($totalOrder = 0)
    {
        if (!$this->is_active) return false;
        if ($this->valid_until && now()->gt($this->valid_until)) return false;
        if ($this->max_usage && $this->used_count >= $this->max_usage) return false;
        if ($totalOrder < $this->min_order) return false;
        
        return true;
    }

    public function calculateDiscount($totalOrder)
    {
        if ($this->tipe == 'persentase') {
            return ($totalOrder * $this->nilai) / 100;
        } else {
            return min($this->nilai, $totalOrder);
        }
    }
}
