@extends('layouts.app')

@section('content')
<!-- Hero Section -->
<section id="home" class="gradient-bg text-white pt-20 pb-16 md:pt-24 md:pb-20 relative overflow-hidden">
    <!-- Background Elements -->
    <div class="absolute top-10 right-10 w-48 h-48 rounded-full bg-white opacity-10"></div>
    <div class="absolute bottom-20 left-10 w-60 h-60 rounded-full bg-white opacity-5"></div>

    <div class="container mx-auto px-4 relative">
        <div class="flex flex-col lg:flex-row items-center">
            <div class="lg:w-1/2 mb-8 lg:mb-0">
                <h1 class="text-3xl md:text-4xl lg:text-5xl font-bold mb-4 leading-tight">
                    Bersama Membangun <span class="text-yellow-300">Inovasi</span> untuk Negeri
                </h1>
                <p class="text-base md:text-lg mb-6 opacity-90 max-w-lg leading-relaxed">
                    Platform kolaborasi antara pemerintah dan akademisi untuk menciptakan solusi inovatif yang berdampak nyata bagi masyarakat.
                </p>
                <div class="flex flex-col sm:flex-row space-y-2 sm:space-y-0 sm:space-x-3">
                    <a href="#hub" class="px-6 py-3 bg-white text-blue-600 font-bold rounded-lg shadow-md hover:bg-gray-100 transition-all duration-300 flex items-center justify-center space-x-2">
                        <i class="fas fa-lightbulb"></i>
                        <span>Mulai Berinovasi</span>
                    </a>
                    <a href="#program" class="px-6 py-3 border-2 border-white text-white font-bold rounded-lg hover:bg-white hover:text-blue-600 transition-all duration-300 flex items-center justify-center space-x-2">
                        <i class="fas fa-search"></i>
                        <span>Telusuri Program</span>
                    </a>
                </div>
            </div>

            <div class="lg:w-1/2 flex justify-center">
                <div class="relative">
                    <img src="https://images.unsplash.com/photo-1522202176988-66273c2fd55f?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1000&q=80" 
                         alt="Ilustrasi kolaborasi digital" 
                         class="rounded-xl shadow-xl relative z-10 w-full max-w-sm">
                    <div class="absolute -bottom-3 -right-3 w-full h-full border-2 border-blue-300 rounded-xl opacity-60"></div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Stats Section -->
<section class="py-6 bg-white">
    <div class="container mx-auto px-4">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            <div class="bg-gray-50 p-4 rounded-xl text-center">
                <div class="text-2xl font-bold text-blue-600 mb-1 font-mono">{{ $stats['opd_terdaftar'] }}</div>
                <p class="text-gray-600 text-sm font-medium">OPD Terdaftar</p>
            </div>
            <div class="bg-gray-50 p-4 rounded-xl text-center">
                <div class="text-2xl font-bold text-green-600 mb-1 font-mono">{{ $stats['akademisi_terdaftar'] }}</div>
                <p class="text-gray-600 text-sm font-medium">Akademisi Terdaftar</p>
            </div>
            <div class="bg-gray-50 p-4 rounded-xl text-center">
                <div class="text-2xl font-bold text-orange-500 mb-1 font-mono">{{ $stats['program_selesai'] + $stats['program_berjalan'] }}</div>
                <p class="text-gray-600 text-sm font-medium">Program Dibuat</p>
            </div>
            <div class="bg-gray-50 p-4 rounded-xl text-center">
                <div class="text-2xl font-bold text-purple-600 mb-1 font-mono">{{ $stats['total_inovasi'] }}+</div>
                <p class="text-gray-600 text-sm font-medium">Inovasi Dibuat</p>
            </div>
        </div>
    </div>
</section>

