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
        .tab-active {
            background: linear-gradient(135deg, #1e40af 0%, #0ea5e9 100%);
            color: white;
            border: none;
        }
        .tab-inactive {
            background: white;
            color: #1e293b;
            border: 2px solid #1e40af;
        }
        .content-section {
            display: none;
            opacity: 0;
            transition: opacity 0.3s ease;
        }
        .content-section.active {
            display: block;
            opacity: 1;
        }
    </style>
@endsection

@section('content')
<!-- Hero Section -->
<section class="hero-bg text-white py-20 md:py-28">
    <div class="container mx-auto px-6 md:px-12 text-center">
        <h1 class="text-4xl md:text-5xl font-extrabold mb-6 leading-tight">
            Program & <span class="text-yellow-300">Inovasi</span>
        </h1>
        <p class="text-lg md:text-xl max-w-3xl mx-auto mb-8 leading-relaxed">
            Kelola program prioritas dan temukan inovasi digital yang dapat mendukung pembangunan daerah.
        </p>
    </div>
</section>

<!-- Program Content -->
<div id="programContent" class="content-section active">
    <!-- Filter Section -->
    <section class="bg-gray-50 py-8">
        <div class="container mx-auto px-6 md:px-12">
            <div class="flex flex-col md:flex-row justify-between items-center mb-6">
                <h2 class="text-2xl font-bold text-dark mb-4 md:mb-0">Program Prioritas Daerah</h2>
                <div class="flex flex-wrap gap-4">
                    <select class="px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary">
                        <option>Semua Kategori</option>
                        <option>Infrastruktur Digital</option>
                        <option>Smart City</option>
                        <option>Pelayanan Publik</option>
                        <option>Ekonomi Digital</option>
                    </select>
                    <select class="px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary">
                        <option>Semua Status</option>
                        <option>Perencanaan</option>
                        <option>Berjalan</option>
                        <option>Selesai</option>
                    </select>
                    <button class="bg-primary text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">
                        🔍 Cari Program
                    </button>
                </div>
            </div>
        </div>
    </section>

    <!-- Program List -->
    <section class="bg-white py-12">
        <div class="container mx-auto px-6 md:px-12">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @for ($i = 1; $i <= 6; $i++)
                <div class="bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden card-hover">
                    <div class="h-40 bg-gradient-to-r from-primary to-secondary relative">
                        <span class="absolute top-4 right-4 bg-white text-primary px-3 py-1 rounded-full text-sm font-semibold shadow-md">
                            @if($i % 3 == 0) 📅 Perencanaan
                            @elseif($i % 3 == 1) 🚀 Berjalan
                            @else ✅ Selesai
                            @endif
                        </span>
                        <div class="absolute bottom-4 left-4">
                            <span class="bg-black/20 text-white px-2 py-1 rounded text-xs">Program Pemerintah</span>
                        </div>
                    </div>
                    <div class="p-6">
                        <div class="flex items-center mb-4">
                            <div class="w-12 h-12 rounded-full bg-blue-100 flex items-center justify-center text-primary font-bold text-lg">
                                D{{ $i }}
                            </div>
                            <div class="ml-3">
                                <p class="text-sm font-medium text-dark">Dinas Contoh {{ $i }}</p>
                                <p class="text-xs text-gray-500">Pemkab Contoh</p>
                            </div>
                        </div>
                        <h3 class="text-xl font-semibold text-dark mb-3">Program Infrastruktur Digital {{ $i }}</h3>
                        <p class="text-gray-600 mb-4 text-sm">Pengembangan infrastruktur digital untuk mendukung smart city dan pelayanan publik digital.</p>
                        
                        <!-- Progress Bar -->
                        <div class="mb-4">
                            <div class="flex justify-between text-sm text-gray-600 mb-1">
                                <span>Progress</span>
                                <span>@if($i % 3 == 0) 0% @elseif($i % 3 == 1) {{ rand(30, 80) }}% @else 100% @endif</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2">
                                <div class="bg-green-600 h-2 rounded-full" 
                                     style="width: @if($i % 3 == 0) 0% @elseif($i % 3 == 1) {{ rand(30, 80) }}% @else 100% @endif"></div>
                            </div>
                        </div>
                        
                        <div class="flex items-center justify-between mb-4">
                            <div class="flex items-center text-sm text-gray-500">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                {{ now()->subDays($i*30)->format('d M Y') }}
                            </div>
                            <span class="bg-green-100 text-green-800 px-2 py-1 rounded text-xs font-medium">
                                💰 Rp {{ number_format(rand(100, 500) * 1000000, 0, ',', '.') }}
                            </span>
                        </div>
                        
                        <div class="flex justify-between items-center">
                            <div class="flex items-center text-sm text-gray-500">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                                {{ rand(2, 10) }} kolaborator
                            </div>
                            <a href="#" class="text-primary font-semibold hover:text-secondary transition flex items-center text-sm">
                                Kelola Program
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" viewBox="0 0 20 20" fill="currentColor">
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
                    <a href="#" class="px-4 py-2 rounded border border-gray-300 text-gray-500 hover:bg-gray-50">&laquo; Sebelumnya</a>
                    <a href="#" class="px-4 py-2 rounded border border-primary bg-primary text-white">1</a>
                    <a href="#" class="px-4 py-2 rounded border border-gray-300 text-gray-700 hover:bg-gray-50">2</a>
                    <a href="#" class="px-4 py-2 rounded border border-gray-300 text-gray-700 hover:bg-gray-50">3</a>
                    <a href="#" class="px-4 py-2 rounded border border-gray-300 text-gray-500 hover:bg-gray-50">Selanjutnya &raquo;</a>
                </nav>
            </div>
        </div>
    </section>
</div>

<!-- Inovasi Content -->
<div id="inovasiContent" class="content-section">
    <!-- Filter Section -->
    <section class="bg-gray-50 py-8">
        <div class="container mx-auto px-6 md:px-12">
            <div class="flex flex-col md:flex-row justify-between items-center mb-6">
                <h2 class="text-2xl font-bold text-dark mb-4 md:mb-0">Inovasi Digital Tersedia</h2>
                <div class="flex flex-wrap gap-4">
                    <select class="px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary">
                        <option>Semua Kategori</option>
                        <option>Artificial Intelligence</option>
                        <option>Internet of Things</option>
                        <option>Big Data</option>
                        <option>Blockchain</option>
                    </select>
                    <select class="px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary">
                        <option>Semua Status</option>
                        <option>Siap Implementasi</option>
                        <option>Prototype</option>
                        <option>Riset</option>
                    </select>
                    <button class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition">
                        🔍 Cari Inovasi
                    </button>
                </div>
            </div>
        </div>
    </section>

    <!-- Inovasi List -->
    <section class="bg-white py-12">
        <div class="container mx-auto px-6 md:px-12">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @for ($i = 1; $i <= 6; $i++)
                <div class="bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden card-hover">
                    <div class="h-40 bg-gradient-to-r from-green-500 to-emerald-400 relative">
                        <span class="absolute top-4 right-4 bg-white text-green-600 px-3 py-1 rounded-full text-sm font-semibold shadow-md">
                            @if($i % 3 == 0) 🔧 Prototype
                            @elseif($i % 3 == 1) ✅ Siap Implementasi
                            @else 🔬 Riset
                            @endif
                        </span>
                        <div class="absolute bottom-4 left-4">
                            <span class="bg-black/20 text-white px-2 py-1 rounded text-xs">Inovasi Akademisi</span>
                        </div>
                    </div>
                    <div class="p-6">
                        <div class="flex items-center mb-4">
                            <div class="w-12 h-12 rounded-full bg-green-100 flex items-center justify-center text-green-600 font-bold text-lg">
                                U{{ $i }}
                            </div>
                            <div class="ml-3">
                                <p class="text-sm font-medium text-dark">Universitas Contoh {{ $i }}</p>
                                <p class="text-xs text-gray-500">Fakultas Teknologi Informasi</p>
                            </div>
                        </div>
                        <h3 class="text-xl font-semibold text-dark mb-3">Solusi AI untuk Smart City {{ $i }}</h3>
                        <p class="text-gray-600 mb-4 text-sm">Platform kecerdasan buatan untuk optimisasi lalu lintas dan manajemen energi kota.</p>
                        
                        <div class="flex items-center justify-between mb-4">
                            <div class="flex items-center text-sm text-gray-500">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                {{ rand(6, 24) }} bulan research
                            </div>
                            <span class="bg-blue-100 text-blue-800 px-2 py-1 rounded text-xs font-medium">
                                ⭐ {{ rand(40, 50) / 10 }}/5.0
                            </span>
                        </div>
                        
                        <div class="flex justify-between items-center">
                            <div class="flex items-center text-sm text-gray-500">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                </svg>
                                Terverifikasi
                            </div>
                            <a href="#" class="bg-green-600 text-white px-3 py-2 rounded text-sm font-semibold hover:bg-green-700 transition flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z" />
                                </svg>
                                Ajukan Kolaborasi
                            </a>
                        </div>
                    </div>
                </div>
                @endfor
            </div>
            
            <!-- Pagination -->
            <div class="mt-12 flex justify-center">
                <nav class="flex items-center space-x-2">
                    <a href="#" class="px-4 py-2 rounded border border-gray-300 text-gray-500 hover:bg-gray-50">&laquo; Sebelumnya</a>
                    <a href="#" class="px-4 py-2 rounded border border-green-600 bg-green-600 text-white">1</a>
                    <a href="#" class="px-4 py-2 rounded border border-gray-300 text-gray-700 hover:bg-gray-50">2</a>
                    <a href="#" class="px-4 py-2 rounded border border-gray-300 text-gray-700 hover:bg-gray-50">3</a>
                    <a href="#" class="px-4 py-2 rounded border border-gray-300 text-gray-500 hover:bg-gray-50">Selanjutnya &raquo;</a>
                </nav>
            </div>
        </div>
    </section>
</div>

<!-- Call to Action -->
<section class="bg-gradient-to-r from-primary to-secondary py-16">
    <div class="container mx-auto px-6 md:px-12 text-center">
        <h2 class="text-3xl font-bold text-white mb-6">Mulai Kolaborasi Sekarang</h2>
        <p class="text-blue-100 max-w-2xl mx-auto mb-8">Ajukan program prioritas atau temukan inovasi yang sesuai dengan kebutuhan daerah Anda.</p>
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <button id="ctaProgram" class="inline-flex items-center bg-white text-primary px-6 py-3 rounded-lg font-semibold hover:bg-gray-100 transition">
                📋 Ajukan Program Baru
            </button>
            <button id="ctaInovasi" class="inline-flex items-center bg-yellow-400 text-dark px-6 py-3 rounded-lg font-semibold hover:bg-yellow-500 transition">
                💡 Lihat Semua Inovasi
            </button>
        </div>
    </div>
</section>
@endsection

@section('scripts')
<script>
    // Tab Switching Functionality
    document.addEventListener('DOMContentLoaded', function() {
        const programTab = document.getElementById('programTab');
        const inovasiTab = document.getElementById('inovasiTab');
        const programContent = document.getElementById('programContent');
        const inovasiContent = document.getElementById('inovasiContent');
        const ctaProgram = document.getElementById('ctaProgram');
        const ctaInovasi = document.getElementById('ctaInovasi');

        function switchToProgram() {
            console.log('Switching to Program tab');
            
            // Update tabs appearance
            programTab.classList.remove('tab-inactive');
            programTab.classList.add('tab-active');
            inovasiTab.classList.remove('tab-active');
            inovasiTab.classList.add('tab-inactive');
            
            // Update content visibility
            programContent.classList.add('active');
            inovasiContent.classList.remove('active');
        }

        function switchToInovasi() {
            console.log('Switching to Inovasi tab');
            
            // Update tabs appearance
            inovasiTab.classList.remove('tab-inactive');
            inovasiTab.classList.add('tab-active');
            programTab.classList.remove('tab-active');
            programTab.classList.add('tab-inactive');
            
            // Update content visibility
            inovasiContent.classList.add('active');
            programContent.classList.remove('active');
        }

        // Add event listeners
        programTab.addEventListener('click', switchToProgram);
        inovasiTab.addEventListener('click', switchToInovasi);
        
        // CTA buttons also switch tabs
        ctaProgram.addEventListener('click', switchToProgram);
        ctaInovasi.addEventListener('click', switchToInovasi);

        // Initialize with program tab active
        switchToProgram();
        
        // Test if tabs are working
        console.log('Tabs initialized');
        console.log('Program Tab:', programTab);
        console.log('Inovasi Tab:', inovasiTab);
    });
</script>
@endsection