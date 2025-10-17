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
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
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
        transform: translateY(-2px);
        box-shadow: 0 8px 20px -6px rgba(0, 0, 0, 0.15);
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
        font-size: 0.65rem;
        padding: 2px 6px;
        border-radius: 10px;
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

    /* Hide scrollbar but keep functionality */
    .scrollbar-hide {
        -ms-overflow-style: none;
        scrollbar-width: none;
    }

    .scrollbar-hide::-webkit-scrollbar {
        display: none;
    }

    .floating-shape {
        position: absolute;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.1);
        animation: float 6s ease-in-out infinite;
    }

    .shape-1 {
        width: 100px;
        height: 100px;
        top: 10%;
        left: 10%;
        animation-delay: 0s;
    }

    .shape-2 {
        width: 150px;
        height: 150px;
        bottom: 10%;
        right: 10%;
        animation-delay: 2s;
    }

    .shape-3 {
        width: 80px;
        height: 80px;
        top: 50%;
        right: 20%;
        animation-delay: 4s;
    }

    @keyframes float {

        0%,
        100% {
            transform: translateY(0px) rotate(0deg);
        }

        50% {
            transform: translateY(-20px) rotate(180deg);
        }
    }
</style>
@endsection

@section('content')

{{-- ========== HERO SECTION COMPACT MODERN ========== --}}
<section class="bg-white py-12 md:py-16 border-b border-gray-100">
    <div class="container mx-auto px-6 md:px-12">
        <div class="max-w-3xl mx-auto text-center">
            <!-- Main Heading -->
            <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">
                Inovasi Digital
                <span class="text-blue-600">Daerah</span>
            </h1>

            <!-- Subheading -->
            <p class="text-base text-gray-600 max-w-xl mx-auto mb-8 leading-relaxed">
                Wadah kolaborasi strategis pemerintah dan akademisi untuk solusi inovatif.
            </p>

            <!-- CTA Buttons - Floating Action -->
            <div class="flex flex-col sm:flex-row gap-3 justify-center items-center mb-12">
                <a href="{{ route('pemerintah.program.create') }}"
                    class="group flex items-center space-x-2 bg-white text-gray-700 px-6 py-3 rounded-xl font-medium border border-gray-200 hover:border-blue-300 hover:shadow-lg hover:-translate-y-0.5 transition-all duration-200 w-full sm:w-auto">
                    <span class="text-blue-500 text-lg">📋</span>
                    <span>Posting Program</span>
                    <span class="opacity-0 group-hover:opacity-100 transition-opacity">→</span>
                </a>

                <a href="{{ route('pemerintah.inovasi.create') }}"
                    class="group flex items-center space-x-2 bg-blue-500 text-white px-6 py-3 rounded-xl font-medium hover:bg-blue-600 hover:shadow-lg hover:-translate-y-0.5 transition-all duration-200 w-full sm:w-auto">
                    <span class="text-lg">💡</span>
                    <span>Posting Inovasi</span>
                    <span class="opacity-0 group-hover:opacity-100 transition-opacity">→</span>
                </a>
            </div>
            <!-- Stats Compact -->
            <div class="grid grid-cols-4 gap-6 max-w-md mx-auto pt-6 border-t border-gray-200">
                <div class="text-center">
                    <div class="text-lg font-bold text-gray-900">{{ $totalPrograms }}</div>
                    <div class="text-xs text-gray-500 mt-0.5">Program</div>
                </div>
                <div class="text-center">
                    <div class="text-lg font-bold text-gray-900">{{ $totalInnovations }}</div>
                    <div class="text-xs text-gray-500 mt-0.5">Inovasi</div>
                </div>
                <div class="text-center">
                    <div class="text-lg font-bold text-gray-900">{{ $programsOngoing }}</div>
                    <div class="text-xs text-gray-500 mt-0.5">Berjalan</div>
                </div>
                <div class="text-center">
                    <div class="text-lg font-bold text-gray-900">{{ $innovationsReady }}</div>
                    <div class="text-xs text-gray-500 mt-0.5">Siap</div>
                </div>
            </div>
        </div>
    </div>
</section>


