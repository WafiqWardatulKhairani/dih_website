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
                }
            }
        }
    }
</script>
<style>
    .card-hover {
        transition: all 0.3s ease;
    }
    .card-hover:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px -8px rgba(0, 0, 0, 0.15);
    }
    .progress-ring {
        transform: rotate(-90deg);
    }
    .progress-ring-circle {
        transition: stroke-dashoffset 1s ease-in-out;
    }
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
<section class="bg-gray-50 py-8">
    <div class="container mx-auto px-4 md:px-12">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            <div class="bg-white text-center p-6 rounded-xl border border-gray-200 card-hover">
                <div class="text-2xl font-bold text-blue-600 mb-2" id="program-counter">{{ $programStats['total_programs'] }}</div>
                <div class="text-gray-600 text-sm font-medium">Total Program</div>
                <div class="text-xs text-green-600 mt-1">{{ $programStats['active_programs'] }} aktif</div>
            </div>
            <div class="bg-white text-center p-6 rounded-xl border border-gray-200 card-hover">
                <div class="text-2xl font-bold text-green-600 mb-2" id="inovasi-counter">{{ $programStats['total_innovations'] }}</div>
                <div class="text-gray-600 text-sm font-medium">Total Inovasi</div>
                <div class="text-xs text-blue-600 mt-1">{{ $programStats['ready_innovations'] }} siap</div>
            </div>
            <div class="bg-white text-center p-6 rounded-xl border border-gray-200 card-hover">
                <div class="text-2xl font-bold text-purple-600 mb-2" id="progress-counter">{{ round($averageProgramProgress) }}%</div>
                <div class="text-gray-600 text-sm font-medium">Progress Rata-rata</div>
                <div class="text-xs text-purple-600 mt-1">Program berjalan</div>
            </div>
            <div class="bg-white text-center p-6 rounded-xl border border-gray-200 card-hover">
                <div class="text-2xl font-bold text-orange-600 mb-2" id="opd-counter">{{ $programStats['active_opd'] }}</div>
                <div class="text-gray-600 text-sm font-medium">OPD Aktif</div>
                <div class="text-xs text-orange-600 mt-1">Terlibat</div>
            </div>
        </div>
    </div>
</section>

