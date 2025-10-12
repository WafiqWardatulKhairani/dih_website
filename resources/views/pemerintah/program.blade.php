@extends('layouts.app')

@section('styles')
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
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
    .hero-bg {
        background: linear-gradient(135deg, #1e3a8a 0%, #1e40af 100%);
        position: relative;
        overflow: hidden;
    }
    
    .hero-bg::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.05'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
    }

    .card-hover {
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        border: 1px solid #e2e8f0;
    }

    .card-hover:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 25px -8px rgba(0, 0, 0, 0.15);
        border-color: #cbd5e1;
    }

    .compact-card {
        height: 100%;
        display: flex;
        flex-direction: column;
        background: white;
        border-radius: 8px;
    }

    .status-badge {
        font-size: 0.7rem;
        padding: 2px 8px;
        border-radius: 12px;
        font-weight: 500;
    }

    .scroll-container {
        scrollbar-width: none;
        -ms-overflow-style: none;
        -webkit-overflow-scrolling: touch;
    }

    .scroll-container::-webkit-scrollbar {
        display: none;
    }

    .scroll-btn {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        width: 40px;
        height: 40px;
        background: white;
        border: 1px solid #e2e8f0;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
        z-index: 10;
    }

    .scroll-btn:hover {
        background: #f8fafc;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        transform: translateY(-50%) scale(1.05);
    }

    .scroll-btn:active {
        transform: translateY(-50%) scale(0.95);
    }

    .scroll-btn.prev {
        left: -20px;
    }

    .scroll-btn.next {
        right: -20px;
    }

    .scroll-btn svg {
        width: 20px;
        height: 20px;
        color: #64748b;
    }

    .scroll-btn:hover svg {
        color: #1e40af;
    }

    .section-title {
        position: relative;
        padding-bottom: 12px;
    }

    .section-title::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        width: 50px;
        height: 3px;
        background: linear-gradient(90deg, #1e40af, #3b82f6);
        border-radius: 2px;
    }

    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .stats-card {
        background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
        border: 1px solid #e2e8f0;
        transition: all 0.3s ease;
    }

    .stats-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px -2px rgba(0, 0, 0, 0.1);
    }

    .fade-overlay {
        position: absolute;
        top: 0;
        bottom: 0;
        width: 60px;
        pointer-events: none;
        z-index: 5;
    }

    .fade-overlay.left {
        left: 0;
        background: linear-gradient(90deg, white 0%, transparent 100%);
    }

    .fade-overlay.right {
        right: 0;
        background: linear-gradient(270deg, white 0%, transparent 100%);
    }
</style>
@endsection

@section('content')

{{-- ========== HERO SECTION ========== --}}
<section class="hero-bg text-white py-16 md:py-20 relative">
    <div class="container mx-auto px-6 md:px-12 text-center relative z-10">
        <h1 class="text-3xl md:text-4xl font-bold mb-4 leading-tight">
            Program & <span class="text-blue-200">Inovasi Digital</span>
        </h1>
        <p class="text-lg max-w-2xl mx-auto mb-8 leading-relaxed opacity-90">
            Kelola program prioritas dan temukan inovasi digital untuk mendukung pembangunan daerah yang lebih baik.
        </p>
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="{{ route('pemerintah.program.create') }}" class="inline-flex items-center bg-white text-primary px-6 py-3 rounded-lg font-semibold hover:bg-gray-100 transition shadow-lg">
                <span class="mr-2">📋</span>
                Posting Program Baru
            </a>
            <a href="{{ route('pemerintah.inovasi.create') }}" class="inline-flex items-center bg-accent text-white px-6 py-3 rounded-lg font-semibold hover:bg-blue-600 transition shadow-lg">
                <span class="mr-2">💡</span>
                Posting Inovasi Baru
            </a>
        </div>
    </div>
</section>

