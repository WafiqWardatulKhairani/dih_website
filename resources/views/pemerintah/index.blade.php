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
@endsection

@section('content')

{{-- ========== HERO SECTION YANG DIPERBAIKI ========== --}}
<section class="hero-bg text-white py-24 md:py-32">
    <div class="container mx-auto px-6 md:px-12 text-center">
        <h1 class="text-4xl md:text-6xl font-extrabold mb-6 leading-tight">
            Portal <span class="text-secondary">OPD</span> Digital Innovation Hub
        </h1>
        <p class="text-xl md:text-2xl max-w-3xl mx-auto mb-10 leading-relaxed">
            Wadah kolaborasi pemerintah daerah dengan akademisi untuk percepatan inovasi digital daerah.
        </p>
        <div class="flex flex-col md:flex-row justify-center gap-4">
            <a href="#program" class="bg-secondary text-white px-8 py-4 rounded-full font-semibold hover:bg-blue-500 transition shadow-lg">
                Jelajahi Program
            </a>
            <a href="#kolaborasi" class="bg-white text-primary px-8 py-4 rounded-full font-semibold hover:bg-gray-100 transition shadow-lg">
                Mulai Berkolaborasi
            </a>
        </div>
    </div>
</section>

{{-- ========== FITUR UTAMA YANG DITINGKATKAN ========== --}}
<section class="bg-white py-20">
    <div class="container mx-auto px-6 md:px-12">
        <div class="text-center mb-16">
            <h2 class="text-3xl md:text-4xl font-bold text-dark mb-4">Layanan Unggulan Kami</h2>
            <p class="text-gray-600 max-w-2xl mx-auto">Platform terintegrasi untuk mendukung inovasi digital pemerintah daerah melalui kolaborasi dengan akademisi</p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-10">
            @php
            $cards = [
                [
                    'title' => 'Program Prioritas', 
                    'desc' => 'Kelola dan pantau program prioritas daerah secara efektif dan transparan.', 
                    'icon' => 'M9 17v-6h13V7a2 2 0 00-2-2H9V3L1 9l8 6v-2h4v2z',
                    'color' => 'text-blue-500'
                ],
                [
                    'title' => 'Bank Solusi Digital', 
                    'desc' => 'Temukan berbagai ide dan solusi inovatif dari berbagai pihak terpercaya.', 
                    'icon' => 'M12 8c-1.657 0-3 1.343-3 3s1.343 3 3 3 3-1.343 3-3-1.343-3-3-3zm0 10c-4.418 0-8-3.582-8-8s3.582-8 8-8 8 3.582 8 8-3.582 8-8 8z',
                    'color' => 'text-green-500'
                ],
                [
                    'title' => 'Kolaborasi Akademisi', 
                    'desc' => 'Jalin kerjasama dengan akademisi untuk penelitian dan pendampingan program.', 
                    'icon' => 'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z',
                    'color' => 'text-purple-500'
                ],
            ];
            @endphp
            
            @foreach($cards as $c)
            <div class="bg-white border border-gray-100 p-8 rounded-2xl shadow-md card-hover">
                <div class="flex items-center justify-center mb-5">
                    <div class="p-4 rounded-xl bg-blue-50">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-10 h-10 {{ $c['color'] }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $c['icon'] }}" />
                        </svg>
                    </div>
                </div>
                <h3 class="text-xl font-semibold mb-3 text-dark">{{ $c['title'] }}</h3>
                <p class="text-gray-600 mb-6">{{ $c['desc'] }}</p>
                <a href="#" class="inline-flex items-center text-primary font-medium hover:text-secondary transition">
                    Selengkapnya
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-1" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M12.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                    </svg>
                </a>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ========== STATISTIK INTERAKTIF ========== --}}
<section class="bg-gradient-to-r from-primary to-secondary py-20 text-white">
    <div class="container mx-auto px-6 md:px-12">
        <h2 class="text-3xl font-bold text-center mb-16">Inovasi Daerah dalam Angka</h2>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-8 text-center">
            @foreach ([
                ['Program Prioritas', '12', 'program'],
                ['Kebutuhan Terdata', '25', 'kebutuhan'],
                ['Solusi Terkirim', '48', 'solusi'],
                ['Kolaborasi Aktif', '15', 'kolaborasi']
            ] as [$label, $val, $id])
            <div class="stat-card bg-white/10 backdrop-blur-sm rounded-xl p-8 border border-white/20">
                <div id="{{ $id }}-counter" class="text-4xl font-extrabold mb-2">0</div>
                <p class="text-lg">{{ $label }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ========== PROGRAM TERBARU & KEBUTUHAN ========== --}}
