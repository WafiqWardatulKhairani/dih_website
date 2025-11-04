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
</style>
@endpush

@section('content')
<div class="max-w-7xl mx-auto px-6 py-10">

    {{-- ========== HEADER ==========' --}}
    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between mb-8">
        <div>
            <h1 class="text-3xl font-bold text-blue-900 mb-2">
                Selamat Datang, {{ Auth::user()->name ?? 'Akademisi' }} 👋
            </h1>
            <p class="text-gray-600">
                Berikut ringkasan aktivitas, inovasi, dan kolaborasi akademikmu di Digital Innovation Hub.
            </p>
            <div class="mt-3">
                <span class="inline-block bg-blue-100 text-blue-700 px-3 py-1 text-xs font-medium rounded-full">
                    Role: {{ ucfirst(Auth::user()->role ?? 'User') }}
                </span>
                @if(isset($badge))
                <span class="inline-block bg-green-100 text-green-700 px-3 py-1 text-xs font-medium rounded-full ml-2">
                    {{ $badge }}
                </span>
                @endif
            </div>
        </div>
    </div>

    {{-- ========== STATISTIC CARDS ==========' --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">
        <x-stat-card title="Inovasi Saya" value="{{ $stat['inovasi'] }}" icon="fa-lightbulb" color="yellow" />
        <x-stat-card title="Ide Kolaborasi" value="{{ $stat['kolaborasi_ide'] }}" icon="fa-users-gear" color="blue" />
        <x-stat-card title="Kolaborasi Diikuti" value="{{ $stat['kolaborasi_member'] }}" icon="fa-people-group" color="indigo" />
        <x-stat-card title="Tugas Kolaborasi" value="{{ $stat['kolaborasi_task'] }}" icon="fa-list-check" color="emerald" />
    </div>

    {{-- ========== GRAFIK TREN & KATEGORI ==========' --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-10">
        <div class="bg-white p-6 rounded-2xl shadow">
            <h2 class="text-lg font-semibold text-blue-900 mb-3">Tren Inovasi & Kolaborasi Bulanan</h2>
            <canvas id="trendChart" height="150"></canvas>
        </div>
        <div class="bg-white p-6 rounded-2xl shadow">
            <h2 class="text-lg font-semibold text-blue-900 mb-3">Kategori Inovasi Terfavorit</h2>
            <canvas id="kategoriChart" height="150"></canvas>
        </div>
    </div>

    {{-- ========== SCROLLING CARDS SECTIONS ==========' --}}
    <div class="space-y-10">

        {{-- === Inovasi Saya === --}}
        <div>
            <div class="flex justify-between items-center mb-3">
                <h2 class="text-xl font-semibold text-blue-900">Inovasi Saya</h2>
                <a href="{{ route('akademisi.inovasi.index') }}" class="text-sm text-blue-600 hover:underline">Lihat Semua</a>
            </div>
            <div class="scrolling-wrapper pb-2">
                @forelse($inovasiSaya as $item)
                    <a href="{{ route('akademisi.inovasi.show', $item->id) }}" class="card-link">
                        <div class="min-w-[260px] bg-white rounded-xl shadow p-4 card-shadow">
                            <h3 class="font-semibold text-gray-800">{{ $item->title }}</h3>
                            <p class="text-sm text-gray-500 mb-2">{{ $item->author_name }}</p>
                            <div class="mt-2">
                                <p class="text-xs text-gray-600 mb-1">TKT: {{ $item->technology_readiness_level }}</p>
                                <div class="w-full bg-gray-200 rounded-full h-2">
                                    <div class="bg-blue-600 h-2 rounded-full" style="width: {{ ($item->technology_readiness_level ?? 0) * 10 }}%"></div>
                                </div>
                            </div>
                        </div>
                    </a>
                @empty
                    <p class="text-gray-500 text-sm">Belum ada inovasi yang diposting.</p>
                @endforelse
            </div>
        </div>

        {{-- === Diskusi Terpopuler === --}}
        <div>
            <div class="flex justify-between items-center mb-3">
                <h2 class="text-xl font-semibold text-blue-900">Diskusi Terpopuler</h2>
                <a href="{{ route('forum-diskusi.index') }}" class="text-sm text-blue-600 hover:underline">Lihat Semua</a>
            </div>
            <div class="scrolling-wrapper pb-2">
                @forelse($diskusiTerpopuler as $diskusi)
<a href="{{ route('forum-diskusi.detail', ['type' => $diskusi->type, 'id' => $diskusi->id]) }}" class="card-link">
                        <div class="min-w-[260px] bg-white rounded-xl shadow p-4 card-shadow">
                            <h3 class="font-semibold text-gray-800">{{ $diskusi->title }}</h3>
                            <p class="text-sm text-gray-500 mb-1">{{ $diskusi->author_name }}</p>
                            <p class="text-xs text-gray-600">Komentar: {{ $diskusi->jumlah_komentar }}</p>
                        </div>
                    </a>
                @empty
                    <p class="text-gray-500 text-sm">Belum ada diskusi populer.</p>
                @endforelse
            </div>
        </div>

        {{-- === Kolaborasi Berjalan === --}}
        <div>
            <div class="flex justify-between items-center mb-3">
                <h2 class="text-xl font-semibold text-blue-900">Kolaborasi Berjalan</h2>
                <a href="{{ route('kolaborasi.index') }}" class="text-sm text-blue-600 hover:underline">Lihat Semua</a>
            </div>
            <div class="scrolling-wrapper pb-2">
                @forelse($kolaborasiBerjalan as $kolab)
                    <a href="{{ route('kolaborasi.ide.show', $kolab->id) }}" class="card-link">
                        <div class="min-w-[260px] bg-white rounded-xl shadow p-4 card-shadow">
                            <h3 class="font-semibold text-gray-800">{{ $kolab->judul }}</h3>
                            <p class="text-sm text-gray-500 mb-1">Status: {{ ucfirst($kolab->status) }}</p>
                            <p class="text-xs text-gray-600">Progress aktif</p>
                        </div>
                    </a>
                @empty
                    <p class="text-gray-500 text-sm">Belum ada kolaborasi berjalan.</p>
                @endforelse
            </div>
        </div>

        {{-- === Kolaborasi yang Membuka Anggota Baru === --}}
        <div>
            <div class="flex justify-between items-center mb-3">
                <h2 class="text-xl font-semibold text-blue-900">Kolaborasi Masih Mencari Anggota</h2>
                <a href="{{ route('kolaborasi.index') }}" class="text-sm text-blue-600 hover:underline">Lihat Semua</a>
            </div>
            <div class="scrolling-wrapper pb-2">
                @forelse($kolaborasiHiring as $hire)
                    <a href="{{ route('kolaborasi.show', $hire->id) }}" class="card-link">
                        <div class="min-w-[260px] bg-white rounded-xl shadow p-4 card-shadow">
                            <h3 class="font-semibold text-gray-800">{{ $hire->judul }}</h3>
                            <p class="text-sm text-gray-500 mb-1">Anggota saat ini: {{ $hire->jumlah_anggota }}/4</p>
                            <p class="text-xs text-gray-600">Masih membuka kolaborator</p>
                        </div>
                    </a>
                @empty
                    <p class="text-gray-500 text-sm">Tidak ada kolaborasi yang sedang membuka anggota.</p>
                @endforelse
            </div>
        </div>
    </div>

    {{-- ========== AKSES CEPAT ==========' --}}
    <div class="mt-14 bg-white shadow rounded-2xl p-6">
        <h2 class="text-xl font-semibold text-blue-900 mb-5">Akses Cepat</h2>
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
            <a href="{{ route('akademisi.inovasi.index') }}"
                class="bg-blue-600 hover:bg-blue-700 text-white text-center rounded-xl p-5 font-medium transition">
                Tambah Inovasi
            </a>
            <a href="{{ route('forum-diskusi.index') }}"
                class="bg-indigo-600 hover:bg-indigo-700 text-white text-center rounded-xl p-5 font-medium transition">
                Bergabung Diskusi
            </a>
            <a href="{{ route('kolaborasi.index') }}"
                class="bg-emerald-600 hover:bg-emerald-700 text-white text-center rounded-xl p-5 font-medium transition">
                Buat Kolaborasi
            </a>
        </div>
    </div>
</div>

{{-- ========== CHART SCRIPTS ==========' --}}
<script>
    const trendCtx = document.getElementById('trendChart');
    new Chart(trendCtx, {
        type: 'line',
        data: {
            labels: @json($trendLabels),
            datasets: [
                {
                    label: 'Inovasi',
                    data: @json($trendInovasi),
                    borderColor: '#2563eb',
                    backgroundColor: 'rgba(37,99,235,0.1)',
                    tension: 0.3,
                    fill: true
                },
                {
                    label: 'Kolaborasi',
                    data: @json($trendKolaborasi),
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

    const kategoriCtx = document.getElementById('kategoriChart');
    new Chart(kategoriCtx, {
        type: 'doughnut',
        data: {
            labels: @json($kategoriLabels),
            datasets: [{
                data: @json($kategoriCounts),
                backgroundColor: ['#2563eb', '#3b82f6', '#60a5fa', '#93c5fd', '#bfdbfe']
            }]
        },
        options: {
            plugins: { legend: { position: 'bottom' } }
        }
    });
</script>
@endsection
