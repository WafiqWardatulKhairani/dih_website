@extends('Admin.layout')

@section('title', 'Statistik')

@section('content')
<div class="bg-white rounded-lg shadow p-6">
    <h2 class="text-2xl font-bold mb-6">Statistik Pengguna</h2>
    
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Total Users Card -->
        <div class="bg-white rounded-lg shadow p-6 border">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-blue-100 text-blue-500">
                    <i class="fas fa-users text-xl"></i>
                </div>
                <div class="ml-4">
                    <h3 class="text-sm font-medium text-gray-500">Total Users</h3>
                    <p class="text-2xl font-bold">{{ $totalUsers }}</p>
                </div>
            </div>
        </div>

        <!-- Pemerintah Users Card -->
        <div class="bg-white rounded-lg shadow p-6 border">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-green-100 text-green-500">
                    <i class="fas fa-building text-xl"></i>
                </div>
                <div class="ml-4">
                    <h3 class="text-sm font-medium text-gray-500">Pemerintah</h3>
                    <p class="text-2xl font-bold">{{ $pemerintahCount }}</p>
                </div>
            </div>
        </div>

        <!-- Akademisi Users Card -->
        <div class="bg-white rounded-lg shadow p-6 border">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-purple-100 text-purple-500">
                    <i class="fas fa-graduation-cap text-xl"></i>
                </div>
                <div class="ml-4">
                    <h3 class="text-sm font-medium text-gray-500">Akademisi</h3>
                    <p class="text-2xl font-bold">{{ $akademisiCount }}</p>
                </div>
            </div>
        </div>

        <!-- Verified Users Card -->
        <div class="bg-white rounded-lg shadow p-6 border">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-green-100 text-green-500">
                    <i class="fas fa-check-circle text-xl"></i>
                </div>
                <div class="ml-4">
                    <h3 class="text-sm font-medium text-gray-500">Terverifikasi</h3>
                    <p class="text-2xl font-bold">{{ $verifiedCount }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection