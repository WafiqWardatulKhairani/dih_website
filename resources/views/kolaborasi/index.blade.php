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
    border-radius: 1rem;
    overflow: hidden;
    background: #ffffff;
    box-shadow: 0 6px 18px rgba(0,0,0,0.08);
}
.kolaborasi-card:hover {
    transform: translateY(-6px);
    box-shadow: 0 12px 24px rgba(0,0,0,0.15);
}

.card-image { height: 14rem; overflow: hidden; position: relative; }
.card-image img { width: 100%; height: 100%; object-fit: cover; transition: transform 0.3s ease; }
.card-image img:hover { transform: scale(1.05); }

.badge {
    display: inline-block;
    font-size: 0.75rem;
    font-weight: 600;
    padding: 0.25rem 0.5rem;
    border-radius: 0.375rem;
    margin-right: 0.25rem;
}

.user-info { display: flex; align-items: center; gap: 0.5rem; margin-top: 0.5rem; font-size: 0.875rem; font-weight: 500; color: #1e293b; }
.user-info i { font-size: 1rem; color: #64748b; }

.stats-info { display: flex; align-items: center; gap: 0.75rem; margin-top: 0.25rem; font-size: 0.875rem; color: #475569; }
.stats-info i { color: #3b82f6; }

.progress-bar-bg { background-color: #e5e7eb; border-radius: 0.25rem; height: 0.5rem; width: 100%; overflow: hidden; margin-top: 0.5rem; }
.progress-bar-fill { background-color: #3b82f6; height: 0.5rem; transition: width 0.3s ease; }

.line-clamp-2 { display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; }

.pagination { display: flex; gap: 0.5rem; justify-content: center; margin-top: 2rem; }
.pagination a, .pagination span { padding: 0.5rem 0.75rem; border-radius: 0.375rem; border: 1px solid #cbd5e1; color: #1e3a8a; font-weight: 500; transition: all 0.2s; }
.pagination a:hover { background-color: #1e40af; color: white; border-color: #1e40af; }
.pagination .active { background-color: #1e3a8a; color: white; border-color: #1e3a8a; }
</style>
@endpush

@section('content')
<div class="w-full">

    <!-- HERO SECTION -->
    <section class="relative text-white py-28 overflow-hidden">
        <div class="absolute inset-0 z-0"
             style="background: linear-gradient(rgba(30,64,175,0.85), rgba(30,58,138,0.9));">
            <img src="https://i.pinimg.com/736x/2b/06/92/2b0692887ba8c9d26aeaface7cdea3be.jpg"
                 alt="Kolaborasi Inovasi"
                 class="w-full h-full object-cover opacity-40">
        </div>
        <div class="relative container mx-auto px-4 text-center z-10">
            <h1 class="text-4xl md:text-5xl font-extrabold mb-4 leading-tight hero-text-shadow">
                Ruang Kolaborasi Inovasi Pekanbaru
            </h1>
            <p class="max-w-3xl mx-auto text-lg md:text-xl mb-10 opacity-90 hero-text-shadow">
                Kolaborasi antara Akademisi dan OPD untuk mewujudkan inovasi nyata bagi Kota Pekanbaru.
            </p>

            <div class="flex flex-col sm:flex-row gap-4 justify-center items-center mb-8">
                <a href="#kolaborasi-list"
                   class="flex items-center gap-2 px-6 py-3 bg-white text-blue-700 font-semibold rounded-lg hover:bg-gray-100 transition transform hover:scale-105">
                    <i class="fas fa-arrow-down"></i> Lihat Kolaborasi
                </a>
            </div>

            <!-- SEARCH BAR -->
            <div class="bg-white/20 backdrop-blur-md p-6 rounded-xl max-w-4xl mx-auto shadow-lg">
                <form action="{{ route('kolaborasi.index') }}" method="GET" class="grid grid-cols-1 gap-4">
                    <input type="text" name="search" value="{{ request('search') }}"
                           placeholder="Cari kolaborasi berdasarkan judul atau pemilik ide..."
                           class="w-full p-3 rounded-lg border border-white/30 bg-white/10 placeholder-white/70 text-white focus:outline-none focus:border-white/50 focus:bg-white/20 transition">
                    <div class="flex justify-center md:justify-start">
                        <button type="submit"
                                class="px-6 py-2 bg-blue-600 text-white font-semibold rounded-lg flex items-center gap-2 text-sm hover:bg-blue-700 transition transform hover:-translate-y-1">
                            <i class="fas fa-search"></i> Cari
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </section>

    <!-- MAIN CONTENT -->
    <div class="container mx-auto px-4 py-14 mt-8" id="kolaborasi-list">
        <div class="grid gap-6 grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4">
            @forelse($kolaborasis as $k)
                @php
                    $membersCount = $k->members_count;
                    $ownerIsLeader = $k->owner_id == optional($k->members->where('role','leader')->first())->user_id;
                    if(!$ownerIsLeader) { $membersCount += 1; }

                    // Hitung jumlah task & jumlah done
                    $tasks = $k->tasks->count();
                    $doneTasks = $k->tasks->where('status', 'done')->count();
                    $progressPercent = $tasks > 0 ? round(($doneTasks / $tasks) * 100) : 0;
                @endphp

                <div class="kolaborasi-card">
                    <!-- IMAGE -->
                    <div class="card-image relative">
                        @if($k->image_path)
                            <img src="{{ asset('storage/'.$k->image_path) }}" alt="{{ $k->title }}" loading="lazy">
                        @else
                            <div class="w-full h-full bg-blue-600 flex items-center justify-center text-yellow-300 text-4xl">
                                <i class="fas fa-handshake"></i>
                            </div>
                        @endif
                        <span class="absolute top-3 right-3 px-2 py-1 rounded text-xs font-semibold text-white bg-blue-500">
                            Kolaborasi
                        </span>
                    </div>

                    <!-- CONTENT -->
                    <div class="p-4 flex flex-col flex-1">
                        <h3 class="font-semibold text-gray-800 text-lg line-clamp-2">{{ $k->title }}</h3>
                        <p class="text-sm text-gray-600 mt-2 line-clamp-2">{{ $k->description }}</p>

                        <!-- OWNER -->
                        <div class="user-info mt-3">
                            <i class="fas fa-user"></i>
                            <span>{{ $k->owner->name ?? 'Anonim' }}</span>
                        </div>

                        <!-- MEMBERS & TASKS -->
                        <div class="stats-info mt-2">
                            <span><i class="fas fa-users"></i> {{ $membersCount }} anggota</span>
                            <span><i class="fas fa-tasks"></i> {{ $tasks }} tugas</span>
                        </div>

                        <!-- PROGRESS BAR -->
                        <div class="progress-bar-bg mt-2">
                            <div class="progress-bar-fill" style="width: {{ $progressPercent }}%"></div>
                        </div>
                        <p class="text-xs text-gray-500 mt-1">{{ $progressPercent }}% selesai</p>

                        <p class="text-xs text-gray-500 mt-1">{{ \Carbon\Carbon::parse($k->created_at)->diffForHumans() }}</p>

                        <!-- LINK DETAIL -->
                        <a href="{{ route('kolaborasi.detail', $k->id) }}"
                           class="mt-auto bg-blue-600 text-white text-sm font-semibold py-2 rounded-lg text-center hover:bg-blue-700 transition mt-3">
                           <i class="fas fa-comments"></i> Lihat Detail Kolaborasi
                        </a>
                    </div>
                </div>
            @empty
                <div class="bg-indigo-50 rounded-xl p-12 text-center border-2 border-dashed border-indigo-300 col-span-full">
                    <i class="fas fa-handshake text-5xl text-blue-400 mb-4"></i>
                    <h3 class="text-xl font-semibold text-gray-700 mb-2">Belum Ada Kolaborasi</h3>
                    <p class="text-gray-500 mb-6">
                        Jadilah yang pertama untuk memulai ide kolaborasi antara Akademisi dan OPD Pekanbaru.
                    </p>
                    <a href="{{ route('kolaborasi.ide.create') }}"
                       class="inline-block bg-blue-600 text-white px-5 py-2 rounded-lg font-semibold hover:bg-blue-700 transition">
                        <i class="fas fa-plus"></i> Buat Ide Baru
                    </a>
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
