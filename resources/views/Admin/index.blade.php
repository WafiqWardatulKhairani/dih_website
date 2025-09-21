@extends('admin.layout')

@section('title', 'Dashboard Admin')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div>
        <h1 class="text-2xl font-semibold text-gray-900">Dashboard</h1>
        <p class="text-gray-600 mt-1">Selamat datang di portal admin Digital Innovation Hub</p>
    </div>

    <!-- Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="bg-white rounded-lg border border-gray-200 p-6 shadow-sm">
            <div class="flex items-center">
                <div class="p-3 bg-blue-50 rounded-lg">
                    <i class="fas fa-users text-blue-600 text-lg"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm text-gray-600">Total Users</p>
                    <p class="text-2xl font-semibold text-gray-900">{{ $totalUsers }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg border border-gray-200 p-6 shadow-sm">
            <div class="flex items-center">
                <div class="p-3 bg-green-50 rounded-lg">
                    <i class="fas fa-building text-green-600 text-lg"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm text-gray-600">Pemerintah</p>
                    <p class="text-2xl font-semibold text-gray-900">{{ $pemerintahCount }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg border border-gray-200 p-6 shadow-sm">
            <div class="flex items-center">
                <div class="p-3 bg-purple-50 rounded-lg">
                    <i class="fas fa-graduation-cap text-purple-600 text-lg"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm text-gray-600">Akademisi</p>
                    <p class="text-2xl font-semibold text-gray-900">{{ $akademisiCount }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg border border-gray-200 p-6 shadow-sm">
            <div class="flex items-center">
                <div class="p-3 bg-amber-50 rounded-lg">
                    <i class="fas fa-clock text-amber-600 text-lg"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm text-gray-600">Pending</p>
                    <p class="text-2xl font-semibold text-gray-900">{{ $pendingCount }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Users & Quick Actions -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Recent Users -->
        <div class="bg-white rounded-lg border border-gray-200 shadow-sm">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-medium text-gray-900">User Terbaru</h3>
            </div>
            <div class="divide-y divide-gray-200">
                @foreach($recentUsers as $user)
                <div class="px-6 py-4">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <div class="w-10 h-10 bg-gray-100 rounded-full flex items-center justify-center">
                                <span class="text-sm font-medium text-gray-600">
                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                </span>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-900">{{ $user->name }}</p>
                                <p class="text-sm text-gray-500">{{ $user->email }}</p>
                            </div>
                        </div>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                            {{ $user->role == 'admin' ? 'bg-purple-100 text-purple-800' : 
                               ($user->role == 'pemerintah' ? 'bg-green-100 text-green-800' : 
                               'bg-blue-100 text-blue-800') }}">
                            {{ $user->role }}
                        </span>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="bg-white rounded-lg border border-gray-200 shadow-sm">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-medium text-gray-900">Quick Actions</h3>
            </div>
            <div class="p-6 space-y-4">
                <a href="{{ route('admin.users.create') }}" class="flex items-center p-4 border border-gray-200 rounded-lg hover:border-primary-500 hover:bg-primary-50 transition-colors duration-200">
                    <div class="p-2 bg-primary-100 rounded-lg">
                        <i class="fas fa-user-plus text-primary-600"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-900">Tambah User Baru</p>
                        <p class="text-sm text-gray-500">Buat akun user baru</p>
                    </div>
                </a>
                
                <a href="{{ route('admin.users.index') }}" class="flex items-center p-4 border border-gray-200 rounded-lg hover:border-primary-500 hover:bg-primary-50 transition-colors duration-200">
                    <div class="p-2 bg-primary-100 rounded-lg">
                        <i class="fas fa-cog text-primary-600"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-900">Kelola User</p>
                        <p class="text-sm text-gray-500">Lihat dan edit semua user</p>
                    </div>
                </a>
            </div>
        </div>
    </div>
</div>
@endsection