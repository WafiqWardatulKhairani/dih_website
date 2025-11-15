@extends('layouts.app')

@section('title', 'Dashboard Akademisi')

@push('styles')
<script src="https://cdn.tailwindcss.com"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<style>
    body {
        background-color: #f9fafb;
    }
    .scrolling-wrapper {
        display: flex;
        overflow-x: auto;
        gap: 1rem;
        scroll-behavior: smooth;
    }
    .scrolling-wrapper::-webkit-scrollbar {
        height: 6px;
    }
    .scrolling-wrapper::-webkit-scrollbar-thumb {
        background: #93c5fd;
        border-radius: 4px;
    }
    .card-link { 
        display: block; 
        text-decoration: none; 
        color: inherit; 
    }
    .card-link:hover .card-shadow {
        box-shadow: 0 10px 25px rgba(0,0,0,0.12);
        transform: translateY(-2px);
        transition: all 0.3s ease-in-out;
    }
    .sidebar-sticky {
        position: sticky;
        top: 2rem;
    }
    .gradient-bg {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    }
    .stat-card {
        background: linear-gradient(135deg, #ffffff 0%, #f8faff 100%);
        border: 1px solid #e1e8ff;
    }
    .quick-action-card {
        background: white;
        border-left: 4px solid;
        transition: all 0.3s ease;
    }
    .quick-action-card:hover {
        transform: translateX(5px);
        box-shadow: 0 10px 25px rgba(0,0,0,0.1);
    }
    .activity-link:hover {
        background-color: #f8fafc;
        cursor: pointer;
    }
    .progress-link:hover {
        cursor: pointer;
    }
    .innovation-image {
        width: 100%;
        height: 120px;
        object-fit: cover;
        border-radius: 8px;
        margin-bottom: 12px;
    }
    .default-image {
        width: 100%;
        height: 120px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 8px;
        margin-bottom: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 14px;
    }
</style>
@endpush

@section('content')
<div class="max-w-7xl mx-auto px-6 py-10">
    <div class="flex flex-col lg:flex-row gap-8">
        
        {{-- ========== MAIN CONTENT ========== --}}
        <div class="flex-1">
            {{-- HEADER --}}
            <div class="bg-white rounded-2xl shadow-sm p-6 mb-8 gradient-bg text-white">
                <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between">
                    <div>
                        <h1 class="text-3xl font-bold mb-2">
                            Selamat Datang, {{ Auth::user()->name ?? 'Akademisi' }} 👋
                        </h1>
                        <p class="text-blue-100 opacity-90">
                            Berikut ringkasan aktivitas, inovasi, dan kolaborasi akademikmu di Digital Innovation Hub.
                        </p>
                        <div class="mt-3 flex flex-wrap gap-2">
                            <span class="inline-block bg-white bg-opacity-20 text-white px-3 py-1 text-xs font-medium rounded-full">
                                {{ ucfirst(Auth::user()->role ?? 'User') }}
                            </span>
                            @if(isset($badge))
                            <span class="inline-block bg-green-500 bg-opacity-20 text-white px-3 py-1 text-xs font-medium rounded-full">
                                {{ $badge }}
                            </span>
                            @endif
                        </div>
                    </div>
                    <div class="mt-4 sm:mt-0">
                        <div class="text-right">
                            <p class="text-blue-100 text-sm">Hari Ini</p>
                            <p class="text-xl font-semibold">{{ now()->format('d F Y') }}</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- STATISTIC CARDS --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">
                <x-stat-card title="Inovasi Saya" value="{{ $stat['inovasi'] }}" icon="fa-lightbulb" color="yellow" />
                <x-stat-card title="Ide Kolaborasi" value="{{ $stat['kolaborasi_ide'] }}" icon="fa-users-gear" color="blue" />
                <x-stat-card title="Kolaborasi Diikuti" value="{{ $stat['kolaborasi_member'] }}" icon="fa-people-group" color="indigo" />
                <x-stat-card title="Tugas Kolaborasi" value="{{ $stat['kolaborasi_task'] }}" icon="fa-list-check" color="emerald" />
            </div>

            {{-- GRAFIK TREN & KATEGORI --}}
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-10">
                {{-- Tren Seluruh User --}}
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                    <h2 class="text-lg font-semibold text-blue-900 mb-3">Tren Inovasi & Kolaborasi Bulanan</h2>
                    <canvas id="trendAllChart" height="150"></canvas>
                </div>
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                    <h2 class="text-lg font-semibold text-blue-900 mb-3">Kategori Inovasi</h2>
                    <canvas id="kategoriAllChart" height="150"></canvas>
                </div>
            </div>

            {{-- GRAFIK SAYA --}}
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-10">
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                    <h2 class="text-lg font-semibold text-blue-900 mb-3">Tren Inovasi & Kolaborasi Bulanan Saya</h2>
                    <canvas id="trendMyChart" height="150"></canvas>
                </div>
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                    <h2 class="text-lg font-semibold text-blue-900 mb-3">Kategori Inovasi Terfavorit Saya</h2>
                    <canvas id="kategoriMyChart" height="150"></canvas>
                </div>
            </div>

            {{-- VISUALISASI TAMBAHAN --}}
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-10">
                {{-- Progress Kolaborasi --}}
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                    <h2 class="text-lg font-semibold text-blue-900 mb-3">Progress Kolaborasi Aktif</h2>
                    <div class="space-y-4">
                        @forelse($progressKolaborasi as $progress)
                        <a href="{{ route('kolaborasi.ide.show', $progress->id) }}" class="block progress-link">
                            <div>
                                <div class="flex justify-between text-sm mb-1">
                                    <span class="font-medium text-gray-700">{{ $progress->judul }}</span>
                                    <span class="text-blue-600">{{ $progress->progress }}%</span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-2">
                                    <div class="bg-green-500 h-2 rounded-full" style="width: {{ $progress->progress }}%"></div>
                                </div>
                            </div>
                        </a>
                        @empty
                        <p class="text-gray-500 text-sm">Tidak ada kolaborasi aktif</p>
                        @endforelse
                    </div>
                </div>

                {{-- Aktivitas Terbaru --}}
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                    <h2 class="text-lg font-semibold text-blue-900 mb-3">Aktivitas Terbaru</h2>
                    <div class="space-y-3">
                        @forelse($aktivitasTerbaru as $aktivitas)
                        <a href="{{ $aktivitas->link ?? '#' }}" class="block activity-link p-2 rounded-lg transition">
                            <div class="flex items-start space-x-3">
                                <div class="w-2 h-2 bg-blue-500 rounded-full mt-2"></div>
                                <div class="flex-1">
                                    <p class="text-sm text-gray-700">{{ $aktivitas->deskripsi }}</p>
                                    <p class="text-xs text-gray-500">{{ $aktivitas->waktu }}</p>
                                </div>
                            </div>
                        </a>
                        @empty
                        <p class="text-gray-500 text-sm">Belum ada aktivitas</p>
                        @endforelse
                    </div>
                </div>
            </div>

            {{-- SCROLLING CARDS SECTIONS --}}
            <div class="space-y-10">
                {{-- Inovasi Saya --}}
                <div>
                    <div class="flex justify-between items-center mb-3">
                        <h2 class="text-xl font-semibold text-blue-900">Inovasi Saya</h2>
                        <a href="{{ route('akademisi.inovasi.index') }}" class="text-sm text-blue-600 hover:underline font-medium">Lihat Semua</a>
                    </div>
                    <div class="scrolling-wrapper pb-2">
                        @forelse($inovasiSaya as $item)
                            <a href="{{ route('akademisi.inovasi.show', $item->id) }}" class="card-link">
                                <div class="min-w-[280px] bg-white rounded-xl shadow-sm p-4 card-shadow border border-gray-100">
                                    {{-- Image --}}
                                    @if($item->image_path)
                                        <img src="{{ asset('storage/' . $item->image_path) }}" alt="{{ $item->title }}" class="innovation-image">
                                    @else
                                        <div class="default-image">
                                            <span>No Image</span>
                                        </div>
                                    @endif
                                    
                                    <div class="flex items-center justify-between mb-2">
                                        <span class="text-xs font-medium px-2 py-1 bg-blue-100 text-blue-700 rounded-full">{{ $item->kategori ?? 'Umum' }}</span>
                                        <span class="text-xs text-gray-500">{{ $item->created_at }}</span>
                                    </div>
                                    <h3 class="font-semibold text-gray-800 mb-2 line-clamp-2">{{ $item->title }}</h3>
                                    <p class="text-sm text-gray-500 mb-3">{{ $item->author_name }}</p>
                                    <div class="mt-2">
                                        <p class="text-xs text-gray-600 mb-1">TKT: {{ $item->technology_readiness_level }}</p>
                                        <div class="w-full bg-gray-200 rounded-full h-2">
                                            <div class="bg-blue-600 h-2 rounded-full" style="width: {{ ($item->technology_readiness_level ?? 0) * 10 }}%"></div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        @empty
                            <div class="min-w-[280px] bg-gray-50 rounded-xl p-6 text-center border border-gray-200">
                                <p class="text-gray-500 text-sm">Belum ada inovasi yang diposting.</p>
                                <a href="{{ route('akademisi.inovasi.index') }}" class="text-blue-600 text-sm font-medium mt-2 inline-block">Buat Inovasi Pertamamu</a>
                            </div>
                        @endforelse
                    </div>
                </div>

                {{-- Diskusi Terpopuler --}}
                <div>
                    <div class="flex justify-between items-center mb-3">
                        <h2 class="text-xl font-semibold text-blue-900">Diskusi Terpopuler</h2>
                        <a href="{{ route('forum-diskusi.index') }}" class="text-sm text-blue-600 hover:underline font-medium">Lihat Semua</a>
                    </div>
                    <div class="scrolling-wrapper pb-2">
                        @forelse($diskusiTerpopuler as $diskusi)
                            <a href="{{ route('forum-diskusi.detail', ['type' => $diskusi->type, 'id' => $diskusi->id]) }}" class="card-link">
                                <div class="min-w-[280px] bg-white rounded-xl shadow-sm p-4 card-shadow border border-gray-100">
                                    {{-- Image --}}
                                    @if($diskusi->image_path)
                                        <img src="{{ asset('storage/' . $diskusi->image_path) }}" alt="{{ $diskusi->title }}" class="innovation-image">
                                    @elseif($diskusi->image)
                                        <img src="{{ asset('storage/' . $diskusi->image) }}" alt="{{ $diskusi->title }}" class="innovation-image">
                                    @else
                                        <div class="default-image">
                                            <span>No Image</span>
                                        </div>
                                    @endif
                                    
                                    <div class="flex items-center justify-between mb-2">
                                        <span class="text-xs font-medium px-2 py-1 bg-purple-100 text-purple-700 rounded-full">{{ ucfirst($diskusi->type) }}</span>
                                        <span class="text-xs text-gray-500">{{ $diskusi->created_at }}</span>
                                    </div>
                                    <h3 class="font-semibold text-gray-800 mb-2 line-clamp-2">{{ $diskusi->title }}</h3>
                                    <p class="text-sm text-gray-500 mb-1">{{ $diskusi->author_name }}</p>
                                    <div class="flex items-center justify-between mt-3">
                                        <span class="text-xs text-gray-600">
                                            <i class="fas fa-comment mr-1"></i>
                                            {{ $diskusi->jumlah_komentar }} Komentar
                                        </span>
                                    </div>
                                </div>
                            </a>
                        @empty
                            <div class="min-w-[280px] bg-gray-50 rounded-xl p-6 text-center border border-gray-200">
                                <p class="text-gray-500 text-sm">Belum ada diskusi populer.</p>
                            </div>
                        @endforelse
                    </div>
                </div>

                {{-- Kolaborasi Berjalan --}}
                <div>
                    <div class="flex justify-between items-center mb-3">
                        <h2 class="text-xl font-semibold text-blue-900">Kolaborasi Berjalan</h2>
                        <a href="{{ route('kolaborasi.index') }}" class="text-sm text-blue-600 hover:underline font-medium">Lihat Semua</a>
                    </div>
                    <div class="scrolling-wrapper pb-2">
                        @forelse($kolaborasiBerjalan as $kolab)
                            <a href="{{ route('kolaborasi.ide.show', $kolab->id) }}" class="card-link">
                                <div class="min-w-[280px] bg-white rounded-xl shadow-sm p-4 card-shadow border border-gray-100">
                                    <div class="flex items-center justify-between mb-2">
                                        <span class="text-xs font-medium px-2 py-1 
                                            {{ $kolab->status == 'active' ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700' }} rounded-full">
                                            {{ ucfirst($kolab->status) }}
                                        </span>
                                        <span class="text-xs text-gray-500">{{ $kolab->deadline ? 'Selesai: '.$kolab->deadline : 'Tanpa deadline' }}</span>
                                    </div>
                                    <h3 class="font-semibold text-gray-800 mb-2">{{ $kolab->judul }}</h3>
                                    <p class="text-sm text-gray-500 mb-3">{{ $kolab->deskripsi_singkat }}</p>
                                    <div class="flex items-center justify-between">
                                        <span class="text-xs text-gray-600">
                                            <i class="fas fa-users mr-1"></i>
                                            {{ $kolab->jumlah_anggota }} Anggota
                                        </span>
                                        <span class="text-xs text-gray-600">
                                            <i class="fas fa-tasks mr-1"></i>
                                            {{ $kolab->jumlah_tugas }} Tugas
                                        </span>
                                    </div>
                                </div>
                            </a>
                        @empty
                            <div class="min-w-[280px] bg-gray-50 rounded-xl p-6 text-center border border-gray-200">
                                <p class="text-gray-500 text-sm">Belum ada kolaborasi berjalan.</p>
                                <a href="{{ route('kolaborasi.index') }}" class="text-blue-600 text-sm font-medium mt-2 inline-block">Temukan Kolaborasi</a>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>

        {{-- ========== SIDEBAR AKSES CEPAT ========== --}}
        <div class="lg:w-80">
            <div class="sidebar-sticky">
                {{-- Quick Actions --}}
                <div class="bg-white rounded-2xl shadow-sm p-6 mb-6 border border-gray-100">
                    <h2 class="text-xl font-semibold text-blue-900 mb-5">Akses Cepat</h2>
                    <div class="space-y-4">
                        <a href="{{ route('akademisi.inovasi.create') }}" 
                           class="quick-action-card block p-4 rounded-lg border-l-4 border-blue-500">
                            <div class="flex items-center">
                                <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center mr-3">
                                    <i class="fas fa-plus text-blue-600"></i>
                                </div>
                                <div>
                                    <h3 class="font-semibold text-gray-800">Tambah Inovasi</h3>
                                    <p class="text-sm text-gray-500">Buat inovasi baru</p>
                                </div>
                            </div>
                        </a>

                        <a href="{{ route('forum-diskusi.index') }}" 
                           class="quick-action-card block p-4 rounded-lg border-l-4 border-indigo-500">
                            <div class="flex items-center">
                                <div class="w-10 h-10 bg-indigo-100 rounded-lg flex items-center justify-center mr-3">
                                    <i class="fas fa-comments text-indigo-600"></i>
                                </div>
                                <div>
                                    <h3 class="font-semibold text-gray-800">Bergabung Diskusi</h3>
                                    <p class="text-sm text-gray-500">Diskusi terbaru</p>
                                </div>
                            </div>
                        </a>

                        <a href="{{ route('kolaborasi.index') }}" 
                           class="quick-action-card block p-4 rounded-lg border-l-4 border-emerald-500">
                            <div class="flex items-center">
                                <div class="w-10 h-10 bg-emerald-100 rounded-lg flex items-center justify-center mr-3">
                                    <i class="fas fa-users text-emerald-600"></i>
                                </div>
                                <div>
                                    <h3 class="font-semibold text-gray-800">Buat Kolaborasi</h3>
                                    <p class="text-sm text-gray-500">Kolaborasi baru</p>
                                </div>
                            </div>
                        </a>

                        <a href="{{ route('akademisi.profil-akademik') }}" 
                           class="quick-action-card block p-4 rounded-lg border-l-4 border-purple-500">
                            <div class="flex items-center">
                                <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center mr-3">
                                    <i class="fas fa-user text-purple-600"></i>
                                </div>
                                <div>
                                    <h3 class="font-semibold text-gray-800">Profil Saya</h3>
                                    <p class="text-sm text-gray-500">Kelola profil</p>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>

                {{-- Pencapaian --}}
                <div class="bg-white rounded-2xl shadow-sm p-6 border border-gray-100">
                    <h2 class="text-xl font-semibold text-blue-900 mb-4">Pencapaian</h2>
                    <div class="space-y-4">
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-600">Inovasi Dibuat</span>
                            <span class="font-semibold text-blue-600">{{ $stat['inovasi'] }}</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-600">Kolaborasi Aktif</span>
                            <span class="font-semibold text-green-600">{{ $stat['kolaborasi_aktif'] ?? 0 }}</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-600">Diskusi Diikuti</span>
                            <span class="font-semibold text-purple-600">{{ $stat['diskusi_diikuti'] ?? 0 }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- CHART SCRIPTS --}}
<script>
    // Chart untuk seluruh user
    const trendAllCtx = document.getElementById('trendAllChart');
    new Chart(trendAllCtx, {
        type: 'line',
        data: {
            labels: @json($trendAllLabels),
            datasets: [
                {
                    label: 'Inovasi',
                    data: @json($trendAllInovasi),
                    borderColor: '#2563eb',
                    backgroundColor: 'rgba(37,99,235,0.1)',
                    tension: 0.3,
                    fill: true
                },
                {
                    label: 'Kolaborasi',
                    data: @json($trendAllKolaborasi),
                    borderColor: '#10b981',
                    backgroundColor: 'rgba(16,185,129,0.1)',
                    tension: 0.3,
                    fill: true
                }
            ]
        },
        options: {
            responsive: true,
            plugins: { legend: { display: true } },
            scales: { y: { beginAtZero: true } }
        }
    });

    // Bar chart untuk kategori seluruh user
    const kategoriAllCtx = document.getElementById('kategoriAllChart');
    new Chart(kategoriAllCtx, {
        type: 'bar',
        data: {
            labels: @json($kategoriAllLabels),
            datasets: [{
                label: 'Jumlah Inovasi',
                data: @json($kategoriAllCounts),
                backgroundColor: '#3b82f6',
                borderColor: '#2563eb',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: { 
                legend: { 
                    display: false 
                } 
            },
            scales: { 
                y: { 
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1
                    }
                } 
            }
        }
    });

    // Chart untuk user yang login
    const trendMyCtx = document.getElementById('trendMyChart');
    new Chart(trendMyCtx, {
        type: 'line',
        data: {
            labels: @json($trendMyLabels),
            datasets: [
                {
                    label: 'Inovasi Saya',
                    data: @json($trendMyInovasi),
                    borderColor: '#8b5cf6',
                    backgroundColor: 'rgba(139,92,246,0.1)',
                    tension: 0.3,
                    fill: true
                },
                {
                    label: 'Kolaborasi Saya',
                    data: @json($trendMyKolaborasi),
                    borderColor: '#f59e0b',
                    backgroundColor: 'rgba(245,158,11,0.1)',
                    tension: 0.3,
                    fill: true
                }
            ]
        },
        options: {
            responsive: true,
            plugins: { legend: { display: true } },
            scales: { y: { beginAtZero: true } }
        }
    });

    const kategoriMyCtx = document.getElementById('kategoriMyChart');
    new Chart(kategoriMyCtx, {
        type: 'doughnut',
        data: {
            labels: @json($kategoriMyLabels),
            datasets: [{
                data: @json($kategoriMyCounts),
                backgroundColor: ['#8b5cf6', '#a78bfa', '#c4b5fd', '#ddd6fe', '#f3f4f6']
            }]
        },
        options: {
            plugins: { legend: { position: 'bottom' } }
        }
    });
</script>
@endsection