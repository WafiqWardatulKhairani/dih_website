@extends('layouts.app')

@section('title', 'Kolaborasi Inovasi')

@push('styles')
<script src="https://cdn.tailwindcss.com"></script>
<script>
tailwind.config = {
    theme: {
        extend: {
            colors: {
                primary: '#1e3a8a',
                secondary: '#1e40af',
                accent: '#3b82f6',
                dark: '#1e293b',
                light: '#f8fafc',
                success: '#059669',
                warning: '#d97706'
            }
        }
    }
}
</script>
<style>
.hero-text-shadow { text-shadow: 2px 2px 8px rgba(0,0,0,0.7); }

.kolaborasi-card {
    transition: all 0.3s ease;
    display: flex;
    flex-direction: column;
    border-radius: 0.75rem;
    overflow: hidden;
    background: #ffffff;
    box-shadow: 0 4px 6px rgba(0,0,0,0.05);
    border: 1px solid #e2e8f0;
    height: 100%;
}
.kolaborasi-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 8px 15px rgba(0,0,0,0.1);
}

.card-image { 
    height: 10rem; 
    overflow: hidden; 
    position: relative; 
}
.card-image img { 
    width: 100%; 
    height: 100%; 
    object-fit: cover; 
    transition: transform 0.3s ease; 
}
.card-image img:hover { 
    transform: scale(1.05); 
}

.source-badge {
    position: absolute;
    top: 0.5rem;
    right: 0.5rem;
    padding: 0.25rem 0.5rem;
    border-radius: 0.375rem;
    font-size: 0.65rem;
    font-weight: 600;
    text-transform: uppercase;
}

.status-badge {
    position: absolute;
    top: 0.5rem;
    left: 0.5rem;
    padding: 0.25rem 0.5rem;
    border-radius: 0.375rem;
    font-size: 0.65rem;
    font-weight: 600;
    text-transform: uppercase;
}

.badge {
    display: inline-block;
    font-size: 0.65rem;
    font-weight: 600;
    padding: 0.2rem 0.4rem;
    border-radius: 0.25rem;
    margin-right: 0.25rem;
}

.card-content {
    padding: 0.75rem;
    display: flex;
    flex-direction: column;
    flex: 1;
}

.card-title {
    font-size: 0.8rem;
    font-weight: 600;
    color: #1e293b;
    margin-bottom: 0.5rem;
    line-height: 1.2;
}

.user-info, .stats-info { 
    display: flex; 
    align-items: center; 
    gap: 0.25rem; 
    font-size: 0.7rem; 
    color: #475569; 
}
.user-info i, .stats-info i { 
    font-size: 0.7rem; 
    color: #64748b; 
}

.progress-bar-bg { 
    background-color: #e5e7eb; 
    border-radius: 0.25rem; 
    height: 0.4rem; 
    width: 100%; 
    overflow: hidden; 
    margin: 0.5rem 0 0.25rem 0;
}
.progress-bar-fill { 
    background-color: #3b82f6; 
    height: 0.4rem; 
    transition: width 0.3s ease; 
}

.line-clamp-2 { 
    display: -webkit-box; 
    -webkit-line-clamp: 2; 
    -webkit-box-orient: vertical; 
    overflow: hidden; 
}

.card-meta {
    margin-top: auto;
    padding-top: 0.5rem;
    border-top: 1px solid #f1f5f9;
}

.pagination { 
    display: flex; 
    gap: 0.5rem; 
    justify-content: center; 
    margin-top: 2rem; 
}
.pagination a, .pagination span { 
    padding: 0.5rem 0.75rem; 
    border-radius: 0.375rem; 
    border: 1px solid #cbd5e1; 
    color: #1e3a8a; 
    font-weight: 500; 
    transition: all 0.2s; 
    font-size: 0.875rem;
}
.pagination a:hover { 
    background-color: #1e40af; 
    color: white; 
    border-color: #1e40af; 
}
.pagination .active { 
    background-color: #1e3a8a; 
    color: white; 
    border-color: #1e3a8a; 
}
</style>
@endpush

