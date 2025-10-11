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
        box-shadow: 0 8px 20px -5px rgba(0, 0, 0, 0.1);
    }

    .compact-card {
        height: 100%;
        display: flex;
        flex-direction: column;
    }
</style>
@endsection

@section('content')

{{-- ========== HERO SECTION ========== --}}
<section class="hero-bg text-white py-16 md:py-20">
    <div class="container mx-auto px-6 md:px-12 text-center">
        <h1 class="text-3xl md:text-4xl font-extrabold mb-4 leading-tight">
            Program & <span class="text-yellow-300">Inovasi</span>
        </h1>
        <p class="text-lg max-w-2xl mx-auto mb-6 leading-relaxed">
            Kelola program prioritas dan temukan inovasi digital untuk mendukung pembangunan daerah.
        </p>
        <div class="flex flex-col sm:flex-row gap-3 justify-center">
            <a href="{{ route('pemerintah.program.create') }}" class="inline-flex items-center bg-green-500 text-white px-5 py-2.5 rounded-lg font-semibold hover:bg-green-600 transition text-sm">
                📋 Posting Program Baru
            </a>
            <a href="{{ route('pemerintah.inovasi.create') }}" class="inline-flex items-center bg-purple-500 text-white px-5 py-2.5 rounded-lg font-semibold hover:bg-purple-600 transition text-sm">
                💡 Posting Inovasi Baru
            </a>
        </div>
    </div>
</section>


{{-- ========== STATISTIK CEPAT ========== --}}
<section class="bg-white py-8 border-t">
    <div class="container mx-auto px-6 md:px-12">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6 text-center">
            <div>
                <div class="text-2xl font-bold text-primary">{{ $totalPrograms }}</div>
                <p class="text-sm text-gray-600">Total Program</p>
            </div>
            <div>
                <div class="text-2xl font-bold text-green-600">{{ $totalInnovations }}</div>
                <p class="text-sm text-gray-600">Total Inovasi</p>
            </div>
            <div>
                <div class="text-2xl font-bold text-orange-600">{{ $programsOngoing }}</div>
                <p class="text-sm text-gray-600">Program Berjalan</p>
            </div>
            <div>
                <div class="text-2xl font-bold text-purple-600">{{ $innovationsReady }}</div>
                <p class="text-sm text-gray-600">Inovasi Siap</p>
            </div>
        </div>
    </div>
</section>
{{-- ========== PROGRAM PRIORITAS ========== --}}
<section class="bg-white py-12">
    <div class="container mx-auto px-6 md:px-12">
        <div class="flex justify-between items-center mb-8">
            <div>
                <h2 class="text-2xl font-bold text-dark mb-2">Program Prioritas</h2>
                <p class="text-gray-600">Program unggulan pemerintah daerah yang sedang berjalan</p>
            </div>
            <a href="{{ route('program.list') }}" class="inline-flex items-center text-primary font-semibold hover:text-secondary transition">
                Lihat Semua Program
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M12.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                </svg>
            </a>
        </div>

        @if($programs->count() > 0)
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4">
            @foreach($programs as $program)
            <div class="bg-white rounded-lg border border-gray-200 overflow-hidden card-hover compact-card">
                <div class="h-20 bg-gradient-to-r from-primary to-secondary relative">
                    @if($program->image)
                    <img src="{{ asset('storage/' . $program->image) }}" alt="{{ $program->title }}" class="w-full h-full object-cover">
                    @endif
                    <span class="absolute top-2 right-2 bg-white text-primary px-1.5 py-0.5 rounded-full text-xs font-medium shadow-sm">
                        @if($program->status == 'planning') 📅
                        @elseif($program->status == 'ongoing') 🚀
                        @else ✅
                        @endif
                    </span>
                </div>
                <div class="p-3 flex-1">
                    <h3 class="text-sm font-semibold text-dark mb-1 leading-tight">{{ Str::limit($program->title, 40) }}</h3>
                    <p class="text-xs text-gray-600 mb-2">{{ Str::limit($program->description, 50) }}</p>

                    <div class="flex items-center justify-between text-xs text-gray-500 mb-1">
                        <span class="truncate">{{ Str::limit($program->opd_name, 12) }}</span>
                        <span>{{ $program->progress }}%</span>
                    </div>

                    <!-- Progress Bar -->
                    <div class="w-full bg-gray-200 rounded-full h-1.5">
                        <div class="bg-green-500 h-1.5 rounded-full" style="width: {{ $program->progress }}%"></div>
                    </div>
                </div>
                <div class="px-3 pb-3">
                    <a href="{{ route('program.detail', $program->id) }}" class="block w-full text-center bg-gray-100 text-gray-700 hover:bg-gray-200 text-xs font-medium py-1.5 rounded transition">
                        Lihat Detail
                    </a>
                </div>
            </div>
            @endforeach
        </div>
        @else
        <div class="text-center py-8 bg-gray-50 rounded-lg border border-gray-200">
            <div class="text-gray-400 text-3xl mb-2">📋</div>
            <p class="text-gray-500 text-sm mb-3">Belum ada program yang diposting.</p>
            <a href="{{ route('pemerintah.program.create') }}" class="inline-block bg-primary text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition text-xs">
                📋 Buat Program Pertama
            </a>
        </div>
        @endif
    </div>
