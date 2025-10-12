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
                    light: '#f8fafc',
                    blue: {
                        50: '#eff6ff',
                        100: '#dbeafe',
                        500: '#3b82f6',
                        600: '#2563eb',
                        700: '#1d4ed8',
                        800: '#1e40af',
                        900: '#1e3a8a'
                    }
                }
            }
        }
    }
</script>
<style>

</style>
@endsection

@section('content')

{{-- ========== DASHBOARD HEADER ========== --}}
<section class="bg-gradient-to-r from-blue-50 to-indigo-50 border-b border-blue-100">
    <div class="container mx-auto px-4 md:px-12 py-8">
        <div class="max-w-6xl mx-auto">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6">
                <div>
                    <nav class="flex items-center space-x-2 text-sm text-gray-500 mb-2">
                        <a href="#" class="hover:text-blue-600 transition">Dashboard</a>
                        <span>/</span>
                        <span class="text-gray-700 font-medium">Portal Inovasi</span>
                    </nav>
                    <h1 class="text-2xl md:text-3xl font-bold text-gray-900">Overview Dashboard</h1>
                </div>
                <div class="flex items-center space-x-6 mt-4 md:mt-0">
                    <div class="text-right">
                        <div class="text-sm text-gray-500">Hari Ini</div>
                        <div class="text-lg font-semibold text-gray-900">{{ now()->format('d M Y') }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ========== QUICK STATS ========== --}}
<section class="bg-white border-b border-gray-100 py-8">
    <div class="container mx-auto px-4 md:px-12">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
            <div class="text-center p-6 rounded-xl border border-gray-100 card-hover">
                <div class="text-2xl md:text-3xl font-bold text-blue-600 mb-2" id="program-counter">0</div>
                <div class="text-gray-600 text-sm font-medium">Program Aktif</div>
                <div class="text-xs text-green-600 mt-1">+2 baru</div>
            </div>
            <div class="text-center p-6 rounded-xl border border-gray-100 card-hover">
                <div class="text-2xl md:text-3xl font-bold text-green-600 mb-2" id="inovasi-counter">0</div>
                <div class="text-gray-600 text-sm font-medium">Inovasi</div>
                <div class="text-xs text-blue-600 mt-1">Terealisasi</div>
            </div>
            <div class="text-center p-6 rounded-xl border border-gray-100 card-hover">
                <div class="text-2xl md:text-3xl font-bold text-purple-600 mb-2" id="kolaborasi-counter">0</div>
                <div class="text-gray-600 text-sm font-medium">Kolaborasi</div>
                <div class="text-xs text-purple-600 mt-1">Aktif</div>
            </div>
            <div class="text-center p-6 rounded-xl border border-gray-100 card-hover">
                <div class="text-2xl md:text-3xl font-bold text-orange-600 mb-2" id="opd-counter">0</div>
                <div class="text-gray-600 text-sm font-medium">OPD</div>
                <div class="text-xs text-orange-600 mt-1">Terlibat</div>
            </div>
        </div>
    </div>
</section>

{{-- ========== FITUR UTAMA ========== --}}
<section class="bg-gray-50 py-6">
    <div class="container mx-auto px-4 md:px-12">
        <div class="text-center mb-12">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-800 mb-4">Layanan Unggulan Platform</h2>
            <p class="text-gray-600 max-w-2xl mx-auto text-lg">Solusi terintegrasi untuk mendukung percepatan inovasi digital pemerintah daerah</p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Feature 1 -->
            <div class="bg-white border border-gray-200 p-8 rounded-2xl shadow-sm card-hover group">
                <div class="flex items-center justify-center mb-6">
                    <div class="p-4 rounded-2xl bg-gradient-to-r from-blue-500 to-cyan-500 transform group-hover:scale-110 transition-transform duration-300">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-6h13V7a2 2 0 00-2-2H9V3L1 9l8 6v-2h4v2z" />
                        </svg>
                    </div>
                </div>
                <h3 class="text-xl font-semibold mb-4 text-gray-800 text-center">Manajemen Program Prioritas</h3>
                <p class="text-gray-600 mb-6 text-center leading-relaxed">Kelola dan pantau program prioritas daerah secara real-time dengan dashboard yang komprehensif.</p>
            </div>

            <!-- Feature 2 -->
            <div class="bg-white border border-gray-200 p-8 rounded-2xl shadow-sm card-hover group">
                <div class="flex items-center justify-center mb-6">
                    <div class="p-4 rounded-2xl bg-gradient-to-r from-green-500 to-emerald-500 transform group-hover:scale-110 transition-transform duration-300">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 1.343-3 3s1.343 3 3 3 3-1.343 3-3-1.343-3-3-3zm0 10c-4.418 0-8-3.582-8-8s3.582-8 8-8 8 3.582 8 8-3.582 8-8 8z" />
                        </svg>
                    </div>
                </div>
                <h3 class="text-xl font-semibold mb-4 text-gray-800 text-center">Repository Solusi Digital</h3>
                <p class="text-gray-600 mb-6 text-center leading-relaxed">Akses katalog solusi digital terverifikasi dari berbagai provider terpercaya.</p>
            </div>

            <!-- Feature 3 -->
            <div class="bg-white border border-gray-200 p-8 rounded-2xl shadow-sm card-hover group">
                <div class="flex items-center justify-center mb-6">
                    <div class="p-4 rounded-2xl bg-gradient-to-r from-purple-500 to-pink-500 transform group-hover:scale-110 transition-transform duration-300">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                    </div>
                </div>
                <h3 class="text-xl font-semibold mb-4 text-gray-800 text-center">Kolaborasi Akademisi</h3>
                <p class="text-gray-600 mb-6 text-center leading-relaxed">Jalin kemitraan strategis dengan akademisi untuk penelitian dan pengembangan solusi.</p>
            </div>
        </div>
    </div>
