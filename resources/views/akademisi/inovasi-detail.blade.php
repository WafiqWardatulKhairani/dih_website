@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto mt-10 mb-12 px-4 sm:px-6 lg:px-8">
    <div class="bg-white rounded-xl shadow-xl overflow-hidden border border-gray-200">
        <!-- Header Gambar -->
        <div class="w-full">
            @if($innovation->image_path)
                <div class="aspect-w-16 aspect-h-9">
                    <img src="{{ asset('storage/' . $innovation->image_path) }}" 
                         alt="{{ $innovation->title }}" 
                         class="w-full h-96 object-cover rounded-t-xl">
                </div>
            @else
                <div class="aspect-w-16 aspect-h-9 bg-gray-100 flex items-center justify-center rounded-t-xl">
                    <i class="fas fa-image fa-4x text-gray-400"></i>
                </div>
            @endif
        </div>

        <!-- Konten Utama -->
        <div class="p-8 sm:p-10 space-y-10">

            <!-- Breadcrumb -->
            <div class="text-sm text-gray-600 mb-6">
                <a href="{{ route('akademisi.inovasi.index') }}" class="hover:text-blue-700 transition duration-200">
                    <i class="fas fa-arrow-left mr-2"></i>Kembali ke Daftar Inovasi
                </a>
            </div>

            <!-- Judul -->
            <h1 class="text-4xl font-bold text-gray-900 leading-tight mb-6">{{ $innovation->title }}</h1>

            <!-- Meta Info -->
            <div class="flex flex-wrap text-sm text-gray-500 mb-8 space-x-6">
                <span>
                    <i class="fas fa-tag text-blue-500 mr-1"></i>
                    {{ $innovation->category ?? '-' }} 
                    @if($innovation->subcategory)
                        <span class="mx-1">›</span>{{ $innovation->subcategory }}
                    @endif
                </span>
                <span>
                    <i class="far fa-calendar-alt text-green-500 mr-1"></i>
                    {{ $innovation->created_at->translatedFormat('d F Y') }}
                </span>
                <span>
                    <i class="far fa-clock text-purple-500 mr-1"></i>
                    {{ $innovation->created_at->diffForHumans() }}
                </span>
            </div>

            <!-- Grid Informasi Utama -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <div class="space-y-4">
                    <div class="bg-gray-50 p-5 rounded-lg shadow-sm">
                        <h5 class="font-semibold text-gray-800 mb-1">Penemu / Penulis</h5>
                        <p class="text-gray-700">{{ $innovation->author_name ?? '-' }}</p>
                    </div>
                    <div class="bg-gray-50 p-5 rounded-lg shadow-sm">
                        <h5 class="font-semibold text-gray-800 mb-1">Kata Kunci</h5>
                        <p class="text-gray-700">
                            @if($innovation->keywords)
                                @foreach(explode(',', $innovation->keywords) as $keyword)
                                    <span class="inline-block bg-blue-100 text-blue-800 px-2 py-1 rounded-full text-sm mr-2 mb-1">
                                        {{ trim($keyword) }}
                                    </span>
                                @endforeach
                            @else
                                -
                            @endif
                        </p>
                    </div>
                </div>

                <div class="space-y-4">
                    <div class="bg-gray-50 p-5 rounded-lg shadow-sm">
                        <h5 class="font-semibold text-gray-800 mb-1">Institusi</h5>
                        <p class="text-gray-700">{{ $innovation->institution ?? '-' }}</p>
                    </div>
                    <div class="bg-gray-50 p-5 rounded-lg shadow-sm">
                        <h5 class="font-semibold text-gray-800 mb-1">Tingkat Kesiapterapan Teknologi (TRL)</h5>
                        <p class="text-gray-700 font-medium mb-2">Level {{ $innovation->technology_readiness_level }}</p>
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            <div class="bg-orange-500 h-2 rounded-full" 
                                 style="width: {{ ($innovation->technology_readiness_level / 9) * 100 }}%"></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Deskripsi -->
            <div>
                <h2 class="text-2xl font-semibold mb-4 text-gray-900 border-b border-gray-200 pb-2">Deskripsi Inovasi</h2>
                <div class="bg-gray-50 p-6 rounded-lg shadow-sm">
                    <p class="text-gray-700 text-justify leading-relaxed text-lg whitespace-pre-line">
                        {{ $innovation->description }}
                    </p>
                </div>
            </div>

            <!-- Tujuan -->
            <div>
                <h2 class="text-2xl font-semibold mb-4 text-gray-900 border-b border-gray-200 pb-2">Tujuan Inovasi</h2>
                <div class="bg-gray-50 p-6 rounded-lg shadow-sm">
                    <p class="text-gray-700 text-justify leading-relaxed text-lg whitespace-pre-line">
                        {{ $innovation->purpose }}
                    </p>
                </div>
            </div>

            <!-- Kontak & Status -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="bg-gray-50 p-5 rounded-lg shadow-sm">
                    <h5 class="font-semibold text-gray-800 mb-2">Kontak</h5>
                    <p class="text-gray-700 break-words">{{ $innovation->contact ?? 'Tidak tersedia' }}</p>
                </div>
                <div class="bg-gray-50 p-5 rounded-lg shadow-sm">
                    <h5 class="font-semibold text-gray-800 mb-2">Status</h5>
                    @php
                        $statusColors = [
                            'draft' => 'bg-gray-100 text-gray-800',
                            'submitted' => 'bg-blue-100 text-blue-800',
                            'under_review' => 'bg-yellow-100 text-yellow-800',
                            'approved' => 'bg-green-100 text-green-800',
                            'published' => 'bg-green-100 text-green-800',
                            'rejected' => 'bg-red-100 text-red-800'
                        ];
                        $statusText = [
                            'draft' => 'Draft',
                            'submitted' => 'Terkirim',
                            'under_review' => 'Dalam Review',
                            'approved' => 'Disetujui',
                            'published' => 'Dipublikasikan',
                            'rejected' => 'Ditolak'
                        ];
                        $status = strtolower($innovation->status ?? 'draft');
                        $statusColor = $statusColors[$status] ?? 'bg-gray-100 text-gray-800';
                        $statusDisplay = $statusText[$status] ?? ucfirst($status);
                    @endphp
                    <span class="px-4 py-2 {{ $statusColor }} rounded-full text-sm font-medium">
                        {{ $statusDisplay }}
                    </span>
                </div>
            </div>

            <!-- Video Demonstrasi -->
            @if($innovation->video_url)
                <div>
                    <h2 class="text-2xl font-semibold mb-4 text-gray-900 border-b border-gray-200 pb-2">Video Demonstrasi</h2>
                    <a href="{{ $innovation->video_url }}" target="_blank" rel="noopener noreferrer"
                       class="inline-flex items-center justify-center px-6 py-3 bg-red-600 text-white rounded-lg hover:bg-red-700 transition duration-200 shadow-md hover:shadow-lg">
                        <i class="fas fa-play mr-2"></i>Tonton Video Demonstrasi
                    </a>
                </div>
            @endif

            <!-- Dokumen & Edit -->
            @auth
                @if(auth()->id() == $innovation->user_id)
                    <div class="mt-8 flex flex-col sm:flex-row gap-4">
                        @if($innovation->document_path)
                            <a href="{{ asset('storage/' . $innovation->document_path) }}" target="_blank"
                               class="inline-flex items-center justify-center px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition duration-200 shadow-md hover:shadow-lg flex-1 sm:flex-none">
                                <i class="fas fa-download mr-2"></i> Unduh Dokumen Lengkap
                            </a>
                        @endif
                        <a href="{{ route('akademisi.inovasi.edit', $innovation->id) }}" 
                           class="inline-flex items-center justify-center px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition duration-200 shadow-md hover:shadow-lg flex-1 sm:flex-none">
                            <i class="fas fa-edit mr-2"></i> Edit Inovasi
                        </a>
                        <form action="{{ route('akademisi.inovasi.destroy', $innovation->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus inovasi ini?');" class="inline-flex flex-1 sm:flex-none">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                    class="px-6 py-3 bg-red-600 text-white rounded-lg hover:bg-red-700 transition duration-200 shadow-md hover:shadow-lg w-full">
                                <i class="fas fa-trash mr-2"></i> Hapus Inovasi
                            </button>
                        </form>
                    </div>
                @endif
            @endauth

            <!-- Flash Message -->
            @if(session('success'))
                <div class="mt-6 p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg">
                    <i class="fas fa-check-circle mr-2"></i>{{ session('success') }}
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Justify dan Style tambahan -->
<style>
    .text-justify {
        text-align: justify;
    }
    .aspect-w-16 {
        position: relative;
    }
    .aspect-w-16::before {
        content: '';
        display: block;
        padding-bottom: 56.25%; /* 16:9 ratio */
    }
    .aspect-w-16 > * {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
    }
</style>
@endsection