<!-- How It Works -->
<div class="bg-gray-50 rounded-xl p-6 mb-12 mx-4">
    <h3 class="text-xl font-bold text-center mb-8">Bagaimana Platform Ini Bekerja?</h3>
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <!-- Step 1 -->
        <div class="text-center">
            <div class="bg-white w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-3 shadow-md">
                <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center text-blue-600 font-bold text-lg">1</div>
            </div>
            <h4 class="font-bold mb-2 text-sm">Identifikasi Masalah</h4>
            <p class="text-gray-600 text-xs">OPD dan UMKM mendaftarkan masalah atau program prioritas yang membutuhkan solusi inovatif.</p>
        </div>
        <!-- Step 2 -->
        <div class="text-center">
            <div class="bg-white w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-3 shadow-md">
                <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center text-green-600 font-bold text-lg">2</div>
            </div>
            <h4 class="font-bold mb-2 text-sm">Eksplorasi Solusi</h4>
            <p class="text-gray-600 text-xs">Akademisi mengeksplorasi masalah dan mengajukan proposal solusi berbasis penelitian.</p>
        </div>
        <!-- Step 3 -->
        <div class="text-center">
            <div class="bg-white w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-3 shadow-md">
                <div class="w-12 h-12 bg-yellow-100 rounded-full flex items-center justify-center text-yellow-600 font-bold text-lg">3</div>
            </div>
            <h4 class="font-bold mb-2 text-sm">Diskusi Kolaboratif</h4>
            <p class="text-gray-600 text-xs">Terjadi diskusi mendalam antara OPD, akademisi, dan UMKM untuk menyempurnakan solusi.</p>
        </div>
        <!-- Step 4 -->
        <div class="text-center">
            <div class="bg-white w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-3 shadow-md">
                <div class="w-12 h-12 bg-purple-100 rounded-full flex items-center justify-center text-purple-600 font-bold text-lg">4</div>
            </div>
            <h4 class="font-bold mb-2 text-sm">Implementasi</h4>
            <p class="text-gray-600 text-xs">Solusi diimplementasikan dan dimonitor dampaknya terhadap masyarakat dan dunia usaha.</p>
        </div>
    </div>
</div>

<!-- Program & Inovasi Section (Side by Side tanpa Scrollbar) -->
<section class="py-6 bg-gray-50">
    <div class="container mx-auto px-4">
        <div class="text-center mb-6">
            <h2 class="text-lg font-bold mb-1">Program & Inovasi Terbaru</h2>
            <p class="text-gray-600 max-w-2xl mx-auto text-xs">
                Kolaborasi antara pemerintah dan akademisi untuk menciptakan solusi inovatif
            </p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
            <!-- Program Prioritas (Kiri) -->
            <div class="bg-white rounded-lg p-3 shadow-sm border border-gray-100">
                <div class="text-center mb-2">
                    <h3 class="text-base font-bold mb-1 text-blue-700">Program Prioritas</h3>
                    <p class="text-gray-600 text-xs">Program unggulan yang membutuhkan solusi inovatif</p>
                </div>

                <div class="space-y-3 max-h-96 overflow-y-auto scrollbar-hide">
                    @foreach($programs as $program)
                    <div class="bg-gray-50 rounded-md p-2 border border-gray-200 hover:border-blue-300 transition-colors">
                        <div class="flex items-start gap-2">
                            <div class="flex-shrink-0 w-16 h-16 rounded-md overflow-hidden">
                                @if($program->image)
                                <img src="{{ asset('storage/' . $program->image) }}"
                                    alt="{{ $program->title }}"
                                    class="w-full h-full object-cover">
                                @else
                                <img src="https://images.unsplash.com/photo-1499750310107-5fef28a66643?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=100&q=80"
                                    alt="{{ $program->title }}"
                                    class="w-full h-full object-cover">
                                @endif
                            </div>
                            <div class="flex-1 min-w-0">
                                <div class="flex items-start justify-between mb-1">
                                    <span class="bg-blue-100 text-blue-800 text-xs font-bold px-1.5 py-0.5 rounded-full">
                                        {{ $program->category ?? 'Umum' }}
                                    </span>
                                    <span class="text-xs text-gray-500">{{ $program->created_at->diffForHumans() }}</span>
                                </div>
                                <h4 class="text-xs font-bold mb-1 line-clamp-1">{{ $program->title }}</h4>
                                <p class="text-gray-600 text-xs mb-1 line-clamp-2">{{ Str::limit($program->description, 60) }}</p>
                                
                                <div class="flex items-center justify-between">
                                    <span class="text-xs text-gray-500">Progress: {{ $program->progress }}%</span>
                                    <button onclick="showLoginAlert()" class="text-blue-600 hover:text-blue-800 text-xs font-medium">
                                        Detail
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach

                    @if($programs->isEmpty())
                    <div class="bg-gray-50 rounded-md p-4 text-center border border-dashed border-gray-300">
                        <svg class="w-6 h-6 text-gray-300 mx-auto mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                        </svg>
                        <p class="text-gray-500 text-xs">Belum ada program</p>
                    </div>
                    @endif
                </div>

                <div class="text-center mt-3">
                    <button onclick="showLoginAlert()" class="bg-blue-600 text-white px-3 py-1 rounded text-xs font-semibold hover:bg-blue-700 transition-all">
                        Lihat Semua Program
                    </button>
                </div>
            </div>

            <!-- Inovasi Terbaru (Kanan) -->
            <div class="bg-white rounded-lg p-3 shadow-sm border border-gray-100">
                <div class="text-center mb-2">
                    <h3 class="text-base font-bold mb-1 text-green-700">Inovasi Terbaru</h3>
                    <p class="text-gray-600 text-xs">Solusi inovatif dari OPD dan akademisi</p>
                </div>

                <div class="space-y-3 max-h-96 overflow-y-auto scrollbar-hide">
                    @foreach($allInnovations as $innovation)
                    <div class="bg-gray-50 rounded-md p-2 border border-gray-200 hover:border-green-300 transition-colors">
                        <div class="flex items-start gap-2">
                            <div class="flex-shrink-0 w-16 h-16 rounded-md overflow-hidden">
                                @if($innovation->image)
                                <img src="{{ asset('storage/' . $innovation->image) }}"
                                    alt="{{ $innovation->title }}"
                                    class="w-full h-full object-cover">
                                @else
                                <img src="https://images.unsplash.com/photo-1551288049-bebda4e38f71?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=100&q=80"
                                    alt="{{ $innovation->title }}"
                                    class="w-full h-full object-cover">
                                @endif
                            </div>
                            <div class="flex-1 min-w-0">
                                <div class="flex items-start justify-between mb-1">
                                    <span class="bg-green-100 text-green-800 text-xs font-bold px-1.5 py-0.5 rounded-full">
                                        {{ $innovation->category ?? 'Umum' }}
                                    </span>
                                    <span class="text-xs text-gray-500">{{ $innovation->created_at->diffForHumans() }}</span>
                                </div>
                                <h4 class="text-xs font-bold mb-1 line-clamp-1">{{ $innovation->title }}</h4>
                                <p class="text-gray-600 text-xs mb-1 line-clamp-2">
                                    {{ Str::limit($innovation->description, 60) }}
                                </p>
                                
                                <div class="flex items-center justify-between">
                                    <span class="text-xs text-gray-500">
                                        @if($innovation->technology_readiness_level)
                                            TRL {{ $innovation->technology_readiness_level }}
                                        @else
                                            Inovasi
                                        @endif
                                    </span>
                                    <button onclick="showLoginAlert()" class="text-green-600 hover:text-green-800 text-xs font-medium">
                                        Detail
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach

                    @if($allInnovations->isEmpty())
                    <div class="bg-gray-50 rounded-md p-4 text-center border border-dashed border-gray-300">
                        <svg class="w-6 h-6 text-gray-300 mx-auto mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path>
                        </svg>
                        <p class="text-gray-500 text-xs">Belum ada inovasi</p>
                    </div>
                    @endif
                </div>

                <div class="text-center mt-3">
                    <button onclick="showLoginAlert()" class="bg-green-600 text-white px-3 py-1 rounded text-xs font-semibold hover:bg-green-700 transition-all">
                        Lihat Semua Inovasi
                    </button>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Innovation Hub Section -->
