@extends('layouts.app')

@section('title', 'Tugas Kolaborasi')

@push('styles')
<script src="https://cdn.tailwindcss.com"></script>
<script>
tailwind.config = {
    theme: {
        extend: {
            colors: {
                primary: '#1e3a8a',
                secondary: '#3b82f6',
                accent: '#60a5fa',
                success: '#16a34a',
                warning: '#f59e0b',
                danger: '#dc2626',
                graylight: '#f3f4f6',
            },
        },
    },
};
</script>
<style>
.page-border {
    border: 1px solid #e5e7eb;
    border-radius: 1rem;
    box-shadow: 0 6px 16px rgba(0,0,0,0.06);
    background-color: white;
    overflow: hidden;
}
.status-badge {
    padding: 0.25rem 0.5rem;
    border-radius: 0.375rem;
    font-size: 0.75rem;
    font-weight: 600;
    text-transform: uppercase;
}
.todo { background-color: #fef3c7; color: #b45309; }
.in-progress { background-color: #bfdbfe; color: #1d4ed8; }
.done { background-color: #d1fae5; color: #065f46; }
td, th {
    text-align: left;
}
.table-no { width: 5%; }
.table-task { width: 20%; }
.table-desc { width: 25%; }
.table-status { width: 15%; }
.table-lampiran { width: 20%; }
.table-keterangan { width: 15%; }
.table-aksi { width: 5%; }
.progress-bar {
    height: 1rem;
    border-radius: 0.5rem;
    background-color: #e5e7eb;
    overflow: hidden;
}
.progress-bar-inner {
    height: 100%;
    background-color: #1e3a8a;
    text-align: center;
    color: white;
    font-size: 0.75rem;
    line-height: 1rem;
    font-weight: 600;
}

/* Gradient untuk ikon kolaborasi */
.text-gradient {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
function toggleProgressForm() {
    const form = document.getElementById('progressForm');
    form.classList.toggle('hidden');
}

@if(session('success'))
Swal.fire({
    icon: 'success',
    title: 'Sukses',
    text: '{{ session('success') }}',
});
@endif

@if(session('error'))
Swal.fire({
    icon: 'error',
    title: 'Gagal',
    text: '{{ session('error') }}',
});
@endif
</script>
@endpush

@section('content')
<div class="max-w-7xl mx-auto mt-10 mb-12 px-4 sm:px-6 lg:px-8">

    @if(!isset($kolaborasi))
        <div class="text-center py-20 text-red-600 font-semibold">
            Kolaborasi tidak ditemukan.
        </div>
    @else

    {{-- ==================== HALAMAN DETAIL - SAMA SEPERTI DI SHOW.BLADE.PHP ==================== --}}
    <div class="bg-white border border-white rounded-2xl shadow-xl overflow-hidden">

        {{-- Gambar Kolaborasi - SAMA SEPERTI DI SHOW.BLADE.PHP --}}
        <div class="w-full relative h-80 border-b border-gray-200 bg-gradient-to-br from-blue-50 to-indigo-100">
            @if($kolaborasi->image_path)
                <img src="{{ asset('storage/' . $kolaborasi->image_path) }}" 
                     alt="{{ $kolaborasi->judul }}" 
                     class="w-full h-full object-cover">
            @else
                <div class="w-full h-full flex flex-col items-center justify-center text-center p-8">
                    <div class="mb-4">
                        <i class="fas fa-hands-helping fa-4x text-gradient"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-700 mb-2">Kolaborasi Inovasi</h3>
                    <p class="text-gray-500 max-w-md">Bersama mewujudkan ide menjadi kenyataan melalui kolaborasi yang sinergis</p>
                </div>
            @endif
        </div>

        {{-- KONTEN UTAMA - GABUNG DALAM SATU DIV SEPERTI DI SHOW.BLADE.PHP --}}
        <div class="p-8">

            {{-- ==================== WRAPPER UTAMA PROGRESS ==================== --}}
            <div class="page-border p-6 space-y-8">

                {{-- HEADER --}}
                <div class="flex justify-between items-center mb-4">
                    <div>
                        <h1 class="text-3xl font-bold text-primary">Tugas Kolaborasi</h1>
                        <p class="text-gray-600">
                            Kolaborasi: 
                            <span class="font-semibold text-secondary">
                                {{ $kolaborasi->judul ?? 'Tanpa Judul' }}
                            </span>
                        </p>

                        {{-- Total Progress khusus user login --}}
                        @php
                            $userTasks = $kolaborasi->tasks()->where('assigned_to', auth()->id())->get();
                            $totalUserTasks = $userTasks->count();
                            $doneUserTasks = $userTasks->filter(function($task){
                                return $task->progress()->where('user_id', auth()->id())->where('status', 'done')->count() > 0;
                            })->count();
                            $progressPercent = $totalUserTasks > 0 ? round(($doneUserTasks / $totalUserTasks) * 100) : 0;
                        @endphp

                        <div class="mt-4">
                            <p class="text-sm text-gray-700 mb-1">Total Progress Anda: {{ $progressPercent }}% ({{ $doneUserTasks }} dari {{ $totalUserTasks }} tugas selesai)</p>
                            <div class="progress-bar">
                                <div class="progress-bar-inner" style="width: {{ $progressPercent }}%">
                                    {{ $progressPercent }}%
                                </div>
                            </div>
                        </div>
                    </div>

                    <button onclick="toggleProgressForm()" class="bg-primary text-white px-4 py-2 rounded-xl shadow hover:bg-secondary transition">
                        + Tambah Progress
                    </button>
                </div>

                {{-- FORM TAMBAH PROGRESS --}}
                <div id="progressForm" class="hidden bg-graylight p-6 rounded-xl border border-gray-200">
                    <form action="{{ route('kolaborasi.progress.store', $kolaborasi->id) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                        @csrf
                        <div>
                            <label class="block text-sm font-semibold mb-1">Task (opsional)</label>
                            <select name="task_id" class="w-full border-gray-300 rounded-lg p-2">
                                <option value="">(Umum)</option>
                                @php
                                    $tasksAvailable = $userTasks->filter(function($task) use ($kolaborasi) {
                                        return !$kolaborasi->progress->where('task_id', $task->id)->where('user_id', auth()->id())->count();
                                    });
                                @endphp
                                @foreach($tasksAvailable as $task)
                                    <option value="{{ $task->id }}">{{ $task->title }}</option>
                                @endforeach
                            </select>
                            @if($tasksAvailable->isEmpty())
                                <small class="text-gray-500 italic">Semua task Anda yang terkait sudah memiliki progress.</small>
                            @endif
                        </div>

                        <div>
                            <label class="block text-sm font-semibold mb-1">Deskripsi / Catatan</label>
                            <textarea name="deskripsi" class="w-full border-gray-300 rounded-lg p-2" rows="3" placeholder="Catatan progress..."></textarea>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-semibold mb-1">Upload Lampiran</label>
                                <input type="file" name="attachment" accept=".jpg,.jpeg,.png,.pdf,.doc,.docx" class="w-full border-gray-300 rounded-lg p-2">
                                <small class="text-gray-500">Maks 3MB. Format: jpg, png, pdf, doc, docx</small>
                            </div>
                            <div>
                                <label class="block text-sm font-semibold mb-1">Status</label>
                                <select name="status" class="w-full border-gray-300 rounded-lg p-2">
                                    <option value="todo">Todo</option>
                                    <option value="in-progress">In Progress</option>
                                    <option value="done">Done</option>
                                </select>
                            </div>
                        </div>

                        <button class="bg-success text-white px-4 py-2 rounded-lg shadow hover:bg-green-600 w-full">Simpan Progress</button>
                    </form>
                </div>

                {{-- DAFTAR PROGRESS --}}
                <div class="overflow-x-auto">
                    {{-- Tombol Halaman Utama Kolaborasi --}}
                    <div class="flex flex-wrap items-center gap-3 mb-8">
                        <a href="{{ route('kolaborasi.detail', $kolaborasi->id) }}" 
                           class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                            <i class="fas fa-home"></i> Halaman Utama Kolaborasi
                        </a>
                    </div>

                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-blue-50 text-gray-800">
                            <tr>
                                <th class="px-4 py-3 text-left text-sm font-semibold table-no">No</th>
                                <th class="px-4 py-3 text-left text-sm font-semibold table-task">Task</th>
                                <th class="px-4 py-3 text-left text-sm font-semibold table-desc">Deskripsi</th>
                                <th class="px-4 py-3 text-left text-sm font-semibold table-status">Status</th>
                                <th class="px-4 py-3 text-left text-sm font-semibold table-lampiran">Lampiran</th>
                                <th class="px-4 py-3 text-left text-sm font-semibold table-keterangan">Keterangan</th>
                                <th class="px-4 py-3 text-center text-sm font-semibold table-aksi">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 bg-graylight/40">
                            @forelse($kolaborasi->progress->where('user_id', auth()->id()) as $p)
                                <tr class="hover:bg-graylight transition">
                                    <td class="px-4 py-4">{{ $loop->iteration }}</td>
                                    <td class="px-4 py-4">{{ optional($p->task)->title ?? '(Umum)' }}</td>
                                    <td class="px-4 py-4">{{ $p->deskripsi ?? '-' }}</td>
                                    <td class="px-4 py-4">
                                        <span class="status-badge {{ $p->status ?? 'todo' }}">{{ ucfirst($p->status ?? 'todo') }}</span>
                                    </td>
                                    <td class="px-4 py-4 space-y-1">
                                        @php
                                            $docs = $p->documents;
                                            if($docs->isEmpty()){
                                                $docs = $kolaborasi->documents->whereNull('progress_id');
                                            }
                                        @endphp
                                        @if($docs && $docs->count())
                                            @foreach($docs as $doc)
                                                <a href="{{ asset('storage/' . $doc->file_path) }}" target="_blank" class="text-blue-600 underline block">
                                                    {{ $doc->title }}
                                                </a>
                                            @endforeach
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td class="px-4 py-4">
                                        @php
                                            $deadline = optional($p->task)->deadline;
                                            $keterangan = '-';
                                            if($deadline){
                                                $keterangan = \Carbon\Carbon::parse($p->created_at)->lessThanOrEqualTo(\Carbon\Carbon::parse($deadline)) 
                                                            ? 'Tepat Waktu' 
                                                            : 'Terlambat';
                                            }
                                        @endphp
                                        {{ $keterangan }}
                                    </td>
                                    <td class="px-4 py-4 text-center">
                                        <form action="{{ route('kolaborasi.progress.destroy', $p->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus progress ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button class="bg-danger text-white px-3 py-1 rounded-lg text-xs hover:bg-red-700 transition">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center py-6 text-gray-500">Belum ada progress yang dibuat.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

            </div> {{-- end page-border --}}

        </div> {{-- end p-8 --}}

    </div> {{-- end bg-white border --}}
    @endif

</div>
@endsection