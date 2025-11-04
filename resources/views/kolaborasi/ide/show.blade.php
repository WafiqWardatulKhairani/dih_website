@extends('layouts.app')

@section('title', $kolaborasi->judul)

@section('content')
<div class="max-w-6xl mx-auto mt-10 mb-12 px-4 sm:px-6 lg:px-8 relative">

    {{-- ==================== PROGRESS POPUP ==================== --}}
    <button id="progressToggle"
        class="fixed top-1/3 right-4 z-40 bg-blue-600 text-white p-3 rounded-full shadow-lg hover:bg-blue-700 transition duration-300 transform hover:scale-110">
        <i class="fas fa-chart-line text-lg"></i>
    </button>

    {{-- Overlay popup --}}
    <div id="progressPopup" class="fixed inset-0 bg-black/40 backdrop-blur-sm hidden z-50 flex justify-center items-center">
        <div id="popupContent" 
             class="bg-white rounded-2xl shadow-2xl border border-gray-200 w-[90%] sm:w-[500px] max-h-[80vh] overflow-y-auto scale-0 opacity-0 transition-all duration-500 ease-out transform origin-center p-5">
            
            {{-- Header --}}
            <div class="flex justify-between items-center mb-4 border-b border-gray-200 pb-2">
                <h2 class="font-semibold text-lg text-blue-700 flex items-center gap-2">
                    <i class="text-green-500"></i> Progress Kolaborasi
                </h2>
                <button id="closePopup" 
                    class="text-gray-500 hover:text-gray-700 transition duration-200">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>

            @php
                use App\Models\KolaborasiTask;

                $tasks = KolaborasiTask::where('kolaborasi_id', $kolaborasi->id)->get();
                $doneTasks = $tasks->where('status', 'done')->count();
                $totalTasks = $tasks->count();
                $progressPercent = $totalTasks > 0 ? round(($doneTasks / $totalTasks) * 100) : 0;
            @endphp

            {{-- Ringkasan progress --}}
            <div class="bg-blue-50 border border-blue-100 p-4 rounded-lg mb-5 shadow-sm">
                <p class="font-semibold text-gray-700 mb-2">
                    Total Progress: 
                    <span class="text-blue-700">{{ $progressPercent }}%</span>
                </p>
                <div class="w-full bg-gray-200 h-3 rounded-full overflow-hidden">
                    <div class="bg-gradient-to-r from-blue-500 to-indigo-600 h-3 rounded-full transition-all duration-500" 
                         style="width: {{ $progressPercent }}%;"></div>
                </div>
                <p class="mt-2 text-xs text-gray-600">
                    {{ $doneTasks }} dari {{ $totalTasks }} tugas telah selesai
                </p>
            </div>

            {{-- Daftar progress detail per task --}}
            @if($tasks->count() > 0)
                <div class="divide-y divide-gray-200">
                    @foreach($tasks as $task)
                        <div class="py-3 transition hover:bg-blue-50 rounded-lg px-2">
                            <h3 class="font-medium text-gray-800">{{ $task->title }}</h3>
                            <p class="text-sm text-gray-600 mt-1">{{ $task->description }}</p>
                            <div class="flex justify-between items-center mt-2 text-sm">
                                <span class="
                                    px-2 py-1 rounded-full text-xs
                                    @if($task->status === 'done') bg-green-100 text-green-700
                                    @elseif($task->status === 'in_progress') bg-yellow-100 text-yellow-700
                                    @else bg-gray-100 text-gray-700
                                    @endif
                                ">
                                    {{ ucfirst($task->status ?? 'todo') }}
                                </span>
                                <span class="text-gray-400 text-xs">
                                    {{ $task->created_at->diffForHumans() }}
                                </span>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-gray-500 italic text-center py-8">
                    Belum ada tugas yang dibuat.
                </div>
            @endif
        </div>
    </div>
    {{-- ================== END POPUP ================== --}}

    {{-- ================== HALAMAN DETAIL ================== --}}
    <div class="bg-white border border-white rounded-2xl shadow-xl overflow-hidden">

        {{-- Gambar Kolaborasi --}}
        <div class="w-full relative h-80 border-b border-gray-200">
            @if($kolaborasi->image_path)
                <img src="{{ asset('storage/' . $kolaborasi->image_path) }}" 
                     alt="{{ $kolaborasi->judul }}" 
                     class="w-full h-full object-cover">
            @else
                <div class="w-full h-full bg-gradient-to-r from-[rgba(30,64,175,0.85)] to-[rgba(30,58,138,0.9)] flex items-center justify-center">
                    <i class="fas fa-lightbulb fa-3x text-blue-100 opacity-70"></i>
                </div>
            @endif
            <div class="absolute inset-0 bg-gradient-to-t from-[rgba(30,64,175,0.85)] to-[rgba(30,58,138,0.9)] mix-blend-multiply"></div>
        </div>

        <div class="p-8">
            {{-- Tombol Halaman Utama Kolaborasi --}}
            <div class="flex flex-wrap items-center gap-3 mb-6">
                <a href="{{ route('kolaborasi.detail', $kolaborasi->id) }}" 
                   class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                    <i class="fas fa-home"></i> Halaman Utama Kolaborasi
                </a>
            </div>

            {{-- Judul --}}
            <h1 class="text-3xl font-bold mb-4 text-gray-900">{{ $kolaborasi->judul }}</h1>

            @include('components.alert-kolaborasi')

            {{-- STATUS + KATEGORI --}}
            <div class="flex flex-wrap items-center justify-between mb-6">
                <div class="flex items-center space-x-3 text-sm">
                                        @if($kolaborasi->is_active)
                        <span class="px-3 py-1 rounded-full bg-green-100 text-green-700">Aktif</span>
                    @else
                        <span class="px-3 py-1 rounded-full bg-yellow-100 text-yellow-700">Belum Aktif</span>
                    @endif

                    <span class="px-3 py-1 rounded-full 
                        @if($kolaborasi->status === 'pending') bg-yellow-100 text-yellow-700 
                        @elseif($kolaborasi->status === 'approved') bg-green-100 text-green-700 
                        @elseif($kolaborasi->status === 'rejected') bg-red-100 text-red-700 
                        @else bg-gray-100 text-gray-700 @endif">
                        <strong>{{ ucfirst($kolaborasi->status ?? '') }}</strong>
                    </span>

                </div>

                <div class="flex flex-wrap gap-2 text-sm">
                    <span class="px-3 py-1 bg-blue-100 text-blue-700 rounded-full">
                        {{ $kolaborasi->category ?? 'Tanpa Kategori' }}
                    </span>
                    <span class="px-3 py-1 bg-purple-100 text-purple-700 rounded-full">
                        {{ $kolaborasi->subcategory ?? 'Tanpa Subkategori' }}
                    </span>
                </div>
            </div>

            {{-- PEMILIK IDE & PENGAJU --}}
            @php
                use App\Models\AcademicInnovation;
                use App\Models\OpdInnovation;
                use App\Models\KolaborasiMember;

                $pemilikIde = null;
                $innovationId = $kolaborasi->innovation_id;

                $academicOwner = AcademicInnovation::with('user')->find($innovationId);
                $opdOwner = OpdInnovation::with('user')->find($innovationId);

                if ($academicOwner && $academicOwner->user) {
                    $pemilikIde = $academicOwner->user;
                } elseif ($opdOwner && $opdOwner->user) {
                    $pemilikIde = $opdOwner->user;
                }

                $pengaju = $kolaborasi->members->firstWhere('role', 'leader');

                $currentUserId = auth()->user()->id ?? null;
                $alreadyMember = $currentUserId 
                    ? KolaborasiMember::where('kolaborasi_id', $kolaborasi->id)
                                       ->where('user_id', $currentUserId)
                                       ->exists()
                    : false;

                $isOwner = $currentUserId === $pemilikIde?->id;
                $leader = $kolaborasi->members->firstWhere('role', 'leader');
                $isLeader = $leader && $currentUserId === $leader->user_id;
            @endphp

            <div class="mb-6 text-gray-800 space-y-1">
                <p><strong>Pemilik Ide Inovasi:</strong> {{ $pemilikIde?->name ?? '-' }}</p>
                <p><strong>Pengaju Kolaborasi:</strong> {{ $pengaju?->user?->name ?? '-' }}</p>
            </div>

            {{-- ESTIMASI --}}
            <p class="mb-6 text-gray-800">
                <strong>Estimasi Waktu Kolaborasi:</strong> 
                {{ $kolaborasi->estimasi_waktu ? $kolaborasi->estimasi_waktu . ' bulan' : '-' }}
            </p>

            {{-- DESKRIPSI --}}
            <div class="mb-6">
                <h2 class="text-lg font-semibold text-gray-800 mb-2">Deskripsi Kolaborasi</h2>
                @if($kolaborasi->deskripsi_singkat)
                    @foreach(explode("\n", $kolaborasi->deskripsi_singkat) as $paragraph)
                        @if(trim($paragraph))
                            <p class="text-gray-700 leading-relaxed mb-3 text-justify">{{ $paragraph }}</p>
                        @endif
                    @endforeach
                @else
                    <p class="text-gray-500 italic">Belum ada deskripsi.</p>
                @endif
            </div>

            {{-- DOKUMEN KOLABORASI --}}
            <div class="bg-gray-50 p-4 rounded-lg shadow-sm mb-8 border border-gray-200">
                <h5 class="font-semibold text-gray-800 mb-2">Dokumen Kolaborasi</h5>
                @if($kolaborasi->dokumen_path)
                    <a href="{{ asset('storage/' . $kolaborasi->dokumen_path) }}" 
                       target="_blank"
                       class="inline-flex items-center gap-2 text-blue-600 font-medium hover:text-blue-800">
                        📄 Lihat Dokumen
                    </a>
                    <br>
                    <a href="{{ asset('storage/' . $kolaborasi->dokumen_path) }}" 
                       download
                       class="mt-3 inline-block px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                        ⬇️ Download Dokumen
                    </a>
                @else
                    <div class="text-gray-500 italic">Tidak ada dokumen terlampir.</div>
                @endif
            </div>

            <hr class="my-6">

            {{-- WORKSPACE --}}
            @if($kolaborasi->is_active)
                <div class="flex flex-wrap gap-2 mb-4">
                    <a href="{{ route('kolaborasi.tasks.index', $kolaborasi->id) }}" class="btn-tab bg-blue-100 text-blue-700">Tugas</a>
                    <a href="{{ route('kolaborasi.progress.index', $kolaborasi->id) }}" class="btn-tab bg-indigo-100 text-indigo-700">Progress</a>
                    <a href="{{ route('kolaborasi.documents.index', $kolaborasi->id) }}" class="btn-tab bg-green-100 text-green-700">Dokumen</a>
                    <a href="{{ route('kolaborasi.reviews.index', $kolaborasi->id) }}" class="btn-tab bg-pink-100 text-pink-700">Review</a>
                    <a href="{{ route('kolaborasi.members.index', $kolaborasi->id) }}" class="btn-tab bg-yellow-100 text-pink-700">Anggota</a>
                </div>

                {{-- BUTTON “BERGABUNG KE KOLABORASI” --}}
                @auth
                    @if(!$isOwner)
                        @if(!$alreadyMember)
                            <form action="{{ route('kolaborasi.requests.store', $kolaborasi->id) }}" method="POST" class="mb-6">
                                @csrf
                                <input type="hidden" name="kolaborasi_id" value="{{ $kolaborasi->id }}">
                                <button type="submit" 
                                    class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition"
                                    id="joinBtn">
                                    🤝 Bergabung ke Kolaborasi
                                </button>
                            </form>
                        @else
                            @php
                                $memberStatus = \App\Models\KolaborasiMember::where('kolaborasi_id', $kolaborasi->id)
                                                    ->where('user_id', auth()->user()->id)
                                                    ->value('status');
                            @endphp
                            <button class="px-4 py-2 bg-gray-400 text-white rounded-lg cursor-not-allowed mb-6" disabled>
                                {{ $memberStatus === 'pending' ? 'Menunggu Persetujuan' : 'Sudah Bergabung' }}
                            </button>
                        @endif
                    @endif
                @endauth

                {{-- BUTTON EDIT & HAPUS --}}
                @if($isLeader || $isOwner)
                    <div class="flex flex-wrap gap-3 mb-6">
                        @if($isLeader)
                            <a href="{{ route('kolaborasi.ide.edit', $kolaborasi->id) }}" 
                               class="px-4 py-2 bg-yellow-500 text-white rounded-lg hover:bg-yellow-600 transition">
                                ✏️ Edit Kolaborasi
                            </a>
                        @endif
                        <form action="{{ route('kolaborasi.ide.destroy', $kolaborasi->id) }}" method="POST" class="inline-block">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition"
                                onclick="return confirm('Apakah Anda yakin ingin menghapus kolaborasi ini?');">
                                🗑️ Hapus Kolaborasi
                            </button>
                        </form>
                    </div>
                @endif
            @else
                <div class="bg-yellow-50 p-4 rounded-lg text-yellow-700 border border-yellow-200 mb-6">
                    Kolaborasi belum aktif. Tim harus mencapai minimal <strong>4 anggota aktif</strong> untuk membuka fitur pembagian tugas dan progress.
                </div>
            @endif

        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
