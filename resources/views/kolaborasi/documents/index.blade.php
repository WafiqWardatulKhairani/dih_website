@extends('layouts.app')

@section('title', 'Dokumen Kolaborasi')

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
td, th {
    text-align: left;
}
.table-no { width: 5%; }
.table-title { width: 40%; }
.table-uploader { width: 25%; }
.table-file { width: 20%; }
.table-category { width: 10%; }
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
// Flash messages
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

            {{-- ==================== WRAPPER UTAMA DOKUMEN ==================== --}}
            <div class="page-border p-6 space-y-8">

                {{-- HEADER --}}
                <div class="flex justify-between items-center mb-4">
                    <div>
                        <h1 class="text-3xl font-bold text-primary">Lampiran Kolaborasi</h1>
                        <p class="text-gray-600">
                            Kolaborasi: 
                            <span class="font-semibold text-secondary">
                                {{ $kolaborasi->judul ?? 'Tanpa Judul' }}
                            </span>
                        </p>
                    </div>
                </div>

                {{-- BUTTON KE HALAMAN UTAMA --}}
                <div class="flex flex-wrap items-center gap-3 mb-8">
                    <a href="{{ route('kolaborasi.detail', $kolaborasi->id) }}" 
                       class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                        <i class="fas fa-home"></i> Halaman Utama Kolaborasi
                    </a>
                </div>

                {{-- TABEL DOKUMEN --}}
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-blue-50 text-gray-800">
                            <tr>
                                <th class="px-4 py-3 text-left text-sm font-semibold table-no">No</th>
                                <th class="px-4 py-3 text-left text-sm font-semibold table-title">Judul Dokumen</th>
                                <th class="px-4 py-3 text-left text-sm font-semibold table-uploader">Uploader</th>
                                <th class="px-4 py-3 text-left text-sm font-semibold table-file">File</th>
                                <th class="px-4 py-3 text-left text-sm font-semibold table-category">Kategori</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 bg-graylight/40">
                            @forelse($kolaborasi->documents->sortBy('category')->sortBy('title') as $doc)
                                @php
                                    // Judul rapi: jika title kosong, ambil nama file tanpa extension
                                    $title = $doc->title ?: pathinfo($doc->file_path, PATHINFO_FILENAME);
                                    // Tambahkan prefix kategori
                                    $displayTitle = '[' . ucfirst($doc->category) . '] ' . $title;
                                @endphp
                                <tr class="hover:bg-graylight transition">
                                    <td class="px-4 py-4">{{ $loop->iteration }}</td>
                                    <td class="px-4 py-4">{{ \Illuminate\Support\Str::limit($displayTitle, 50, '...') }}</td>
                                    <td class="px-4 py-4">{{ $doc->uploader->name ?? '-' }}</td>
                                    <td class="px-4 py-4">
                                        <a href="{{ asset('storage/' . $doc->file_path) }}" target="_blank" class="text-blue-600 underline">
                                            Lihat Lampiran
                                        </a>
                                    </td>
                                    <td class="px-4 py-4">{{ ucfirst($doc->category) }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-6 text-gray-500">Belum ada dokumen yang diunggah.</td>
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