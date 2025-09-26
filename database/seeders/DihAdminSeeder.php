<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\DihAdmin;
use Illuminate\Support\Facades\Hash;

class DihAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admins = [
            [
                'name' => 'Super Admin',
                'email' => 'superadmin@portalopd.com',
                'phone' => '081234567890',
                'password' => Hash::make('SuperAdminDIH_21September2025'),
                'role' => 'superadmin',
                'status' => 'verified',
                'email_verified_at' => now(),
            ],
            [
                'name' => 'Admin Pemerintah',
                'email' => 'admin.pemerintah@portalopd.com',
                'phone' => '081234567891',
                'password' => Hash::make('AdminPemerintah_DIH21September2025'),
                'role' => 'admin_pemerintah',
                'status' => 'verified',
                'email_verified_at' => now(),
            ],
            [
                'name' => 'Admin Akademisi',
                'email' => 'admin.akademisi@portalopd.com',
                'phone' => '081234567892',
                'password' => Hash::make('Admin_AkademisiDIH21September2025'),
                'role' => 'admin_akademisi',
                'status' => 'verified',
                'email_verified_at' => now(),
            ]
        ];

        foreach ($admins as $admin) {
            DihAdmin::create($admin);
        }

        $this->command->info('3 DIH admin users created successfully!');
    }
}