{{-- ========== PROGRAM PRIORITAS ========== --}}
<section class="bg-white py-10">
    <div class="container mx-auto px-4">
        <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center mb-8">
            <div class="mb-4 lg:mb-0">
                <h2 class="text-xl font-bold text-dark mb-2 section-title">Program Prioritas</h2>
                <p class="text-gray-600 text-sm max-w-2xl">Program unggulan pemerintah daerah yang sedang berjalan dan mendukung pembangunan wilayah</p>
            </div>
            <a href="{{ route('program.list') }}" class="inline-flex items-center text-primary font-semibold hover:text-secondary transition px-4 py-2 bg-blue-50 rounded-lg text-sm">
                Lihat Semua Program
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-2" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M12.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                </svg>
            </a>
        </div>

        @if($programs->count() > 0)
        <div class="flex space-x-4 overflow-x-auto scrollbar-hide pb-3">
            @foreach($programs->take(8) as $program)
            <div class="flex-shrink-0 w-64">
                <div class="compact-card card-hover rounded-lg overflow-hidden bg-white flex flex-col" style="min-height: 380px;">
                    <div class="h-32 bg-gradient-to-r from-primary to-secondary relative flex-shrink-0">
                        @if($program->image)
                        <img src="{{ asset('storage/' . $program->image) }}" alt="{{ $program->title }}" class="w-full h-full object-cover">
                        @else
                        <div class="w-full h-full flex items-center justify-center bg-gradient-to-r from-blue-600 to-blue-800">
                            <span class="text-white text-2xl">📋</span>
                        </div>
                        @endif
                        <div class="absolute top-2 right-2">
                            @if($program->status == 'planning')
                            <span class="status-badge bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded-full">📅 Planning</span>
                            @elseif($program->status == 'ongoing')
                            <span class="status-badge bg-green-100 text-green-800 text-xs px-2 py-1 rounded-full">🚀 Ongoing</span>
                            @else
                            <span class="status-badge bg-gray-100 text-gray-800 text-xs px-2 py-1 rounded-full">✅ Completed</span>
                            @endif
                        </div>
                    </div>

                    <div class="p-4 flex-1 flex flex-col">
                        <h3 class="text-sm font-semibold text-dark mb-2 leading-tight line-clamp-2">{{ $program->title }}</h3>
                        <p class="text-xs text-gray-600 mb-3 line-clamp-2 flex-grow">{{ Str::limit($program->description, 80) }}</p>

                        <div class="space-y-2 mt-auto">
                            <div class="flex items-center justify-between text-xs text-gray-500">
                                <span class="font-medium truncate flex items-center" title="{{ $program->opd_name }}">
                                    <span class="w-2 h-2 bg-blue-500 rounded-full mr-1"></span>
                                    {{ Str::limit($program->opd_name, 15) }}
                                </span>
                                <span class="font-semibold {{ $program->progress >= 80 ? 'text-green-600' : ($program->progress >= 50 ? 'text-yellow-600' : 'text-red-600') }}">
                                    {{ $program->progress }}%
                                </span>
                            </div>

                            <div class="w-full bg-gray-200 rounded-full h-2 mb-2">
                                <div class="h-2 rounded-full transition-all duration-300 
                                        {{ $program->progress >= 80 ? 'bg-green-500' : ($program->progress >= 50 ? 'bg-yellow-500' : 'bg-red-500') }}"
                                    style="width: {{ $program->progress }}%">
                                </div>
                            </div>

                            <div class="flex justify-between items-center text-xs text-gray-500">
                                <span>{{ \Carbon\Carbon::parse($program->start_date)->format('M Y') }}</span>
                                <span class="bg-blue-50 text-blue-700 px-2 py-1 rounded text-xs">{{ $program->category }}</span>
                            </div>
                        </div>
                    </div>

                    {{-- ✅ BUTTON LIHAT DETAIL PROGRAM --}}
                    <div class="px-4 pb-4 pt-2 border-t border-gray-100 mt-auto">
                        <a href="{{ route('program.detail', $program->id) }}" class="block w-full text-center bg-gray-100 text-gray-700 hover:bg-gray-200 text-xs font-medium py-2 rounded transition">
                            Lihat Detail
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @else
        <div class="text-center py-8 bg-gray-50 rounded-lg border border-gray-200">
            <div class="text-gray-400 text-3xl mb-3">📋</div>
            <h3 class="text-base font-semibold text-gray-600 mb-1">Belum ada program</h3>
            <p class="text-gray-500 text-xs mb-4 max-w-md mx-auto">Mulai dengan memposting program pertama untuk menunjukkan kinerja OPD Anda</p>
            <a href="{{ route('pemerintah.program.create') }}" class="inline-flex items-center bg-primary text-white px-4 py-2 rounded-lg font-medium hover:bg-blue-700 transition text-sm">
                <span class="mr-2">📋</span>
                Buat Program Pertama
            </a>
        </div>
        @endif
    </div>
</section>

