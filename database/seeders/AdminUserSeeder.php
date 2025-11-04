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
                'password' => 'SuperAdminDIH_21September2025', // password raw, nanti di-hash
                'role' => 'admin',
                'status' => 'verified',
                'avatar' => null,
                'document_path' => null,
            ],
            [
                'name' => 'Admin Pemerintah',
                'institution_name' => null,
                'email' => 'admin.pemerintah@portalopd.com',
                'phone' => '081234567891',
                'address' => 'Jl. Pemerintah No. 2',
                'password' => 'AdminPemerintah_DIH21September2025',
                'role' => 'admin',
                'status' => 'verified',
                'avatar' => null,
                'document_path' => null,
            ],
            [
                'name' => 'Admin Akademisi',
                'institution_name' => null,
                'email' => 'admin.akademisi@portalopd.com',
                'phone' => '081234567892',
                'address' => 'Jl. Akademik No. 3',
                'password' => 'Admin_AkademisiDIH21September2025',
                'role' => 'admin',
                'status' => 'verified',
                'avatar' => null,
                'document_path' => null,
            ]
        ];

        foreach ($admins as $admin) {
            User::updateOrCreate(
                ['email' => $admin['email']], // kondisi unik
                [
                    'name' => $admin['name'],
                    'institution_name' => $admin['institution_name'],
                    'phone' => $admin['phone'],
                    'address' => $admin['address'],
                    'password' => Hash::make($admin['password']),
                    'role' => $admin['role'],
                    'status' => $admin['status'],
                    'email_verified_at' => now(),
                    'avatar' => $admin['avatar'],
                    'document_path' => $admin['document_path'],
                ]
            );
        }

        $this->command->info('3 admin users created or updated successfully!');
        $this->command->info('Email: superadmin@portalopd.com / Password: SuperAdminDIH_21September2025');
        $this->command->info('Email: admin.pemerintah@portalopd.com / Password: AdminPemerintah_DIH21September2025');
        $this->command->info('Email: admin.akademisi@portalopd.com / Password: Admin_AkademisiDIH21September2025');
    }
}