</section>

{{-- ========== INOVASI DIGITAL ========== --}}
<section class="bg-gray-50 py-12">
    <div class="container mx-auto px-6 md:px-12">
        <div class="flex justify-between items-center mb-8">
            <div>
                <h2 class="text-2xl font-bold text-dark mb-2">Inovasi Digital</h2>
                <p class="text-gray-600">Solusi teknologi inovatif untuk mendukung program daerah</p>
            </div>
            <a href="{{ route('program.innovation.list') }}" class="inline-flex items-center text-primary font-semibold hover:text-secondary transition">
                Lihat Semua Inovasi
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M12.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                </svg>
            </a>
        </div>

        @if($innovations->count() > 0)
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4">
            @foreach($innovations as $innovation)
            <div class="bg-white rounded-lg border border-gray-200 overflow-hidden card-hover compact-card">
                <div class="h-20 bg-gradient-to-r from-green-500 to-emerald-400 relative">
                    @if($innovation->image)
                    <img src="{{ asset('storage/' . $innovation->image) }}" alt="{{ $innovation->title }}" class="w-full h-full object-cover">
                    @endif
                    <span class="absolute top-2 right-2 bg-white text-green-600 px-1.5 py-0.5 rounded-full text-xs font-medium shadow-sm">
                        @if($innovation->status == 'prototype') 🔧
                        @elseif($innovation->status == 'ready') ✅
                        @elseif($innovation->status == 'implemented') 🚀
                        @else 🔬
                        @endif
                    </span>
                </div>
                <div class="p-3 flex-1">
                    <h3 class="text-sm font-semibold text-dark mb-1 leading-tight">{{ Str::limit($innovation->title, 40) }}</h3>
                    <p class="text-xs text-gray-600 mb-2">{{ Str::limit($innovation->description, 50) }}</p>

                    <div class="flex items-center justify-between text-xs text-gray-500 mb-1">
                        <span class="truncate">{{ Str::limit($innovation->institution, 12) }}</span>
                        <div class="flex items-center">
                            ⭐ {{ $innovation->rating }}
                            @if($innovation->is_verified)
                            <span class="text-green-500 ml-0.5">✓</span>
                            @endif
                        </div>
                    </div>

                    <div class="flex justify-between items-center text-xs text-gray-500">
                        <span>{{ $innovation->research_duration }}bln</span>
                        <span class="capitalize">{{ $innovation->innovation_type }}</span>
                    </div>
                </div>
                <div class="px-3 pb-3">
                    <a href="#" class="block w-full text-center bg-green-100 text-green-700 hover:bg-green-200 text-xs font-medium py-1.5 rounded transition">
                        Ajukan Kolaborasi
                    </a>
                </div>
            </div>
            @endforeach
        </div>
        @else
        <div class="text-center py-8 bg-white rounded-lg border border-gray-200">
            <div class="text-gray-400 text-3xl mb-2">💡</div>
            <p class="text-gray-500 text-sm mb-3">Belum ada inovasi yang diposting.</p>
            <a href="{{ route('pemerintah.inovasi.create') }}" class="inline-block bg-purple-500 text-white px-4 py-2 rounded-lg hover:bg-purple-600 transition text-xs">
                💡 Buat Inovasi Pertama
            </a>
        </div>
        @endif
    </div>
</section>



@endsection