</section>

{{-- ========== MAIN DASHBOARD GRID ========== --}}
<section class="bg-gray-50 py-12">
    <div class="container mx-auto px-4 md:px-12">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

            {{-- LEFT COLUMN - PERFORMANCE METRICS --}}
            <div class="lg:col-span-2 space-y-8">

                <!-- Progress Overview -->
                <div class="bg-white rounded-xl border border-gray-200 p-6">
                    <h3 class="text-xl font-bold text-gray-800 mb-6">Progress Program & Inovasi</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Program Progress -->
                        <div class="text-center">
                            <div class="relative inline-block mb-4">
                                <svg class="w-24 h-24 progress-ring" viewBox="0 0 100 100">
                                    <circle class="text-gray-200" stroke-width="8" stroke="currentColor" fill="transparent" r="42" cx="50" cy="50" />
                                    <circle class="text-blue-600 progress-ring-circle"
                                        stroke-width="8"
                                        stroke-dasharray="264"
                                        stroke-dashoffset="264"
                                        data-progress="{{ $averageProgramProgress }}"
                                        stroke-linecap="round"
                                        stroke="currentColor"
                                        fill="transparent"
                                        r="42"
                                        cx="50"
                                        cy="50" />
                                </svg>
                                <div class="absolute inset-0 flex items-center justify-center">
                                    <span class="text-2xl font-bold text-gray-800">{{ round($averageProgramProgress) }}%</span>
                                </div>
                            </div>
                            <h4 class="font-semibold text-gray-800 mb-2">Program Prioritas</h4>
                            <p class="text-sm text-gray-600">Rata-rata progress program daerah</p>
                        </div>

                        <!-- Innovation Impact -->
                        <div class="text-center">
                            <div class="relative inline-block mb-4">
                                <svg class="w-24 h-24 progress-ring" viewBox="0 0 100 100">
                                    <circle class="text-gray-200" stroke-width="8" stroke="currentColor" fill="transparent" r="42" cx="50" cy="50" />
                                    <circle class="text-green-600 progress-ring-circle"
                                        stroke-width="8"
                                        stroke-dasharray="264"
                                        stroke-dashoffset="264"
                                        data-progress="{{ $innovationImpact }}"
                                        stroke-linecap="round"
                                        stroke="currentColor"
                                        fill="transparent"
                                        r="42"
                                        cx="50"
                                        cy="50" />
                                </svg>
                                <div class="absolute inset-0 flex items-center justify-center">
                                    <span class="text-2xl font-bold text-gray-800">{{ round($innovationImpact) }}%</span>
                                </div>
                            </div>
                            <h4 class="font-semibold text-gray-800 mb-2">Dampak Inovasi</h4>
                            <p class="text-sm text-gray-600">Tingkat keberhasilan implementasi</p>
                        </div>
                    </div>
                </div>

                <!-- Quick Metrics -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Program Status -->
                    <div class="bg-white rounded-xl border border-gray-200 p-6">
                        <h4 class="font-semibold text-gray-800 mb-4">Status Program</h4>
                        <div class="space-y-3">
                            @foreach([
                            ['Berjalan', 8, 'blue', '🚀'],
                            ['Perencanaan', 3, 'yellow', '📅'],
                            ['Selesai', 5, 'green', '✅'],
                            ['Tertunda', 1, 'red', '⏸️']
                            ] as [$status, $count, $color, $icon])
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <span class="text-lg mr-3">{{ $icon }}</span>
                                    <span class="text-sm text-gray-700">{{ $status }}</span>
                                </div>
                                <span class="text-sm font-semibold text-gray-900">{{ $count }}</span>
                            </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Innovation Categories -->
                    <div class="bg-white rounded-xl border border-gray-200 p-6">
                        <h4 class="font-semibold text-gray-800 mb-4">Kategori Inovasi</h4>
                        <div class="space-y-3">
                            @foreach([
                            ['Digital', 12, '💻'],
                            ['Layanan', 8, '🎯'],
                            ['Infrastruktur', 6, '🏗️'],
                            ['Proses', 4, '⚙️']
                            ] as [$category, $count, $icon])
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <span class="text-lg mr-3">{{ $icon }}</span>
                                    <span class="text-sm text-gray-700">{{ $category }}</span>
                                </div>
                                <span class="text-sm font-semibold text-gray-900">{{ $count }}</span>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Recent Achievements -->
                <div class="bg-white rounded-xl border border-gray-200 p-6">
                    <h3 class="text-xl font-bold text-gray-800 mb-4">Pencapaian Terbaru</h3>
                    <div class="space-y-4">
                        @foreach([
                        ['Program Smart City mencapai 85% progress', 'Dinas Kominfo', 'Hari ini', '🏆'],
                        ['Inovasi e-Layanan tersertifikasi nasional', 'Dinas Penanaman Modal', '2 hari lalu', '⭐'],
                        ['Kolaborasi dengan 3 universitas terealisasi', 'Tim Inovasi', '1 minggu lalu', '🤝'],
                        ['5 OPD baru bergabung platform', 'Admin System', '2 minggu lalu', '👥']
                        ] as [$achievement, $source, $time, $icon])
                        <div class="flex items-start">
                            <span class="text-2xl mr-4">{{ $icon }}</span>
                            <div class="flex-1">
                                <p class="text-sm font-medium text-gray-800">{{ $achievement }}</p>
                                <div class="flex items-center text-xs text-gray-500 mt-1">
                                    <span>{{ $source }}</span>
                                    <span class="mx-2">•</span>
                                    <span>{{ $time }}</span>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- RIGHT COLUMN - QUICK ACTIONS & INFO --}}
            <div class="space-y-8">

                <!-- Quick Actions -->
                <div class="bg-white rounded-xl border border-gray-200 p-6">
                    <h3 class="text-xl font-bold text-gray-800 mb-4">Aksi Cepat</h3>
                    <div class="space-y-3">
                        <a href="{{ route('pemerintah.program.create') }}" class="flex items-center p-3 rounded-lg border border-blue-200 bg-blue-50 hover:bg-blue-100 transition-colors group">
                            <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center mr-3 group-hover:bg-blue-200 transition-colors">
                                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                </svg>
                            </div>
                            <div>
                                <p class="font-medium text-gray-800">Buat Program Baru</p>
                                <p class="text-xs text-gray-600">Posting program prioritas</p>
                            </div>
                        </a>

                        <a href="{{ route('pemerintah.inovasi.create') }}" class="flex items-center p-3 rounded-lg border border-green-200 bg-green-50 hover:bg-green-100 transition-colors group">
                            <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center mr-3 group-hover:bg-green-200 transition-colors">
                                <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                                </svg>
                            </div>
                            <div>
                                <p class="font-medium text-gray-800">Posting Inovasi</p>
                                <p class="text-xs text-gray-600">Bagikan karya inovasi</p>
                            </div>
                        </a>

                        <!-- TAMBAHAN BARU: Lihat Semua Inovasi -->
                        <a href="{{ route('program.innovation.list') }}" class="flex items-center p-3 rounded-lg border border-orange-200 bg-orange-50 hover:bg-orange-100 transition-colors group">
                            <div class="w-10 h-10 bg-orange-100 rounded-lg flex items-center justify-center mr-3 group-hover:bg-orange-200 transition-colors">
                                <svg class="w-5 h-5 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
                                </svg>
                            </div>
                            <div>
                                <p class="font-medium text-gray-800">Lihat Semua Inovasi</p>
                                <p class="text-xs text-gray-600">Explore karya inovatif</p>
                            </div>
                        </a>

                        <a href="{{ route('program.list') }}" class="flex items-center p-3 rounded-lg border border-purple-200 bg-purple-50 hover:bg-purple-100 transition-colors group">
                            <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center mr-3 group-hover:bg-purple-200 transition-colors">
                                <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                </svg>
                            </div>
                            <div>
                                <p class="font-medium text-gray-800">Lihat Semua Program</p>
                                <p class="text-xs text-gray-600">Kelola program aktif</p>
                            </div>
                        </a>


                    </div>
                </div>
                <!-- System Health -->
                <div class="bg-white rounded-xl border border-gray-200 p-6">
                    <h3 class="text-xl font-bold text-gray-800 mb-4">Status Sistem</h3>
                    <div class="space-y-3">
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-700">Platform</span>
                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                <span class="w-1.5 h-1.5 bg-green-500 rounded-full mr-1"></span>
                                Online
                            </span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-700">Database</span>
                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                <span class="w-1.5 h-1.5 bg-green-500 rounded-full mr-1"></span>
                                Normal
                            </span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-700">Pengguna Aktif</span>
                            <span class="text-sm font-semibold text-gray-900">247</span>
                        </div>
                    </div>
                </div>
            </div>


        </div>
    </div>
