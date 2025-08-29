@extends('layouts.akademisi.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-blue-500 via-indigo-500 to-purple-600 py-12">
    <div class="max-w-4xl mx-auto px-4">
        <!-- Header -->
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-16 h-16 bg-white rounded-full shadow-lg mb-4">
                <i class="fas fa-lightbulb text-3xl text-purple-600"></i>
            </div>
            <h1 class="text-3xl md:text-4xl font-bold text-white mb-2">Posting Inovasi Akademisi</h1>
            <p class="text-white/90">Bagikan karya inovatif Anda untuk pengembangan UMKM</p>
        </div>

        {{-- Flash message --}}
        @if(session('success'))
            <div class="mb-4 p-4 bg-green-50 border border-green-200 text-green-800 rounded">
                {{ session('success') }}
            </div>
        @endif

        {{-- Form --}}
        <form class="space-y-6" id="inovasiForm" method="POST" action="{{ route('akademisi.post_inovasi.store') }}" enctype="multipart/form-data">
            @csrf

            <!-- 1. Informasi Dasar -->
            <div class="bg-white rounded-2xl p-6 shadow-xl">
                <div class="flex items-center mb-6">
                    <div class="w-8 h-8 bg-purple-600 rounded-full flex items-center justify-center text-white mr-3">
                        <span class="font-bold">1</span>
                    </div>
                    <h2 class="text-xl font-semibold text-gray-800">Informasi Dasar</h2>
                </div>

                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Judul Inovasi <span class="text-red-500">*</span></label>
                        <input name="title" type="text" value="{{ old('title') }}" required
                               class="w-full px-4 py-3 border border-gray-200 rounded-lg bg-white focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                               placeholder="Judul inovasi yang singkat dan jelas">
                        @error('title') <div class="text-red-600 text-sm mt-1">{{ $message }}</div> @enderror
                    </div>

                    <div class="grid md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Bidang Inovasi <span class="text-red-500">*</span></label>
                            <select name="category" required class="w-full px-4 py-3 border border-gray-200 rounded-lg bg-white focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                                <option value="">Pilih kategori</option>
                                @foreach(['Teknologi','Pendidikan','Kesehatan','Energi','Pertanian','Lainnya'] as $cat)
                                    <option value="{{ $cat }}" {{ old('category') == $cat ? 'selected' : '' }}>{{ $cat }}</option>
                                @endforeach
                            </select>
                            @error('category') <div class="text-red-600 text-sm mt-1">{{ $message }}</div> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Kata Kunci</label>
                            <input name="keywords" type="text" value="{{ old('keywords') }}"
                                   class="w-full px-4 py-3 border border-gray-200 rounded-lg bg-white focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                                   placeholder="inovasi, teknologi, pertanian">
                            <p class="text-xs text-gray-500 mt-1">Pisahkan dengan koma</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 2. Deskripsi & Konten -->
            <div class="bg-white rounded-2xl p-6 shadow-xl">
                <div class="flex items-center mb-6">
                    <div class="w-8 h-8 bg-purple-600 rounded-full flex items-center justify-center text-white mr-3">
                        <span class="font-bold">2</span>
                    </div>
                    <h2 class="text-xl font-semibold text-gray-800">Deskripsi & Konten</h2>
                </div>

                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Abstrak Singkat <span class="text-red-500">*</span></label>
                        <textarea name="abstract" required rows="3" maxlength="200"
                                  class="w-full px-4 py-3 border border-gray-200 rounded-lg bg-white focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                                  placeholder="Ringkasan inovasi maksimal 150-200 kata">{{ old('abstract') }}</textarea>
                        <div class="flex justify-between text-xs text-gray-500 mt-1">
                            <span>Maksimal 200 kata</span>
                            <span class="char-count">0/200</span>
                        </div>
                        @error('abstract') <div class="text-red-600 text-sm mt-1">{{ $message }}</div> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Deskripsi Lengkap <span class="text-red-500">*</span></label>
                        <textarea name="description" required rows="5"
                                  class="w-full px-4 py-3 border border-gray-200 rounded-lg bg-white focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                                  placeholder="Penjelasan detail inovasi...">{{ old('description') }}</textarea>
                        @error('description') <div class="text-red-600 text-sm mt-1">{{ $message }}</div> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Tujuan & Manfaat <span class="text-red-500">*</span></label>
                        <textarea name="purpose" required rows="3"
                                  class="w-full px-4 py-3 border border-gray-200 rounded-lg bg-white focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                                  placeholder="Mengapa inovasi ini penting...">{{ old('purpose') }}</textarea>
                        @error('purpose') <div class="text-red-600 text-sm mt-1">{{ $message }}</div> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Tingkat Kesiapan Teknologi</label>
                        <select name="technology_readiness_level" class="w-full px-4 py-3 border border-gray-200 rounded-lg bg-white focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                            <option value="">Pilih tingkat kesiapan</option>
                            @foreach(['Ide','Prototype','Siap Komersialisasi'] as $trl)
                                <option value="{{ $trl }}" {{ old('technology_readiness_level') == $trl ? 'selected' : '' }}>{{ $trl }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <!-- 3. Media Pendukung -->
            <div class="bg-white rounded-2xl p-6 shadow-xl">
                <div class="flex items-center mb-6">
                    <div class="w-8 h-8 bg-purple-600 rounded-full flex items-center justify-center text-white mr-3">
                        <span class="font-bold">3</span>
                    </div>
                    <h2 class="text-xl font-semibold text-gray-800">Media Pendukung</h2>
                </div>

                <div class="space-y-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Unggah Gambar / Poster (maks 2MB)</label>
                        <input type="file" name="image" accept="image/*" class="w-full rounded-md border border-dashed border-gray-200 p-2 bg-white" />
                        @error('image') <div class="text-red-600 text-sm mt-1">{{ $message }}</div> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Dokumen Pendukung (PDF - maks 5MB)</label>
                        <input type="file" name="document" accept=".pdf" class="w-full rounded-md border border-dashed border-gray-200 p-2 bg-white" />
                        @error('document') <div class="text-red-600 text-sm mt-1">{{ $message }}</div> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Video Presentasi (opsional)</label>
                        <input name="video_url" type="url" value="{{ old('video_url') }}"
                               class="w-full px-4 py-3 border border-gray-200 rounded-lg bg-white focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                               placeholder="https://youtube.com/...">
                    </div>
                </div>
            </div>

            <!-- 4. Informasi Penulis -->
            <div class="bg-white rounded-2xl p-6 shadow-xl">
                <div class="flex items-center mb-6">
                    <div class="w-8 h-8 bg-purple-600 rounded-full flex items-center justify-center text-white mr-3">
                        <span class="font-bold">4</span>
                    </div>
                    <h2 class="text-xl font-semibold text-gray-800">Informasi Penulis</h2>
                </div>

                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Nama Penulis / Tim <span class="text-red-500">*</span></label>
                        <input name="author_name" type="text" value="{{ old('author_name') }}" required
                               class="w-full px-4 py-3 border border-gray-200 rounded-lg bg-white focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                               placeholder="Nama lengkap penulis atau tim">
                        @error('author_name') <div class="text-red-600 text-sm mt-1">{{ $message }}</div> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Institusi Asal <span class="text-red-500">*</span></label>
                        <input name="institution" type="text" value="{{ old('institution') }}" required
                               class="w-full px-4 py-3 border border-gray-200 rounded-lg bg-white focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                               placeholder="Universitas atau lembaga penelitian">
                        @error('institution') <div class="text-red-600 text-sm mt-1">{{ $message }}</div> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Kontak</label>
                        <input name="contact" type="text" value="{{ old('contact') }}"
                               class="w-full px-4 py-3 border border-gray-200 rounded-lg bg-white focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                               placeholder="email@example.com, linkedin.com/in/username">
                        <p class="text-xs text-gray-500 mt-1">Email, website, atau LinkedIn (pisahkan dengan koma)</p>
                    </div>
                </div>
            </div>

            <!-- 5. Status & Hak Akses -->
            <div class="bg-white rounded-2xl p-6 shadow-xl">
                <div class="flex items-center mb-6">
                    <div class="w-8 h-8 bg-purple-600 rounded-full flex items-center justify-center text-white mr-3">
                        <span class="font-bold">5</span>
                    </div>
                    <h2 class="text-xl font-semibold text-gray-800">Status & Hak Akses</h2>
                </div>

                <div class="grid md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Status Inovasi <span class="text-red-500">*</span></label>
                        <select name="status" required class="w-full px-4 py-3 border border-gray-200 rounded-lg bg-white focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                            <option value="Draft" {{ old('status')=='Draft' ? 'selected' : '' }}>Draft (belum dipublikasikan)</option>
                            <option value="Publish" {{ old('status')=='Publish' ? 'selected' : '' }}>Publish</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Hak Cipta / Kepemilikan</label>
                        <select name="copyright_status" class="w-full px-4 py-3 border border-gray-200 rounded-lg bg-white focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                            <option value="">Pilih status hak cipta</option>
                            <option value="Sudah Paten" {{ old('copyright_status')=='Sudah Paten' ? 'selected' : '' }}>Sudah Paten</option>
                            <option value="Dalam Proses" {{ old('copyright_status')=='Dalam Proses' ? 'selected' : '' }}>Dalam Proses</option>
                            <option value="Belum" {{ old('copyright_status')=='Belum' ? 'selected' : '' }}>Belum</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Submit Button -->
            <button type="submit" class="w-full bg-gradient-to-r from-purple-600 to-indigo-600 text-white py-4 px-6 rounded-xl font-semibold text-lg hover:from-purple-700 hover:to-indigo-700 transition-all duration-300 shadow-lg">
                <i class="fas fa-paper-plane mr-2"></i>
                Simpan Inovasi
            </button>
        </form>

        <!-- Daftar Inovasi Sebelumnya -->
        <div class="bg-white rounded-2xl p-6 shadow-xl mt-8">
            <div class="flex items-center mb-6">
                <i class="fas fa-history text-2xl text-purple-600 mr-3"></i>
                <h2 class="text-xl font-semibold text-gray-800">Inovasi yang Pernah Diposting</h2>
            </div>

            <div class="space-y-4" id="previousInnovations">
                @forelse($innovations as $item)
                    <div class="innovation-card bg-white p-6 rounded-xl shadow-md border border-gray-100">
                        <div class="flex justify-between items-start mb-3">
                            <h3 class="text-lg font-semibold text-gray-800">{{ \Illuminate\Support\Str::limit($item->title, 80) }}</h3>
                            <span class="inline-block bg-gradient-to-r from-blue-500 to-indigo-600 text-white text-xs px-3 py-1 rounded-full">{{ $item->category }}</span>
                        </div>
                        <p class="text-gray-600 text-sm mb-4">{{ \Illuminate\Support\Str::limit($item->abstract, 150) }}</p>
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-500">
                                {{ $item->status }} • {{ $item->created_at->isoFormat('D MMM YYYY') }}
                            </span>
                            <div class="flex space-x-2">
                                @if($item->technology_readiness_level)
                                    <span class="bg-green-100 text-green-800 text-xs px-2 py-1 rounded">{{ $item->technology_readiness_level }}</span>
                                @endif
                                @if($item->copyright_status)
                                    <span class="bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded">{{ $item->copyright_status }}</span>
                                @endif
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="text-gray-600">Belum ada inovasi yang diposting.</div>
                @endforelse

                {{-- pagination --}}
                <div class="mt-6">
                    {{ $innovations->withQueryString()->links() }}
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Scripts (character count & simple UI) --}}
@push('scripts')
<script>
    // Character counter for abstract
    const textarea = document.querySelector('textarea[maxlength="200"]');
    const charCount = document.querySelector('.char-count');

    if(textarea && charCount){
        textarea.addEventListener('input', function() {
            const currentLength = this.value.length;
            charCount.textContent = `${currentLength}/200`;

            if (currentLength > 190) {
                charCount.classList.add('text-red-500');
            } else {
                charCount.classList.remove('text-red-500');
            }
        });

        // initial count
        charCount.textContent = `${textarea.value.length}/200`;
    }
</script>
@endpush

@endsection
