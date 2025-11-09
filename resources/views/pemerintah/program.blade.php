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
                    secondary: '#2563eb',
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
   
</style>
@endsection

@section('content')

{{-- HERO SECTION - PROFESSIONAL --}}
<section class="hero-bg min-h-[60vh] flex items-center relative overflow-hidden">
    <div class="absolute inset-0 bg-white/5"></div>
    
    {{-- Subtle Floating Shapes --}}
    <div class="absolute top-20 left-10 w-16 h-16 bg-white/10 rounded-lg floating-shape" style="animation-delay: 0s;"></div>
    <div class="absolute bottom-20 right-16 w-12 h-12 bg-white/10 rounded-full floating-shape" style="animation-delay: 2s;"></div>
    <div class="absolute top-1/3 right-1/4 w-20 h-20 bg-white/5 rounded-lg floating-shape" style="animation-delay: 4s;"></div>
    
    <div class="container mx-auto px-6 relative z-10">
        <div class="max-w-4xl mx-auto text-center">
            {{-- Main Title --}}
            <h1 class="text-4xl md:text-5xl font-bold text-white mb-6 leading-tight">
                Platform Inovasi Digital 
                <span class="text-blue-200">Daerah</span>
            </h1>
            
            {{-- Subtitle --}}
            <p class="text-lg text-blue-100 mb-8 max-w-2xl mx-auto leading-relaxed">
                Wadah kolaborasi strategis antara pemerintah daerah dan akademisi 
                dalam menciptakan solusi inovatif untuk pembangunan wilayah.
            </p>
            
            {{-- CTA Buttons - Professional --}}
            <div class="flex flex-col sm:flex-row gap-4 justify-center items-center mb-12">
                <a href="{{ route('pemerintah.program.create') }}" 
                   class="group flex items-center space-x-3 bg-white text-primary px-6 py-3 rounded-lg font-semibold hover:bg-blue-50 hover:shadow-lg transition-all duration-300 border border-white/20">
                    <span class="text-lg">📋</span>
                    <span>Posting Program</span>
                    <svg class="w-4 h-4 opacity-0 group-hover:opacity-100 transition-opacity duration-300 transform group-hover:translate-x-1" 
                         fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                    </svg>
                </a>
                
                <a href="{{ route('pemerintah.inovasi.create') }}" 
                   class="group flex items-center space-x-3 bg-blue-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-blue-700 hover:shadow-lg transition-all duration-300 border border-blue-500">
                    <span class="text-lg">💡</span>
                    <span>Posting Inovasi</span>
                    <svg class="w-4 h-4 opacity-0 group-hover:opacity-100 transition-opacity duration-300 transform group-hover:translate-x-1" 
                         fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                    </svg>
                </a>
            </div>
            
            {{-- Stats - Clean --}}
            <div class="grid grid-cols-2 md:grid-cols-3 gap-4 max-w-xl mx-auto">
                <div class="text-center bg-white/10 backdrop-blur-sm rounded-lg p-4 border border-white/20">
                    <div class="text-xl font-bold text-white">{{ $totalPrograms }}</div>
                    <div class="text-blue-100 text-sm mt-1">Program</div>
                </div>
                <div class="text-center bg-white/10 backdrop-blur-sm rounded-lg p-4 border border-white/20">
                    <div class="text-xl font-bold text-white">{{ $totalInnovations }}</div>
                    <div class="text-blue-100 text-sm mt-1">Inovasi</div>
                </div>
                <div class="text-center bg-white/10 backdrop-blur-sm rounded-lg p-4 border border-white/20">
                    <div class="text-xl font-bold text-white">{{ $programsOngoing }}</div>
                    <div class="text-blue-100 text-sm mt-1">Berjalan</div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- PROGRAM PRIORITAS --}}
