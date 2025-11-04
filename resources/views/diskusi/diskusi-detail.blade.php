@extends('layouts.app')
@section('title', 'Detail Diskusi Inovasi')

@php
use Carbon\Carbon;
@endphp

@section('content')
<div class="max-w-6xl mx-auto mt-10 mb-12 px-4 sm:px-6 lg:px-8">
    <div class="flex flex-col lg:flex-row gap-8">

        <!-- Konten Utama -->
        <div class="flex-1 bg-white rounded-xl shadow-xl overflow-hidden border border-gray-200">

            <!-- Header Gambar -->
            @if($innovation->image_url)
                <div class="w-full aspect-w-16 aspect-h-9">
                    <img src="{{ $innovation->image_url }}" 
                         alt="{{ $innovation->title }}" 
                         class="w-full h-96 object-cover rounded-t-xl">
                </div>
            @else
                <div class="w-full aspect-w-16 aspect-h-9 bg-gray-100 flex items-center justify-center rounded-t-xl">
                    <i class="fas fa-image fa-4x text-gray-400"></i>
                </div>
            @endif

            <div class="p-8 sm:p-10 space-y-8">
                <!-- Breadcrumb -->
                <div class="text-sm text-gray-600 mb-6">
                    <a href="{{ route('forum-diskusi.index') }}" class="hover:text-blue-700 transition duration-200">
                        <i class="fas fa-arrow-left mr-2"></i>Kembali ke Forum
                    </a>
                </div>

                <!-- Judul -->
                <h1 class="text-4xl font-bold text-gray-900 leading-tight mb-4">{{ $innovation->title }}</h1>

                <!-- Meta Info -->
                @php
                    $createdAt = $innovation->created_at instanceof Carbon ? $innovation->created_at : Carbon::parse($innovation->created_at ?? now());
                @endphp
                <div class="flex flex-wrap text-sm text-gray-500 mb-6 space-x-6">
                    <span>
                        <i class="fas fa-tag text-blue-500 mr-1"></i>
                        {{ $innovation->category ?? '-' }} 
                        @if($innovation->subcategory_name && $innovation->subcategory_name != '-')
                            <span class="mx-1">›</span>{{ $innovation->subcategory_name }}
                        @endif
                    </span>
                    <span>
                        <i class="far fa-calendar-alt text-green-500 mr-1"></i>
                        {{ $createdAt->translatedFormat('d F Y') }}
                    </span>
                    <span>
                        <i class="far fa-clock text-purple-500 mr-1"></i>
                        {{ $createdAt->diffForHumans() }}
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
                            <p class="text-gray-700 font-medium mb-2">Level {{ $innovation->technology_readiness_level ?? 0 }}</p>
                            <div class="w-full bg-gray-200 rounded-full h-2">
                                <div class="bg-orange-500 h-2 rounded-full" 
                                     style="width: {{ ($innovation->technology_readiness_level ?? 0) / 9 * 100 }}%"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Deskripsi -->
                <div>
                    <h2 class="text-2xl font-semibold mb-4 text-gray-900 border-b border-gray-200 pb-2">Deskripsi Inovasi</h2>
                    <div class="bg-gray-50 p-6 rounded-lg shadow-sm">
                        <p class="text-gray-700 text-justify leading-relaxed text-lg whitespace-pre-line">
                            {{ $innovation->description ?? '-' }}
                        </p>
                    </div>
                </div>

                <!-- Tujuan -->
                <div>
                    <h2 class="text-2xl font-semibold mb-4 text-gray-900 border-b border-gray-200 pb-2">Tujuan Inovasi</h2>
                    <div class="bg-gray-50 p-6 rounded-lg shadow-sm">
                        <p class="text-gray-700 text-justify leading-relaxed text-lg whitespace-pre-line">
                            {{ $innovation->purpose ?? '-' }}
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
                                'publication' => 'bg-green-100 text-green-800',
                                'rejected' => 'bg-red-100 text-red-800'
                            ];
                            $statusText = [
                                'draft' => 'Draft',
                                'submitted' => 'Terkirim',
                                'under_review' => 'Dalam Review',
                                'approved' => 'Disetujui',
                                'publication' => 'Dipublikasikan',
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
                @if(!empty($innovation->video_url))
                    <div>
                        <h2 class="text-2xl font-semibold mb-4 text-gray-900 border-b border-gray-200 pb-2">Video Demonstrasi</h2>
                        <a href="{{ $innovation->video_url }}" target="_blank" rel="noopener noreferrer"
                           class="inline-flex items-center justify-center px-6 py-3 bg-red-600 text-white rounded-lg hover:bg-red-700 transition duration-200 shadow-md hover:shadow-lg">
                            <i class="fas fa-play mr-2"></i>Tonton Video Demonstrasi
                        </a>
                    </div>
                @endif

                <!-- 🔽 Tambahan: Tombol Unduh Dokumen -->
                @if(!empty($innovation->document_path))
                    <div>
                        <h2 class="text-2xl font-semibold mb-4 text-gray-900 border-b border-gray-200 pb-2">Dokumen Inovasi</h2>
                        <a href="{{ asset('storage/' . $innovation->document_path) }}" target="_blank"
                           class="inline-flex items-center justify-center px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition duration-200 shadow-md hover:shadow-lg">
                            <i class="fas fa-download mr-2"></i> Unduh Dokumen
                        </a>
                    </div>
                @endif
                <!-- 🔼 End of Tambahan -->

                <!-- Komentar -->
                <div>
                    <h2 class="text-2xl font-semibold mb-4 text-gray-900 border-b border-gray-200 pb-2">Komentar</h2>

                    @auth
                    <form action="{{ route('forum-diskusi.add-comment', ['type'=>$type,'id'=>$innovation->id]) }}" method="POST" class="mb-6">
                        @csrf
                        <textarea name="content" placeholder="Tulis komentar Anda..." class="w-full border rounded p-3 text-sm focus:ring-2 focus:ring-blue-300 mb-2" required>{{ old('content') }}</textarea>
                        <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700 transition">Kirim Komentar</button>
                    </form>
                    @else
                    <p class="text-gray-500 mb-4">
                        Silakan <a href="{{ route('login') }}" class="text-blue-600 underline">login</a> untuk menulis komentar.
                    </p>
                    @endauth

                    @if($comments->count())
                        @foreach($comments as $comment)
                        @php
                            $commentCreatedAt = $comment->created_at instanceof Carbon ? $comment->created_at : Carbon::parse($comment->created_at ?? now());
                            $avatar = $comment->avatar_url ?? asset('images/default-avatar.png');
                        @endphp
                        <div class="bg-gray-50 p-4 rounded-lg shadow mb-3">
                            <div class="flex items-start justify-between">
                                <div class="flex items-start gap-3">
                                    <img src="{{ $avatar }}" class="w-10 h-10 rounded-full object-cover">
                                    <div>
                                        <div class="font-semibold text-gray-800">{{ $comment->user_name ?? 'Anonymous' }}</div>
                                        <div class="text-xs text-gray-500">
                                            {{ $comment->user_role ?? '-' }} | {{ $commentCreatedAt->diffForHumans() }}
                                        </div>
                                        <p class="mt-1 text-gray-700 text-sm">{{ $comment->content }}</p>
                                    </div>
                                </div>
                                @if(auth()->check() && auth()->id() == $comment->user_id)
                                <form action="{{ route('forum-diskusi.delete-comment', ['id'=>$comment->id]) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 text-xs hover:underline ml-2">Hapus</button>
                                </form>
                                @endif
                            </div>
                        </div>
                        @endforeach
                    @else
                        <p class="text-gray-500 text-sm">Belum ada komentar.</p>
                    @endif
                </div>

            </div>
        </div>

        <!-- Sidebar -->
        <aside class="w-full lg:w-96 flex-shrink-0 space-y-6">
            <!-- Diskusi Lainnya -->
            <div class="bg-white rounded-xl shadow-xl border border-gray-200 p-6 space-y-6">
                <h3 class="text-xl font-semibold mb-4">Diskusi Lainnya</h3>
                @foreach($sidebarInnovations as $item)
                    @php
                        $commentsCount = \App\Models\DiscussionComment::where('innovation_id', $item->id)->count();
                    @endphp
                    <div class="p-4 bg-gray-50 rounded-lg shadow-sm hover:bg-gray-100 transition mb-3">
                        <h4 class="font-semibold text-gray-800">{{ $item->title }}</h4>
                        <p class="text-xs text-gray-500">{{ $item->category ?? '-' }} › {{ $item->subcategory ?? '-' }}</p>
                        <p class="text-xs text-gray-500">Penulis: {{ $item->author_name ?? '-' }}</p>
                        <p class="text-xs text-gray-400 mt-1">Komentar: {{ $commentsCount }}</p>
                    </div>
                @endforeach
            </div>

            <!-- Pengajuan Kolaborasi -->
            <div class="bg-white rounded-xl shadow-xl border border-gray-200 p-6 space-y-4">
                <h3 class="text-xl font-semibold mb-4">Pengajuan Kolaborasi</h3>
                @php
                    use App\Models\KolaborasiIde;
                    $userId = auth()->id();
                    $collaboration = KolaborasiIde::where('innovation_id', $innovation->id)->first();
                    $isOwner = $userId === $innovation->user_id;
                    $isApplicant = $collaboration && $userId === $collaboration->user_id;
                @endphp
                @if(!$collaboration)
                    <p class="text-gray-500 text-sm">Belum ada kolaborasi masuk.</p>
                    <a href="{{ route('kolaborasi.ide.create', ['innovation_id'=>$innovation->id]) }}" 
                       class="inline-block px-5 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                        Ajukan Kolaborasi Sekarang!
                    </a>
                @else
                    @if($isOwner)
                        <p class="text-gray-700 text-sm">Sudah ada 1 ajuan kolaborasi yang masuk.</p>
                        <a href="{{ route('kolaborasi.ide.show', ['id'=>$collaboration->id]) }}" 
                           class="inline-block px-5 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition">
                            Lihat Pengajuan Kolaborasi
                        </a>
                    @elseif($isApplicant)
                        <p class="text-gray-700 text-sm">Anda telah mengajukan kolaborasi. Menunggu persetujuan pemilik ide.</p>
                        <a href="{{ route('kolaborasi.ide.show', ['id'=>$collaboration->id]) }}" 
                           class="inline-block px-5 py-2 bg-yellow-500 text-white rounded-lg hover:bg-yellow-600 transition">
                            Edit Kolaborasi
                        </a>
                    @else
                        <p class="text-gray-700 text-sm">Sudah ada 1 kolaborasi yang masuk.</p>
                        <a href="{{ route('kolaborasi.ide.show', ['id'=>$collaboration->id]) }}" 
                           class="inline-block px-5 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition">
                            Gabung ke Kolaborasi
                        </a>
                    @endif
                @endif
            </div>
        </aside>
    </div>
</div>

@push('styles')
<style>
    .aspect-w-16 {
        position: relative;
    }
    .aspect-w-16::before {
        content: '';
        display: block;
        padding-bottom: 56.25%;
    }
    .aspect-w-16 > * {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
    }
</style>
@endpush

@endsection
