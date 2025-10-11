@extends('layouts.app')

@section('title', 'Posting Inovasi Baru')

@section('content')
<div class="min-h-screen py-12 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col lg:flex-row gap-8">

            <!-- FORM UTAMA -->
            <div class="w-full lg:w-7/12">
                <div class="bg-white rounded-2xl shadow-md p-6 lg:p-8">

                    <div class="text-center mb-10">
                        <h1 class="text-3xl font-bold text-gray-800 mb-2">Posting Inovasi Baru</h1>
                        <p class="text-gray-600">Isi langkah demi langkah untuk memposting inovasi Anda</p>
                    </div>

                    <!-- ALERTS -->
                    @if($errors->any())
                        <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-lg text-red-600">
                            <ul class="list-disc list-inside">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    @if(session('success'))
                        <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-lg text-green-700">
                            {{ session('success') }}
                        </div>
                    @endif

                    <!-- STEP INDICATOR -->
                    <div class="mb-8 relative">
                        <div class="flex justify-between items-center relative">
                            @php
                                $steps = [
                                    ['label'=>'Informasi Dasar','icon'=>'fas fa-info-circle'],
                                    ['label'=>'Detail Inovasi','icon'=>'fas fa-clipboard-list'],
                                    ['label'=>'Upload & Kontak','icon'=>'fas fa-upload'],
                                    ['label'=>'Review','icon'=>'fas fa-check-circle'],
                                ];
                            @endphp
                            @foreach($steps as $i => $step)
                                <div class="flex flex-col items-center step" data-step="{{ $i+1 }}">
                                    <div class="w-10 h-10 rounded-full flex items-center justify-center bg-gray-200 text-gray-700 border-2 border-transparent step-number transition">
                                        <i class="{{ $step['icon'] }}"></i>
                                    </div>
                                    <div class="text-xs text-gray-500 mt-2 text-center step-label">{{ $step['label'] }}</div>
                                </div>
                            @endforeach
                        </div>
                        <div class="absolute top-5 left-0 right-0 h-1 bg-gray-200 rounded">
                            <div id="progressFill" class="h-1 bg-blue-500 rounded w-1/4 transition-all"></div>
                        </div>
                    </div>

                    <!-- FORM WIZARD -->
                    <form id="innovationForm" action="{{ route('akademisi.inovasi.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <!-- STEP 1 -->
                        <div class="step-section" data-step="1">
                            <h2 class="font-semibold text-lg mb-4">Informasi Dasar</h2>
                            <div class="space-y-4">

                                <div>
                                    <label class="block font-medium mb-1">Judul Inovasi *</label>
                                    <input type="text" name="title" required class="w-full border rounded-lg px-4 py-2">
                                    <p class="text-sm text-red-500 hidden">Wajib diisi</p>
                                </div>

                                <div>
                                    <label class="block font-medium mb-1">Kategori *</label>
                                    <select name="category" id="category" required class="w-full border rounded-lg px-4 py-2">
                                        <option value="">Pilih Kategori</option>
                                        @foreach($categories as $cat)
                                            <option value="{{ $cat }}">{{ $cat }}</option>
                                        @endforeach
                                    </select>
                                    <p class="text-sm text-red-500 hidden">Wajib diisi</p>
                                </div>

                                <div>
                                    <label class="block font-medium mb-1">Subkategori *</label>
                                    <select name="subcategory" id="subcategory" required disabled class="w-full border rounded-lg px-4 py-2 bg-gray-50">
                                        <option value="">Pilih kategori terlebih dahulu</option>
                                    </select>
                                    <p class="text-sm text-red-500 hidden">Wajib diisi</p>
                                </div>

                                <div>
                                    <label class="block font-medium mb-1">Nama Penulis</label>
                                    <input type="text" name="author_name" value="{{ auth()->user()->name ?? '' }}" class="w-full border rounded-lg px-4 py-2" readonly>
                                </div>

                                <div>
                                    <label class="block font-medium mb-1">Institusi / Organisasi</label>
                                    <input type="text" name="institution" value="{{ auth()->user()->institution_name ?? '' }}" class="w-full border rounded-lg px-4 py-2" readonly>
                                </div>
                            </div>

                            <div class="flex justify-end mt-6">
                                <button type="button" class="btn-primary" onclick="validateStep(1)">Selanjutnya</button>
                            </div>
                        </div>

                        <!-- STEP 2 -->
                        <div class="step-section hidden" data-step="2">
                            <h2 class="font-semibold text-lg mb-4">Detail Inovasi</h2>
                            <div class="space-y-4">

                                <div>
                                    <label class="block font-medium mb-1">Kata Kunci *</label>
                                    <input type="text" name="keywords" required class="w-full border rounded-lg px-4 py-2">
                                    <p class="text-sm text-red-500 hidden">Wajib diisi</p>
                                </div>

                                <div>
                                    <label class="block font-medium mb-1">Deskripsi *</label>
                                    <textarea name="description" rows="4" required class="w-full border rounded-lg px-4 py-2"></textarea>
                                    <p class="text-sm text-red-500 hidden">Wajib diisi</p>
                                </div>

                                <div>
                                    <label class="block font-medium mb-1">Tujuan Inovasi *</label>
                                    <textarea name="purpose" rows="3" required class="w-full border rounded-lg px-4 py-2"></textarea>
                                    <p class="text-sm text-red-500 hidden">Wajib diisi</p>
                                </div>

                                <div>
                                    <label class="block font-medium mb-1">Technology Readiness Level (TRL)</label>
                                    <div class="flex items-center gap-4">
                                        <input type="range" id="technology_readiness_level" name="technology_readiness_level" min="1" max="9" value="1" class="flex-1">
                                        <span id="trlValue" class="font-bold text-blue-600">1</span>
                                    </div>
                                </div>

                            </div>

                            <div class="flex justify-between mt-6">
                                <button type="button" class="btn-outline" onclick="goToStep(1)">Sebelumnya</button>
                                <button type="button" class="btn-primary" onclick="validateStep(2)">Selanjutnya</button>
                            </div>
                        </div>

                        <!-- STEP 3 -->
                        <div class="step-section hidden" data-step="3">
                            <h2 class="font-semibold text-lg mb-4">Upload & Kontak</h2>
                            <div class="space-y-4">

                                <div>
                                    <label class="block font-medium mb-1">Gambar Inovasi *</label>
                                    <input type="file" name="image_path" required accept=".jpg,.jpeg,.png" class="w-full border rounded-lg px-4 py-2">
                                    <p class="text-sm text-red-500 hidden">Wajib diisi</p>
                                </div>

                                <div>
                                    <label class="block font-medium mb-1">Dokumen Pendukung *</label>
                                    <input type="file" name="document_path" required accept=".pdf" class="w-full border rounded-lg px-4 py-2">
                                    <p class="text-sm text-red-500 hidden">Wajib diisi</p>
                                </div>

                                <div>
                                    <label class="block font-medium mb-1">Video (Opsional)</label>
                                    <input type="url" name="video_url" placeholder="Link video YouTube" class="w-full border rounded-lg px-4 py-2">
                                </div>

                                <div>
                                    <label class="block font-medium mb-1">Kontak *</label>
                                    <input type="text" name="contact" required class="w-full border rounded-lg px-4 py-2">
                                    <p class="text-sm text-red-500 hidden">Wajib diisi</p>
                                </div>

                            </div>

                            <div class="flex justify-between mt-6">
                                <button type="button" class="btn-outline" onclick="goToStep(2)">Sebelumnya</button>
                                <button type="button" class="btn-primary" onclick="validateStep(3)">Selanjutnya</button>
                            </div>
                        </div>

                        <!-- STEP 4 -->
                        <div class="step-section hidden" data-step="4">
                            <h2 class="font-semibold text-lg mb-4">Review & Submit</h2>
                            <div class="bg-gray-50 p-4 rounded space-y-2 mb-4">
                                <p><strong>Judul:</strong> <span id="reviewTitle">-</span></p>
                                <p><strong>Kategori:</strong> <span id="reviewCategory">-</span></p>
                                <p><strong>Penulis:</strong> <span id="reviewAuthor">-</span></p>
                                <p><strong>Institusi:</strong> <span id="reviewInstitution">-</span></p>
                                <p><strong>Kata Kunci:</strong> <span id="reviewKeywords">-</span></p>
                                <p><strong>TRL:</strong> <span id="reviewTRL">-</span></p>
                                <p><strong>Kontak:</strong> <span id="reviewContact">-</span></p>
                            </div>

                            <div class="flex justify-between mt-6">
                                <button type="button" class="btn-outline" onclick="goToStep(3)">Sebelumnya</button>
                                <button type="submit" class="btn-primary">Posting Inovasi</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- SIDEBAR -->
            <div class="w-full lg:w-5/12">
                <div class="bg-white rounded-2xl shadow-md p-6 sticky top-4">
                    <h2 class="font-bold text-xl mb-4">Inovasi Saya</h2>
                    @forelse($yearlyInnovations as $year => $items)
                        <h3 class="font-semibold text-gray-700 mt-4 mb-2 border-b pb-1">{{ $year }}</h3>
                        @foreach($items as $item)
                            <a href="{{ route('akademisi.inovasi.show', $item->id) }}" class="block mb-3 p-3 border rounded hover:border-blue-500 transition">
                                <h3 class="font-semibold">{{ $item->title }}</h3>
                                <p class="text-sm text-gray-500">{{ $item->category }}</p>
                            </a>
                        @endforeach
                    @empty
                        <p class="text-gray-400 text-sm">Belum ada inovasi.</p>
                    @endforelse
                </div>
            </div>

        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
