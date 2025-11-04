@extends('layouts.app')

@section('title', 'Anggota Kolaborasi')

@section('content')
<div class="max-w-6xl mx-auto mt-10 mb-12 px-4 sm:px-6 lg:px-8">
    <div class="bg-white border border-white rounded-2xl shadow-xl overflow-hidden">

        {{-- Gambar Kolaborasi --}}
        <div class="w-full relative h-80 border-b border-gray-200">
            @if($kolaborasi->image_path)
                <img src="{{ asset('storage/' . $kolaborasi->image_path) }}" 
                     alt="{{ $kolaborasi->judul }}" 
                     class="w-full h-full object-cover">
            @else
                <div class="w-full h-full bg-gradient-to-r from-blue-800/90 to-blue-900/95 flex items-center justify-center">
                    <i class="fas fa-lightbulb fa-3x text-blue-100 opacity-70"></i>
                </div>
            @endif
            <div class="absolute inset-0 bg-gradient-to-t from-blue-900/90 to-blue-800/80 mix-blend-multiply"></div>
        </div>

        {{-- Judul + Tombol Navigasi --}}
        <div class="p-6 border-b border-gray-200 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">
                    Anggota Kolaborasi — {{ $kolaborasi->judul }}
                </h1>
            </div>
        </div>

        @include('components.alert-kolaborasi')

        {{-- Tabel Anggota --}}
        <div class="overflow-x-auto p-6">
            <table class="min-w-full text-sm border border-gray-300 rounded-lg overflow-hidden">
                            <div class="flex flex-wrap items-center gap-3 mb-8">
                {{-- 🔹 Tombol Halaman Utama Kolaborasi --}}
                <a href="{{ route('kolaborasi.detail', $kolaborasi->id) }}" 
                   class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                    <i class="fas fa-home"></i> Halaman Utama Kolaborasi
                </a>

                {{-- 🔹 Tombol Buka Detail Ide Kolaborasi --}}
                <a href="{{ route('kolaborasi.ide.show', $kolaborasi->id) }}" 
                   class="inline-flex items-center gap-2 px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition">
                    <i class="fas fa-info-circle"></i> Buka Detail Ide Kolaborasi
                </a>
            </div>

                <thead>
                    <tr class="bg-blue-50 text-gray-800">
                        <th class="py-3 px-4 text-left border-b border-gray-300">No</th>
                        <th class="py-3 px-4 text-left border-b border-gray-300">Nama</th>
                        <th class="py-3 px-4 text-left border-b border-gray-300">Peran</th>
                        <th class="py-3 px-4 text-left border-b border-gray-300">Status</th>
                        <th class="py-3 px-4 text-center border-b border-gray-300">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @php $no = 1; @endphp

                    {{-- PEMILIK IDE INOVASI --}}
                    @foreach($academicOwners as $owner)
                        <tr class="hover:bg-gray-50">
                            <td class="py-3 px-4">{{ $no++ }}</td>
                            <td class="py-3 px-4 font-medium text-gray-900">{{ $owner->name }}</td>
                            <td class="py-3 px-4 font-semibold text-blue-700">Pemilik Ide Inovasi</td>
                            <td class="py-3 px-4 text-gray-700">Aktif</td>
                            <td class="py-3 px-4 text-center">
                                @if(auth()->id() === $owner->id)
                                    <form action="{{ route('kolaborasi.members.destroy', [$kolaborasi->id, $owner->id]) }}" method="POST" class="inline delete-form">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="delete-btn px-3 py-1 bg-red-600 text-white rounded hover:bg-red-700 text-xs transition">
                                            🗑️ Hapus
                                        </button>
                                    </form>
                                @else
                                    <span class="text-gray-400 italic">—</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach

                    @foreach($opdOwners as $owner)
                        <tr class="hover:bg-gray-50">
                            <td class="py-3 px-4">{{ $no++ }}</td>
                            <td class="py-3 px-4 font-medium text-gray-900">{{ $owner->name }}</td>
                            <td class="py-3 px-4 font-semibold text-blue-700">Pemilik Ide Inovasi</td>
                            <td class="py-3 px-4 text-gray-700">Aktif</td>
                            <td class="py-3 px-4 text-center">
                                @if(auth()->id() === $owner->id)
                                    <form action="{{ route('kolaborasi.members.destroy', [$kolaborasi->id, $owner->id]) }}" method="POST" class="inline delete-form">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="delete-btn px-3 py-1 bg-red-600 text-white rounded hover:bg-red-700 text-xs transition">
                                            🗑️ Hapus
                                        </button>
                                    </form>
                                @else
                                    <span class="text-gray-400 italic">—</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach

                    {{-- ANGGOTA & PENGAJU --}}
                    @forelse($kolaborasi->members as $member)
                        @php
                            $role = $member->role === 'leader' ? 'Pengaju Kolaborasi' : 'Anggota';
                            $status = match($member->status) {
                                'active' => 'Aktif',
                                'pending' => 'Menunggu Persetujuan',
                                default => ucfirst($member->status ?? '-')
                            };

                            $userId = auth()->id();
                            $isOwner = in_array($userId, array_merge(
                                $academicOwners->pluck('id')->toArray(),
                                $opdOwners->pluck('id')->toArray()
                            ));
                            $isLeader = $kolaborasi->members->where('user_id', $userId)->where('role', 'leader')->count() > 0;

                            $canApprove = $isOwner || $isLeader;
                            $canDelete = $isOwner || ($isLeader && $role === 'Anggota');
                        @endphp

                        <tr class="hover:bg-gray-50">
                            <td class="py-3 px-4">{{ $no++ }}</td>
                            <td class="py-3 px-4 font-medium text-gray-900">{{ $member->user->name }}</td>
                            <td class="py-3 px-4 font-semibold {{ $role === 'Pengaju Kolaborasi' ? 'text-indigo-700' : 'text-gray-800' }}">
                                {{ $role }}
                            </td>
                            <td class="py-3 px-4 text-gray-700">{{ $status }}</td>
                            <td class="py-3 px-4 text-center">
                                {{-- SETUJUI --}}
                                @if($canApprove && $member->status === 'pending')
                                    <form action="{{ route('kolaborasi.members.approve', [$kolaborasi->id, $member->id]) }}" method="POST" class="inline approve-form">
                                        @csrf
                                        <button type="button" 
                                            class="approve-btn px-3 py-1 bg-green-600 text-white rounded hover:bg-green-700 text-xs transition">
                                            ✅ Setujui
                                        </button>
                                    </form>
                                @elseif($member->status === 'active')
                                    <button disabled class="px-3 py-1 bg-gray-300 text-gray-600 rounded text-xs cursor-not-allowed">
                                        ✅ Disetujui
                                    </button>
                                @endif

                                {{-- HAPUS --}}
                                @if($canDelete)
                                    <form action="{{ route('kolaborasi.members.destroy', [$kolaborasi->id, $member->user_id]) }}" method="POST" class="inline delete-form">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" 
                                            class="delete-btn px-3 py-1 bg-red-600 text-white rounded hover:bg-red-700 text-xs transition">
                                            🗑️ Hapus
                                        </button>
                                    </form>
                                @else
                                    <span class="text-gray-400 italic">Tidak tersedia</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-6 text-gray-500 italic">
                                Belum ada anggota kolaborasi.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    table {
        border-collapse: separate;
        border-spacing: 0;
        border-radius: 12px;
        overflow: hidden;
    }
    th:first-child { border-top-left-radius: 12px; }
    th:last-child { border-top-right-radius: 12px; }
    tr:last-child td:first-child { border-bottom-left-radius: 12px; }
    tr:last-child td:last-child { border-bottom-right-radius: 12px; }
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.addEventListener('DOMContentLoaded', () => {
    // === Hapus Anggota ===
    document.querySelectorAll('.delete-btn').forEach(btn => {
        btn.addEventListener('click', e => {
            e.preventDefault();
            const form = btn.closest('.delete-form');
            Swal.fire({
                title: 'Hapus Anggota?',
                text: 'Tindakan ini tidak dapat dibatalkan.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#e02424',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Ya, hapus',
                cancelButtonText: 'Batal'
            }).then(result => {
                if (result.isConfirmed) form.submit();
            });
        });
    });

    // === Setujui Anggota ===
    document.querySelectorAll('.approve-btn').forEach(btn => {
        btn.addEventListener('click', e => {
            e.preventDefault();
            const form = btn.closest('.approve-form');
            Swal.fire({
                title: 'Setujui Anggota?',
                text: 'Anggota ini akan menjadi aktif dan dapat berkolaborasi.',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#16a34a',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Ya, setujui',
                cancelButtonText: 'Batal'
            }).then(result => {
                if (result.isConfirmed) form.submit();
            });
        });
    });

    // === Notifikasi Sukses ===
    @if(session('success'))
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: '{{ session('success') }}',
            confirmButtonColor: '#2563eb'
        });
    @endif
});
</script>
@endpush
