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
    .select-category {
        border: 2px solid #e5e7eb;
        border-radius: 8px;
        padding: 1rem;
        transition: all 0.3s ease;
    }
    .select-category:focus {
        border-color: #3b82f6;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
    }
    .file-upload-area {
        border: 2px dashed #d1d5db;
        border-radius: 8px;
        padding: 2rem;
        text-align: center;
        transition: all 0.3s ease;
        cursor: pointer;
    }
    .file-upload-area:hover {
        border-color: #3b82f6;
        background-color: #f8fafc;
    }
    .file-upload-area.dragover {
        border-color: #3b82f6;
        background-color: #eff6ff;
    }
    .hidden {
        display: none;
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

        <form action="{{ route('kolaborasi.ide.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <!-- Step 1: Basic Information -->
            <div class="form-section">
                <h2 class="text-xl font-bold text-gray-800 mb-6">Informasi Dasar Ide</h2>
                
                <div class="space-y-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Judul Ide *</label>
                        <input type="text" name="judul" value="{{ old('judul') }}" 
                               placeholder="Contoh: Sistem Smart Parking Berbasis IoT" 
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('judul') border-red-500 @enderror" 
                               required>
                        @error('judul')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                        <p class="text-xs text-gray-500 mt-1">Buat judul yang jelas dan menarik (minimal 10 karakter)</p>
                    </div>

                    <!-- Kategori Section -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Kategori *</label>
                        <select name="category_id" required 
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('category_id') border-red-500 @enderror"
                                id="category-select">
                            <option value="">Pilih Kategori</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" 
                                        {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('category_id')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Subkategori Section -->
                    <div id="subcategory-container" class="hidden">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Subkategori (Opsional)</label>
                        <select name="subcategory_id" 
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('subcategory_id') border-red-500 @enderror"
                                id="subcategory-select">
                            <option value="">Pilih Subkategori</option>
                            <!-- Subkategori akan di-load via AJAX -->
                        </select>
                        @error('subcategory_id')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Deskripsi Singkat *</label>
                        <textarea name="deskripsi_singkat" rows="3" 
                                  placeholder="Jelaskan ide Anda secara singkat dan jelas..." 
                                  class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('deskripsi_singkat') border-red-500 @enderror" 
                                  required>{{ old('deskripsi_singkat') }}</textarea>
                        @error('deskripsi_singkat')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                        <div class="text-xs text-gray-500 mt-1 text-right">
                            <span id="char-count">0</span>/200 karakter
                        </div>
                    </div>
                </div>
            </div>

            <!-- Step 2: Detailed Information -->
            <div class="form-section">
                <h2 class="text-xl font-bold text-gray-800 mb-6">Detail Implementasi</h2>
                
                <div class="space-y-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Latar Belakang & Permasalahan</label>
                        <textarea name="latar_belakang" rows="4" 
                                  placeholder="Apa latar belakang dan permasalahan yang ingin diselesaikan?" 
                                  class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('latar_belakang') border-red-500 @enderror">{{ old('latar_belakang') }}</textarea>
                        @error('latar_belakang')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                        <p class="text-xs text-gray-500 mt-1">Jelaskan secara detail latar belakang dan masalah yang ingin diatasi</p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Solusi yang Diusulkan</label>
                        <textarea name="solusi" rows="4" 
                                  placeholder="Bagaimana ide Anda menyelesaikan permasalahan tersebut?" 
                                  class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('solusi') border-red-500 @enderror">{{ old('solusi') }}</textarea>
                        @error('solusi')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                        <p class="text-xs text-gray-500 mt-1">Jelaskan solusi yang Anda tawarkan secara spesifik</p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Estimasi Waktu</label>
                            <select name="estimasi_waktu" 
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('estimasi_waktu') border-red-500 @enderror">
                                <option value="">Pilih Estimasi</option>
                                <option value="1-3" {{ old('estimasi_waktu') == '1-3' ? 'selected' : '' }}>1-3 bulan</option>
                                <option value="3-6" {{ old('estimasi_waktu') == '3-6' ? 'selected' : '' }}>3-6 bulan</option>
                                <option value="6-12" {{ old('estimasi_waktu') == '6-12' ? 'selected' : '' }}>6-12 bulan</option>
                                <option value="12+" {{ old('estimasi_waktu') == '12+' ? 'selected' : '' }}>Lebih dari 1 tahun</option>
                            </select>
                            @error('estimasi_waktu')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Tingkat Kompleksitas</label>
                            <select name="kompleksitas" 
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('kompleksitas') border-red-500 @enderror">
                                <option value="">Pilih Tingkat</option>
                                <option value="low" {{ old('kompleksitas') == 'low' ? 'selected' : '' }}>Rendah</option>
                                <option value="medium" {{ old('kompleksitas') == 'medium' ? 'selected' : '' }}>Sedang</option>
                                <option value="high" {{ old('kompleksitas') == 'high' ? 'selected' : '' }}>Tinggi</option>
                            </select>
                            @error('kompleksitas')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Keahlian yang Dibutuhkan</label>
                        <div class="space-y-2 border border-gray-300 rounded-lg p-4 @error('keahlian') border-red-500 @enderror">
                            @foreach(['Programmer', 'Designer', 'Researcher', 'Business Analyst', 'Data Scientist', 'Hardware Engineer', 'Project Manager', 'Marketing Specialist'] as $skill)
                            <label class="flex items-center hover:bg-gray-50 p-2 rounded">
                                <input type="checkbox" name="keahlian[]" value="{{ $skill }}" 
                                       class="text-blue-600 focus:ring-blue-500 rounded"
                                       {{ is_array(old('keahlian')) && in_array($skill, old('keahlian')) ? 'checked' : '' }}>
                                <span class="ml-3 text-sm text-gray-700">{{ $skill }}</span>
                            </label>
                            @endforeach
                        </div>
                        @error('keahlian')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                        <p class="text-xs text-gray-500 mt-1">Pilih keahlian yang diperlukan untuk mewujudkan ide ini</p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Partner yang Diinginkan</label>
                        <div class="space-y-2 border border-gray-300 rounded-lg p-4 @error('partner') border-red-500 @enderror">
                            <label class="flex items-center hover:bg-gray-50 p-2 rounded">
                                <input type="checkbox" name="partner[]" value="pemerintah" 
                                       class="text-blue-600 focus:ring-blue-500 rounded"
                                       {{ is_array(old('partner')) && in_array('pemerintah', old('partner')) ? 'checked' : 'checked' }}>
                                <span class="ml-3 text-sm text-gray-700">Pemerintah/OPD</span>
                            </label>
                            <label class="flex items-center hover:bg-gray-50 p-2 rounded">
                                <input type="checkbox" name="partner[]" value="akademisi" 
                                       class="text-blue-600 focus:ring-blue-500 rounded"
                                       {{ is_array(old('partner')) && in_array('akademisi', old('partner')) ? 'checked' : 'checked' }}>
                                <span class="ml-3 text-sm text-gray-700">Akademisi/Peneliti</span>
                            </label>
                            <label class="flex items-center hover:bg-gray-50 p-2 rounded">
                                <input type="checkbox" name="partner[]" value="umkm" 
                                       class="text-blue-600 focus:ring-blue-500 rounded"
                                       {{ is_array(old('partner')) && in_array('umkm', old('partner')) ? 'checked' : '' }}>
                                <span class="ml-3 text-sm text-gray-700">UMKM/Bisnis</span>
                            </label>
                            <label class="flex items-center hover:bg-gray-50 p-2 rounded">
                                <input type="checkbox" name="partner[]" value="komunitas" 
                                       class="text-blue-600 focus:ring-blue-500 rounded"
                                       {{ is_array(old('partner')) && in_array('komunitas', old('partner')) ? 'checked' : '' }}>
                                <span class="ml-3 text-sm text-gray-700">Komunitas</span>
                            </label>
                            <label class="flex items-center hover:bg-gray-50 p-2 rounded">
                                <input type="checkbox" name="partner[]" value="swasta" 
                                       class="text-blue-600 focus:ring-blue-500 rounded"
                                       {{ is_array(old('partner')) && in_array('swasta', old('partner')) ? 'checked' : '' }}>
                                <span class="ml-3 text-sm text-gray-700">Perusahaan Swasta</span>
                            </label>
                        </div>
                        @error('partner')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                        <p class="text-xs text-gray-500 mt-1">Pilih jenis partner yang ingin diajak berkolaborasi</p>
                    </div>
                </div>
            </div>

            <!-- Step 3: Additional Information -->
            <div class="form-section">
                <h2 class="text-xl font-bold text-gray-800 mb-6">Informasi Tambahan</h2>
                
                <div class="space-y-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Dampak yang Diharapkan</label>
                        <textarea name="dampak" rows="3" 
                                  placeholder="Apa dampak positif yang diharapkan dari implementasi ide ini?" 
                                  class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('dampak') border-red-500 @enderror">{{ old('dampak') }}</textarea>
                        @error('dampak')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                        <p class="text-xs text-gray-500 mt-1">Jelaskan manfaat dan dampak positif dari implementasi ide</p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Upload Dokumen Pendukung (Opsional)</label>
                        <div class="file-upload-area" id="file-upload-area">
                            <i class="fas fa-cloud-upload-alt text-3xl text-gray-400 mb-3"></i>
                            <p class="text-sm text-gray-600 mb-2">Drag & drop file atau klik untuk upload</p>
                            <p class="text-xs text-gray-500">PDF, DOC, DOCX, PPT, PPTX (Maks. 10MB)</p>
                            <input type="file" name="dokumen" class="hidden" id="file-input" accept=".pdf,.doc,.docx,.ppt,.pptx">
                            <button type="button" onclick="document.getElementById('file-input').click()" 
                                    class="mt-3 bg-gray-100 hover:bg-gray-200 text-gray-700 px-4 py-2 rounded-lg text-sm font-medium transition-colors">
                                Pilih File
                            </button>
                        </div>
                        <div id="file-info" class="mt-2 hidden">
                            <p class="text-sm text-green-600 flex items-center">
                                <i class="fas fa-check-circle mr-2"></i>
                                <span id="file-name"></span>
                            </p>
                        </div>
                        @error('dokumen')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="border-t pt-4">
                        <label class="flex items-start">
                            <input type="checkbox" name="agree_terms" value="1" 
                                   class="mt-1 text-blue-600 focus:ring-blue-500 rounded @error('agree_terms') border-red-500 @enderror"
                                   {{ old('agree_terms') ? 'checked' : '' }} required>
                            <span class="ml-3 text-sm text-gray-700">
                                Saya setuju dengan <a href="#" class="text-blue-600 hover:text-blue-800 underline">syarat dan ketentuan</a> 
                                serta menyatakan bahwa ide ini adalah original dan belum pernah diajukan sebelumnya.
                            </span>
                        </label>
                        @error('agree_terms')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex justify-between pt-6">
                <a href="{{ route('kolaborasi.index') }}" 
                   class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-8 py-3 rounded-lg font-semibold transition-colors flex items-center">
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
document.addEventListener('DOMContentLoaded', function() {
    // Category and Subcategory handling
    const categorySelect = document.getElementById('category-select');
    const subcategoryContainer = document.getElementById('subcategory-container');
    const subcategorySelect = document.getElementById('subcategory-select');

    if (categorySelect) {
        categorySelect.addEventListener('change', function() {
            const categoryId = this.value;
            
            // Reset subcategory
            subcategorySelect.innerHTML = '<option value="">Pilih Subkategori</option>';
            
            if (categoryId) {
                // Show subcategory container
                subcategoryContainer.classList.remove('hidden');
                
                // Show loading state
                const loadingOption = document.createElement('option');
                loadingOption.value = '';
                loadingOption.textContent = 'Memuat subkategori...';
                loadingOption.disabled = true;
                subcategorySelect.appendChild(loadingOption);
                
                // Load subcategories via AJAX
                fetch(`/api/categories/${categoryId}/subcategories`, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    subcategorySelect.innerHTML = '<option value="">Pilih Subkategori</option>';
                    data.forEach(subcategory => {
                        const option = document.createElement('option');
                        option.value = subcategory.id;
                        option.textContent = subcategory.name;
                        
                        // Preselect if this was previously selected
                        const oldSubcategoryId = '{{ old("subcategory_id") }}';
                        if (oldSubcategoryId && oldSubcategoryId == subcategory.id) {
                            option.selected = true;
                        }
                        
                        subcategorySelect.appendChild(option);
                    });
                })
                .catch(error => {
                    console.error('Error loading subcategories:', error);
                    subcategorySelect.innerHTML = '<option value="">Error loading subcategories</option>';
                });
            } else {
                // Hide subcategory container if no category selected
                subcategoryContainer.classList.add('hidden');
            }
        });

        // Trigger change event on page load if category is pre-selected (for old input)
        const oldCategoryId = '{{ old("category_id") }}';
        if (oldCategoryId) {
            categorySelect.value = oldCategoryId;
            categorySelect.dispatchEvent(new Event('change'));
        }
    }

    // Character counter for description
    const descTextarea = document.querySelector('textarea[name="deskripsi_singkat"]');
    const charCounter = document.getElementById('char-count');

    if (descTextarea && charCounter) {
        // Set initial count
        charCounter.textContent = descTextarea.value.length;
        
        descTextarea.addEventListener('input', function() {
            const count = this.value.length;
            charCounter.textContent = count;
            
            if (count > 200) {
                charCounter.classList.add('text-red-500');
                charCounter.classList.remove('text-gray-500');
            } else {
                charCounter.classList.remove('text-red-500');
                charCounter.classList.add('text-gray-500');
            }
        });
    }

    // File upload handling
    const fileInput = document.getElementById('file-input');
    const fileUploadArea = document.getElementById('file-upload-area');
    const fileInfo = document.getElementById('file-info');
    const fileName = document.getElementById('file-name');

    if (fileInput && fileUploadArea) {
        // Click on area to trigger file input
        fileUploadArea.addEventListener('click', function(e) {
            if (e.target.tagName !== 'INPUT' && e.target.tagName !== 'BUTTON') {
                fileInput.click();
            }
        });

        // Drag and drop functionality
        ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
            fileUploadArea.addEventListener(eventName, preventDefaults, false);
        });

        function preventDefaults(e) {
            e.preventDefault();
            e.stopPropagation();
        }

        ['dragenter', 'dragover'].forEach(eventName => {
            fileUploadArea.addEventListener(eventName, highlight, false);
        });

        ['dragleave', 'drop'].forEach(eventName => {
            fileUploadArea.addEventListener(eventName, unhighlight, false);
        });

        function highlight() {
            fileUploadArea.classList.add('dragover');
        }

        function unhighlight() {
            fileUploadArea.classList.remove('dragover');
        }

        fileUploadArea.addEventListener('drop', handleDrop, false);

        function handleDrop(e) {
            const dt = e.dataTransfer;
            const files = dt.files;
            fileInput.files = files;
            handleFiles(files);
        }

        fileInput.addEventListener('change', function() {
            handleFiles(this.files);
        });

        function handleFiles(files) {
            if (files.length > 0) {
                const file = files[0];
                // Validate file type
                const allowedTypes = ['application/pdf', 'application/msword', 
                                    'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                                    'application/vnd.ms-powerpoint', 
                                    'application/vnd.openxmlformats-officedocument.presentationml.presentation'];
                
                // Validate file size (10MB)
                const maxSize = 10 * 1024 * 1024;
                
                if (!allowedTypes.includes(file.type)) {
                    alert('Format file tidak didukung. Harap upload file PDF, DOC, DOCX, PPT, atau PPTX.');
                    fileInput.value = '';
                    return;
                }
                
                if (file.size > maxSize) {
                    alert('Ukuran file terlalu besar. Maksimal 10MB.');
                    fileInput.value = '';
                    return;
                }
                
                fileName.textContent = file.name;
                fileInfo.classList.remove('hidden');
                fileUploadArea.classList.add('hidden');
            }
        }

        // Remove file functionality
        fileInfo.addEventListener('click', function() {
            fileInput.value = '';
            fileInfo.classList.add('hidden');
            fileUploadArea.classList.remove('hidden');
        });
    }

    // Form validation before submit
    const form = document.querySelector('form');
    if (form) {
        form.addEventListener('submit', function(e) {
            const categoryId = document.getElementById('category-select').value;
            if (!categoryId) {
                e.preventDefault();
                alert('Harap pilih kategori terlebih dahulu.');
                document.getElementById('category-select').focus();
                return;
            }

            const agreeTerms = document.querySelector('input[name="agree_terms"]');
            if (!agreeTerms.checked) {
                e.preventDefault();
                alert('Harap setujui syarat dan ketentuan terlebih dahulu.');
                agreeTerms.focus();
                return;
            }
        });
    }
});
</script>
@endsection