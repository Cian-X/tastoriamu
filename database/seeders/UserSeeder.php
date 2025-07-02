<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::insert([
            [
                'name' => 'Aslam Muzaky',
                'email' => 'zakyaslam2004@gmail.com',
                'password' => bcrypt('aslam123.'),
                'role' => 'admin',
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);
    }
}
