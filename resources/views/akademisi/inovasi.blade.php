@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto mt-8 px-4 sm:px-6 lg:px-8">
    <div class="flex flex-col lg:flex-row gap-8 justify-center items-start">
        <!-- Form Section (70%) -->
        <div class="w-full lg:basis-[70%]">
            <div class="bg-white rounded-xl card-shadow p-6 mb-6">
                <h2 class="text-2xl font-bold text-gray-800 mb-6">Posting Inovasi Baru</h2>
                
                @if(session('success'))
                    <div class="mb-4 p-3 bg-green-50 border border-green-200 text-green-700 rounded">
                        {{ session('success') }}
                    </div>
                @endif

                @if($errors->any())
                    <div class="mb-4 p-3 bg-red-50 border border-red-200 text-red-700 rounded">
                        <ul class="list-disc pl-5">
                            @foreach($errors->all() as $err)
                                <li>{{ $err }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form id="inovasiForm" method="POST" action="{{ route('akademisi.inovasi.store') }}" enctype="multipart/form-data">
                    @csrf

                    <!-- Judul Inovasi -->
                    <div class="mb-6">
                        <label for="title" class="block text-gray-700 font-medium mb-2">Judul Inovasi</label>
                        <input value="{{ old('title') }}" type="text" id="title" name="title" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Masukkan judul inovasi" required>
                    </div>

                    <!-- Kategori dan Subkategori -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div>
                            <label for="category" class="block text-gray-700 font-medium mb-2">Kategori</label>
                            <select id="category" name="category" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <option value="">Pilih Kategori</option>
                                @foreach($categories as $cat)
                                    <option value="{{ $cat }}" {{ old('category') == $cat ? 'selected' : '' }}>{{ $cat }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label for="subcategory" class="block text-gray-700 font-medium mb-2">Subkategori</label>
                            <select id="subcategory" name="subcategory" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" {{ old('subcategory') ? '' : 'disabled' }}>
                                <option value="">{{ old('subcategory') ? old('subcategory') : 'Pilih Kategori terlebih dahulu' }}</option>
                            </select>
                        </div>
                    </div>

                    <!-- Penulis dan Institusi -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div>
                            <label for="author_name" class="block text-gray-700 font-medium mb-2">Nama Penulis/Penemu</label>
                            <input value="{{ old('author_name', auth()->user()->name ?? '') }}" type="text" id="author_name" name="author_name" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Nama lengkap penulis">
                        </div>
                        <div>
                            <label for="institution" class="block text-gray-700 font-medium mb-2">Institusi/Organisasi</label>
                            <input value="{{ old('institution') }}" type="text" id="institution" name="institution" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Nama institusi">
                        </div>
                    </div>

                    <!-- Kata Kunci -->
                    <div class="mb-6">
                        <label for="keywords" class="block text-gray-700 font-medium mb-2">Kata Kunci</label>
                        <input value="{{ old('keywords') }}" type="text" id="keywords" name="keywords" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Pisahkan dengan koma (contoh: AI, IoT, Edukasi)">
                    </div>

                    <!-- Deskripsi -->
                    <div class="mb-6">
                        <label for="description" class="block text-gray-700 font-medium mb-2">Deskripsi Inovasi</label>
                        <textarea id="description" name="description" rows="4" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Jelaskan detail inovasi Anda">{{ old('description') }}</textarea>
                    </div>

                    <!-- Tujuan -->
                    <div class="mb-6">
                        <label for="purpose" class="block text-gray-700 font-medium mb-2">Tujuan Inovasi</label>
                        <textarea id="purpose" name="purpose" rows="3" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Apa tujuan dari inovasi ini?">{{ old('purpose') }}</textarea>
                    </div>

                    <!-- TRL -->
                    <div class="mb-6">
                        <label for="technology_readiness_level" class="block text-gray-700 font-medium mb-2">Tingkat Kesiapan Teknologi (TRL)</label>
                        <div class="flex items-center">
                            <input type="range" id="technology_readiness_level" name="technology_readiness_level" min="1" max="9" value="{{ old('technology_readiness_level', 1) }}" class="w-full mr-4">
                            <span id="trlValue" class="text-blue-600 font-bold">{{ old('technology_readiness_level', 1) }}</span>
                        </div>
                        <div class="text-sm text-gray-500 mt-2">
                            <span>1: Prinsip dasar diamati</span> - 
                            <span>9: Sistem terbukti dalam lingkungan operasional</span>
                        </div>
                    </div>

                    <!-- Uploads -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div>
                            <label for="image_path" class="block text-gray-700 font-medium mb-2">Gambar Inovasi</label>
                            <div class="border-2 border-dashed border-gray-300 rounded-lg p-4 text-center drop-zone">
                                <i class="fas fa-cloud-upload-alt text-3xl text-gray-400 mb-2"></i>
                                <p class="text-gray-500">Seret gambar atau <span class="text-blue-500 cursor-pointer">pilih file</span></p>
                                <input type="file" id="image_path" name="image_path" class="hidden" accept="image/*">
                            </div>
                        </div>
                        <div>
                            <label for="document_path" class="block text-gray-700 font-medium mb-2">Dokumen (PDF)</label>
                            <div class="border-2 border-dashed border-gray-300 rounded-lg p-4 text-center drop-zone">
                                <i class="fas fa-file-pdf text-3xl text-red-400 mb-2"></i>
                                <p class="text-gray-500">Seret dokumen atau <span class="text-blue-500 cursor-pointer">pilih file</span></p>
                                <input type="file" id="document_path" name="document_path" class="hidden" accept=".pdf">
                            </div>
                        </div>
                    </div>

                    <!-- Video & Kontak -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div>
                            <label for="video_url" class="block text-gray-700 font-medium mb-2">Link Video (Opsional)</label>
                            <input value="{{ old('video_url') }}" type="url" id="video_url" name="video_url" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="https://youtube.com/...">
                        </div>
                        <div>
                            <label for="contact" class="block text-gray-700 font-medium mb-2">Kontak (Email/Telepon)</label>
                            <input value="{{ old('contact') }}" type="text" id="contact" name="contact" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="email@contoh.com atau 08xx-xxxx-xxxx">
                        </div>
                    </div>

                    <!-- Status -->
<div class="mb-6">
    <label for="status" class="block text-gray-700 font-medium mb-2">Status</label>
    <select id="status" name="status" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
        @foreach(\App\Models\Innovation::statuses() as $s)
            <option value="{{ $s }}" {{ old('status', \App\Models\Innovation::STATUS_DRAFT) === $s ? 'selected' : '' }}>
                {{ $s }}
            </option>
        @endforeach
    </select>
    <p class="text-xs text-gray-400 mt-1">Pilih status: Draft (default) atau Publication.</p>
</div>


                    <!-- Buttons -->
                    <div class="flex justify-end mt-8">
                        <a href="{{ url()->previous() }}" class="px-6 py-2 bg-gray-300 text-gray-700 rounded-lg font-medium mr-4 hover:bg-gray-400 transition duration-300">Batal</a>
                        <button type="submit" class="px-6 py-2 gradient-bg text-white rounded-lg font-medium hover:opacity-90 transition duration-300">Posting Inovasi</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Inovasi Saya (30%) -->
        <div class="w-full lg:basis-[30%]">
            <div class="bg-white rounded-xl card-shadow p-6">
                <h2 class="text-2xl font-bold text-gray-800 mb-6">Inovasi Saya</h2>
                
                @forelse($innovations as $year => $items)
                    <div class="mb-6">
                        <h4 class="font-semibold text-gray-600 mb-3">{{ $year }}</h4>
                        <div class="space-y-4">
                            @foreach($items as $item)
                                <a href="{{ route('akademisi.inovasi.show', $item->id) }}" class="block border border-gray-200 rounded-lg p-4 hover:border-blue-300 hover:shadow-md transition duration-300">
                                    <div class="flex items-start gap-4">
                                        <div class="w-24 h-16 bg-gray-100 rounded overflow-hidden flex-shrink-0">
                                            @if($item->image_path)
                                                <img src="{{ asset('storage/' . $item->image_path) }}" alt="" class="w-full h-full object-cover">
                                            @else
                                                <div class="w-full h-full flex items-center justify-center text-gray-400">
                                                    <i class="fas fa-image text-xl"></i>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="flex-1">
                                            <h3 class="font-semibold text-gray-800 text-base">{{ \Illuminate\Support\Str::limit($item->title, 100) }}</h3>
                                            <p class="text-sm text-gray-600 mt-1">{{ \Illuminate\Support\Str::limit($item->description, 160) }}</p>
                                            <div class="flex justify-between text-xs text-gray-400 mt-3">
                                                <span class="inline-flex items-center px-2 py-1 bg-gray-100 rounded text-xs">{{ $item->category ?? '-' }}</span>
                                                <span>{{ $item->created_at->format('d M Y') }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    </div>
                @empty
                    <p class="text-sm text-gray-500">Belum ada inovasi. Mulai posting inovasi pertama kamu!</p>
                @endforelse

            </div>
        </div>
    </div>
</div>

<!-- Inline script khusus halaman -->
@push('scripts')
<script>
    // update TRL value
    const trl = document.getElementById('technology_readiness_level');
    const trlValue = document.getElementById('trlValue');
    if (trl) {
        trl.addEventListener('input', function() {
            trlValue.textContent = this.value;
        });
    }

    // dynamic subcategory via ajax
    const category = document.getElementById('category');
    const subcategory = document.getElementById('subcategory');

    async function loadSubcategories(cat) {
        subcategory.innerHTML = '<option>Memuat...</option>';
        try {
            const res = await fetch("{{ route('akademisi.subcategories') }}?category="+encodeURIComponent(cat));
            const data = await res.json();
            subcategory.innerHTML = '<option value="">Pilih Subkategori</option>';
            data.forEach(s => {
                const opt = document.createElement('option');
                opt.value = s;
                opt.textContent = s;
                subcategory.appendChild(opt);
            });
            subcategory.disabled = false;
        } catch (e) {
            subcategory.innerHTML = '<option value="">Gagal memuat subkategori</option>';
            subcategory.disabled = true;
            console.error(e);
        }
    }

    if (category) {
        category.addEventListener('change', function() {
            const val = this.value;
            if (!val) {
                subcategory.innerHTML = '<option value="">Pilih Kategori terlebih dahulu</option>';
                subcategory.disabled = true;
                return;
            }
            loadSubcategories(val);
        });

        // jika ada old value (mis. setelah validasi error) load subcategories dan set selected
        @if(old('category') && old('subcategory'))
            loadSubcategories("{{ old('category') }}").then(() => {
                setTimeout(() => {
                    subcategory.value = "{{ old('subcategory') }}";
                }, 250);
            });
        @endif
    }

    // Drag & drop and click for each drop-zone
    document.querySelectorAll('.drop-zone').forEach(zone => {
        const fileInput = zone.querySelector('input[type=file]');
        const text = zone.querySelector('p');

        zone.addEventListener('click', () => fileInput.click());

        fileInput.addEventListener('change', () => {
            if (fileInput.files.length > 0) {
                text.innerHTML = `<span class="text-green-500">${fileInput.files[0].name}</span>`;
            }
        });

        zone.addEventListener('dragover', (e) => {
            e.preventDefault();
            zone.classList.add('border-blue-400', 'bg-blue-50');
        });

        zone.addEventListener('dragleave', () => {
            zone.classList.remove('border-blue-400', 'bg-blue-50');
        });

        zone.addEventListener('drop', (e) => {
            e.preventDefault();
            zone.classList.remove('border-blue-400', 'bg-blue-50');
            if (e.dataTransfer.files.length > 0) {
                fileInput.files = e.dataTransfer.files;
                text.innerHTML = `<span class="text-green-500">${fileInput.files[0].name}</span>`;
            }
        });
    });
</script>
@endpush
@endsection
