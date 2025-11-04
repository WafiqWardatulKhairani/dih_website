@extends('layouts.app')

@section('title', 'Diskusi Inovasi')

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
/* HERO TEXT SHADOW */
.hero-text-shadow { text-shadow: 2px 2px 8px rgba(0,0,0,0.7); }

/* CARD STYLE */
.innovation-card {
    transition: all 0.3s ease;
    display: flex;
    flex-direction: column;
    border-radius: 1rem;
    overflow: hidden;
    background: #ffffff;
    box-shadow: 0 6px 18px rgba(0,0,0,0.08);
}
.innovation-card:hover {
    transform: translateY(-6px);
    box-shadow: 0 12px 24px rgba(0,0,0,0.15);
}

/* CARD IMAGE */
.card-image { height: 16rem; overflow: hidden; position: relative; }
.card-image img { width: 100%; height: 100%; object-fit: cover; transition: transform 0.3s ease; }
.card-image img:hover { transform: scale(1.05); }

/* BADGE */
.badge {
    display: inline-block;
    font-size: 0.75rem;
    font-weight: 600;
    padding: 0.25rem 0.5rem;
    border-radius: 0.375rem;
    margin-right: 0.25rem;
}

/* TRL PROGRESS BAR */
.trl-bar { height: 0.5rem; border-radius: 0.25rem; background-color: #e5e7eb; overflow: hidden; margin-top: 0.25rem; }
.trl-fill { height: 100%; background-color: #3b82f6; text-align: right; color: white; font-size: 0.625rem; line-height: 0.5rem; padding-right: 0.25rem; font-weight: bold; }

/* USER INFO */
.user-info { display: flex; align-items: center; gap: 0.5rem; margin-top: 0.5rem; font-size: 0.875rem; font-weight: 500; color: #1e293b; }
.user-info i { font-size: 1rem; color: #64748b; }

/* COMMENT COUNT */
.comment-count { display: flex; align-items: center; gap: 0.25rem; font-size: 0.875rem; color: #475569; margin-top: 0.25rem; }
.comment-count i { color: #3b82f6; }

/* LINE CLAMP */
.line-clamp-2 { display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; }

/* PAGINATION */
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
            <img src="https://i.pinimg.com/1200x/34/4b/08/344b08abcafb830d2e90193586ded579.jpg"
                 alt="Diskusi Inovasi"
                 class="w-full h-full object-cover opacity-40">
        </div>
        <div class="relative container mx-auto px-4 text-center z-10">
            <h1 class="text-4xl md:text-5xl font-extrabold mb-4 leading-tight hero-text-shadow">
                Jelajahi Forum Diskusi!
            </h1>
            <p class="max-w-3xl mx-auto text-lg md:text-xl mb-10 opacity-90 hero-text-shadow">
                Temukan ide dan karya terbaru dari akademisi dan OPD Pekanbaru!
            </p>

            <div class="flex flex-col sm:flex-row gap-4 justify-center items-center mb-8">
                <a href="#diskusi-list"
                   class="flex items-center gap-2 px-6 py-3 bg-white text-blue-700 font-semibold rounded-lg hover:bg-gray-100 transition transform hover:scale-105">
                    <i class="fas fa-arrow-down"></i> Lihat Diskusi
                </a>
            </div>

            <!-- SEARCH BAR -->
            <div class="bg-white/20 backdrop-blur-md p-6 rounded-xl max-w-4xl mx-auto shadow-lg">
                <form action="{{ route('forum-diskusi.index') }}" method="GET" class="grid grid-cols-1 gap-4">
                    <input type="text" name="search" value="{{ request('search') }}"
                           placeholder="Cari diskusi berdasarkan kata kunci..."
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

    <!-- MAIN CONTENT: Daftar Diskusi -->
    <div class="container mx-auto px-4 py-14 mt-8" id="diskusi-list">
        <div class="grid gap-6 grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4">
            @forelse($paginatedInnovations as $innovation)
                <div class="innovation-card">
                    <!-- IMAGE -->
                    <div class="card-image relative">
                        @if($innovation->image_path)
                            <img src="{{ asset('storage/'.$innovation->image_path) }}" 
                                 alt="{{ $innovation->title }}" loading="lazy">
                        @else
                            <div class="w-full h-full bg-blue-500 flex items-center justify-center text-yellow-300 text-4xl">
                                <i class="fas fa-lightbulb"></i>
                            </div>
                        @endif
                        <span class="absolute top-3 right-3 px-2 py-1 rounded text-xs font-semibold text-white
                            {{ $innovation->source_type == 'academic' ? 'bg-green-500' : 'bg-yellow-400' }}">
                            {{ ucfirst($innovation->source_type) }}
                        </span>
                    </div>

                    <!-- CONTENT -->
                    <div class="p-4 flex flex-col flex-1">
                        <h3 class="font-semibold text-gray-800 text-lg line-clamp-2">{{ $innovation->title }}</h3>

                        <!-- CATEGORY / SUBCATEGORY BADGE -->
                        <div class="my-2 flex flex-wrap gap-1">
                            @if($innovation->category)
                                <span class="badge bg-blue-100 text-blue-800">{{ $innovation->category }}</span>
                            @endif
                            @if($innovation->subcategory_name && $innovation->subcategory_name !== '-')
                                <span class="badge bg-indigo-100 text-indigo-800">{{ $innovation->subcategory_name }}</span>
                            @endif
                        </div>

                        <!-- TRL PROGRESS -->
                        <div class="mt-2">
                            <span class="text-sm font-semibold text-gray-600">TRL: {{ $innovation->technology_readiness_level ?? '-' }}</span>
                            <div class="trl-bar">
                                @php
                                    $trl = $innovation->technology_readiness_level ?? 0;
                                    $trlPercent = min(max($trl * 10, 0), 100);
                                @endphp
                                <div class="trl-fill" style="width: {{ $trlPercent }}%"></div>
                            </div>
                        </div>

                        <!-- POSTER NAME -->
                        <div class="user-info mt-3">
                            <i class="fas fa-user"></i>
                            <span>{{ $innovation->author_name ?? 'Anonim' }}</span>
                        </div>

                        <!-- COMMENT COUNT -->
                        @php
                            $commentCount = \DB::table('discussion_comments')
                                ->where('innovation_id', $innovation->id)
                                ->count();
                        @endphp
                        <div class="comment-count">
                            <i class="fas fa-comments"></i>
                            <span>{{ $commentCount }} Komentar</span>
                        </div>

                        <p class="text-xs text-gray-500 mt-1">{{ \Carbon\Carbon::parse($innovation->created_at)->diffForHumans() }}</p>

                        <!-- DETAIL LINK -->
                        <a href="{{ route('forum-diskusi.detail', ['type' => $innovation->source_type, 'id' => $innovation->id]) }}"
                           class="mt-auto bg-blue-600 text-white text-sm font-semibold py-2 rounded-lg text-center hover:bg-blue-700 transition mt-3">
                           Lihat Diskusi
                        </a>
                    </div>
                </div>
            @empty
                <div class="bg-indigo-50 rounded-xl p-12 text-center border-2 border-dashed border-indigo-300 col-span-full">
                    <i class="fas fa-lightbulb text-5xl text-yellow-300 mb-4"></i>
                    <h3 class="text-xl font-semibold text-gray-700 mb-2">Belum Ada Diskusi</h3>
                    <p class="text-gray-500 mb-6">
                        Mulai jelajahi ide dan karya terbaru dari akademisi dan OPD Pekanbaru.
                    </p>
                </div>
            @endforelse
        </div>

        <!-- PAGINATION -->
        <div class="pagination">
            {{ $paginatedInnovations->appends(request()->query())->links() }}
        </div>
    </div>
</div>
@endsection