<section class="py-12 bg-white">
    <div class="container mx-auto px-6">
        {{-- Section Header --}}
        <div class="section-header rounded-xl p-6 mb-8">
            <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center">
                <div class="mb-4 lg:mb-0">
                    <h2 class="text-2xl font-bold text-dark mb-2">Program Prioritas Daerah</h2>
                    <p class="text-gray-600 max-w-2xl">
                        Program strategis pemerintah daerah yang mendukung percepatan pembangunan dan kesejahteraan masyarakat
                    </p>
                </div>
                <a href="{{ route('program.list') }}" 
                   class="flex items-center space-x-2 bg-white text-primary border border-gray-300 px-4 py-2 rounded-lg font-medium hover:bg-gray-50 transition-colors">
                    <span>Lihat Semua</span>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                    </svg>
                </a>
            </div>
        </div>

        @if($programs->count() > 0)
        <div class="flex space-x-6 overflow-x-auto scroll-container pb-6 -mx-2 px-2">
            @foreach($programs->take(8) as $program)
            <div class="flex-shrink-0 w-72">
                <div class="bg-white rounded-xl overflow-hidden card-hover border border-gray-200">
                    {{-- Image/Thumbnail --}}
                    <div class="h-40 bg-gradient-to-r from-primary to-secondary relative overflow-hidden">
                        @if($program->image)
                        <img src="{{ asset('storage/' . $program->image) }}" alt="{{ $program->title }}" 
                             class="w-full h-full object-cover">
                        @else
                        <div class="w-full h-full flex items-center justify-center bg-gradient-to-r from-blue-700 to-blue-800">
                            <span class="text-white text-2xl">📋</span>
                        </div>
                        @endif
                        
                        {{-- Status Badge --}}
                        <div class="absolute top-3 right-3">
                            @if($program->status == 'planning')
                            <span class="status-badge bg-blue-100 text-blue-800 border border-blue-200">Rencana</span>
                            @elseif($program->status == 'ongoing')
                            <span class="status-badge bg-green-100 text-green-800 border border-green-200">Berjalan</span>
                            @else
                            <span class="status-badge bg-gray-100 text-gray-800 border border-gray-200">Selesai</span>
                            @endif
                        </div>
                    </div>

                    {{-- Content --}}
                    <div class="p-4">
                        <h3 class="font-bold text-dark mb-2 line-clamp-2 text-sm leading-tight">{{ $program->title }}</h3>
                        <p class="text-gray-600 text-xs mb-3 line-clamp-2">{{ Str::limit($program->description, 80) }}</p>

                        {{-- Progress --}}
                        <div class="space-y-2 mb-3">
                            <div class="flex justify-between items-center text-xs">
                                <span class="text-gray-500">Progress</span>
                                <span class="font-semibold {{ $program->progress >= 80 ? 'text-green-600' : ($program->progress >= 50 ? 'text-yellow-600' : 'text-red-600') }}">
                                    {{ $program->progress }}%
                                </span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-1.5">
                                <div class="h-1.5 rounded-full progress-bar 
                                    {{ $program->progress >= 80 ? 'bg-green-500' : ($program->progress >= 50 ? 'bg-yellow-500' : 'bg-red-500') }}"
                                    style="width: {{ $program->progress }}%">
                                </div>
                            </div>
                        </div>

                        {{-- Meta Info --}}
                        <div class="flex items-center justify-between text-xs text-gray-500 mb-3">
                            <div class="flex items-center space-x-1">
                                <span>🏢</span>
                                <span class="truncate max-w-[100px]" title="{{ $program->opd_name }}">
                                    {{ Str::limit($program->opd_name, 15) }}
                                </span>
                            </div>
                            <span class="bg-blue-50 text-blue-700 px-2 py-1 rounded text-xs">
                                {{ $program->category }}
                            </span>
                        </div>
                    </div>

                    {{-- Action Button --}}
                    <div class="px-4 pb-4">
                        <a href="{{ route('program.detail', $program->id) }}" 
                           class="block w-full text-center bg-gray-100 text-gray-700 hover:bg-gray-200 text-xs font-medium py-2 rounded-lg transition-colors duration-200">
                            Lihat Detail
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @else
        <div class="text-center py-12 bg-gray-50 rounded-xl border-2 border-dashed border-gray-300">
            <div class="text-4xl mb-4">📋</div>
            <h3 class="text-lg font-semibold text-gray-600 mb-2">Belum ada program</h3>
            <p class="text-gray-500 text-sm mb-6 max-w-md mx-auto">
                Mulai dengan memposting program pertama untuk menunjukkan kinerja OPD Anda
            </p>
            <a href="{{ route('pemerintah.program.create') }}" 
               class="inline-flex items-center space-x-2 bg-primary text-white px-6 py-3 rounded-lg font-medium hover:bg-blue-700 transition-colors duration-300">
                <span>📋</span>
                <span>Buat Program Pertama</span>
            </a>
        </div>
        @endif
    </div>
</section>

