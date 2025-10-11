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
        transform: translateY(-3px);
        box-shadow: 0 8px 20px -6px rgba(0, 0, 0, 0.15);
    }
    .compact-card {
        height: fit-content;
        min-height: 380px;
    }
</style>
@endsection

@section('content')
<!-- Hero Section - Lebih Compact -->
<section class="hero-bg text-white py-12">
    <div class="container mx-auto px-4 md:px-6 text-center">
        <h1 class="text-3xl md:text-4xl font-bold mb-3 leading-tight">
            Semua <span class="text-yellow-300">Inovasi</span>
        </h1>
        <p class="text-base md:text-lg max-w-2xl mx-auto leading-relaxed opacity-90">
            Temukan semua inovasi digital yang dapat mendukung pembangunan daerah.
        </p>
        <a href="{{ route('pemerintah.inovasi.create') }}" 
           class="inline-flex items-center bg-purple-500 text-white px-5 py-2.5 rounded-lg font-semibold hover:bg-purple-600 transition mt-4 text-sm">
            💡 Posting Inovasi Baru
        </a>
    </div>
</section>

<!-- Filter Section - Lebih Compact -->
<section class="bg-gray-50 py-6">
    <div class="container mx-auto px-4 md:px-6">
        <div class="flex flex-col md:flex-row justify-between items-center gap-4">
            <h2 class="text-xl font-bold text-dark">Daftar Inovasi Digital</h2>
            <div class="flex flex-wrap gap-3">
                <select class="px-3 py-1.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary text-sm">
                    <option>Semua Kategori</option>
                    <option>Artificial Intelligence</option>
                    <option>Internet of Things</option>
                    <option>Big Data</option>
                    <option>Blockchain</option>
                    <option>Pelayanan Publik</option>
                </select>
                <select class="px-3 py-1.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary text-sm">
                    <option>Semua Status</option>
                    <option>Research</option>
                    <option>Prototype</option>
                    <option>Siap Implementasi</option>
                    <option>Sudah Diimplementasikan</option>
                </select>
                <button class="bg-primary text-white px-3 py-1.5 rounded-lg hover:bg-blue-700 transition text-sm">
                    🔍 Cari
                </button>
            </div>
        </div>
    </div>
</section>

<!-- Inovasi List - 4 Cards per Row -->
<section class="bg-white py-8">
    <div class="container mx-auto px-4 md:px-6">
        @if($innovations->count() > 0)
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4 md:gap-6">
                @foreach($innovations as $innovation)
                <div class="bg-white rounded-lg shadow-md border border-gray-100 overflow-hidden card-hover compact-card">
                    <!-- Header Image -->
                    <div class="h-28 bg-gradient-to-r from-green-500 to-emerald-400 relative">
                        @if($innovation->image)
                            <img src="{{ asset('storage/' . $innovation->image) }}" alt="{{ $innovation->title }}" class="w-full h-full object-cover">
                        @endif
                        <span class="absolute top-2 right-2 bg-white text-green-600 px-2 py-1 rounded-full text-xs font-semibold shadow-sm">
                            @if($innovation->status == 'research') 🔬
                            @elseif($innovation->status == 'prototype') 🔧
                            @elseif($innovation->status == 'ready') ✅
                            @else 🚀
                            @endif
                        </span>
                        <div class="absolute bottom-2 left-2">
                            <span class="bg-black/20 text-white px-1.5 py-0.5 rounded text-xs">Inovasi</span>
                        </div>
                    </div>
                    
                    <!-- Content -->
                    <div class="p-4">
                        <!-- Institution Info -->
                        <div class="flex items-center mb-3">
                            <div class="w-8 h-8 rounded-full bg-green-100 flex items-center justify-center text-green-600 font-bold text-sm">
                                {{ substr($innovation->institution, 0, 1) }}
                            </div>
                            <div class="ml-2">
                                <p class="text-xs font-medium text-dark truncate max-w-[120px]">{{ $innovation->institution }}</p>
                                <p class="text-xs text-gray-500">{{ $innovation->author_name }}</p>
                            </div>
                        </div>
                        
                        <!-- Title & Description -->
                        <h3 class="text-sm font-semibold text-dark mb-2 line-clamp-2 leading-tight">{{ $innovation->title }}</h3>
                        <p class="text-gray-600 text-xs mb-3 line-clamp-2 leading-relaxed">{{ Str::limit($innovation->description, 80) }}</p>
                        
                        <!-- TRL Level -->
                        <div class="mb-3">
                            <div class="flex justify-between text-xs text-gray-600 mb-1">
                                <span>Kesiapan Teknologi</span>
                                <span>TRL {{ $innovation->technology_readiness_level }}</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-1.5">
                                <div class="bg-green-500 h-1.5 rounded-full" style="width: {{ ($innovation->technology_readiness_level / 9) * 100 }}%"></div>
                            </div>
                        </div>
                        
                        <!-- Research Duration & Status -->
                        <div class="flex items-center justify-between mb-3">
                            <div class="flex items-center text-xs text-gray-500">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                {{ $innovation->research_duration }} bln
                            </div>
                            @if($innovation->is_verified)
                            <span class="bg-green-100 text-green-700 px-1.5 py-0.5 rounded text-xs font-medium">
                                ✅ Terverifikasi
                            </span>
                            @else
                            <span class="bg-yellow-100 text-yellow-700 px-1.5 py-0.5 rounded text-xs font-medium">
                                ⏳ Review
                            </span>
                            @endif
                        </div>
                        
                        <!-- Category & Actions -->
                        <div class="flex justify-between items-center pt-2 border-t border-gray-100">
                            <span class="text-xs text-gray-500 truncate max-w-[80px]">{{ $innovation->category }}</span>
                            <div class="flex gap-2">
                                <a href="{{ route('pemerintah.inovasi.edit', $innovation->id) }}" 
                                   class="text-blue-600 hover:text-blue-800 text-xs font-medium">
                                    ✏️
                                </a>
                                <form action="{{ route('pemerintah.inovasi.destroy', $innovation->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="text-red-600 hover:text-red-800 text-xs font-medium"
                                            onclick="return confirm('Yakin ingin menghapus inovasi ini?')">
                                        🗑️
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            
            <!-- Pagination - Lebih Compact -->
            <div class="mt-8">
                {{ $innovations->links() }}
            </div>
        @else
            <div class="text-center py-12">
                <div class="text-gray-400 text-5xl mb-3">💡</div>
                <p class="text-gray-500 text-base mb-4">Belum ada inovasi yang diposting.</p>
                <a href="{{ route('pemerintah.inovasi.create') }}" class="inline-block bg-purple-500 text-white px-5 py-2.5 rounded-lg hover:bg-purple-600 transition text-sm">
                    💡 Posting Inovasi Pertama
                </a>
            </div>
        @endif
    </div>
</section>

<style>
.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

/* Responsive adjustments */
@media (max-width: 640px) {
    .compact-card {
        min-height: 350px;
    }
}

@media (min-width: 1280px) {
    .xl\:grid-cols-4 {
        grid-template-columns: repeat(4, minmax(0, 1fr));
    }
}
</style>
@endsection