h1, h6 { line-height: 1.3; }
.rounded-2xl { border-radius: 1rem; }
.border-white { border: 5px solid #fff; }
.shadow-xl { box-shadow: 0 10px 25px rgba(0,0,0,0.08); }
.btn-tab {
    display:inline-block; padding:0.5rem 0.75rem; border-radius:0.5rem;
    font-size:0.875rem; transition:all .2s ease-in-out;
}
.btn-tab:hover { filter:brightness(0.9); }

/* Efek popup “mekar” */
#progressPopup.show {
    display: flex !important;
}
#progressPopup.show #popupContent {
    transform: scale(1);
    opacity: 1;
}
#progressPopup.hide #popupContent {
    transform: scale(0.2);
    opacity: 0;
}
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
    const toggleBtn = document.getElementById('progressToggle');
    const popup = document.getElementById('progressPopup');
    const content = document.getElementById('popupContent');
    const closeBtn = document.getElementById('closePopup');

    toggleBtn.addEventListener('click', () => {
        popup.classList.remove('hidden');
        setTimeout(() => popup.classList.add('show'), 10);
    });

    closeBtn.addEventListener('click', () => {
        popup.classList.remove('show');
        popup.classList.add('hide');
        setTimeout(() => {
            popup.classList.remove('hide');
            popup.classList.add('hidden');
        }, 400);
    });

    popup.addEventListener('click', (e) => {
        if (e.target === popup) closeBtn.click();
    });
});
</script>
@endpush
