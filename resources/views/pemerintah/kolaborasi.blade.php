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
            background: linear-gradient(135deg, #1e40af 0%, #0ea5e9 100%);
        }
        .card-hover {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .card-hover:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1);
        }
    </style>
@endsection

@section('content')
<!-- Hero Section -->
<section class="hero-bg text-white py-24 md:py-32">
    <div class="container mx-auto px-6 md:px-12 text-center">
        <h1 class="text-4xl md:text-6xl font-extrabold mb-6 leading-tight">
            Ruang<span class="text-secondary">Kolaborasi</span>
        </h1>
        <p class="text-xl md:text-2xl max-w-3xl mx-auto mb-10 leading-relaxed">
            Temukan berbagai kolaborasi digital pada pemerintah daerah.
        </p>
    </div>
</section>

<!-- Search Section -->
<section class="bg-white py-12">
    <div class="container mx-auto px-6 md:px-12">
        <div class="max-w-4xl mx-auto">
            <div class="relative">
                <input type="text" placeholder="Cari kolaborasi..." class="w-full px-6 py-4 border border-gray-300 rounded-2xl focus:outline-none focus:ring-2 focus:ring-primary">
                <button class="absolute right-2 top-2 bg-primary text-white p-2 rounded-xl hover:bg-blue-700 transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </button>
            </div>
        </div>
    </div>
</section>

<!-- Categories Section -->
<section class="bg-gray-50 py-12">
    <div class="container mx-auto px-6 md:px-12">
        <h2 class="text-2xl font-bold text-dark mb-8 text-center">Kategori Kolaborasi</h2>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            @foreach(['Infrastruktur', 'Smart City', 'Layanan Publik', 'Data & Analytics', 'Keamanan', 'Komunikasi', 'Mobility', 'Energi'] as $category)
            <a href="#" class="bg-white p-6 rounded-xl shadow-sm text-center hover:shadow-md transition card-hover">
                <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center mx-auto mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                    </svg>
                </div>
                <h3 class="font-semibold text-dark">{{ $category }}</h3>
            </a>
            @endforeach
        </div>
    </div>
</section>

<!-- Solutions List -->
<section class="bg-white py-16">
    <div class="container mx-auto px-6 md:px-12">
        <h2 class="text-2xl font-bold text-dark mb-8">Kolaboasi Terpopuler</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            @for ($i = 1; $i <= 4; $i++)
            <div class="bg-gray-50 rounded-xl p-6 card-hover">
                <div class="flex items-start mb-4">
                    <div class="w-16 h-16 bg-blue-100 rounded-xl flex items-center justify-center text-primary mr-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-xl font-semibold text-dark mb-2">Solusi Smart City {{ $i }}</h3>
                        <div class="flex items-center text-sm text-gray-500 mb-3">
                            <span class="mr-4">Oleh: Akademisi {{ $i }}</span>
                            <span class="flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                {{ now()->subDays($i*5)->format('d M Y') }}
                            </span>
                        </div>
                    </div>
                </div>
                <p class="text-gray-600 mb-6">Solusi inovatif untuk mengembangkan smart city dengan pendekatan berbasis data dan teknologi terkini.</p>
                <div class="flex justify-between items-center">
                    <div class="flex items-center">
                        <span class="bg-blue-100 text-primary px-3 py-1 rounded-full text-sm font-medium mr-2">
                            Infrastruktur
                        </span>
                        <span class="flex items-center text-sm text-gray-500">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                            {{ $i * 124 }}
                        </span>
                    </div>
                    <a href="#" class="text-primary font-semibold hover:text-secondary transition flex items-center">
                        Detail
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-1" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M12.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </a>
                </div>
            </div>
            @endfor
        </div>
        
        <div class="text-center mt-12">
            <a href="#" class="inline-flex items-center px-6 py-3 border border-primary text-primary font-semibold rounded-full hover:bg-primary hover:text-white transition">
                Lihat Semua Solusi
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M12.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                </svg>
            </a>
        </div>
    </div>
</section>


@endsection