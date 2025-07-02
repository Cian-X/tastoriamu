<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Promo;

class PromoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Promo::insert([
            [
                'kode' => 'WELCOME10',
                'nama' => 'Welcome Discount 10%',
                'deskripsi' => 'Diskon 10% untuk pesanan pertama Anda',
                'tipe' => 'persentase',
                'nilai' => 10,
                'min_order' => 50000,
                'max_usage' => 100,
                'used_count' => 0,
                'valid_until' => now()->addMonths(1),
                'is_active' => true
            ],
            [
                'kode' => 'FREESHIP',
                'nama' => 'Free Shipping',
                'deskripsi' => 'Gratis ongkos kirim untuk pesanan minimal Rp100.000',
                'tipe' => 'fixed',
                'nilai' => 5000,
                'min_order' => 100000,
                'max_usage' => 50,
                'used_count' => 0,
                'valid_until' => now()->addWeeks(2),
                'is_active' => true
            ],
            [
                'kode' => 'HAPPY20',
                'nama' => 'Happy Day 20%',
                'deskripsi' => 'Diskon 20% untuk semua menu',
                'tipe' => 'persentase',
                'nilai' => 20,
                'min_order' => 75000,
                'max_usage' => 30,
                'used_count' => 0,
                'valid_until' => now()->addDays(7),
                'is_active' => true
            ]
        ]);
    }
}
