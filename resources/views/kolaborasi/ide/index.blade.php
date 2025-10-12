@extends('layouts.app')

@section('title', 'Ajukan Ide Kolaborasi')

@section('styles')
<style>
    .form-section {
        background: white;
        border-radius: 12px;
        padding: 2rem;
        margin-bottom: 2rem;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
    }
    .step-indicator {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
        font-size: 0.875rem;
    }
    .step-active {
        background: #3b82f6;
        color: white;
    }
    .step-inactive {
        background: #e5e7eb;
        color: #6b7280;
    }
    .step-completed {
        background: #10b981;
        color: white;
    }
    .category-card {
        border: 2px solid #e5e7eb;
        border-radius: 8px;
        padding: 1.5rem;
        cursor: pointer;
        transition: all 0.3s ease;
    }
    .category-card:hover {
        border-color: #3b82f6;
        transform: translateY(-2px);
    }
    .category-card.selected {
        border-color: #3b82f6;
        background: #eff6ff;
    }
</style>
@endsection

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="container mx-auto px-4 max-w-4xl">
        <!-- Header -->
        <div class="mb-8 text-center">
            <h1 class="text-3xl font-bold text-gray-800 mb-2">Ajukan Ide Kolaborasi</h1>
            <p class="text-gray-600">Bagikan ide inovatif Anda dan temukan partner untuk mewujudkannya</p>
        </div>

        <!-- Progress Steps -->
        <div class="mb-8">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-4">
                    <div class="step-indicator step-active">1</div>
                    <div class="text-sm font-medium text-blue-600">Informasi Dasar</div>
                </div>
                <div class="flex-1 h-1 bg-gray-200 mx-4"></div>
                <div class="flex items-center gap-4">
                    <div class="step-indicator step-inactive">2</div>
                    <div class="text-sm font-medium text-gray-500">Detail Ide</div>
                </div>
                <div class="flex-1 h-1 bg-gray-200 mx-4"></div>
                <div class="flex items-center gap-4">
                    <div class="step-indicator step-inactive">3</div>
                    <div class="text-sm font-medium text-gray-500">Review</div>
                </div>
            </div>
        </div>

        <form action="{{ route('kolaborasi.ide.store') }}" method="POST" class="space-y-6">
            @csrf

            <!-- Step 1: Basic Information -->
            <div class="form-section">
                <h2 class="text-xl font-bold text-gray-800 mb-6">Informasi Dasar Ide</h2>
                
                <div class="space-y-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Judul Ide *</label>
                        <input type="text" name="judul" placeholder="Contoh: Sistem Smart Parking Berbasis IoT" 
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" required>
                        <p class="text-xs text-gray-500 mt-1">Buat judul yang jelas dan menarik</p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Kategori *</label>
                        <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                            <label class="category-card">
                                <input type="radio" name="kategori" value="teknologi" class="hidden">
                                <div class="text-center">
                                    <i class="fas fa-microchip text-2xl text-blue-600 mb-2"></i>
                                    <p class="font-medium text-gray-800">Teknologi</p>
                                    <p class="text-xs text-gray-500 mt-1">IoT, AI, Software</p>
                                </div>
                            </label>
                            
                            <label class="category-card">
                                <input type="radio" name="kategori" value="lingkungan" class="hidden">
                                <div class="text-center">
                                    <i class="fas fa-leaf text-2xl text-green-600 mb-2"></i>
                                    <p class="font-medium text-gray-800">Lingkungan</p>
                                    <p class="text-xs text-gray-500 mt-1">Konservasi, Energi</p>
                                </div>
                            </label>
                            
                            <label class="category-card">
                                <input type="radio" name="kategori" value="ekonomi" class="hidden">
                                <div class="text-center">
                                    <i class="fas fa-chart-line text-2xl text-yellow-600 mb-2"></i>
                                    <p class="font-medium text-gray-800">Ekonomi</p>
                                    <p class="text-xs text-gray-500 mt-1">UMKM, Investasi</p>
                                </div>
                            </label>
                            
                            <label class="category-card">
                                <input type="radio" name="kategori" value="kesehatan" class="hidden">
                                <div class="text-center">
                                    <i class="fas fa-heartbeat text-2xl text-red-600 mb-2"></i>
                                    <p class="font-medium text-gray-800">Kesehatan</p>
                                    <p class="text-xs text-gray-500 mt-1">Medis, Kesehatan</p>
                                </div>
                            </label>
                            
                            <label class="category-card">
                                <input type="radio" name="kategori" value="pendidikan" class="hidden">
                                <div class="text-center">
                                    <i class="fas fa-graduation-cap text-2xl text-purple-600 mb-2"></i>
                                    <p class="font-medium text-gray-800">Pendidikan</p>
                                    <p class="text-xs text-gray-500 mt-1">E-learning, Edukasi</p>
                                </div>
                            </label>
                            
                            <label class="category-card">
                                <input type="radio" name="kategori" value="smart-city" class="hidden">
                                <div class="text-center">
                                    <i class="fas fa-city text-2xl text-indigo-600 mb-2"></i>
                                    <p class="font-medium text-gray-800">Smart City</p>
                                    <p class="text-xs text-gray-500 mt-1">Transportasi, Layanan</p>
                                </div>
                            </label>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Deskripsi Singkat *</label>
                        <textarea name="deskripsi_singkat" rows="3" placeholder="Jelaskan ide Anda secara singkat dan jelas..." 
                                  class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" required></textarea>
                        <p class="text-xs text-gray-500 mt-1">Maksimal 200 karakter</p>
                    </div>
                </div>
            </div>

            <!-- Step 2: Detailed Information -->
            <div class="form-section">
                <h2 class="text-xl font-bold text-gray-800 mb-6">Detail Implementasi</h2>
                
                <div class="space-y-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Latar Belakang & Permasalahan</label>
                        <textarea name="latar_belakang" rows="4" placeholder="Apa latar belakang dan permasalahan yang ingin diselesaikan?" 
                                  class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"></textarea>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Solusi yang Diusulkan</label>
                        <textarea name="solusi" rows="4" placeholder="Bagaimana ide Anda menyelesaikan permasalahan tersebut?" 
                                  class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"></textarea>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Estimasi Waktu</label>
                            <select name="estimasi_waktu" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                <option value="">Pilih Estimasi</option>
                                <option value="1-3">1-3 bulan</option>
                                <option value="3-6">3-6 bulan</option>
                                <option value="6-12">6-12 bulan</option>
                                <option value="12+">Lebih dari 1 tahun</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Tingkat Kompleksitas</label>
                            <select name="kompleksitas" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                <option value="">Pilih Tingkat</option>
                                <option value="low">Rendah</option>
                                <option value="medium">Sedang</option>
                                <option value="high">Tinggi</option>
                            </select>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Keahlian yang Dibutuhkan</label>
                        <div class="space-y-2">
                            @foreach(['Programmer', 'Designer', 'Researcher', 'Business Analyst', 'Data Scientist', 'Hardware Engineer'] as $skill)
                            <label class="flex items-center">
                                <input type="checkbox" name="keahlian[]" value="{{ $skill }}" class="text-blue-600 focus:ring-blue-500">
                                <span class="ml-3 text-sm text-gray-700">{{ $skill }}</span>
                            </label>
                            @endforeach
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Partner yang Diinginkan</label>
                        <div class="space-y-2">
                            <label class="flex items-center">
                                <input type="checkbox" name="partner[]" value="pemerintah" class="text-blue-600 focus:ring-blue-500" checked>
                                <span class="ml-3 text-sm text-gray-700">Pemerintah/OPD</span>
                            </label>
                            <label class="flex items-center">
                                <input type="checkbox" name="partner[]" value="akademisi" class="text-blue-600 focus:ring-blue-500" checked>
                                <span class="ml-3 text-sm text-gray-700">Akademisi/Peneliti</span>
                            </label>
                            <label class="flex items-center">
                                <input type="checkbox" name="partner[]" value="umkm" class="text-blue-600 focus:ring-blue-500">
                                <span class="ml-3 text-sm text-gray-700">UMKM/Bisnis</span>
                            </label>
                            <label class="flex items-center">
                                <input type="checkbox" name="partner[]" value="komunitas" class="text-blue-600 focus:ring-blue-500">
                                <span class="ml-3 text-sm text-gray-700">Komunitas</span>
                            </label>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Step 3: Additional Information -->
            <div class="form-section">
                <h2 class="text-xl font-bold text-gray-800 mb-6">Informasi Tambahan</h2>
                
                <div class="space-y-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Dampak yang Diharapkan</label>
                        <textarea name="dampak" rows="3" placeholder="Apa dampak positif yang diharapkan dari implementasi ide ini?" 
                                  class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"></textarea>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Upload Dokumen Pendukung (Opsional)</label>
                        <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center">
                            <i class="fas fa-cloud-upload-alt text-3xl text-gray-400 mb-3"></i>
                            <p class="text-sm text-gray-600 mb-2">Drag & drop file atau klik untuk upload</p>
                            <p class="text-xs text-gray-500">PDF, DOC, PPT (Maks. 10MB)</p>
                            <input type="file" name="dokumen" class="hidden" id="file-upload">
                            <button type="button" onclick="document.getElementById('file-upload').click()" 
                                    class="mt-3 bg-gray-100 hover:bg-gray-200 text-gray-700 px-4 py-2 rounded-lg text-sm font-medium">
                                Pilih File
                            </button>
                        </div>
                    </div>

                    <div>
                        <label class="flex items-center">
                            <input type="checkbox" name="agree_terms" class="text-blue-600 focus:ring-blue-500" required>
                            <span class="ml-3 text-sm text-gray-700">
                                Saya setuju dengan <a href="#" class="text-blue-600 hover:text-blue-800">syarat dan ketentuan</a> 
                                serta menyatakan bahwa ide ini adalah original
                            </span>
                        </label>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex justify-between pt-6">
                <a href="{{ route('kolaborasi.index') }}" 
                   class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-8 py-3 rounded-lg font-semibold transition-colors">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Kembali
                </a>
                <button type="submit" 
                        class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-3 rounded-lg font-semibold transition-colors flex items-center gap-2">
                    <i class="fas fa-paper-plane"></i>
                    Ajukan Ide
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
// Category card selection
document.querySelectorAll('.category-card').forEach(card => {
    card.addEventListener('click', function() {
        // Remove selected class from all cards
        document.querySelectorAll('.category-card').forEach(c => {
            c.classList.remove('selected');
        });
        
        // Add selected class to clicked card
        this.classList.add('selected');
        
        // Check the radio input
        const radio = this.querySelector('input[type="radio"]');
        radio.checked = true;
    });
});

// Character counter for description
const descTextarea = document.querySelector('textarea[name="deskripsi_singkat"]');
const charCounter = document.createElement('div');
charCounter.className = 'text-xs text-gray-500 mt-1 text-right';
descTextarea.parentNode.appendChild(charCounter);

descTextarea.addEventListener('input', function() {
    const count = this.value.length;
    charCounter.textContent = `${count}/200 karakter`;
    
    if (count > 200) {
        charCounter.classList.add('text-red-500');
    } else {
        charCounter.classList.remove('text-red-500');
    }
});
</script>
@endsection