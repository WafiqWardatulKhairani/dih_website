@php
use App\Models\AcademicInnovation;
@endphp

@extends('layouts.app')

@section('content')
<div class="flex items-center justify-center min-h-screen bg-gray-50 px-4 sm:px-6 lg:px-8 mt-8 mb-8">
    <div class="w-full max-w-4xl">

        <!-- Card Form -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="px-6 py-4 border-b text-center">
                <h2 class="text-2xl font-bold text-gray-800">Edit Inovasi</h2>
                <p class="text-gray-600">Perbarui informasi inovasi Anda</p>
            </div>

            @if(session('success'))
                <div class="m-4 p-4 bg-green-100 text-green-700 rounded-lg text-center">
                    {{ session('success') }}
                </div>
            @endif

            <form action="{{ route('akademisi.inovasi.update', $innovation->id) }}" method="POST" enctype="multipart/form-data" class="p-6 space-y-6">
                @csrf
                @method('PUT')

                <!-- Judul -->
                <div>
                    <label for="title" class="block text-sm font-medium text-gray-700">Judul Inovasi *</label>
                    <input type="text" name="title" id="title" required
                           value="{{ old('title', $innovation->title) }}"
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-600 focus:ring-blue-600">
                    @error('title')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Kategori & Subkategori -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="category" class="block text-sm font-medium text-gray-700">Kategori *</label>
                        <select name="category" id="category" required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-600 focus:ring-blue-600">
                            <option value="">Pilih Kategori</option>
                            <option value="Teknologi" {{ old('category', $innovation->category) == 'Teknologi' ? 'selected' : '' }}>Teknologi</option>
                            <option value="Sosial" {{ old('category', $innovation->category) == 'Sosial' ? 'selected' : '' }}>Sosial</option>
                            <option value="Pendidikan" {{ old('category', $innovation->category) == 'Pendidikan' ? 'selected' : '' }}>Pendidikan</option>
                            <option value="Humaniora" {{ old('category', $innovation->category) == 'Humaniora' ? 'selected' : '' }}>Humaniora</option>
                        </select>
                    </div>
                    <div>
                        <label for="subcategory" class="block text-sm font-medium text-gray-700">Subkategori *</label>
                        <select name="subcategory" id="subcategory" required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-600 focus:ring-blue-600">
                            <option value="">Pilih Subkategori</option>
                        </select>
                    </div>
                </div>

                <!-- Deskripsi -->
                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700">Deskripsi Singkat *</label>
                    <textarea name="description" id="description" rows="3" required
                              class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-600 focus:ring-blue-600">{{ old('description', $innovation->description) }}</textarea>
                </div>

                <!-- Tujuan -->
                <div>
                    <label for="purpose" class="block text-sm font-medium text-gray-700">Tujuan Inovasi *</label>
                    <textarea name="purpose" id="purpose" rows="3" required
                              class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-600 focus:ring-blue-600">{{ old('purpose', $innovation->purpose) }}</textarea>
                </div>

                <!-- Penemu -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="author_name" class="block text-sm font-medium text-gray-700">Nama Penemu *</label>
                        <input type="text" name="author_name" id="author_name" required
                               value="{{ old('author_name', $innovation->author_name) }}"
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-600 focus:ring-blue-600">
                    </div>
                    <div>
                        <label for="institution" class="block text-sm font-medium text-gray-700">Institusi *</label>
                        <input type="text" name="institution" id="institution" required
                               value="{{ old('institution', $innovation->institution) }}"
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-600 focus:ring-blue-600">
                    </div>
                </div>

                <!-- Kata Kunci & TRL -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 items-center">
                    <div>
                        <label for="keywords" class="block text-sm font-medium text-gray-700">Kata Kunci *</label>
                        <input type="text" name="keywords" id="keywords" required
                               value="{{ old('keywords', $innovation->keywords) }}"
                               placeholder="Contoh: AI, Machine Learning, Pendidikan"
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-600 focus:ring-blue-600">
                    </div>

                    <div>
                        <label for="trl" class="block text-sm font-medium text-gray-700">
                            Tingkat Kesiapterapan Teknologi (TRL) *
                            <span id="trlValue" class="font-semibold text-blue-700 ml-2">{{ old('technology_readiness_level', $innovation->technology_readiness_level) }}</span>
                        </label>
                        <input type="range" name="technology_readiness_level" id="trl"
                               min="1" max="9" step="1"
                               value="{{ old('technology_readiness_level', $innovation->technology_readiness_level) }}"
                               class="w-full accent-blue-600 mt-2">
                        <div class="flex justify-between text-xs text-gray-500 mt-1">
                            <span>1</span><span>3</span><span>5</span><span>7</span><span>9</span>
                        </div>
                    </div>
                </div>

                <!-- Kontak -->
                <div>
                    <label for="contact" class="block text-sm font-medium text-gray-700">Kontak *</label>
                    <input type="text" name="contact" id="contact" required
                           value="{{ old('contact', $innovation->contact) }}"
                           placeholder="Email atau nomor telepon"
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-600 focus:ring-blue-600">
                </div>

                <!-- Upload File -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Gambar -->
                    <div>
                        <label for="image_path" class="block text-sm font-medium text-gray-700">Gambar Inovasi</label>
                        <input type="file" name="image_path" id="image_path" accept="image/*"
                               class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 
                               file:rounded-full file:border-0 file:text-sm file:font-semibold 
                               file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                        @if($innovation->image_path)
                            <p class="mt-1 text-sm text-gray-500 text-center" id="currentImage">
                                Gambar saat ini: 
                                <a href="{{ asset('storage/' . $innovation->image_path) }}" target="_blank" class="text-blue-600 hover:underline">Lihat</a>
                            </p>
                        @endif
                        <div id="previewImage" class="mt-2"></div>
                    </div>

                    <!-- Dokumen PDF -->
                    <div>
                        <label for="document_path" class="block text-sm font-medium text-gray-700">Dokumen (PDF)</label>
                        <input type="file" name="document_path" id="document_path" accept=".pdf"
                               class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 
                               file:rounded-full file:border-0 file:text-sm file:font-semibold 
                               file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                        @if($innovation->document_path)
                            <p class="mt-1 text-sm text-gray-500 text-center" id="currentDoc">
                                Dokumen saat ini: 
                                <a href="{{ asset('storage/' . $innovation->document_path) }}" target="_blank" class="text-blue-600 hover:underline">Lihat</a>
                            </p>
                        @endif
                        <div id="previewDoc" class="mt-2 text-sm text-gray-700"></div>
                    </div>
                </div>

                <!-- Video -->
                <div>
                    <label for="video_url" class="block text-sm font-medium text-gray-700">URL Video</label>
                    <input type="url" name="video_url" id="video_url"
                           value="{{ old('video_url', $innovation->video_url) }}"
                           placeholder="https://youtube.com/..."
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-600 focus:ring-blue-600">
                </div>

                <!-- Status -->
                <div>
                    <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                    @php
                        $allStatuses = AcademicInnovation::statuses();
                        if (!in_array($innovation->status, $allStatuses)) {
                            $allStatuses[] = $innovation->status;
                        }
                    @endphp
                    <select name="status" id="status"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-600 focus:ring-blue-600">
                        @foreach($allStatuses as $status)
                            <option value="{{ $status }}" {{ old('status', $innovation->status) == $status ? 'selected' : '' }}>
                                {{ ucfirst($status) }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Tombol Action -->
                <div class="mt-8 flex justify-between gap-4 pt-6 border-t">
                    <a href="{{ route('akademisi.inovasi.show', $innovation->id) }}"
                       class="px-6 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-100">
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

<!-- JS: TRL Slider + Subcategory manual + Preview file -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Data subkategori manual (sama seperti di halaman create)
    const subcategories = {
        'Teknologi': [
            'Artificial Intelligence',
            'Internet of Things',
            'Sistem Informasi Akademik',
            'Robotics',
            'Biotechnology',
        ],
        'Sosial': [
            'Kewirausahaan Sosial',
            'Pemberdayaan Masyarakat',
            'Inklusi Sosial',
            'Pengentasan Kemiskinan',
        ],
        'Pendidikan': [
            'EdTech',
            'Metode Pembelajaran',
            'Kurikulum',
            'Assesmen Pendidikan',
        ],
        'Humaniora': [
            'Psikologi',
            'Seni & Budaya',
            'Filsafat',
            'Sejarah',
            'Antropologi',
        ]
    };

    // TRL slider
    const trl = document.getElementById('trl');
    const trlValue = document.getElementById('trlValue');
    trl.addEventListener('input', () => trlValue.textContent = trl.value);

    // Subcategory manual
    const categorySelect = document.getElementById('category');
    const subcategorySelect = document.getElementById('subcategory');
    const currentSubcategory = "{{ old('subcategory', $innovation->subcategory) }}";

    // Load subcategories berdasarkan kategori yang dipilih
    function loadSubcategories(category, selectedValue = '') {
        subcategorySelect.innerHTML = '<option value="">Pilih Subkategori</option>';
        
        if (category && subcategories[category]) {
            subcategories[category].forEach(sub => {
                const option = document.createElement('option');
                option.value = sub;
                option.textContent = sub;
                if (sub === selectedValue) {
                    option.selected = true;
                }
                subcategorySelect.appendChild(option);
            });
        }
    }

    // Inisialisasi subkategori saat halaman dimuat
    if (categorySelect.value) {
        loadSubcategories(categorySelect.value, currentSubcategory);
    }

    // Event listener untuk perubahan kategori
    categorySelect.addEventListener('change', function() {
        loadSubcategories(this.value);
    });

    // Preview gambar
    const imageInput = document.getElementById('image_path');
    const previewImage = document.getElementById('previewImage');
    const currentImage = document.getElementById('currentImage');

    imageInput.addEventListener('change', function(e){
        const file = e.target.files[0];
        if(file){
            const reader = new FileReader();
            reader.onload = function(event){
                previewImage.innerHTML = `<img src="${event.target.result}" class="w-32 h-32 object-cover rounded mt-2 mx-auto">`;
            }
            reader.readAsDataURL(file);
            if(currentImage) currentImage.style.display = 'none';
        } else {
            previewImage.innerHTML = '';
            if(currentImage) currentImage.style.display = 'block';
        }
    });

    // Preview PDF
    const docInput = document.getElementById('document_path');
    const previewDoc = document.getElementById('previewDoc');
    const currentDoc = document.getElementById('currentDoc');

    docInput.addEventListener('change', function(e){
        const file = e.target.files[0];
        if(file){
            previewDoc.textContent = `File yang dipilih: ${file.name}`;
            if(currentDoc) currentDoc.style.display = 'none';
        } else {
            previewDoc.textContent = '';
            if(currentDoc) currentDoc.style.display = 'block';
        }
    });
});
</script>
@endsection