<section id="hub" class="py-12 bg-white">
    <div class="container mx-auto px-4">
        <div class="text-center mb-8">
            <h2 class="text-2xl font-bold mb-2 relative inline-block">
                <span class="relative z-10">Siapa Saja Yang Dapat Mengakses Platform Ini?</span>
                <span class="absolute bottom-0 left-0 w-full h-1.5 bg-blue-200 opacity-60 -z-0 rounded-full" style="bottom: 2px;"></span>
            </h2>
            <p class="text-gray-600 max-w-2xl mx-auto text-sm">Platform kolaborasi antara UMKM, pemerintah daerah dan akademisi untuk menciptakan solusi inovatif berbasis penelitian dan kebutuhan nyata.</p>
        </div>

        <!-- Baris pertama: 2 card -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
            <!-- OPD Card -->
            <div class="bg-blue-50 rounded-lg p-4 shadow-sm border border-blue-100">
                <div class="bg-blue-600 text-white w-10 h-10 rounded-lg flex items-center justify-center mb-3 shadow-sm">
                    <i class="fas fa-building"></i>
                </div>
                <h3 class="text-lg font-bold mb-2 text-blue-800">Untuk OPD</h3>
                <p class="text-gray-600 text-sm mb-3">Publikasikan tantangan dan program prioritas Anda, dapatkan solusi berbasis penelitian dari para ahli.</p>
                <button onclick="showLoginAlert()" class="text-blue-600 font-medium flex items-center text-sm">
                    Pelajari Lebih Lanjut
                    <i class="fas fa-arrow-right ml-2"></i>
                </button>
            </div>

            <!-- Akademisi Card -->
            <div class="bg-green-50 rounded-lg p-4 shadow-sm border border-green-100">
                <div class="bg-green-600 text-white w-10 h-10 rounded-lg flex items-center justify-center mb-3 shadow-sm">
                    <i class="fas fa-graduation-cap"></i>
                </div>
                <h3 class="text-lg font-bold mb-2 text-green-800">Untuk Akademisi</h3>
                <p class="text-gray-600 text-sm mb-3">Temukan masalah nyata sebagai bahan penelitian dan pengabdian masyarakat, bangun kolaborasi dengan OPD dan UMKM.</p>
                <button onclick="showLoginAlert()" class="text-green-600 font-medium flex items-center text-sm">
                    Pelajari Lebih Lanjut
                    <i class="fas fa-arrow-right ml-2"></i>
                </button>
            </div>
        </div>

        <!-- Baris kedua: 2 card -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <!-- UMKM Card -->
            <div class="bg-orange-50 rounded-lg p-4 shadow-sm border border-orange-100">
                <div class="bg-orange-600 text-white w-10 h-10 rounded-lg flex items-center justify-center mb-3 shadow-sm">
                    <i class="fas fa-store"></i>
                </div>
                <h3 class="text-lg font-bold mb-2 text-orange-800">Untuk UMKM</h3>
                <p class="text-gray-600 text-sm mb-3">Ajukan permasalahan bisnis yang dihadapi, dapatkan solusi inovatif dari akademisi dan dukungan kebijakan dari pemerintah.</p>
                <button onclick="showLoginAlert()" class="text-orange-600 font-medium flex items-center text-sm">
                    Pelajari Lebih Lanjut
                    <i class="fas fa-arrow-right ml-2"></i>
                </button>
            </div>

            <!-- Kolaborasi Card -->
            <div class="bg-purple-50 rounded-lg p-4 shadow-sm border border-purple-100">
                <div class="bg-purple-600 text-white w-10 h-10 rounded-lg flex items-center justify-center mb-3 shadow-sm">
                    <i class="fas fa-users"></i>
                </div>
                <h3 class="text-lg font-bold mb-2 text-purple-800">Proses Kolaborasi</h3>
                <p class="text-gray-600 text-sm mb-3">Temukan bagaimana kolaborasi antara pemerintah, akademisi, dan UMKM dapat menghasilkan solusi yang berdampak.</p>
                <button onclick="showLoginAlert()" class="text-purple-600 font-medium flex items-center text-sm">
                    Pelajari Lebih Lanjut
                    <i class="fas fa-arrow-right ml-2"></i>
                </button>
            </div>
        </div>
    </div>