<section id="program" class="bg-gray-50 py-20">
    <div class="container mx-auto px-6 md:px-12">
        <div class="text-center mb-16">
            <h2 class="text-3xl md:text-4xl font-bold text-dark mb-4">Program & Kebutuhan Terbaru</h2>
            <p class="text-gray-600 max-w-2xl mx-auto">Temukan program prioritas dan kebutuhan inovasi terbaru dari pemerintah daerah</p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-12">
            @for ($i = 1; $i <= 4; $i++)
            <div class="program-card bg-white border border-gray-100 p-8 rounded-2xl shadow-sm">
                <div class="flex justify-between items-start mb-4">
                    <span class="inline-block px-3 py-1 text-sm font-medium bg-blue-100 text-primary rounded-full">
                        Program Prioritas
                    </span>
                    <span class="text-sm text-gray-500">2 hari lalu</span>
                </div>
                <h3 class="text-xl font-semibold text-dark mb-3">
                    Peningkatan Infrastruktur Digital {{ $i }}
                </h3>
                <p class="text-gray-600 mb-6">
                    Membutuhkan solusi inovatif untuk meningkatkan infrastruktur digital daerah guna mendukung smart city dan pelayanan publik digital.
                </p>
                <div class="flex justify-between items-center">
                    <div class="flex items-center">
                        <div class="w-10 h-10 rounded-full bg-blue-500 flex items-center justify-center text-white font-bold">
                            D{{ $i }}
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-dark">Dinas Komunikasi</p>
                            <p class="text-xs text-gray-500">Pemkab Contoh</p>
                        </div>
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
        
        <div class="text-center">
            <a href="#" class="inline-flex items-center px-6 py-3 border border-primary text-primary font-semibold rounded-full hover:bg-primary hover:text-white transition">
                Lihat Semua Program
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M12.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                </svg>
            </a>
        </div>
    </div>
</section>

{{-- ========== BAGIAN KOLABORASI ========== --}}
<section id="kolaborasi" class="bg-white py-20">
    <div class="container mx-auto px-6 md:px-12">
        <div class="bg-gradient-to-r from-primary to-secondary rounded-3xl overflow-hidden shadow-xl">
            <div class="md:flex items-center">
                <div class="md:w-1/2 p-12 text-white">
                    <h3 class="text-3xl font-bold mb-4">Akademisi? Mari Berkolaborasi!</h3>
                    <p class="text-blue-100 mb-8">
                        Daftarkan diri Anda atau institusi untuk berpartisipasi dalam program penelitian dan pengabdian masyarakat. Bersama kita wujudkan inovasi digital untuk kemajuan daerah.
                    </p>
                    <ul class="space-y-3 mb-8">
                        <li class="flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-blue-200" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                            </svg>
                            Akses ke data dan kebutuhan riil pemerintah daerah
                        </li>
                        <li class="flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-blue-200" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                            </svg>
                            Pendanaan untuk penelitian dan pengembangan
                        </li>
                        <li class="flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-blue-200" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                            </svg>
                            Jejaring dengan praktisi dan decision maker
                        </li>
                    </ul>
                    <a href="#" class="inline-block bg-white text-primary px-8 py-3 rounded-full font-semibold hover:bg-blue-50 transition shadow-lg">
                        Daftar Sekarang
                    </a>
                </div>
                <div class="md:w-1/2 hidden md:block">
                    <img src="https://images.unsplash.com/photo-1522202176988-66273c2fd55f?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" alt="Kolaborasi" class="w-full h-96 object-cover">
                </div>
            </div>
            </div>
    </div>
</section>

@endsection

@section('scripts')
<script>
    // Animasi counter untuk statistik
    document.addEventListener('DOMContentLoaded', function() {
        const counters = document.querySelectorAll('[id$="-counter"]');
        const speed = 200;
        
        counters.forEach(counter => {
            const target = +counter.getAttribute('data-target') || 
                (counter.id === 'program-counter' ? 12 :
                counter.id === 'kebutuhan-counter' ? 25 :
                counter.id === 'solusi-counter' ? 48 : 15);
            
            let count = 0;
            const updateCount = () => {
                const increment = target / speed;
                if (count < target) {
                    count += increment;
                    counter.innerText = Math.ceil(count);
                    setTimeout(updateCount, 1);
                } else {
                    counter.innerText = target;
                }
            };
            updateCount();
        });
    });
</script>
@endsection