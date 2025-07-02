<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Food;

class FoodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Food::insert([
            [
                'nama' => 'Sate Madura',
                'deskripsi' => 'Sate ayam khas Madura dengan bumbu kacang gurih dan lontong.',
                'harga' => 25000,
                'gambar' => '/images/sate-madura.jpg'
            ],
            [
                'nama' => 'Rawon',
                'deskripsi' => 'Sup daging sapi khas Jawa Timur dengan kuah hitam dari kluwek.',
                'harga' => 28000,
                'gambar' => '/images/rawon.jpg'
            ],
            [
                'nama' => 'Pempek Palembang',
                'deskripsi' => 'Pempek ikan tenggiri dengan kuah cuko khas Palembang.',
                'harga' => 22000,
                'gambar' => '/images/pempek-palembang.jpg'
            ],
            [
                'nama' => 'Gudeg Jogja',
                'deskripsi' => 'Gudeg nangka muda khas Yogyakarta dengan krecek dan telur.',
                'harga' => 26000,
                'gambar' => '/images/gudeg-jogja.jpg'
            ],
            [
                'nama' => 'Soto Betawi',
                'deskripsi' => 'Soto daging sapi dengan kuah santan khas Betawi.',
                'harga' => 24000,
                'gambar' => '/images/soto-betawi.jpg'
            ],
            [
                'nama' => 'Es Doger',
                'deskripsi' => 'Minuman es khas Betawi dengan tape, ketan, dan kelapa muda.',
                'harga' => 10000,
                'gambar' => '/images/es-doger.jpg'
            ],
            [
                'nama' => 'Kopi Tubruk',
                'deskripsi' => 'Kopi hitam khas Indonesia dengan aroma kuat dan rasa pekat.',
                'harga' => 12000,
                'gambar' => '/images/kopi-tubruk.jpg'
            ],
            [
                'nama' => 'Nasi Uduk',
                'deskripsi' => 'Nasi gurih dengan lauk pauk lengkap khas Betawi.',
                'harga' => 20000,
                'gambar' => '/images/nasi-uduk.jpg'
            ],
            [
                'nama' => 'Es Teler',
                'deskripsi' => 'Minuman es campur buah, alpukat, kelapa, dan susu kental manis.',
                'harga' => 12000,
                'gambar' => '/images/es-teler.jpg'
            ],
        ]);
    }
}