let currentStep = 1;
const totalSteps = 4;

function goToStep(step) {
    document.querySelector(`.step-section[data-step="${currentStep}"]`).classList.add('hidden');
    document.querySelector(`.step-section[data-step="${step}"]`).classList.remove('hidden');
    currentStep = step;
    updateProgress();
    if(step === 4) populateReview();
    window.scrollTo({ top: 0, behavior: 'smooth' });
}

function updateProgress() {
    document.getElementById('progressFill').style.width = `${(currentStep/totalSteps)*100}%`;
}

// VALIDATION PER STEP
function validateStep(step) {
    const section = document.querySelector(`.step-section[data-step="${step}"]`);
    const inputs = section.querySelectorAll('[required]');
    let valid = true;

    inputs.forEach(input => {
        const warning = input.nextElementSibling;
        if (input.value.trim() === '') {
            input.classList.add('border-red-500');
            if (warning) warning.classList.remove('hidden');
            valid = false;
        } else {
            input.classList.remove('border-red-500');
            if (warning) warning.classList.add('hidden');
        }
    });

    if (valid) goToStep(step + 1);
}

// Populate review
function populateReview() {
    document.getElementById('reviewTitle').textContent = document.querySelector('[name="title"]').value;
    document.getElementById('reviewCategory').textContent = document.querySelector('[name="category"]').value;
    document.getElementById('reviewAuthor').textContent = document.querySelector('[name="author_name"]').value;
    document.getElementById('reviewInstitution').textContent = document.querySelector('[name="institution"]').value;
    document.getElementById('reviewKeywords').textContent = document.querySelector('[name="keywords"]').value;
    document.getElementById('reviewTRL').textContent = document.getElementById('technology_readiness_level').value;
    document.getElementById('reviewContact').textContent = document.querySelector('[name="contact"]').value;
}

// TRL live update
document.getElementById('technology_readiness_level').addEventListener('input', function(){
    document.getElementById('trlValue').textContent = this.value;
});

// Dynamic Subcategory
document.getElementById('category').addEventListener('change', function(){
    const sub = document.getElementById('subcategory');
    sub.disabled = true;
    sub.innerHTML = '<option>Memuat...</option>';

    fetch(`{{ route('akademisi.inovasi.subcategories') }}?category=${encodeURIComponent(this.value)}`)
        .then(res => {
            if(!res.ok) throw new Error('HTTP error ' + res.status);
            return res.json();
        })
        .then(data=>{
            sub.innerHTML = '<option value="">Pilih Subkategori</option>';
            if(Array.isArray(data) && data.length > 0){
                data.forEach(s=>{
                    const opt = document.createElement('option');
                    opt.value = s;
                    opt.textContent = s;
                    sub.appendChild(opt);
                });
            } else {
                sub.innerHTML = '<option value="">Tidak ada subkategori</option>';
            }
            sub.disabled = false;
        })
        .catch(err=>{
            console.error(err);
            sub.innerHTML = '<option value="">Gagal memuat</option>';
            sub.disabled = true;
        });
});

updateProgress();
</script>
@endpush