</section>

<!-- LOGIN MODAL -->
<div id="loginModal" class="fixed inset-0 bg-black/50 hidden items-center justify-center z-50 p-4">
    <div class="bg-white rounded-xl shadow-lg w-full max-w-md p-6 relative">
        <button id="closeModal" class="absolute top-3 right-3 text-gray-500 hover:text-gray-800 text-2xl">&times;</button>
        <h2 class="text-2xl font-bold mb-6 text-center text-blue-600">Login Akun</h2>

        <!-- Ganti dengan Livewire Component -->
        <livewire:auth.user-login />

    </div>
</div>
@endsection

@push('scripts')
<script>
    // Pastikan DOM sudah sepenuhnya dimuat
    document.addEventListener('DOMContentLoaded', function() {
        // Smooth scrolling
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                e.preventDefault();
                const targetId = this.getAttribute('href');
                if (targetId === '#') return;

                const targetElement = document.querySelector(targetId);
                if (targetElement) {
                    targetElement.scrollIntoView({
                        behavior: 'smooth'
                    });
                }
            });
        });

        // Login modal functionality
        const modal = document.getElementById('loginModal');
        const openButtons = document.querySelectorAll('.open-login-modal');
        const closeBtn = document.getElementById('closeModal');

        // Function to open modal
        function openModal(e) {
            e.preventDefault();
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            document.body.style.overflow = 'hidden';
        }

        // Function to close modal
        function closeModal() {
            modal.classList.add('hidden');
            modal.classList.remove('flex');
            document.body.style.overflow = 'auto';
        }

        // Add event listeners to all open buttons
        openButtons.forEach(btn => {
            btn.addEventListener('click', openModal);
        });

        // Add event listener to close button
        if (closeBtn) {
            closeBtn.addEventListener('click', closeModal);
        }

        // Close modal when clicking outside
        window.addEventListener('click', function(e) {
            if (e.target === modal) {
                closeModal();
            }
        });

        // Close modal with Escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && !modal.classList.contains('hidden')) {
                closeModal();
            }
        });
    });

    // Function to show login alert
    function showLoginAlert() {
        const modal = document.getElementById('loginModal');
        modal.classList.remove('hidden');
        modal.classList.add('flex');
        document.body.style.overflow = 'hidden';
    }
</script>
@endpush