@section('content')
<div class="w-full">

    <!-- HERO SECTION - Diperkecil seperti diskusi -->
    <section class="relative text-white py-16 overflow-hidden">
        <div class="absolute inset-0 z-0"
             style="background: linear-gradient(rgba(30,64,175,0.85), rgba(30,58,138,0.9));">
            <img src="https://i.pinimg.com/736x/2b/06/92/2b0692887ba8c9d26aeaface7cdea3be.jpg"
                 alt="Kolaborasi Inovasi"
                 class="w-full h-full object-cover opacity-40">
        </div>
        <div class="relative container mx-auto px-4 text-center z-10">
            <h1 class="text-2xl md:text-3xl font-bold mb-3 leading-tight hero-text-shadow">
                Ruang Kolaborasi Inovasi
            </h1>
            <p class="max-w-2xl mx-auto text-sm md:text-base mb-6 opacity-90 hero-text-shadow">
                Kolaborasi antara Akademisi dan OPD untuk mewujudkan inovasi nyata bagi Kota Pekanbaru.
            </p>

            <div class="flex flex-col sm:flex-row gap-2 justify-center items-center mb-4">
                <a href="#kolaborasi-list"
                   class="flex items-center gap-1 px-4 py-2 bg-white text-blue-700 font-semibold rounded-lg hover:bg-gray-100 transition transform hover:scale-105 text-xs">
                    <i class="fas fa-arrow-down text-xs"></i> Lihat Kolaborasi
                </a>
            </div>

            <!-- SEARCH BAR - Diperkecil seperti diskusi -->
            <div class="bg-white/20 backdrop-blur-md p-3 rounded-lg max-w-2xl mx-auto shadow-lg">
                <form action="{{ route('kolaborasi.index') }}" method="GET" class="flex gap-2">
                    <input type="text" name="search" value="{{ request('search') }}"
                           placeholder="Cari kolaborasi berdasarkan judul atau pemilik ide..."
                           class="flex-1 p-2 rounded-lg border border-white/30 bg-white/10 placeholder-white/70 text-white focus:outline-none focus:border-white/50 focus:bg-white/20 transition text-xs">
                    <button type="submit"
                            class="px-3 py-2 bg-blue-600 text-white font-semibold rounded-lg flex items-center gap-1 text-xs hover:bg-blue-700 transition">
                        <i class="fas fa-search text-xs"></i> Cari
                    </button>
                </form>
            </div>
        </div>
    </section>

    <!-- MAIN CONTENT - Grid disesuaikan dengan diskusi -->
    <div class="container mx-auto px-3 py-6" id="kolaborasi-list">
        <div class="grid gap-3 grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5">
            @forelse($kolaborasis as $k)
                @php
                    $membersCount = $k->members_count;
                    $ownerIsLeader = $k->owner_id == optional($k->members->where('role','leader')->first())->user_id;
                    if(!$ownerIsLeader) { $membersCount += 1; }

                    // Hitung jumlah task & jumlah done
                    $tasks = $k->tasks->count();
                    $doneTasks = $k->tasks->where('status', 'done')->count();
                    $progressPercent = $tasks > 0 ? round(($doneTasks / $tasks) * 100) : 0;

                    // Tentukan status kolaborasi
                    $status = $k->is_active ? 'Aktif' : 'Mencari Anggota';
                    $statusColor = $k->is_active ? 'bg-success' : 'bg-warning';
                @endphp

                <div class="kolaborasi-card">
                    <!-- IMAGE -->
                    <div class="card-image relative">
                        @if($k->image_path)
                            <img src="{{ asset('storage/'.$k->image_path) }}" alt="{{ $k->title }}" loading="lazy">
                        @else
                            <div class="w-full h-full bg-gradient-to-br from-blue-400 to-blue-500 flex items-center justify-center text-white text-xl">
                                <i class="fas fa-handshake"></i>
                            </div>
                        @endif
                        <span class="source-badge bg-blue-500">
                            Kolaborasi
                        </span>
                        <!-- STATUS BADGE -->
                        <span class="status-badge {{ $statusColor }} text-white">
                            {{ $status }}
                        </span>
                    </div>

                    <!-- CONTENT -->
                    <div class="card-content">
                        <h3 class="card-title line-clamp-2">{{ $k->title }}</h3>

                        <!-- DESCRIPTION -->
                        <p class="text-xs text-gray-600 mb-2 line-clamp-2">{{ $k->description }}</p>

                        <!-- OWNER -->
                        <div class="user-info">
                            <i class="fas fa-user"></i>
                            <span class="truncate max-w-[60px]">{{ Str::limit($k->owner->name ?? 'Anonim', 8) }}</span>
                        </div>

                        <!-- MEMBERS & TASKS -->
                        <div class="stats-info">
                            <span><i class="fas fa-users"></i> {{ $membersCount }}</span>
                            <span><i class="fas fa-tasks"></i> {{ $tasks }}</span>
                        </div>

                        <!-- PROGRESS BAR -->
                        <div class="mt-1">
                            <div class="flex justify-between items-center text-xs text-gray-600 mb-1">
                                <span class="font-medium text-[0.6rem]">Progress:</span>
                                <span class="font-semibold text-[0.6rem]">{{ $progressPercent }}%</span>
                            </div>
                            <div class="progress-bar-bg">
                                <div class="progress-bar-fill" style="width: {{ $progressPercent }}%"></div>
                            </div>
                        </div>

                        <!-- DETAIL LINK -->
                        <a href="{{ route('kolaborasi.detail', $k->id) }}"
                           class="w-full bg-blue-600 text-white text-[0.65rem] font-semibold py-1.5 rounded text-center hover:bg-blue-700 transition mt-1 flex items-center justify-center gap-1">
                            <i class="fas fa-eye text-[0.6rem]"></i> Detail
                        </a>

                        <!-- TIMESTAMP -->
                        <div class="card-meta">
                            <span class="text-[0.6rem] text-gray-500">
                                <i class="fas fa-clock mr-0.5"></i>
                                {{ \Carbon\Carbon::parse($k->created_at)->shortRelativeDiffForHumans() }}
                            </span>
                        </div>
                    </div>
                </div>
            @empty
                <div class="bg-indigo-50 rounded-xl p-12 text-center border-2 border-dashed border-indigo-300 col-span-full">
                    <i class="fas fa-handshake text-5xl text-blue-400 mb-4"></i>
                    <h3 class="text-xl font-semibold text-gray-700 mb-2">Belum Ada Kolaborasi</h3>
                    <p class="text-gray-500 mb-6">
                        Mulai kolaborasi antara Akademisi dan OPD Pekanbaru.
                    </p>
                </div>
            @endforelse
        </div>

        <!-- PAGINATION -->
        <div class="pagination">
            {{ $kolaborasis->appends(request()->query())->links() }}
        </div>
    </div>
</div>
@endsection