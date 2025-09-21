<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Super Admin',
            'institution_name' => 'Kementerian Pusat',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'phone' => '081234567890',
            'address' => 'Jakarta',
            'avatar' => null,
            'status' => 'verified', // Tambahkan ini
            'email_verified_at' => now(), // Tambahkan ini
        ]);

        User::create([
            'name' => 'Pemerintah',
            'institution_name' => 'Kementerian Pendidikan',
            'email' => 'pemerintah@example.com',
            'password' => Hash::make('password'),
            'role' => 'pemerintah',
            'phone' => '081111111111',
            'address' => 'Jakarta',
            'avatar' => null,
            'status' => 'verified', // Tambahkan ini
            'email_verified_at' => now(), // Tambahkan ini
        ]);

        User::create([
            'name' => 'Akademisi',
            'institution_name' => 'Universitas Negeri',
            'email' => 'akademisi@example.com',
            'password' => Hash::make('password'),
            'role' => 'akademisi',
            'phone' => '082222222222',
            'address' => 'Bandung',
            'avatar' => null,
            'status' => 'verified', // Tambahkan ini
            'email_verified_at' => now(), // Tambahkan ini
        ]);
    }
}