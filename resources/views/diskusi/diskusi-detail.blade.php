@extends('layouts.app')
@section('title', 'Detail Diskusi Inovasi')

@section('content')
<section class="px-6 py-8 max-w-5xl mx-auto">

    <!-- Detail Inovasi -->
    <div class="bg-white shadow rounded p-6 mb-6 relative">

        <!-- Gambar Inovasi -->
        @if($innovation->image_path)
        <img src="{{ asset('storage/' . $innovation->image_path) }}" 
             alt="Gambar Inovasi" 
             class="mb-4 rounded w-full max-h-96 object-cover">
        @endif

        <!-- Tombol Action / Ajukan Kolaborasi -->
        @auth
        @php
            $disabled = ($myCollaboration && in_array($myCollaboration->status, ['pending','accepted']));
        @endphp
        <div class="absolute top-4 right-4">
            <a href="{{ route('kolaborasi.ide.create', ['innovation_id'=>$innovation->id]) }}" 
               class="px-3 py-1 bg-gray-200 rounded @if($disabled) opacity-50 cursor-not-allowed @endif">
               Ajukan Kolaborasi
            </a>
        </div>
        @endauth

        <!-- Judul & Informasi Inovasi -->
        <h2 class="text-2xl font-bold mb-2">{{ $innovation->title }}</h2>
        <p class="text-sm mb-1 text-gray-600">
            {{ $innovation->category ?? '-' }} > {{ $innovation->subcategory_name ?? '-' }}
        </p>
        <p class="text-sm mb-1">
            TRL: <span class="font-semibold">{{ $innovation->technology_readiness_level ?? '-' }}</span>
        </p>
        <p class="text-sm mb-1">
            Oleh: <span class="font-semibold">{{ $innovation->author_name ?? '-' }}</span> 
            ({{ $innovation->institution_name ?? '-' }})
        </p>
        <p class="text-sm mb-1 text-gray-500">
            Diterbitkan: {{ \Carbon\Carbon::parse($innovation->created_at)->translatedFormat('d F Y, H:i') }}
        </p>

        <!-- Deskripsi Inovasi -->
        <p class="mt-4 leading-relaxed">{{ $innovation->description ?? '-' }}</p>

        <!-- Dokumen & Video -->
        @if($innovation->document_path)
        <p class="mt-2">
            Dokumen: <a href="{{ asset('storage/' . $innovation->document_path) }}" 
                        target="_blank" class="text-blue-600 underline">Download</a>
        </p>
        @endif
        @if($innovation->video_url)
        <div class="mt-4">
            <iframe width="100%" height="400" src="{{ $innovation->video_url }}" frameborder="0" allowfullscreen></iframe>
        </div>
        @endif

    </div>

    <!-- Notifikasi Pengajuan Kolaborasi -->
    @auth
        @if(isset($pendingForOwner) && $innovation->user_id == auth()->id() && $pendingForOwner)
            <div class="bg-yellow-100 border-l-4 border-yellow-500 p-4 mb-4">
                1 pengajuan kolaborasi telah diajukan. 
                <a href="{{ route('kolaborasi.ide.create', ['innovation_id'=>$innovation->id]) }}" class="underline text-blue-600">Review & ACC</a>
            </div>
        @elseif(isset($myCollaboration) && $myCollaboration)
            @if($myCollaboration->status == 'pending')
                <div class="bg-blue-100 border-l-4 border-blue-500 p-4 mb-4">
                    Pengajuan kolaborasi Anda sedang ditinjau.
                </div>
            @elseif($myCollaboration->status == 'accepted')
                <div class="bg-green-100 border-l-4 border-green-500 p-4 mb-4">
                    Pengajuan kolaborasi diterima. 
                    <a href="{{ route('kolaborasi.ide.create', ['innovation_id'=>$innovation->id]) }}" class="bg-blue-600 text-white px-2 py-1 rounded text-sm">Bergabung Kolaborasi</a>
                </div>
            @elseif($myCollaboration->status == 'rejected')
                <div class="bg-red-100 border-l-4 border-red-500 p-4 mb-4">
                    Pengajuan kolaborasi ditolak. Tombol ajukan kembali sudah aktif.
                </div>
            @endif
        @endif
    @endauth

    <!-- User Tergabung -->
    @if(isset($participants) && $participants->count())
    <div class="mb-8">
        <h3 class="font-bold mb-3 text-lg">User Tergabung</h3>
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-5 gap-4">
            @foreach($participants as $user)
            <div class="bg-gray-100 p-4 rounded text-center">
                <img src="{{ $user->avatar ? asset('storage/' . $user->avatar) : asset('images/default-avatar.png') }}" 
                     class="w-12 h-12 mx-auto rounded-full mb-2">
                <div class="font-semibold text-sm">{{ $user->name ?? '-' }}</div>
                <div class="text-xs text-gray-600">{{ $user->institution_name ?? '-' }}</div>
            </div>
            @endforeach
        </div>
    </div>
    @endif

    <!-- Komentar -->
    <div class="mb-8">
        <h3 class="font-bold mb-3 text-lg">Komentar</h3>

        @auth
        <form action="{{ route('forum-diskusi.add-comment', ['type'=>$innovation->author_role,'id'=>$innovation->id]) }}" method="POST" class="mb-4">
            @csrf
            <textarea name="content" placeholder="Tulis komentar Anda..." class="w-full border rounded p-2 mb-2 text-sm" required></textarea>
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded text-sm hover:bg-blue-700">Kirim Komentar</button>
        </form>
        @else
        <p class="text-gray-500 mb-4">Silakan <a href="{{ route('login') }}" class="text-blue-600 underline">login</a> untuk menulis komentar.</p>
        @endauth

        @if(isset($comments) && $comments->count())
            @foreach($comments as $comment)
            <div class="bg-gray-50 p-4 rounded mb-3">
                <div class="flex items-center mb-2 justify-between">
                    <div class="flex items-center">
                        <img src="{{ $comment->user_avatar ? asset('storage/' . $comment->user_avatar) : asset('images/default-avatar.png') }}" 
                             class="w-8 h-8 rounded-full mr-2">
                        <div>
                            <div class="font-semibold text-sm">{{ $comment->user_name ?? 'Anonymous' }}</div>
                            <div class="text-xs text-gray-500">
                                {{ $comment->user_institution ?? '-' }} | {{ ucfirst($comment->user_role ?? '-') }} | {{ \Carbon\Carbon::parse($comment->created_at)->diffForHumans() }}
                            </div>
                        </div>
                    </div>
                    @if(auth()->check() && auth()->id() == $comment->user_id)
                    <form action="{{ route('forum-diskusi.delete-comment', ['id'=>$comment->id]) }}" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-600 text-xs ml-2 hover:underline">Hapus</button>
                    </form>
                    @endif
                </div>
                <p class="text-sm">{{ $comment->content }}</p>
            </div>
            @endforeach
        @else
        <p class="text-gray-500 text-sm">Belum ada komentar.</p>
        @endif

    </div>

</section>
@endsection