{{-- ========== STATISTIK CEPAT ========== --}}
<section class="bg-white py-10 border-b">
    <div class="container mx-auto px-6 md:px-12">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6 text-center">
            <div class="stats-card p-6 rounded-lg">
                <div class="text-2xl font-bold text-primary mb-1">{{ $totalPrograms }}</div>
                <p class="text-sm text-gray-600 font-medium">Total Program</p>
            </div>
            <div class="stats-card p-6 rounded-lg">
                <div class="text-2xl font-bold text-success mb-1">{{ $totalInnovations }}</div>
                <p class="text-sm text-gray-600 font-medium">Total Inovasi</p>
            </div>
            <div class="stats-card p-6 rounded-lg">
                <div class="text-2xl font-bold text-warning mb-1">{{ $programsOngoing }}</div>
                <p class="text-sm text-gray-600 font-medium">Program Berjalan</p>
            </div>
            <div class="stats-card p-6 rounded-lg">
                <div class="text-2xl font-bold text-purple-600 mb-1">{{ $innovationsReady }}</div>
                <p class="text-sm text-gray-600 font-medium">Inovasi Siap</p>
            </div>
        </div>
    </div>
</section>

{{-- ========== PROGRAM PRIORITAS ========== --}}
<section class="bg-white py-14">
    <div class="container mx-auto px-6 md:px-12">
        <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center mb-10">
            <div class="mb-4 lg:mb-0">
                <h2 class="text-2xl font-bold text-dark mb-3 section-title">Program Prioritas</h2>
                <p class="text-gray-600 max-w-2xl">Program unggulan pemerintah daerah yang sedang berjalan dan mendukung pembangunan wilayah</p>
            </div>
            <a href="{{ route('program.list') }}" class="inline-flex items-center text-primary font-semibold hover:text-secondary transition px-4 py-2 bg-blue-50 rounded-lg">
                Lihat Semua Program
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-2" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M12.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                </svg>
            </a>
        </div>

        @if($programs->count() > 0)
            @if($programs->count() <= 5)
            {{-- Grid layout untuk item sedikit --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-5">
                @foreach($programs as $program)
                <div class="compact-card card-hover rounded-lg overflow-hidden">
                    <div class="h-24 bg-gradient-to-r from-primary to-secondary relative">
                        @if($program->image)
                        <img src="{{ asset('storage/' . $program->image) }}" alt="{{ $program->title }}" class="w-full h-full object-cover">
                        @endif
                        <div class="absolute top-3 right-3">
                            @if($program->status == 'planning')
                            <span class="status-badge bg-blue-100 text-blue-800">📅 Rencana</span>
                            @elseif($program->status == 'ongoing')
                            <span class="status-badge bg-green-100 text-green-800">🚀 Berjalan</span>
                            @else
                            <span class="status-badge bg-gray-100 text-gray-800">✅ Selesai</span>
                            @endif
                        </div>
                    </div>
                    
                    <div class="p-4 flex-1">
                        <h3 class="text-sm font-semibold text-dark mb-2 leading-tight line-clamp-2">{{ $program->title }}</h3>
                        <p class="text-xs text-gray-600 mb-3 line-clamp-2">{{ Str::limit($program->description, 70) }}</p>

                        <div class="flex items-center justify-between text-xs text-gray-500 mb-2">
                            <span class="font-medium truncate" title="{{ $program->opd_name }}">{{ Str::limit($program->opd_name, 15) }}</span>
                            <span class="font-semibold">{{ $program->progress }}%</span>
                        </div>

                        <div class="w-full bg-gray-200 rounded-full h-2 mb-3">
                            <div class="bg-green-500 h-2 rounded-full transition-all duration-300" style="width: {{ $program->progress }}%"></div>
                        </div>

                        <div class="flex justify-between items-center text-xs text-gray-500">
                            <span>{{ \Carbon\Carbon::parse($program->start_date)->format('M Y') }}</span>
                            <span>{{ $program->category }}</span>
                        </div>
                    </div>
                    
                    <div class="px-4 pb-4">
                        <a href="{{ route('program.detail', $program->id) }}" class="block w-full text-center bg-gray-100 text-gray-700 hover:bg-gray-200 text-xs font-medium py-2 rounded transition">
                            Lihat Detail
                        </a>
                    </div>
                </div>
                @endforeach
            </div>
            @else
            {{-- Horizontal scroll dengan arrows untuk item banyak --}}
            <div class="relative">
                <div class="fade-overlay left"></div>
                <div class="fade-overlay right"></div>
                
                <button class="scroll-btn prev" onclick="scrollPrograms('left')">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                </button>
                
                <div id="programs-scroll" class="scroll-container overflow-x-auto pb-4" style="scroll-behavior: smooth;">
                    <div class="flex space-x-5" style="min-width: min-content;">
                        @foreach($programs->take(15) as $program)
                        <div class="flex-shrink-0 w-64">
                            <div class="compact-card card-hover rounded-lg overflow-hidden">
                                <div class="h-24 bg-gradient-to-r from-primary to-secondary relative">
                                    @if($program->image)
                                    <img src="{{ asset('storage/' . $program->image) }}" alt="{{ $program->title }}" class="w-full h-full object-cover">
                                    @endif
                                    <div class="absolute top-3 right-3">
                                        @if($program->status == 'planning')
                                        <span class="status-badge bg-blue-100 text-blue-800">📅 Rencana</span>
                                        @elseif($program->status == 'ongoing')
                                        <span class="status-badge bg-green-100 text-green-800">🚀 Berjalan</span>
                                        @else
                                        <span class="status-badge bg-gray-100 text-gray-800">✅ Selesai</span>
                                        @endif
                                    </div>
                                </div>
                                
                                <div class="p-4 flex-1">
                                    <h3 class="text-sm font-semibold text-dark mb-2 leading-tight line-clamp-2">{{ $program->title }}</h3>
                                    <p class="text-xs text-gray-600 mb-3 line-clamp-2">{{ Str::limit($program->description, 70) }}</p>

                                    <div class="flex items-center justify-between text-xs text-gray-500 mb-2">
                                        <span class="font-medium truncate" title="{{ $program->opd_name }}">{{ Str::limit($program->opd_name, 15) }}</span>
                                        <span class="font-semibold">{{ $program->progress }}%</span>
                                    </div>

                                    <div class="w-full bg-gray-200 rounded-full h-2 mb-3">
                                        <div class="bg-green-500 h-2 rounded-full transition-all duration-300" style="width: {{ $program->progress }}%"></div>
                                    </div>

                                    <div class="flex justify-between items-center text-xs text-gray-500">
                                        <span>{{ \Carbon\Carbon::parse($program->start_date)->format('M Y') }}</span>
                                        <span>{{ $program->category }}</span>
                                    </div>
                                </div>
                                
                                <div class="px-4 pb-4">
                                    <a href="{{ route('program.detail', $program->id) }}" class="block w-full text-center bg-gray-100 text-gray-700 hover:bg-gray-200 text-xs font-medium py-2 rounded transition">
                                        Lihat Detail
                                    </a>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                
                <button class="scroll-btn next" onclick="scrollPrograms('right')">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </button>
            </div>
            @endif
        @else
        <div class="text-center py-12 bg-gray-50 rounded-lg border border-gray-200">
            <div class="text-gray-400 text-4xl mb-4">📋</div>
            <h3 class="text-lg font-semibold text-gray-600 mb-2">Belum ada program</h3>
            <p class="text-gray-500 text-sm mb-6 max-w-md mx-auto">Mulai dengan memposting program pertama untuk menunjukkan kinerja OPD Anda</p>
            <a href="{{ route('pemerintah.program.create') }}" class="inline-flex items-center bg-primary text-white px-5 py-2.5 rounded-lg font-medium hover:bg-blue-700 transition">
                <span class="mr-2">📋</span>
                Buat Program Pertama
            </a>
        </div>
        @endif
    </div>
</section>

{{-- ========== INOVASI DIGITAL ========== --}}
<section class="bg-gray-50 py-14">
    <div class="container mx-auto px-6 md:px-12">
        <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center mb-10">
            <div class="mb-4 lg:mb-0">
                <h2 class="text-2xl font-bold text-dark mb-3 section-title">Inovasi Digital</h2>
                <p class="text-gray-600 max-w-2xl">Solusi teknologi inovatif untuk mendukung program daerah dan meningkatkan pelayanan publik</p>
            </div>
            <a href="{{ route('program.innovation.list') }}" class="inline-flex items-center text-primary font-semibold hover:text-secondary transition px-4 py-2 bg-blue-50 rounded-lg">
                Lihat Semua Inovasi
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-2" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M12.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                </svg>
            </a>
        </div>

        @if($innovations->count() > 0)
            @if($innovations->count() <= 5)
            {{-- Grid layout untuk item sedikit --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-5">
                @foreach($innovations as $innovation)
                <div class="compact-card card-hover rounded-lg overflow-hidden">
                    <div class="h-24 bg-gradient-to-r from-green-600 to-emerald-500 relative">
                        @if($innovation->image)
                        <img src="{{ asset('storage/' . $innovation->image) }}" alt="{{ $innovation->title }}" class="w-full h-full object-cover">
                        @endif
                        <div class="absolute top-3 right-3">
                            @if($innovation->status == 'prototype')
                            <span class="status-badge bg-orange-100 text-orange-800">🔧 Prototype</span>
                            @elseif($innovation->status == 'ready')
                            <span class="status-badge bg-green-100 text-green-800">✅ Siap</span>
                            @elseif($innovation->status == 'implemented')
                            <span class="status-badge bg-blue-100 text-blue-800">🚀 Diimplementasi</span>
                            @else
                            <span class="status-badge bg-purple-100 text-purple-800">🔬 Riset</span>
                            @endif
                        </div>
                    </div>
                    
                    <div class="p-4 flex-1">
                        <h3 class="text-sm font-semibold text-dark mb-2 leading-tight line-clamp-2">{{ $innovation->title }}</h3>
                        <p class="text-xs text-gray-600 mb-3 line-clamp-2">{{ Str::limit($innovation->description, 70) }}</p>

                        <div class="flex items-center justify-between text-xs text-gray-500 mb-3">
                            <span class="font-medium truncate" title="{{ $innovation->institution }}">{{ Str::limit($innovation->institution, 15) }}</span>
                            <div class="flex items-center">
                                ⭐ {{ number_format($innovation->rating, 1) }}
                                @if($innovation->is_verified)
                                <span class="text-green-500 ml-1" title="Terverifikasi">✓</span>
                                @endif
                            </div>
                        </div>

                        <div class="flex justify-between items-center text-xs text-gray-500">
                            <span class="capitalize">{{ $innovation->innovation_type }}</span>
                            <span class="bg-blue-50 text-blue-700 px-2 py-1 rounded">{{ $innovation->research_duration }} bln</span>
                        </div>
                    </div>
                    
                    <div class="px-4 pb-4">
                        <a href="#" class="block w-full text-center bg-green-100 text-green-700 hover:bg-green-200 text-xs font-medium py-2 rounded transition">
                            Ajukan Kolaborasi
                        </a>
                    </div>
                </div>
                @endforeach
            </div>
            @else
            {{-- Horizontal scroll dengan arrows untuk item banyak --}}
            <div class="relative">
                <div class="fade-overlay left"></div>
                <div class="fade-overlay right"></div>
                
                <button class="scroll-btn prev" onclick="scrollInnovations('left')">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                </button>
                
                <div id="innovations-scroll" class="scroll-container overflow-x-auto pb-4" style="scroll-behavior: smooth;">
                    <div class="flex space-x-5" style="min-width: min-content;">
                        @foreach($innovations->take(15) as $innovation)
                        <div class="flex-shrink-0 w-64">
                            <div class="compact-card card-hover rounded-lg overflow-hidden">
                                <div class="h-24 bg-gradient-to-r from-green-600 to-emerald-500 relative">
                                    @if($innovation->image)
                                    <img src="{{ asset('storage/' . $innovation->image) }}" alt="{{ $innovation->title }}" class="w-full h-full object-cover">
                                    @endif
                                    <div class="absolute top-3 right-3">
                                        @if($innovation->status == 'prototype')
                                        <span class="status-badge bg-orange-100 text-orange-800">🔧 Prototype</span>
                                        @elseif($innovation->status == 'ready')
                                        <span class="status-badge bg-green-100 text-green-800">✅ Siap</span>
                                        @elseif($innovation->status == 'implemented')
                                        <span class="status-badge bg-blue-100 text-blue-800">🚀 Diimplementasi</span>
                                        @else
                                        <span class="status-badge bg-purple-100 text-purple-800">🔬 Riset</span>
                                        @endif
                                    </div>
                                </div>
                                
                                <div class="p-4 flex-1">
                                    <h3 class="text-sm font-semibold text-dark mb-2 leading-tight line-clamp-2">{{ $innovation->title }}</h3>
                                    <p class="text-xs text-gray-600 mb-3 line-clamp-2">{{ Str::limit($innovation->description, 70) }}</p>

                                    <div class="flex items-center justify-between text-xs text-gray-500 mb-3">
                                        <span class="font-medium truncate" title="{{ $innovation->institution }}">{{ Str::limit($innovation->institution, 15) }}</span>
                                        <div class="flex items-center">
                                            ⭐ {{ number_format($innovation->rating, 1) }}
                                            @if($innovation->is_verified)
                                            <span class="text-green-500 ml-1" title="Terverifikasi">✓</span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="flex justify-between items-center text-xs text-gray-500">
                                        <span class="capitalize">{{ $innovation->innovation_type }}</span>
                                        <span class="bg-blue-50 text-blue-700 px-2 py-1 rounded">{{ $innovation->research_duration }} bln</span>
                                    </div>
                                </div>
                                
                                <div class="px-4 pb-4">
                                    <a href="#" class="block w-full text-center bg-green-100 text-green-700 hover:bg-green-200 text-xs font-medium py-2 rounded transition">
                                        Ajukan Kolaborasi
                                    </a>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                
                <button class="scroll-btn next" onclick="scrollInnovations('right')">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </button>
            </div>
            @endif
        @else
        <div class="text-center py-12 bg-white rounded-lg border border-gray-200">
            <div class="text-gray-400 text-4xl mb-4">💡</div>
            <h3 class="text-lg font-semibold text-gray-600 mb-2">Belum ada inovasi</h3>
            <p class="text-gray-500 text-sm mb-6 max-w-md mx-auto">Bagikan inovasi digital OPD Anda untuk menginspirasi dan berkolaborasi</p>
            <a href="{{ route('pemerintah.inovasi.create') }}" class="inline-flex items-center bg-purple-500 text-white px-5 py-2.5 rounded-lg font-medium hover:bg-purple-600 transition">
                <span class="mr-2">💡</span>
                Buat Inovasi Pertama
            </a>
        </div>
        @endif
    </div>
</section>

<script>
function scrollPrograms(direction) {
    const container = document.getElementById('programs-scroll');
    const scrollAmount = 300;
    
    if (direction === 'left') {
        container.scrollLeft -= scrollAmount;
    } else {
        container.scrollLeft += scrollAmount;
    }
}

function scrollInnovations(direction) {
    const container = document.getElementById('innovations-scroll');
    const scrollAmount = 300;
    
    if (direction === 'left') {
        container.scrollLeft -= scrollAmount;
    } else {
        container.scrollLeft += scrollAmount;
    }
}

// Hide arrows when at the edges
document.addEventListener('DOMContentLoaded', function() {
    const programsContainer = document.getElementById('programs-scroll');
    const innovationsContainer = document.getElementById('innovations-scroll');
    
    function checkScroll(container) {
        const prevBtn = container.parentElement.querySelector('.scroll-btn.prev');
        const nextBtn = container.parentElement.querySelector('.scroll-btn.next');
        
        prevBtn.style.display = container.scrollLeft <= 0 ? 'none' : 'flex';
        nextBtn.style.display = container.scrollLeft + container.clientWidth >= container.scrollWidth ? 'none' : 'flex';
    }
    
    if (programsContainer) {
        programsContainer.addEventListener('scroll', () => checkScroll(programsContainer));
        checkScroll(programsContainer);
    }
    
    if (innovationsContainer) {
        innovationsContainer.addEventListener('scroll', () => checkScroll(innovationsContainer));
        checkScroll(innovationsContainer);
    }
});
</script>
@endsection