@extends('layouts.app')

@section('styles')
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<script src="https://cdn.tailwindcss.com"></script>
<script>
    tailwind.config = {
        theme: {
            extend: {
                colors: {
                    primary: '#1e40af',
                    secondary: '#0ea5e9',
                    accent: '#3b82f6',
                    dark: '#1e293b',
                    light: '#f8fafc'
                }
            }
        }
    }
</script>
<style>
    .hero-bg {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
    }
</style>
@endsection

@section('content')
<!-- Hero Section -->
<section class="hero-bg text-white py-12">
    <div class="container mx-auto px-6 md:px-12">
        <div class="flex items-center justify-between">
            <div>
                <a href="{{ route('pemerintah.program') }}" class="inline-flex items-center text-green-100 hover:text-white mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                    Kembali ke Inovasi
                </a>
                <h1 class="text-3xl md:text-4xl font-bold mb-2">{{ $innovation->title }}</h1>
                <p class="text-green-100 text-lg">{{ $innovation->institution }}</p>
            </div>
            <div class="text-right">
                <span class="bg-white text-green-600 px-4 py-2 rounded-full text-sm font-semibold mb-2 block">
                    @if($innovation->status == 'prototype') 🔧 Prototype
                    @elseif($innovation->status == 'ready') ✅ Siap Implementasi
                    @elseif($innovation->status == 'implemented') 🚀 Sudah Diimplementasikan
                    @else 🔬 Research
                    @endif
                </span>
                @if($innovation->is_verified)
                <span class="bg-green-500 text-white px-3 py-1 rounded-full text-xs font-medium">
                    ✓ Terverifikasi
                </span>
                @endif
            </div>
        </div>
    </div>
</section>

<!-- Content Section -->
<section class="bg-white py-8">
    <div class="container mx-auto px-6 md:px-12">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Main Content -->
            <div class="lg:col-span-2">
                @if($innovation->image)
                <div class="mb-6">
                    <img src="{{ asset('storage/' . $innovation->image) }}" alt="{{ $innovation->title }}" 
                         class="w-full h-64 object-cover rounded-lg shadow-md">
                </div>
                @endif
                
                <div class="prose max-w-none">
                    <h3 class="text-xl font-semibold mb-4">Deskripsi Inovasi</h3>
                    <p class="text-gray-700 leading-relaxed">{{ $innovation->description }}</p>
                </div>

                <!-- Research Info -->
                <div class="mt-8 bg-gray-50 p-6 rounded-lg">
                    <h3 class="text-xl font-semibold mb-4">Informasi Research</h3>
                    <div class="grid grid-cols-2 gap-6">
                        <div>
                            <span class="text-gray-500 text-sm">Durasi Research:</span>
                            <p class="font-medium text-lg">{{ $innovation->research_duration }} bulan</p>
                        </div>
                        <div>
                            <span class="text-gray-500 text-sm">Rating:</span>
                            <div class="flex items-center">
                                <span class="font-medium text-lg mr-2">{{ $innovation->rating }}/5.0</span>
                                <div class="flex text-yellow-400">
                                    @for($i = 1; $i <= 5; $i++)
                                        @if($i <= floor($innovation->rating))
                                            ⭐
                                        @else
                                            ☆
                                        @endif
                                    @endfor
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                <!-- Info Box -->
                <div class="bg-green-50 border border-green-200 rounded-lg p-6">
                    <h4 class="font-semibold text-green-800 mb-4">Informasi Inovasi</h4>
                    <div class="space-y-3">
                        <div>
                            <span class="text-green-600 text-sm">Kategori:</span>
                            <p class="font-medium">{{ $innovation->category }}</p>
                        </div>
                        <div>
                            <span class="text-green-600 text-sm">Institusi:</span>
                            <p class="font-medium">{{ $innovation->institution }}</p>
                        </div>
                        <div>
                            <span class="text-green-600 text-sm">Jenis Inovasi:</span>
                            <p class="font-medium capitalize">{{ $innovation->innovation_type }}</p>
                        </div>
                        <div>
                            <span class="text-green-600 text-sm">Status Verifikasi:</span>
                            <p class="font-medium">
                                @if($innovation->is_verified)
                                    <span class="text-green-600">✓ Terverifikasi</span>
                                @else
                                    <span class="text-orange-600">⏳ Belum Diverifikasi</span>
                                @endif
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="bg-white border border-gray-200 rounded-lg p-6">
                    <h4 class="font-semibold text-dark mb-4">Aksi</h4>
                    <div class="space-y-3">
                        <a href="{{ route('pemerintah.inovasi.edit', $innovation->id) }}" 
                           class="w-full inline-flex justify-center items-center bg-primary text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">
                            ✏️ Edit Inovasi
                        </a>
                        <form action="{{ route('pemerintah.inovasi.destroy', $innovation->id) }}" method="POST" class="inline w-full">
                            @csrf
                            @method('DELETE')
                            <button type="submit" 
                                    class="w-full inline-flex justify-center items-center bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700 transition"
                                    onclick="return confirm('Yakin ingin menghapus inovasi ini?')">
                                🗑️ Hapus Inovasi
                            </button>
                        </form>
                        <button class="w-full inline-flex justify-center items-center bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition">
                            🤝 Ajukan Kolaborasi
                        </button>
                    </div>
                </div>

                <!-- Status Info -->
                <div class="bg-blue-50 border border-blue-200 rounded-lg p-6">
                    <h4 class="font-semibold text-blue-800 mb-2">Status Inovasi</h4>
                    <div class="flex items-center">
                        <div class="w-3 h-3 bg-blue-500 rounded-full mr-2"></div>
                        <span class="text-blue-700">
                            @if($innovation->status == 'research')
                                Dalam tahap penelitian
                            @elseif($innovation->status == 'prototype')
                                Sudah memiliki prototype
                            @elseif($innovation->status == 'ready')
                                Siap diimplementasikan
                            @else
                                Sudah diimplementasikan
                            @endif
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection