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
            Program & <span class="text-secondary">Inovasi</span>
        </h1>
        <p class="text-xl md:text-2xl max-w-3xl mx-auto mb-10 leading-relaxed">
            Temukan program prioritas dan inovasi digital yang sedang dikembangkan oleh pemerintah daerah.
        </p>
    </div>
</section>

<!-- Filter Section -->
<section class="bg-white py-12">
    <div class="container mx-auto px-6 md:px-12">
        <div class="flex flex-col md:flex-row justify-between items-center mb-8">
            <h2 class="text-2xl font-bold text-dark mb-4 md:mb-0">Program Prioritas Daerah</h2>
            <div class="flex flex-wrap gap-4">
                <select class="px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary">
                    <option>Semua Kategori</option>
                    <option>Infrastruktur Digital</option>
                    <option>Smart City</option>
                    <option>Pelayanan Publik</option>
                </select>
                <select class="px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary">
                    <option>Semua Status</option>
                    <option>Perencanaan</option>
                    <option>Berjalan</option>
                    <option>Selesai</option>
                </select>
            </div>
        </div>
    </div>
</section>

<!-- Program List -->
<section class="bg-gray-50 py-16">
    <div class="container mx-auto px-6 md:px-12">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @for ($i = 1; $i <= 6; $i++)
            <div class="bg-white rounded-xl shadow-md overflow-hidden card-hover">
                <div class="h-48 bg-gradient-to-r from-primary to-secondary relative">
                    <span class="absolute top-4 right-4 bg-white text-primary px-3 py-1 rounded-full text-sm font-semibold">
                        @if($i % 3 == 0) Perencanaan
                        @elseif($i % 3 == 1) Berjalan
                        @else Selesai
                        @endif
                    </span>
                </div>
                <div class="p-6">
                    <div class="flex items-center mb-4">
                        <div class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center text-primary font-bold">
                            D{{ $i }}
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-dark">Dinas Contoh {{ $i }}</p>
                            <p class="text-xs text-gray-500">Pemkab Contoh</p>
                        </div>
                    </div>
                    <h3 class="text-xl font-semibold text-dark mb-3">Program Infrastruktur Digital {{ $i }}</h3>
                    <p class="text-gray-600 mb-6">Pengembangan infrastruktur digital untuk mendukung smart city dan pelayanan publik digital.</p>
                    <div class="flex justify-between items-center">
                        <div class="text-sm text-gray-500">
                            <span class="flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                {{ now()->subDays($i*10)->format('d M Y') }}
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
            </div>
            @endfor
        </div>
        
        <!-- Pagination -->
        <div class="mt-12 flex justify-center">
            <nav class="flex items-center space-x-2">
                <a href="#" class="px-3 py-1 rounded border border-gray-300 text-gray-500 hover:bg-gray-50">&laquo;</a>
                <a href="#" class="px-3 py-1 rounded border border-primary bg-primary text-white">1</a>
                <a href="#" class="px-3 py-1 rounded border border-gray-300 text-gray-700 hover:bg-gray-50">2</a>
                <a href="#" class="px-3 py-1 rounded border border-gray-300 text-gray-700 hover:bg-gray-50">3</a>
                <a href="#" class="px-3 py-1 rounded border border-gray-300 text-gray-500 hover:bg-gray-50">&raquo;</a>
            </nav>
        </div>
    </div>
</section>

<!-- Call to Action -->
<section class="bg-white py-16">
    <div class="container mx-auto px-6 md:px-12 text-center">
        <h2 class="text-3xl font-bold text-dark mb-6">Ajukan Program Prioritas</h2>
        <p class="text-gray-600 max-w-2xl mx-auto mb-8">Dinas dapat mengajukan program prioritas untuk mendapatkan dukungan dan kolaborasi dari akademisi.</p>
        <a href="#" class="inline-flex items-center bg-primary text-white px-6 py-3 rounded-lg font-semibold hover:bg-blue-700 transition">
            Ajukan Program
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-8.707l-3-3a1 1 0 00-1.414 0l-3 3a1 1 0 001.414 1.414L9 9.414V13a1 1 0 102 0V9.414l1.293 1.293a1 1 0 001.414-1.414z" clip-rule="evenodd" />
            </svg>
        </a>
    </div>
</section>
@endsection