{{-- INOVASI DIGITAL --}}
<section class="py-12 bg-gray-50">
    <div class="container mx-auto px-6">
        {{-- Section Header --}}
        <div class="section-header rounded-xl p-6 mb-8">
            <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center">
                <div class="mb-4 lg:mb-0">
                    <h2 class="text-2xl font-bold text-dark mb-2">Inovasi Digital Daerah</h2>
                    <p class="text-gray-600 max-w-2xl">
                        Solusi teknologi dan inovasi digital untuk meningkatkan efektivitas program daerah dan pelayanan publik
                    </p>
                </div>
                <a href="{{ route('program.innovation.list') }}" 
                   class="flex items-center space-x-2 bg-white text-primary border border-gray-300 px-4 py-2 rounded-lg font-medium hover:bg-gray-50 transition-colors">
                    <span>Lihat Semua</span>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                    </svg>
                </a>
            </div>
        </div>

        @if($innovations->count() > 0)
        <div class="flex space-x-6 overflow-x-auto scroll-container pb-6 -mx-2 px-2">
            @foreach($innovations->take(8) as $innovation)
            <div class="flex-shrink-0 w-72">
                <div class="bg-white rounded-xl overflow-hidden card-hover border border-gray-200">
                    {{-- Image/Thumbnail --}}
                    <div class="h-40 bg-gradient-to-r from-green-600 to-emerald-500 relative overflow-hidden">
                        @if($innovation->image)
                        <img src="{{ asset('storage/' . $innovation->image) }}" alt="{{ $innovation->title }}" 
                             class="w-full h-full object-cover">
                        @else
                        <div class="w-full h-full flex items-center justify-center bg-gradient-to-r from-green-700 to-emerald-600">
                            <span class="text-white text-2xl">💡</span>
                        </div>
                        @endif
                        
                        {{-- Status Badge --}}
                        <div class="absolute top-3 right-3">
                            @if($innovation->status == 'prototype')
                            <span class="status-badge bg-orange-100 text-orange-800 border border-orange-200">Prototype</span>
                            @elseif($innovation->status == 'ready')
                            <span class="status-badge bg-green-100 text-green-800 border border-green-200">Siap</span>
                            @elseif($innovation->status == 'implemented')
                            <span class="status-badge bg-blue-100 text-blue-800 border border-blue-200">Implementasi</span>
                            @else
                            <span class="status-badge bg-purple-100 text-purple-800 border border-purple-200">Riset</span>
                            @endif
                        </div>
                        
                        {{-- Verification Badge --}}
                        @if($innovation->is_verified)
                        <div class="absolute top-3 left-3">
                            <span class="status-badge bg-green-100 text-green-800 border border-green-200 flex items-center space-x-1">
                                <span>✓</span>
                                <span class="text-xs">Terverifikasi</span>
                            </span>
                        </div>
                        @endif
                    </div>

                    {{-- Content --}}
                    <div class="p-4">
                        <h3 class="font-bold text-dark mb-2 line-clamp-2 text-sm leading-tight">{{ $innovation->title }}</h3>
                        <p class="text-gray-600 text-xs mb-3 line-clamp-2">{{ Str::limit($innovation->description, 80) }}</p>

                        {{-- Rating & Duration --}}
                        <div class="flex justify-between items-center mb-3">
                            <div class="flex items-center space-x-1">
                                <div class="flex items-center space-x-1 bg-yellow-50 px-2 py-1 rounded">
                                    <span class="text-yellow-500 text-xs">⭐</span>
                                    <span class="text-xs font-semibold text-gray-700">{{ number_format($innovation->rating, 1) }}</span>
                                </div>
                            </div>
                            <span class="text-xs text-gray-500 font-medium">{{ $innovation->research_duration }} bln</span>
                        </div>

                        {{-- Progress Indicator --}}
                        <div class="w-full bg-gray-200 rounded-full h-1.5 mb-3">
                            <div class="bg-gradient-to-r from-green-500 to-emerald-400 h-1.5 rounded-full progress-bar"
                                style="width: {{ $innovation->status == 'research' ? '25%' : ($innovation->status == 'prototype' ? '50%' : ($innovation->status == 'ready' ? '75%' : '100%')) }}">
                            </div>
                        </div>

                        {{-- Meta Info --}}
                        <div class="flex items-center justify-between text-xs text-gray-500">
                            <div class="flex items-center space-x-1">
                                <span>🏛️</span>
                                <span class="truncate max-w-[100px]" title="{{ $innovation->institution }}">
                                    {{ Str::limit($innovation->institution, 15) }}
                                </span>
                            </div>
                            <span class="bg-green-50 text-green-700 px-2 py-1 rounded text-xs capitalize">
                                {{ $innovation->innovation_type }}
                            </span>
                        </div>
                    </div>

                    {{-- Action Button --}}
                    <div class="px-4 pb-4">
                        <a href="{{ route('program.innovation.detail', $innovation->id) }}" 
                           class="block w-full text-center bg-gray-100 text-gray-700 hover:bg-gray-200 text-xs font-medium py-2 rounded-lg transition-colors duration-200">
                            Lihat Detail
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @else
        <div class="text-center py-12 bg-white rounded-xl border-2 border-dashed border-gray-300">
            <div class="text-4xl mb-4">💡</div>
            <h3 class="text-lg font-semibold text-gray-600 mb-2">Belum ada inovasi</h3>
            <p class="text-gray-500 text-sm mb-6 max-w-md mx-auto">
                Bagikan inovasi digital OPD Anda untuk menginspirasi dan berkolaborasi
            </p>
            <a href="{{ route('pemerintah.inovasi.create') }}" 
               class="inline-flex items-center space-x-2 bg-green-600 text-white px-6 py-3 rounded-lg font-medium hover:bg-green-700 transition-colors duration-300">
                <span>💡</span>
                <span>Buat Inovasi Pertama</span>
            </a>
        </div>
        @endif
    </div>
</section>

<script>
    // Animasi progress bars
    document.addEventListener('DOMContentLoaded', function() {
        const progressBars = document.querySelectorAll('.progress-bar');
        
        progressBars.forEach(bar => {
            const width = bar.style.width;
            bar.style.width = '0';
            
            setTimeout(() => {
                bar.style.width = width;
            }, 200);
        });
        
        // Smooth scroll untuk horizontal containers
        const scrollContainers = document.querySelectorAll('.scroll-container');
        
        scrollContainers.forEach(container => {
            container.addEventListener('wheel', (e) => {
                if (e.deltaY !== 0) {
                    e.preventDefault();
                    container.scrollLeft += e.deltaY;
                }
            });
        });
    });
</script>
@endsection