{{-- ========== INOVASI DIGITAL ========== --}}
<section class="bg-gray-50 py-10">
    <div class="container mx-auto px-4">
        <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center mb-8">
            <div class="mb-4 lg:mb-0">
                <h2 class="text-xl font-bold text-dark mb-2 section-title">Inovasi Digital</h2>
                <p class="text-gray-600 text-sm max-w-2xl">Solusi teknologi inovatif untuk mendukung program daerah dan meningkatkan pelayanan publik</p>
            </div>
            <a href="{{ route('program.innovation.list') }}" class="inline-flex items-center text-primary font-semibold hover:text-secondary transition px-4 py-2 bg-blue-50 rounded-lg text-sm">
                Lihat Semua Inovasi
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-2" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M12.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                </svg>
            </a>
        </div>

        @if($innovations->count() > 0)
        <div class="flex space-x-4 overflow-x-auto scrollbar-hide pb-3">
            @foreach($innovations->take(8) as $innovation)
            <div class="flex-shrink-0 w-64">
                <div class="compact-card card-hover rounded-lg overflow-hidden bg-white flex flex-col" style="min-height: 380px;">
                    <div class="h-32 bg-gradient-to-r from-green-600 to-emerald-500 relative flex-shrink-0">
                        @if($innovation->image)
                        <img src="{{ asset('storage/' . $innovation->image) }}" alt="{{ $innovation->title }}" class="w-full h-full object-cover">
                        @else
                        <div class="w-full h-full flex items-center justify-center bg-gradient-to-r from-green-600 to-emerald-600">
                            <span class="text-white text-2xl">💡</span>
                        </div>
                        @endif
                        <div class="absolute top-2 right-2">
                            @if($innovation->status == 'prototype')
                            <span class="status-badge bg-orange-100 text-orange-800 text-xs px-2 py-1 rounded-full">🔧 Prototype</span>
                            @elseif($innovation->status == 'ready')
                            <span class="status-badge bg-green-100 text-green-800 text-xs px-2 py-1 rounded-full">✅ Siap</span>
                            @elseif($innovation->status == 'implemented')
                            <span class="status-badge bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded-full">🚀 Diimplementasi</span>
                            @else
                            <span class="status-badge bg-purple-100 text-purple-800 text-xs px-2 py-1 rounded-full">🔬 Riset</span>
                            @endif
                        </div>
                    </div>

                    <div class="p-4 flex-1 flex flex-col">
                        <h3 class="text-sm font-semibold text-dark mb-2 leading-tight line-clamp-2">{{ $innovation->title }}</h3>
                        <p class="text-xs text-gray-600 mb-3 line-clamp-2 flex-grow">{{ Str::limit($innovation->description, 80) }}</p>

                        <div class="space-y-2 mt-auto">
                            <div class="flex items-center justify-between text-xs text-gray-500">
                                <span class="font-medium truncate flex items-center" title="{{ $innovation->institution }}">
                                    <span class="w-2 h-2 bg-green-500 rounded-full mr-1"></span>
                                    {{ Str::limit($innovation->institution, 15) }}
                                </span>
                                <div class="flex items-center">
                                    ⭐ {{ number_format($innovation->rating, 1) }}
                                    @if($innovation->is_verified)
                                    <span class="text-green-500 ml-1" title="Terverifikasi">✓</span>
                                    @endif
                                </div>
                            </div>

                            <div class="flex items-center justify-between text-xs text-gray-500 mb-1">
                                <span class="capitalize">{{ $innovation->innovation_type }}</span>
                                <span class="font-semibold text-green-600">{{ $innovation->research_duration }} bln</span>
                            </div>

                            <div class="w-full bg-gray-200 rounded-full h-2 mb-2">
                                <div class="bg-green-500 h-2 rounded-full transition-all duration-300"
                                    style="width: {{ $innovation->status == 'research' ? '25%' : ($innovation->status == 'prototype' ? '50%' : ($innovation->status == 'ready' ? '75%' : '100%')) }}">
                                </div>
                            </div>

                            <div class="flex justify-between items-center text-xs text-gray-500">
                                <span>{{ \Carbon\Carbon::parse($innovation->created_at)->format('M Y') }}</span>
                                <span class="bg-green-50 text-green-700 px-2 py-1 rounded text-xs">{{ $innovation->category }}</span>
                            </div>
                        </div>
                    </div>

                    {{-- ✅ BUTTON LIHAT DETAIL INOVASI --}}
                    <div class="px-4 pb-4 pt-2 border-t border-gray-100 mt-auto">
                        <a href="{{ route('program.innovation.detail', $innovation->id) }}" class="block w-full text-center bg-gray-100 text-gray-700 hover:bg-gray-200 text-xs font-medium py-2 rounded transition">
                            Lihat Detail
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @else
        <div class="text-center py-8 bg-white rounded-lg border border-gray-200">
            <div class="text-gray-400 text-3xl mb-3">💡</div>
            <h3 class="text-base font-semibold text-gray-600 mb-1">Belum ada inovasi</h3>
            <p class="text-gray-500 text-xs mb-4 max-w-md mx-auto">Bagikan inovasi digital OPD Anda untuk menginspirasi dan berkolaborasi</p>
            <a href="{{ route('pemerintah.inovasi.create') }}" class="inline-flex items-center bg-purple-500 text-white px-4 py-2 rounded-lg font-medium hover:bg-purple-600 transition text-sm">
                <span class="mr-2">💡</span>
                Buat Inovasi Pertama
            </a>
        </div>
        @endif
    </div>
</section>

<script>
    // Smooth scrolling for containers
    document.addEventListener('DOMContentLoaded', function() {
        const programContainer = document.querySelector('#programs-scroll');
        const innovationContainer = document.querySelector('#innovations-scroll');

        if (programContainer) {
            programContainer.addEventListener('wheel', (e) => {
                if (e.deltaY !== 0) {
                    e.preventDefault();
                    programContainer.scrollLeft += e.deltaY;
                }
            });
        }

        if (innovationContainer) {
            innovationContainer.addEventListener('wheel', (e) => {
                if (e.deltaY !== 0) {
                    e.preventDefault();
                    innovationContainer.scrollLeft += e.deltaY;
                }
            });
        }
    });
</script>
@endsection