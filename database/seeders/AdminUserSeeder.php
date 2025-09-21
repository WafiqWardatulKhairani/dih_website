<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admins = [
            [
                'name' => 'Super Admin',
                'institution_name' => null,
                'email' => 'superadmin@portalopd.com',
                'phone' => '081234567890',
                'address' => 'Jl. Admin Utama No. 1',
                'password' => Hash::make('SuperAdminDIH_21September2025'), // Password kompleks
                'role' => 'admin',
                'status' => 'verified',
                'email_verified_at' => now(),
                'avatar' => null,
                'document_path' => null,
            ],
            [
                'name' => 'Admin Pemerintah',
                'institution_name' => null,
                'email' => 'admin.pemerintah@portalopd.com',
                'phone' => '081234567891',
                'address' => 'Jl. Pemerintah No. 2',
                'password' => Hash::make('AdminPemerintah_DIH21September2025'), // Password kompleks
                'role' => 'admin',
                'status' => 'verified',
                'email_verified_at' => now(),
                'avatar' => null,
                'document_path' => null,
            ],
            [
                'name' => 'Admin Akademisi',
                'institution_name' => null,
                'email' => 'admin.akademisi@portalopd.com',
                'phone' => '081234567892',
                'address' => 'Jl. Akademik No. 3',
                'password' => Hash::make('Admin_AkademisiDIH21September2025'), // Password kompleks
                'role' => 'admin',
                'status' => 'verified',
                'email_verified_at' => now(),
                'avatar' => null,
                'document_path' => null,
            ]
        ];

        foreach ($admins as $admin) {
            User::create($admin);
        }

        $this->command->info('3 admin users created successfully!');
        $this->command->info('Email: superadmin@portalopd.com / Password: SuperAdminDIH_21September2025');
        $this->command->info('Email: admin.pemerintah@portalopd.com / Password: AdminPemerintah_DIH21September2025');
        $this->command->info('Email: admin.akademisi@portalopd.com / Password: Admin_AkademisiDIH21September2025');
    }
}