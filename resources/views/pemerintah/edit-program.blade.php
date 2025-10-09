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
    .card-hover {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    .card-hover:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 20px -6px rgba(0, 0, 0, 0.15);
    }
</style>
@endsection

@section('content')
<!-- Hero Section -->
<section class="hero-bg text-white py-12">
    <div class="container mx-auto px-4 md:px-6 text-center">
        <h1 class="text-3xl md:text-4xl font-bold mb-3 leading-tight">
            Edit <span class="text-yellow-300">Program</span>
        </h1>
        <p class="text-base md:text-lg max-w-2xl mx-auto leading-relaxed opacity-90">
            Perbarui informasi program prioritas daerah.
        </p>
    </div>
</section>

<!-- Edit Form Section -->
<section class="bg-white py-8">
    <div class="container mx-auto px-4 md:px-6">
        <div class="max-w-4xl mx-auto">
            <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-6 md:p-8">
                <h2 class="text-2xl font-bold text-gray-800 mb-6">Edit Program: {{ $program->title }}</h2>
                
                @if(session('success'))
                    <div class="mb-6 p-4 bg-green-50 border border-green-200 text-green-700 rounded-lg">
                        {{ session('success') }}
                    </div>
                @endif

                @if($errors->any())
                    <div class="mb-6 p-4 bg-red-50 border border-red-200 text-red-700 rounded-lg">
                        <ul class="list-disc pl-5">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('pemerintah.program.update', $program->id) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <!-- Judul Program -->
                    <div class="mb-6">
                        <label for="title" class="block text-gray-700 font-medium mb-2">Judul Program</label>
                        <input value="{{ old('title', $program->title) }}" type="text" id="title" name="title" 
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary" 
                               placeholder="Masukkan judul program" required>
                    </div>

                    <!-- OPD dan Kategori -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div>
                            <label for="opd_name" class="block text-gray-700 font-medium mb-2">OPD Penanggung Jawab</label>
                            <input value="{{ old('opd_name', $program->opd_name) }}" type="text" id="opd_name" name="opd_name" 
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary" 
                                   placeholder="Nama OPD" required>
                        </div>
                        <div>
                            <label for="category" class="block text-gray-700 font-medium mb-2">Kategori</label>
                            <select id="category" name="category" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary" required>
                                <option value="">Pilih Kategori</option>
                                <option value="Infrastruktur Digital" {{ old('category', $program->category) == 'Infrastruktur Digital' ? 'selected' : '' }}>Infrastruktur Digital</option>
                                <option value="Smart City" {{ old('category', $program->category) == 'Smart City' ? 'selected' : '' }}>Smart City</option>
                                <option value="Pelayanan Publik" {{ old('category', $program->category) == 'Pelayanan Publik' ? 'selected' : '' }}>Pelayanan Publik</option>
                                <option value="Ekonomi Digital" {{ old('category', $program->category) == 'Ekonomi Digital' ? 'selected' : '' }}>Ekonomi Digital</option>
                                <option value="Kesehatan" {{ old('category', $program->category) == 'Kesehatan' ? 'selected' : '' }}>Kesehatan</option>
                                <option value="Pendidikan" {{ old('category', $program->category) == 'Pendidikan' ? 'selected' : '' }}>Pendidikan</option>
                            </select>
                        </div>
                    </div>

                    <!-- Status dan Progress -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div>
                            <label for="status" class="block text-gray-700 font-medium mb-2">Status Program</label>
                            <select id="status" name="status" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary" required>
                                <option value="planning" {{ old('status', $program->status) == 'planning' ? 'selected' : '' }}>📅 Perencanaan</option>
                                <option value="ongoing" {{ old('status', $program->status) == 'ongoing' ? 'selected' : '' }}>🚀 Berjalan</option>
                                <option value="completed" {{ old('status', $program->status) == 'completed' ? 'selected' : '' }}>✅ Selesai</option>
                            </select>
                        </div>
                        <div>
                            <label for="progress" class="block text-gray-700 font-medium mb-2">Progress (%)</label>
                            <input value="{{ old('progress', $program->progress) }}" type="number" id="progress" name="progress" 
                                   min="0" max="100" 
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary" 
                                   placeholder="0-100" required>
                            <div class="mt-2">
                                <div class="w-full bg-gray-200 rounded-full h-2">
                                    <div id="progressBar" class="bg-green-500 h-2 rounded-full" style="width: {{ old('progress', $program->progress) }}%"></div>
                                </div>
                                <div class="flex justify-between text-xs text-gray-600 mt-1">
                                    <span>0%</span>
                                    <span id="progressValue">{{ old('progress', $program->progress) }}%</span>
                                    <span>100%</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Tanggal Mulai & Selesai -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div>
                            <label for="start_date" class="block text-gray-700 font-medium mb-2">Tanggal Mulai</label>
                            <input value="{{ old('start_date', $program->start_date->format('Y-m-d')) }}" type="date" id="start_date" name="start_date" 
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary" required>
                        </div>
                        <div>
                            <label for="end_date" class="block text-gray-700 font-medium mb-2">Tanggal Selesai</label>
                            <input value="{{ old('end_date', $program->end_date->format('Y-m-d')) }}" type="date" id="end_date" name="end_date" 
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary" required>
                        </div>
                    </div>

                    <!-- Anggaran -->
                    <div class="mb-6">
                        <label for="budget" class="block text-gray-700 font-medium mb-2">Anggaran (Rp)</label>
                        <input value="{{ old('budget', $program->budget) }}" type="number" id="budget" name="budget" 
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary" 
                               placeholder="Contoh: 500000000">
                        <p class="text-xs text-gray-500 mt-1">Kosongkan jika tidak ada anggaran</p>
                    </div>

                    <!-- Deskripsi -->
                    <div class="mb-6">
                        <label for="description" class="block text-gray-700 font-medium mb-2">Deskripsi Program</label>
                        <textarea id="description" name="description" rows="5" 
                                  class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary" 
                                  placeholder="Jelaskan detail program Anda" required>{{ old('description', $program->description) }}</textarea>
                    </div>

                    <!-- Upload Gambar -->
                    <div class="mb-6">
                        <label for="image" class="block text-gray-700 font-medium mb-2">Gambar Program</label>
                        
                        @if($program->image)
                        <div class="mb-4">
                            <p class="text-sm text-gray-600 mb-2">Gambar saat ini:</p>
                            <img src="{{ asset('storage/' . $program->image) }}" alt="{{ $program->title }}" 
                                 class="w-32 h-32 object-cover rounded-lg border border-gray-300">
                        </div>
                        @endif

                        <div class="border-2 border-dashed border-gray-300 rounded-lg p-4 text-center">
                            <i class="fas fa-cloud-upload-alt text-2xl text-gray-400 mb-2"></i>
                            <p class="text-gray-500 text-sm">Seret gambar atau <span class="text-blue-500 cursor-pointer">pilih file</span></p>
                            <input type="file" id="image" name="image" class="hidden" accept="image/*">
                            <p class="text-xs text-gray-400 mt-2">Format: JPG, PNG, GIF (Max: 2MB)</p>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex flex-col sm:flex-row justify-between items-center gap-4 pt-6 border-t border-gray-200">
                        <a href="{{ route('pemerintah.program') }}" 
                           class="w-full sm:w-auto px-6 py-2.5 bg-gray-300 text-gray-700 rounded-lg font-medium text-center hover:bg-gray-400 transition">
                            ← Kembali
                        </a>
                        <div class="flex gap-3 w-full sm:w-auto">
                            <a href="{{ route('pemerintah.program') }}" 
                               class="w-1/2 sm:w-auto px-6 py-2.5 bg-gray-500 text-white rounded-lg font-medium text-center hover:bg-gray-600 transition">
                                Batal
                            </a>
                            <button type="submit" 
                                    class="w-1/2 sm:w-auto px-6 py-2.5 bg-green-600 text-white rounded-lg font-medium hover:bg-green-700 transition">
                                💾 Update Program
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Progress bar update
    const progressInput = document.getElementById('progress');
    const progressBar = document.getElementById('progressBar');
    const progressValue = document.getElementById('progressValue');

    if (progressInput && progressBar && progressValue) {
        progressInput.addEventListener('input', function() {
            const value = this.value;
            progressBar.style.width = value + '%';
            progressValue.textContent = value + '%';
        });
    }

    // Image upload preview
    const imageInput = document.getElementById('image');
    const dropZone = document.querySelector('.border-dashed');

    if (imageInput && dropZone) {
        dropZone.addEventListener('click', () => imageInput.click());

        imageInput.addEventListener('change', function() {
            if (this.files.length > 0) {
                dropZone.querySelector('p').innerHTML = `<span class="text-green-500">${this.files[0].name}</span>`;
            }
        });

        // Drag and drop functionality
        dropZone.addEventListener('dragover', (e) => {
            e.preventDefault();
            dropZone.classList.add('border-blue-400', 'bg-blue-50');
        });

        dropZone.addEventListener('dragleave', () => {
            dropZone.classList.remove('border-blue-400', 'bg-blue-50');
        });

        dropZone.addEventListener('drop', (e) => {
            e.preventDefault();
            dropZone.classList.remove('border-blue-400', 'bg-blue-50');
            if (e.dataTransfer.files.length > 0) {
                imageInput.files = e.dataTransfer.files;
                dropZone.querySelector('p').innerHTML = `<span class="text-green-500">${imageInput.files[0].name}</span>`;
            }
        });
    }

    // Auto-set progress based on status
    const statusSelect = document.getElementById('status');
    if (statusSelect && progressInput) {
        statusSelect.addEventListener('change', function() {
            switch(this.value) {
                case 'planning':
                    progressInput.value = 0;
                    break;
                case 'ongoing':
                    if (progressInput.value < 10) progressInput.value = 25;
                    break;
                case 'completed':
                    progressInput.value = 100;
                    break;
            }
            // Trigger progress bar update
            progressInput.dispatchEvent(new Event('input'));
        });
    }
});
</script>
@endsection