{{-- ========== MAIN DASHBOARD GRID ========== --}}
<section class="bg-white py-8">
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
                            <p class="text-sm text-gray-600">Rata-rata progress program</p>
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
                            @foreach($programStatus as $status => $count)
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <span class="text-lg mr-3">
                                        @if($status == 'Berjalan') 🚀
                                        @elseif($status == 'Perencanaan') 📅
                                        @elseif($status == 'Selesai') ✅
                                        @elseif($status == 'Tertunda') ⏸️
                                        @else 📊
                                        @endif
                                    </span>
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
                            @foreach($innovationCategories as $category => $count)
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <span class="text-lg mr-3">
                                        @if(str_contains(strtolower($category), 'digital')) 💻
                                        @elseif(str_contains(strtolower($category), 'layanan')) 🎯
                                        @elseif(str_contains(strtolower($category), 'infrastruktur')) 🏗️
                                        @elseif(str_contains(strtolower($category), 'proses')) ⚙️
                                        @else 💡
                                        @endif
                                    </span>
                                    <span class="text-sm text-gray-700">{{ $category }}</span>
                                </div>
                                <span class="text-sm font-semibold text-gray-900">{{ $count }}</span>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Recent Activities -->
                <div class="bg-white rounded-xl border border-gray-200 p-6">
                    <h3 class="text-xl font-bold text-gray-800 mb-4">Aktivitas Terbaru</h3>
                    <div class="space-y-4">
                        @foreach($recentAchievements as $achievement)
                        <div class="flex items-start">
                            <span class="text-2xl mr-4">{{ $achievement['icon'] }}</span>
                            <div class="flex-1">
                                <p class="text-sm font-medium text-gray-800">{{ $achievement['achievement'] }}</p>
                                <div class="flex items-center text-xs text-gray-500 mt-1">
                                    <span>{{ $achievement['source'] }}</span>
                                    <span class="mx-2">•</span>
                                    <span>{{ $achievement['time'] }}</span>
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
                                <span class="text-blue-600">📋</span>
                            </div>
                            <div>
                                <p class="font-medium text-gray-800">Buat Program</p>
                                <p class="text-xs text-gray-600">Program prioritas daerah</p>
                            </div>
                        </a>

                        <a href="{{ route('pemerintah.inovasi.create') }}" class="flex items-center p-3 rounded-lg border border-green-200 bg-green-50 hover:bg-green-100 transition-colors group">
                            <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center mr-3 group-hover:bg-green-200 transition-colors">
                                <span class="text-green-600">💡</span>
                            </div>
                            <div>
                                <p class="font-medium text-gray-800">Posting Inovasi</p>
                                <p class="text-xs text-gray-600">Solusi digital terbaru</p>
                            </div>
                        </a>

                        <a href="{{ route('program.innovation.list') }}" class="flex items-center p-3 rounded-lg border border-orange-200 bg-orange-50 hover:bg-orange-100 transition-colors group">
                            <div class="w-10 h-10 bg-orange-100 rounded-lg flex items-center justify-center mr-3 group-hover:bg-orange-200 transition-colors">
                                <span class="text-orange-600">🔍</span>
                            </div>
                            <div>
                                <p class="font-medium text-gray-800">Lihat Inovasi</p>
                                <p class="text-xs text-gray-600">Explore semua inovasi</p>
                            </div>
                        </a>

                        <a href="{{ route('program.list') }}" class="flex items-center p-3 rounded-lg border border-purple-200 bg-purple-50 hover:bg-purple-100 transition-colors group">
                            <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center mr-3 group-hover:bg-purple-200 transition-colors">
                                <span class="text-purple-600">📊</span>
                            </div>
                            <div>
                                <p class="font-medium text-gray-800">Lihat Program</p>
                                <p class="text-xs text-gray-600">Kelola program aktif</p>
                            </div>
                        </a>
                    </div>
                </div>

                <!-- System Info -->
                <div class="bg-white rounded-xl border border-gray-200 p-6">
                    <h3 class="text-xl font-bold text-gray-800 mb-4">Informasi Sistem</h3>
                    <div class="space-y-3">
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-700">Status Platform</span>
                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                <span class="w-1.5 h-1.5 bg-green-500 rounded-full mr-1"></span>
                                Aktif
                            </span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-700">Total Data</span>
                            <span class="text-sm font-semibold text-gray-900">
                                {{ $programStats['total_programs'] + $programStats['total_innovations'] }}
                            </span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-700">Update Terakhir</span>
                            <span class="text-sm text-gray-900">{{ now()->format('d/m/Y') }}</span>
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
        // Counter Animation
        const counters = [
            { id: 'program-counter', target: {{ $programStats['total_programs'] }} },
            { id: 'inovasi-counter', target: {{ $programStats['total_innovations'] }} },
            { id: 'progress-counter', target: {{ round($averageProgramProgress) }} },
            { id: 'opd-counter', target: {{ $programStats['active_opd'] }} }
        ];

        counters.forEach(({ id, target }) => {
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
            }, { threshold: 0.5 });

            observer.observe(counter);
        });

        // Progress Ring Animation
        const progressRings = document.querySelectorAll('.progress-ring-circle');
        progressRings.forEach(ring => {
            const radius = ring.r.baseVal.value;
            const circumference = 2 * Math.PI * radius;
            const progress = parseFloat(ring.getAttribute('data-progress') || 0);
            const offset = circumference - (progress / 100) * circumference;

            ring.style.strokeDasharray = `${circumference} ${circumference}`;
            ring.style.strokeDashoffset = circumference;

            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        setTimeout(() => {
                            ring.style.strokeDashoffset = offset;
                        }, 300);
                        observer.unobserve(entry.target);
                    }
                });
            }, { threshold: 0.5 });

            observer.observe(ring);
        });
    });
</script>
@endsection