</section>

@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // ========== COUNTER ANIMATION ==========
        const counters = [{
                id: 'program-counter',
                target: {
                    {
                        $programStats['active_programs']
                    }
                }
            },
            {
                id: 'inovasi-counter',
                target: {
                    {
                        $programStats['total_innovations']
                    }
                }
            },
            {
                id: 'kolaborasi-counter',
                target: {
                    {
                        $programStats['active_collaborations']
                    }
                }
            },
            {
                id: 'opd-counter',
                target: {
                    {
                        $programStats['active_opd']
                    }
                }
            }
        ];

        counters.forEach(({
            id,
            target
        }) => {
            const counter = document.getElementById(id);
            if (!counter) return;

            let count = 0;
            const duration = 1500;
            const increment = target / (duration / 16);

            const updateCount = () => {
                if (count < target) {
                    count += increment;
                    counter.innerText = Math.min(Math.ceil(count), target);
                    requestAnimationFrame(updateCount);
                } else {
                    counter.innerText = target;
                }
            };

            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        updateCount();
                        observer.unobserve(entry.target);
                    }
                });
            }, {
                threshold: 0.5
            });

            observer.observe(counter);
        });

        // ========== PROGRESS RING ANIMATION ==========
        const progressRings = document.querySelectorAll('.progress-ring-circle');
        progressRings.forEach(ring => {
            const radius = ring.r.baseVal.value;
            const circumference = 2 * Math.PI * radius;

            ring.style.strokeDasharray = `${circumference} ${circumference}`;
            ring.style.strokeDashoffset = circumference;

            // Animate progress rings when they come into view
            const ringObserver = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        const progress = parseFloat(ring.getAttribute('data-progress') || 0);
                        const offset = circumference - (progress / 100) * circumference;
                        ring.style.transition = 'stroke-dashoffset 1s ease-in-out';
                        ring.style.strokeDashoffset = offset;
                        ringObserver.unobserve(entry.target);
                    }
                });
            }, {
                threshold: 0.5
            });

            ringObserver.observe(ring);
        });

        // ========== SMOOTH SCROLL FOR ANCHOR LINKS ==========
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });

        // ========== CARD HOVER EFFECTS ==========
        const cards = document.querySelectorAll('.card-hover');
        cards.forEach(card => {
            card.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-5px)';
                this.style.boxShadow = '0 20px 40px rgba(0, 0, 0, 0.1)';
            });

            card.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0)';
                this.style.boxShadow = '';
            });
        });

        // ========== REAL-TIME UPDATES (OPTIONAL) ==========
        function updateDashboardStats() {
            // Ini bisa digunakan untuk real-time updates jika diperlukan
            // Misalnya dengan WebSockets atau periodic AJAX calls
            console.log('Dashboard stats updated at:', new Date().toLocaleTimeString());
        }

        // Update setiap 5 menit (optional)
        // setInterval(updateDashboardStats, 300000);
    });

    // ========== PROGRESS RING HELPER FUNCTION ==========
    function setProgressRing(ringElement, progress) {
        const radius = ringElement.r.baseVal.value;
        const circumference = 2 * Math.PI * radius;
        const offset = circumference - (progress / 100) * circumference;

        ringElement.style.strokeDasharray = `${circumference} ${circumference}`;
        ringElement.style.strokeDashoffset = offset;
        ringElement.setAttribute('data-progress', progress);
    }
</script>
@endsection