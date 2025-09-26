@php
use App\Models\Innovation;
@endphp

@extends('layouts.app')

@section('content')
<div class="flex justify-center py-6 px-4 sm:px-6 lg:px-8">   
     <div class="md:flex md:space-x-6">
        <!-- Sidebar -->
<div class="md:w-1/4 mb-6 md:mb-0">    
    <div class="bg-white rounded-lg shadow p-4">
                <h3 class="font-bold text-lg mb-4">Menu Inovasi</h3>
                <a href="{{ route('akademisi.inovasi.create') }}" 
                   class="block w-full text-left px-4 py-2 bg-blue-600 text-white rounded mb-2 hover:bg-blue-700">
                    + Buat Inovasi Baru
                </a>
                
                <h4 class="font-semibold mt-6 mb-2">Inovasi Saya</h4>
                @foreach($innovations as $year => $items)
                    <div class="mb-3">
                        <h5 class="font-medium text-gray-700">{{ $year }}</h5>
                        <ul class="ml-2 mt-1 space-y-1">
                            @foreach($items as $item)
                                <li>
                                    <a href="{{ route('akademisi.inovasi.show', $item->id) }}" 
                                       class="text-sm text-gray-600 hover:text-blue-600 truncate block {{ isset($innovation) && $innovation->id == $item->id ? 'text-blue-600 font-medium' : '' }}">
                                        {{ Str::limit($item->title, 30) }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Main Content -->
<div class="md:w-3/4 md:ml-12">   
    <div class="bg-white rounded-lg shadow overflow-hidden">
                <div class="px-6 py-4 border-b">
                    <h2 class="text-2xl font-bold text-gray-800">Edit Inovasi</h2>
                    <p class="text-gray-600">Perbarui informasi inovasi Anda</p>
                </div>

                @if(session('success'))
                    <div class="m-4 p-4 bg-green-100 text-green-700 rounded-lg">
                        {{ session('success') }}
                    </div>
                @endif

                <form action="{{ route('akademisi.inovasi.update', $innovation->id) }}" method="POST" enctype="multipart/form-data" class="p-6">
                    @csrf
                    @method('PUT')

                    <div class="space-y-6">
                        <!-- Judul -->
                        <div>
                            <label for="title" class="block text-sm font-medium text-gray-700">Judul Inovasi *</label>
                            <input type="text" name="title" id="title" required
                                   value="{{ old('title', $innovation->title) }}"
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            @error('title')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Kategori dan Subkategori -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="category" class="block text-sm font-medium text-gray-700">Kategori *</label>
                                <select name="category" id="category" required
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    <option value="">Pilih Kategori</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category }}" {{ old('category', $innovation->category) == $category ? 'selected' : '' }}>
                                            {{ $category }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label for="subcategory" class="block text-sm font-medium text-gray-700">Subkategori *</label>
                                <select name="subcategory" id="subcategory" required
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    <option value="">Pilih Subkategori</option>
                                    <!-- Subkategori akan diisi via JavaScript -->
                                </select>
                            </div>
                        </div>

                        <!-- Deskripsi -->
                        <div>
                            <label for="description" class="block text-sm font-medium text-gray-700">Deskripsi Singkat *</label>
                            <textarea name="description" id="description" rows="3" required
                                      class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">{{ old('description', $innovation->description) }}</textarea>
                        </div>

                        <!-- Tujuan -->
                        <div>
                            <label for="purpose" class="block text-sm font-medium text-gray-700">Tujuan Inovasi *</label>
                            <textarea name="purpose" id="purpose" rows="3" required
                                      class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">{{ old('purpose', $innovation->purpose) }}</textarea>
                        </div>

                        <!-- Informasi Penemu -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="author_name" class="block text-sm font-medium text-gray-700">Nama Penemu *</label>
                                <input type="text" name="author_name" id="author_name" required
                                       value="{{ old('author_name', $innovation->author_name) }}"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            </div>
                            <div>
                                <label for="institution" class="block text-sm font-medium text-gray-700">Institusi *</label>
                                <input type="text" name="institution" id="institution" required
                                       value="{{ old('institution', $innovation->institution) }}"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            </div>
                        </div>

                        <!-- Kata Kunci dan TRL -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="keywords" class="block text-sm font-medium text-gray-700">Kata Kunci *</label>
                                <input type="text" name="keywords" id="keywords" required
                                       value="{{ old('keywords', $innovation->keywords) }}"
                                       placeholder="Contoh: AI, Machine Learning, Pendidikan"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            </div>
                            <div>
                                <label for="technology_readiness_level" class="block text-sm font-medium text-gray-700">Tingkat Kesiapterapan Teknologi (TRL) *</label>
                                <select name="technology_readiness_level" id="technology_readiness_level" required
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    <option value="">Pilih TRL</option>
                                    @for($i = 1; $i <= 9; $i++)
                                        <option value="{{ $i }}" {{ old('technology_readiness_level', $innovation->technology_readiness_level) == $i ? 'selected' : '' }}>
                                            TRL {{ $i }}
                                        </option>
                                    @endfor
                                </select>
                            </div>
                        </div>

                        <!-- Kontak -->
                        <div>
                            <label for="contact" class="block text-sm font-medium text-gray-700">Kontak *</label>
                            <input type="text" name="contact" id="contact" required
                                   value="{{ old('contact', $innovation->contact) }}"
                                   placeholder="Email atau nomor telepon"
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        </div>

                        <!-- File Uploads -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <!-- Gambar -->
                            <div>
                                <label for="image_path" class="block text-sm font-medium text-gray-700">Gambar Inovasi</label>
                                <input type="file" name="image_path" id="image_path" accept="image/*"
                                       class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                                @if($innovation->image_path)
                                    <p class="mt-1 text-sm text-gray-500">
                                        Gambar saat ini: 
                                        <a href="{{ asset('storage/' . $innovation->image_path) }}" target="_blank" class="text-blue-600">Lihat</a>
                                        <span class="text-gray-400">|</span>
                                        <button type="button" onclick="document.getElementById('image_path').value=''" class="text-red-600 hover:text-red-800">Hapus</button>
                                    </p>
                                @endif
                            </div>

                            <!-- Dokumen -->
                            <div>
                                <label for="document_path" class="block text-sm font-medium text-gray-700">Dokumen (PDF)</label>
                                <input type="file" name="document_path" id="document_path" accept=".pdf"
                                       class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                                @if($innovation->document_path)
                                    <p class="mt-1 text-sm text-gray-500">
                                        Dokumen saat ini: 
                                        <a href="{{ asset('storage/' . $innovation->document_path) }}" target="_blank" class="text-blue-600">Lihat</a>
                                        <span class="text-gray-400">|</span>
                                        <button type="button" onclick="document.getElementById('document_path').value=''" class="text-red-600 hover:text-red-800">Hapus</button>
                                    </p>
                                @endif
                            </div>
                        </div>

                        <!-- URL Video -->
                        <div>
                            <label for="video_url" class="block text-sm font-medium text-gray-700">URL Video</label>
                            <input type="url" name="video_url" id="video_url"
                                   value="{{ old('video_url', $innovation->video_url) }}"
                                   placeholder="https://youtube.com/..."
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        </div>

                        <!-- Status -->
                        <div>
                            <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                            <select name="status" id="status"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                @foreach(Innovation::statuses() as $status)
                                    <option value="{{ $status }}" {{ old('status', $innovation->status) == $status ? 'selected' : '' }}>
                                        {{ $status }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <!-- Tombol Action -->
                    <div class="mt-8 flex justify-end gap-4 pt-6 border-t">
                        <a href="{{ route('akademisi.inovasi.show', $innovation->id) }}"
                           class="px-6 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50">
                            Batal
                        </a>
                        <button type="submit"
                                class="px-6 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            Perbarui Inovasi
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- JavaScript untuk dynamic subcategories -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const categorySelect = document.getElementById('category');
    const subcategorySelect = document.getElementById('subcategory');
    const currentSubcategory = "{{ old('subcategory', $innovation->subcategory) }}";

    // Load subcategories saat halaman dimuat
    if (categorySelect.value) {
        loadSubcategories(categorySelect.value, currentSubcategory);
    }

    categorySelect.addEventListener('change', function() {
        loadSubcategories(this.value);
    });

    function loadSubcategories(category, selectedValue = '') {
        if (!category) {
            subcategorySelect.innerHTML = '<option value="">Pilih Subkategori</option>';
            return;
        }

        fetch("{{ route('akademisi.subcategories') }}?category=" + encodeURIComponent(category))
            .then(response => response.json())
            .then(subcategories => {
                let options = '<option value="">Pilih Subkategori</option>';
                subcategories.forEach(sub => {
                    const selected = sub === selectedValue ? 'selected' : '';
                    options += `<option value="${sub}" ${selected}>${sub}</option>`;
                });
                subcategorySelect.innerHTML = options;
            });
    }
});
</script>
@endsection
