@extends('layouts.app')

@section('styles')
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<script src="https://cdn.tailwindcss.com"></script>
<script>
    tailwind.config = {
        theme: {
            extend: {
                colors: {
                    primary: '#1e40af',
                    secondary: '#0ea5e9',
                    accent: '#3b82f6',
                    dark: '#1e293b',
                    light: '#f8fafc'
                }
            }
        }
    }
</script>
<style>
    .hero-bg {
        background: linear-gradient(135deg, #1e40af 0%, #0ea5e9 100%);
    }
</style>
@endsection

@section('content')
<!-- Hero Section -->
<section class="hero-bg text-white py-16">
    <div class="container mx-auto px-6 md:px-12 text-center">
        <h1 class="text-4xl md:text-5xl font-extrabold mb-4 leading-tight">
            Posting <span class="text-yellow-300">Program Baru</span>
        </h1>
        <p class="text-lg md:text-xl max-w-2xl mx-auto leading-relaxed">
            Bagikan program prioritas daerah Anda untuk menjangkau lebih banyak kolaborator.
        </p>
    </div>
</section>

<!-- Form Section -->
<section class="bg-white py-12">
    <div class="container mx-auto px-6 md:px-12">
        <div class="max-w-4xl mx-auto bg-white rounded-xl shadow-lg border border-gray-100 p-8">
            <form action="{{ route('pemerintah.program.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Kolom Kiri -->
                    <div class="space-y-6">
                        <!-- Judul Program -->
                        <div>
                            <label for="title" class="block text-sm font-medium text-gray-700 mb-2">
                                Judul Program *
                            </label>
                            <input type="text" id="title" name="title" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent"
                                placeholder="Contoh: Program Infrastruktur Digital Kota"
                                value="{{ old('title') }}">
                            @error('title')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- OPD Penanggung Jawab -->
                        <div>
                            <label for="opd_name" class="block text-sm font-medium text-gray-700 mb-2">
                                OPD Penanggung Jawab *
                            </label>
                            <input type="text" id="opd_name" name="opd_name" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent"
                                placeholder="Contoh: Dinas Komunikasi dan Informatika"
                                value="{{ old('opd_name') }}">
                            @error('opd_name')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Kategori -->
                        <div>
                            <label for="category" class="block text-sm font-medium text-gray-700 mb-2">
                                Kategori *
                            </label>
                            <select id="category" name="category" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent">
                                <option value="">Pilih Kategori</option>
                                <option value="Infrastruktur Digital" {{ old('category') == 'Infrastruktur Digital' ? 'selected' : '' }}>Infrastruktur Digital</option>
                                <option value="Smart City" {{ old('category') == 'Smart City' ? 'selected' : '' }}>Smart City</option>
                                <option value="Pelayanan Publik" {{ old('category') == 'Pelayanan Publik' ? 'selected' : '' }}>Pelayanan Publik</option>
                                <option value="Ekonomi Digital" {{ old('category') == 'Ekonomi Digital' ? 'selected' : '' }}>Ekonomi Digital</option>
                                <option value="Kesehatan" {{ old('category') == 'Kesehatan' ? 'selected' : '' }}>Kesehatan</option>
                                <option value="Pendidikan" {{ old('category') == 'Pendidikan' ? 'selected' : '' }}>Pendidikan</option>
                            </select>
                            @error('category')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Status -->
                        <div>
                            <label for="status" class="block text-sm font-medium text-gray-700 mb-2">
                                Status Program *
                            </label>
                            <select id="status" name="status" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent">
                                <option value="">Pilih Status</option>
                                <option value="planning" {{ old('status') == 'planning' ? 'selected' : '' }}>📅 Perencanaan</option>
                                <option value="ongoing" {{ old('status') == 'ongoing' ? 'selected' : '' }}>🚀 Berjalan</option>
                                <option value="completed" {{ old('status') == 'completed' ? 'selected' : '' }}>✅ Selesai</option>
                            </select>
                            @error('status')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Kolom Kanan -->
                    <div class="space-y-6">
                        <!-- Progress -->
                        <div>
                            <label for="progress" class="block text-sm font-medium text-gray-700 mb-2">
                                Progress (%)
                            </label>
                            <input type="number" id="progress" name="progress" min="0" max="100" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent"
                                placeholder="0-100"
                                value="{{ old('progress', 0) }}">
                            @error('progress')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Anggaran -->
                        <div>
                            <label for="budget" class="block text-sm font-medium text-gray-700 mb-2">
                                Anggaran (Rp)
                            </label>
                            <input type="number" id="budget" name="budget"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent"
                                placeholder="Contoh: 5000000000"
                                value="{{ old('budget') }}">
                            @error('budget')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Tanggal Mulai -->
                        <div>
                            <label for="start_date" class="block text-sm font-medium text-gray-700 mb-2">
                                Tanggal Mulai *
                            </label>
                            <input type="date" id="start_date" name="start_date" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent"
                                value="{{ old('start_date') }}">
                            @error('start_date')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Tanggal Selesai -->
                        <div>
                            <label for="end_date" class="block text-sm font-medium text-gray-700 mb-2">
                                Tanggal Selesai *
                            </label>
                            <input type="date" id="end_date" name="end_date" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent"
                                value="{{ old('end_date') }}">
                            @error('end_date')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Deskripsi -->
                <div class="mt-6">
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                        Deskripsi Program *
                    </label>
                    <textarea id="description" name="description" rows="6" required
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent"
                        placeholder="Jelaskan detail program, tujuan, manfaat, dan target yang ingin dicapai...">{{ old('description') }}</textarea>
                    @error('description')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Upload Gambar -->
                <div class="mt-6">
                    <label for="image" class="block text-sm font-medium text-gray-700 mb-2">
                        Upload Gambar Program
                    </label>
                    <input type="file" id="image" name="image"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent"
                        accept="image/*">
                    <p class="text-sm text-gray-500 mt-1">Format: JPEG, PNG, JPG, GIF (Maksimal 2MB)</p>
                    @error('image')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Button Actions -->
                <div class="mt-8 flex flex-col sm:flex-row gap-4 justify-end">
                    <a href="{{ route('program.innovation.index') }}" 
                       class="inline-flex justify-center items-center px-6 py-3 border border-gray-300 text-gray-700 rounded-lg font-semibold hover:bg-gray-50 transition">
                        ❌ Batal
                    </a>
                    <button type="submit"
                            class="inline-flex justify-center items-center px-6 py-3 bg-primary text-white rounded-lg font-semibold hover:bg-blue-700 transition">
                        📋 Posting Program
                    </button>
                </div>
            </form>
        </div>
    </div>
</section>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Auto-set progress based on status
        const statusSelect = document.getElementById('status');
        const progressInput = document.getElementById('progress');
        
        statusSelect.addEventListener('change', function() {
            switch(this.value) {
                case 'planning':
                    progressInput.value = 0;
                    break;
                case 'ongoing':
                    progressInput.value = progressInput.value || 50;
                    break;
                case 'completed':
                    progressInput.value = 100;
                    break;
            }
        });

        // Date validation
        const startDate = document.getElementById('start_date');
        const endDate = document.getElementById('end_date');
        
        startDate.addEventListener('change', function() {
            if (this.value && endDate.value && this.value > endDate.value) {
                alert('Tanggal mulai tidak boleh setelah tanggal selesai!');
                this.value = '';
            }
        });
        
        endDate.addEventListener('change', function() {
            if (this.value && startDate.value && this.value < startDate.value) {
                alert('Tanggal selesai tidak boleh sebelum tanggal mulai!');
                this.value = '';
            }
        });
    });
</script>
@endsection