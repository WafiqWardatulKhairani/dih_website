@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto mt-8 mb-8 px-4 sm:px-6 lg:px-8">
    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
        <!-- Gambar dengan aspect ratio 16:9 -->
        <div class="w-full">
            @if($innovation->image_path)
                <div class="aspect-w-16 aspect-h-9">
                    <img src="{{ asset('storage/' . $innovation->image_path) }}" 
                         alt="{{ $innovation->title }}" 
                         class="w-full h-80 object-cover">
                </div>
            @else
                <div class="aspect-w-16 aspect-h-9 bg-gradient-to-r from-gray-100 to-gray-200 flex items-center justify-center">
                    <i class="fas fa-image fa-3x text-gray-400"></i>
                </div>
            @endif
        </div>

        <!-- Konten di bawah gambar -->
        <div class="p-6 sm:p-8">
            <!-- Breadcrumb dengan fallback route -->
            <div class="flex items-center text-sm text-gray-500 mb-4">
                @if(Route::has('akademisi.inovasi.index'))
                    <a href="{{ route('akademisi.inovasi.index') }}" class="hover:text-blue-600 transition duration-200">
                        <i class="fas fa-arrow-left mr-2"></i>Kembali ke Daftar Inovasi
                    </a>
                @else
                    <a href="{{ url('/akademisi/inovasi') }}" class="hover:text-blue-600 transition duration-200">
                        <i class="fas fa-arrow-left mr-2"></i>Kembali ke Daftar Inovasi
                    </a>
                @endif
            </div>

            <h1 class="text-3xl font-bold text-gray-900 mb-4 leading-tight">{{ $innovation->title }}</h1>
            
            <!-- Meta informasi -->
            <div class="flex flex-wrap items-center text-sm text-gray-500 mb-6 pb-4 border-b border-gray-200">
                <span class="inline-flex items-center mr-4 mb-2">
                    <i class="fas fa-tag mr-2 text-blue-500"></i>
                    {{ $innovation->category ?? '-' }}
                    @if($innovation->subcategory)
                        <span class="mx-2">›</span>
                        {{ $innovation->subcategory }}
                    @endif
                </span>
                <span class="inline-flex items-center mr-4 mb-2">
                    <i class="far fa-calendar mr-2 text-green-500"></i>
                    {{ $innovation->created_at->translatedFormat('d F Y') }}
                </span>
                <span class="inline-flex items-center mb-2">
                    <i class="far fa-clock mr-2 text-purple-500"></i>
                    {{ $innovation->created_at->diffForHumans() }}
                </span>
            </div>

            <!-- Grid informasi utama -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
                <div class="space-y-4">
                    <div class="flex items-start bg-gray-50 p-4 rounded-lg">
                        <i class="fas fa-user text-blue-500 mt-1 mr-3 text-lg"></i>
                        <div>
                            <h5 class="font-semibold text-gray-900 mb-1">Penemu / Penulis</h5>
                            <p class="text-gray-700">{{ $innovation->author_name ?? '-' }}</p>
                        </div>
                    </div>
                    
                    <div class="flex items-start bg-gray-50 p-4 rounded-lg">
                        <i class="fas fa-key text-green-500 mt-1 mr-3 text-lg"></i>
                        <div>
                            <h5 class="font-semibold text-gray-900 mb-1">Kata Kunci</h5>
                            <p class="text-gray-700">
                                @if($innovation->keywords)
                                    @foreach(explode(',', $innovation->keywords) as $keyword)
                                        <span class="inline-block bg-green-100 text-green-800 px-2 py-1 rounded-full text-sm mr-2 mb-1">
                                            {{ trim($keyword) }}
                                        </span>
                                    @endforeach
                                @else
                                    -
                                @endif
                            </p>
                        </div>
                    </div>
                </div>
                
                <div class="space-y-4">
                    <div class="flex items-start bg-gray-50 p-4 rounded-lg">
                        <i class="fas fa-university text-purple-500 mt-1 mr-3 text-lg"></i>
                        <div>
                            <h5 class="font-semibold text-gray-900 mb-1">Institusi</h5>
                            <p class="text-gray-700">{{ $innovation->institution ?? '-' }}</p>
                        </div>
                    </div>
                    
                    <div class="flex items-start bg-gray-50 p-4 rounded-lg">
                        <i class="fas fa-chart-line text-orange-500 mt-1 mr-3 text-lg"></i>
                        <div>
                            <h5 class="font-semibold text-gray-900 mb-1">Tingkat Kesiapterapan Teknologi (TRL)</h5>
                            <p class="text-gray-700 font-medium">
                                Level {{ $innovation->technology_readiness_level }}
                            </p>
                            <div class="w-full bg-gray-200 rounded-full h-2 mt-2">
                                <div class="bg-orange-500 h-2 rounded-full" 
                                     style="width: {{ ($innovation->technology_readiness_level / 9) * 100 }}%"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Deskripsi -->
            <div class="mb-8">
                <h4 class="font-semibold text-xl mb-4 text-gray-900 flex items-center">
                    <i class="fas fa-align-left text-blue-500 mr-3"></i>
                    Deskripsi Inovasi
                </h4>
                <div class="bg-blue-50 p-6 rounded-lg">
                    <p class="text-gray-700 leading-relaxed text-lg whitespace-pre-line">{{ $innovation->description }}</p>
                </div>
            </div>

            <!-- Tujuan Inovasi -->
            <div class="mb-8">
                <h4 class="font-semibold text-xl mb-4 text-gray-900 flex items-center">
                    <i class="fas fa-bullseye text-green-500 mr-3"></i>
                    Tujuan Inovasi
                </h4>
                <div class="bg-green-50 p-6 rounded-lg">
                    <p class="text-gray-700 leading-relaxed text-lg whitespace-pre-line">{{ $innovation->purpose }}</p>
                </div>
            </div>

            <!-- Informasi Tambahan -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                <!-- Kontak -->
                <div class="bg-purple-50 p-6 rounded-lg">
                    <h4 class="font-semibold text-lg mb-3 text-gray-900 flex items-center">
                        <i class="fas fa-envelope text-purple-500 mr-3"></i>
                        Kontak
                    </h4>
                    <p class="text-gray-700 break-words">{{ $innovation->contact ?? 'Tidak tersedia' }}</p>
                </div>

                <!-- Status -->
                <div class="bg-yellow-50 p-6 rounded-lg">
                    <h4 class="font-semibold text-lg mb-3 text-gray-900 flex items-center">
                        <i class="fas fa-info-circle text-yellow-500 mr-3"></i>
                        Status
                    </h4>
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

            <!-- Video dan Actions -->
            @if($innovation->video_url)
                <div class="mb-8">
                    <h4 class="font-semibold text-xl mb-4 text-gray-900 flex items-center">
                        <i class="fas fa-video text-red-500 mr-3"></i>
                        Video Demonstrasi
                    </h4>
                    <a href="{{ $innovation->video_url }}" target="_blank" rel="noopener noreferrer"
                       class="inline-flex items-center justify-center px-6 py-3 bg-red-600 text-white rounded-lg hover:bg-red-700 transition duration-200 shadow-md hover:shadow-lg">
                        <i class="fas fa-play mr-2"></i>
                        Tonton Video Demonstrasi
                    </a>
                </div>
            @endif

            <!-- Actions untuk pemilik inovasi -->
            @auth
                @if(auth()->id() == $innovation->user_id)
                    <div class="pt-8 border-t border-gray-200">
                        <h4 class="font-semibold text-lg mb-4 text-gray-900">Kelola Inovasi</h4>
                        <div class="flex flex-col sm:flex-row gap-4">
                            @if($innovation->document_path)
                                <a href="{{ asset('storage/' . $innovation->document_path) }}" target="_blank" 
                                   class="inline-flex items-center justify-center px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition duration-200 shadow-md hover:shadow-lg flex-1 sm:flex-none">
                                    <i class="fas fa-download mr-2"></i>
                                    Unduh Dokumen Lengkap
                                </a>
                            @endif

                            <!-- Tombol Edit dengan fallback route -->
                            @if(Route::has('akademisi.inovasi.edit'))
                                <a href="{{ route('akademisi.inovasi.edit', $innovation->id) }}" 
                                   class="inline-flex items-center justify-center px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition duration-200 shadow-md hover:shadow-lg flex-1 sm:flex-none">
                                    <i class="fas fa-edit mr-2"></i>
                                    Edit Inovasi
                                </a>
                            @else
                                <a href="{{ url('/akademisi/inovasi/' . $innovation->id . '/edit') }}" 
                                   class="inline-flex items-center justify-center px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition duration-200 shadow-md hover:shadow-lg flex-1 sm:flex-none">
                                    <i class="fas fa-edit mr-2"></i>
                                    Edit Inovasi
                                </a>
                            @endif
                        </div>
                    </div>
                @endif
            @endauth

            <!-- Flash message untuk success update -->
            @if(session('success'))
                <div class="mt-6 p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg">
                    <div class="flex items-center">
                        <i class="fas fa-check-circle mr-2"></i>
                        {{ session('success') }}
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Style tambahan -->
<style>
    .aspect-w-16 {
        position: relative;
    }
    .aspect-w-16::before {
        content: '';
        display: block;
        padding-bottom: 56.25%; /* 16:9 aspect ratio */
    }
    .aspect-w-16 > * {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
    }
    
    /* Smooth transitions for all interactive elements */
    .transition {
        transition: all 0.3s ease;
    }
    
    /* Better focus styles for accessibility */
    a:focus {
        outline: 2px solid #3b82f6;
        outline-offset: 2px;
    }
</style>
@endsection