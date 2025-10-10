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
</style>
@endsection

@section('content')
<!-- Hero Section -->
<section class="hero-bg text-white py-12">
    <div class="container mx-auto px-6 md:px-12">
        <div class="flex items-center justify-between">
            <div>
                <a href="{{ route('pemerintah.program') }}" class="inline-flex items-center text-blue-100 hover:text-white mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                    Kembali ke Program
                </a>
                <h1 class="text-3xl md:text-4xl font-bold mb-2">{{ $program->title }}</h1>
                <p class="text-blue-100 text-lg">{{ $program->opd_name }}</p>
            </div>
            <span class="bg-white text-primary px-4 py-2 rounded-full text-sm font-semibold">
                @if($program->status == 'planning') 📅 Perencanaan
                @elseif($program->status == 'ongoing') 🚀 Berjalan
                @else ✅ Selesai
                @endif
            </span>
        </div>
    </div>
</section>

<!-- Content Section -->
<section class="bg-white py-8">
    <div class="container mx-auto px-6 md:px-12">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Main Content -->
            <div class="lg:col-span-2">
                @if($program->image)
                <div class="mb-6">
                    <img src="{{ asset('storage/' . $program->image) }}" alt="{{ $program->title }}" 
                         class="w-full h-64 object-cover rounded-lg shadow-md">
                </div>
                @endif
                
                <div class="prose max-w-none">
                    <h3 class="text-xl font-semibold mb-4">Deskripsi Program</h3>
                    <p class="text-gray-700 leading-relaxed">{{ $program->description }}</p>
                </div>

                <!-- Progress Section -->
                <div class="mt-8 bg-gray-50 p-6 rounded-lg">
                    <h3 class="text-xl font-semibold mb-4">Progress Pelaksanaan</h3>
                    <div class="mb-4">
                        <div class="flex justify-between text-sm text-gray-600 mb-2">
                            <span>Progress saat ini</span>
                            <span>{{ $program->progress }}%</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-3">
                            <div class="bg-green-600 h-3 rounded-full transition-all duration-500" 
                                 style="width: {{ $program->progress }}%"></div>
                        </div>
                    </div>
                    
                    <div class="grid grid-cols-2 gap-4 text-sm">
                        <div>
                            <span class="text-gray-500">Tanggal Mulai:</span>
                            <p class="font-medium">{{ $program->start_date->format('d M Y') }}</p>
                        </div>
                        <div>
                            <span class="text-gray-500">Tanggal Selesai:</span>
                            <p class="font-medium">{{ $program->end_date->format('d M Y') }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                <!-- Info Box -->
                <div class="bg-blue-50 border border-blue-200 rounded-lg p-6">
                    <h4 class="font-semibold text-blue-800 mb-4">Informasi Program</h4>
                    <div class="space-y-3">
                        <div>
                            <span class="text-blue-600 text-sm">Kategori:</span>
                            <p class="font-medium">{{ $program->category }}</p>
                        </div>
                        <div>
                            <span class="text-blue-600 text-sm">OPD Penanggung Jawab:</span>
                            <p class="font-medium">{{ $program->opd_name }}</p>
                        </div>
                        @if($program->budget)
                        <div>
                            <span class="text-blue-600 text-sm">Anggaran:</span>
                            <p class="font-medium">Rp {{ number_format($program->budget, 0, ',', '.') }}</p>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="bg-white border border-gray-200 rounded-lg p-6">
                    <h4 class="font-semibold text-dark mb-4">Aksi</h4>
                    <div class="space-y-3">
                        <a href="{{ route('pemerintah.program.edit', $program->id) }}" 
                           class="w-full inline-flex justify-center items-center bg-primary text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">
                            ✏️ Edit Program
                        </a>
                        <form action="{{ route('pemerintah.program.destroy', $program->id) }}" method="POST" class="inline w-full">
                            @csrf
                            @method('DELETE')
                            <button type="submit" 
                                    class="w-full inline-flex justify-center items-center bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700 transition"
                                    onclick="return confirm('Yakin ingin menghapus program ini?')">
                                🗑️ Hapus Program
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Status Info -->
                <div class="bg-green-50 border border-green-200 rounded-lg p-6">
                    <h4 class="font-semibold text-green-800 mb-2">Status Program</h4>
                    <div class="flex items-center">
                        <div class="w-3 h-3 bg-green-500 rounded-full mr-2"></div>
                        <span class="text-green-700">
                            @if($program->status == 'planning')
                                Program dalam tahap perencanaan
                            @elseif($program->status == 'ongoing')
                                Program sedang berjalan
                            @else
                                Program telah selesai
                            @endif
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection