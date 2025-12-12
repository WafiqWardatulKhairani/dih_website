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

/* Revisi kolom agar No, Judul, dan Deskripsi lebih kecil */
.table-no { width: 4%; }
.table-title { width: 20%; }
.table-desc { width: 26%; }
.table-assignee { width: 15%; }
.table-deadline { width: 15%; }
.table-status { width: 15%; }
.table-action { width: 5%; }

.progress-bar {
    height: 1rem;
    border-radius: 0.5rem;
    background-color: #e5e7eb;
    overflow: hidden;
    margin-bottom: 1rem;
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

@section('content')
<div class="max-w-7xl mx-auto mt-10 mb-12 px-4 sm:px-6 lg:px-8">

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

            {{-- Tombol Halaman Utama Kolaborasi --}}
            <div class="flex flex-wrap items-center gap-3 mb-6">
                <a href="{{ route('kolaborasi.detail', $kolaborasi->id) }}" 
                   class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                    <i class="fas fa-home"></i> Halaman Utama Kolaborasi
                </a>
            </div>

            {{-- ==================== WRAPPER UTAMA TUGAS ==================== --}}
            <div class="page-border p-6 space-y-8">

                <!-- Header -->
                <div class="flex justify-between items-center mb-4">
                    <div>
                        <h1 class="text-3xl font-bold text-primary">Daftar Penugasan Kolaborasi</h1>
                        <p class="text-gray-600">
                            Kolaborasi: 
                            <span class="font-semibold text-secondary">
                                {{ $kolaborasi->judul ?? 'Tanpa Judul' }}
                            </span>
                        </p>

                        {{-- Total Progress --}}
                        @php
                            $totalTasks = $tasks->count();
                            $doneTasks = $tasks->where('status', 'done')->count();
                            $progressPercent = $totalTasks > 0 ? round(($doneTasks / $totalTasks) * 100) : 0;
                        @endphp
                        <div class="mt-4">
                            <p class="text-sm text-gray-700 mb-1">Total Progress: {{ $progressPercent }}% ({{ $doneTasks }} dari {{ $totalTasks }} tugas selesai)</p>
                            <div class="progress-bar">
                                <div class="progress-bar-inner" style="width: {{ $progressPercent }}%">
                                    {{ $progressPercent }}%
                                </div>
                            </div>
                        </div>
                    </div>
                    <button onclick="toggleTaskForm()" class="bg-primary text-white px-4 py-2 rounded-xl shadow hover:bg-secondary transition">
                        + Tambah Tugas
                    </button>
                </div>

                @include('components.alert-kolaborasi')

                <!-- Form Tambah Tugas -->
                <div id="taskForm" class="hidden bg-graylight p-6 rounded-xl border border-gray-200">
                    <form action="{{ route('kolaborasi.tasks.store', $kolaborasi->id) }}" method="POST" class="space-y-4">
                        @csrf
                        <div>
                            <label class="block text-sm font-semibold mb-1">Judul Tugas</label>
                            <input type="text" name="title" class="w-full border-gray-300 rounded-lg p-2" placeholder="Judul tugas..." required>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold mb-1">Deskripsi</label>
                            <textarea name="description" class="w-full border-gray-300 rounded-lg p-2" rows="3" placeholder="Deskripsi tugas..."></textarea>
                        </div>
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                            <div>
                                <label class="block text-sm font-semibold mb-1">Tugaskan ke</label>
                                <select name="assigned_to" class="w-full border-gray-300 rounded-lg p-2">
                                    <option value="">Pilih anggota...</option>
                                    @php
                                        use App\Models\KolaborasiMember;
                                        
                                        // Ambil semua anggota dengan status active (termasuk leader)
                                        $activeMembers = KolaborasiMember::where('kolaborasi_id', $kolaborasi->id)
                                            ->where('status', 'active')
                                            ->with('user')
                                            ->get();
                                        
                                        // Kumpulkan user_id yang sudah ada untuk menghindari duplikasi
                                        $assignedUserIds = [];
                                    @endphp
                                    
                                    {{-- Tampilkan pemilik ide --}}
                                    @if($pemilikIde)
                                        <option value="{{ $pemilikIde->id }}">
                                            {{ $pemilikIde->name ?? 'Pemilik Ide' }} 
                                        </option>
                                        @php $assignedUserIds[] = $pemilikIde->id; @endphp
                                    @endif
                                    
                                    {{-- Tampilkan leader --}}
                                    @if($leader && $leader->status === 'active' && !in_array($leader->user_id, $assignedUserIds))
                                        <option value="{{ $leader->user_id }}">
                                            {{ optional($leader->user)->name ?? 'Leader' }}
                                        </option>
                                        @php $assignedUserIds[] = $leader->user_id; @endphp
                                    @endif
                                    
                                    {{-- Tampilkan anggota aktif lainnya --}}
                                    @foreach($activeMembers as $member)
                                        @if(!in_array($member->user_id, $assignedUserIds))
                                            <option value="{{ $member->user_id }}">
                                                {{ optional($member->user)->name ?? 'Tanpa Nama' }}
                                                @if($member->role === 'leader') 
                                                @elseif($member->role === 'member') 
                                                @endif
                                            </option>
                                            @php $assignedUserIds[] = $member->user_id; @endphp
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-semibold mb-1">Deadline</label>
                                <input type="date" name="deadline" class="w-full border-gray-300 rounded-lg p-2">
                            </div>
                            <div class="flex items-end">
                                <button class="bg-success text-white px-4 py-2 rounded-lg shadow hover:bg-green-600 w-full">Simpan Tugas</button>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- Daftar Tugas -->
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-blue-50 text-gray-800">
                            <tr>
                                <th class="px-3 py-3 text-left text-sm font-semibold table-no">No</th>
                                <th class="px-3 py-3 text-left text-sm font-semibold table-title">Judul</th>
                                <th class="px-3 py-3 text-left text-sm font-semibold table-desc">Deskripsi</th>
                                <th class="px-3 py-3 text-left text-sm font-semibold table-assignee">Assignee</th>
                                <th class="px-3 py-3 text-left text-sm font-semibold table-deadline">Deadline</th>
                                <th class="px-3 py-3 text-left text-sm font-semibold table-status">Status</th>
                                <th class="px-3 py-3 text-center text-sm font-semibold table-action">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 bg-graylight/40">
                            @forelse($tasks as $task)
                                <tr class="hover:bg-graylight transition">
                                    <td class="px-3 py-4">{{ $loop->iteration }}</td>
                                    <td class="px-3 py-4 font-semibold text-gray-800">{{ $task->title }}</td>
                                    <td class="px-3 py-4 text-gray-700">{{ $task->description }}</td>
                                    <td class="px-3 py-4">{{ optional($task->assignee)->name ?? '-' }}</td>
                                    <td class="px-3 py-4 text-gray-600">
                                        {{ $task->deadline ? \Carbon\Carbon::parse($task->deadline)->format('d M Y') : '-' }}
                                    </td>
                                    <td class="px-3 py-4">
                                        @php
                                            $status = $task->status ?? 'todo';
                                            $badgeColor = match($status) {
                                                'done' => 'bg-success',
                                                'in_progress' => 'bg-warning',
                                                default => 'bg-gray-400'
                                            };
                                        @endphp
                                        <span class="text-white px-3 py-1 rounded-full text-xs font-semibold {{ $badgeColor }}">
                                            {{ ucfirst($status) }}
                                        </span>
                                    </td>
                                    <td class="px-3 py-4 text-center">
                                        <form action="{{ route('kolaborasi.tasks.destroy', $task->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus tugas ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button class="bg-danger text-white px-3 py-1 rounded-lg text-xs hover:bg-red-700 transition">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center py-6 text-gray-500">Belum ada tugas yang dibuat.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

            </div> {{-- end page-border --}}

        </div> {{-- end p-8 --}}

    </div> {{-- end bg-white border --}}

</div>

<!-- JS: Toggle form -->
<script>
function toggleTaskForm() {
    const form = document.getElementById('taskForm');
    form.classList.toggle('hidden');
}
</script>
@endsection