@extends('layouts.app')

@section('styles')
    <!-- Styles sama seperti program.blade.php -->
@endsection

@section('content')
<!-- Hero Section -->
<section class="hero-bg text-white py-20 md:py-28">
    <div class="container mx-auto px-6 md:px-12 text-center">
        <h1 class="text-4xl md:text-5xl font-extrabold mb-6 leading-tight">
            Inovasi <span class="text-yellow-300">Digital</span>
        </h1>
        <p class="text-lg md:text-xl max-w-3xl mx-auto mb-8 leading-relaxed">
            Temukan inovasi digital terbaru yang dapat mendukung pembangunan daerah.
        </p>
        <a href="{{ route('innovation.create') }}" class="inline-flex items-center bg-purple-500 text-white px-6 py-3 rounded-lg font-semibold hover:bg-purple-600 transition">
            💡 Posting Inovasi Baru
        </a>
    </div>
</section>

<!-- Inovasi List -->
<section class="bg-white py-12">
    <div class="container mx-auto px-6 md:px-12">
        @if($innovations->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($innovations as $innovation)
                <div class="bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden card-hover">
                    <div class="h-40 bg-gradient-to-r from-green-500 to-emerald-400 relative">
                        @if($innovation->image)
                            <img src="{{ asset('storage/' . $innovation->image) }}" alt="{{ $innovation->title }}" class="w-full h-full object-cover">
                        @endif
                        <span class="absolute top-4 right-4 bg-white text-green-600 px-3 py-1 rounded-full text-sm font-semibold shadow-md">
                            @if($innovation->status == 'prototype') 🔧 Prototype
                            @elseif($innovation->status == 'ready') ✅ Siap Implementasi
                            @else 🔬 Riset
                            @endif
                        </span>
                        <div class="absolute bottom-4 left-4">
                            <span class="bg-black/20 text-white px-2 py-1 rounded text-xs">Inovasi {{ $innovation->institution }}</span>
                        </div>
                    </div>
                    <div class="p-6">
                        <div class="flex items-center mb-4">
                            <div class="w-12 h-12 rounded-full bg-green-100 flex items-center justify-center text-green-600 font-bold text-lg">
                                {{ substr($innovation->institution, 0, 1) }}
                            </div>
                            <div class="ml-3">
                                <p class="text-sm font-medium text-dark">{{ $innovation->institution }}</p>
                                <p class="text-xs text-gray-500">{{ $innovation->innovation_type }}</p>
                            </div>
                        </div>
                        <h3 class="text-xl font-semibold text-dark mb-3">{{ $innovation->title }}</h3>
                        <p class="text-gray-600 mb-4 text-sm">{{ Str::limit($innovation->description, 100) }}</p>
                        
                        <div class="flex items-center justify-between mb-4">
                            <div class="flex items-center text-sm text-gray-500">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                {{ $innovation->research_duration }} bulan research
                            </div>
                            <span class="bg-blue-100 text-blue-800 px-2 py-1 rounded text-xs font-medium">
                                ⭐ {{ $innovation->rating }}/5.0
                            </span>
                        </div>
                        
                        <div class="flex justify-between items-center">
                            <div class="flex items-center text-sm text-gray-500">
                                @if($innovation->is_verified)
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                </svg>
                                Terverifikasi
                                @else
                                <span class="text-orange-500 text-xs">Belum diverifikasi</span>
                                @endif
                            </div>
                            <a href="#" class="bg-green-600 text-white px-3 py-2 rounded text-sm font-semibold hover:bg-green-700 transition flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z" />
                                </svg>
                                Ajukan Kolaborasi
                            </a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            
            <!-- Pagination -->
            <div class="mt-12">
                {{ $innovations->links() }}
            </div>
        @else
            <div class="text-center py-12">
                <p class="text-gray-500 text-lg">Belum ada inovasi yang diposting.</p>
                <a href="{{ route('innovation.create') }}" class="inline-block mt-4 bg-purple-500 text-white px-6 py-3 rounded-lg hover:bg-purple-600 transition">
                    💡 Posting Inovasi Pertama
                </a>
            </div>
        @endif
    </div>
</section>
@endsection