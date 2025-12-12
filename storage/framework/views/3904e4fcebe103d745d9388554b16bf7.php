<?php $__env->startSection('title', 'Posting Inovasi Baru'); ?>

<?php $__env->startSection('content'); ?>
<div class="min-h-screen py-12 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col lg:flex-row gap-8">

            <!-- FORM UTAMA -->
            <div class="w-full lg:w-7/12">
                <div class="bg-white rounded-2xl shadow-lg p-6 lg:p-8 hover:shadow-xl transition-shadow">

                    <div class="text-center mb-10">
                        <h1 class="text-3xl font-bold text-gray-800 mb-2">Posting Inovasi Baru</h1>
                        <p class="text-gray-600">Isi langkah demi langkah untuk memposting inovasi Anda</p>
                    </div>

                    <!-- ALERTS -->
                    <?php if($errors->any()): ?>
                        <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-lg text-red-600">
                            <ul class="list-disc list-inside">
                                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <li><?php echo e($error); ?></li>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </ul>
                        </div>
                    <?php endif; ?>
                    <?php if(session('success')): ?>
                        <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-lg text-green-700">
                            <?php echo e(session('success')); ?>

                        </div>
                    <?php endif; ?>

                    <!-- STEP INDICATOR -->
                    <div class="mb-8 relative">
                        <div class="flex justify-between items-center relative z-10">
                            <?php
                                $steps = [
                                    ['label'=>'Informasi Dasar','icon'=>'fas fa-info-circle'],
                                    ['label'=>'Detail Inovasi','icon'=>'fas fa-clipboard-list'],
                                    ['label'=>'Upload & Kontak','icon'=>'fas fa-upload'],
                                    ['label'=>'Review','icon'=>'fas fa-check-circle'],
                                ];
                            ?>
                            <?php $__currentLoopData = $steps; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $step): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="flex flex-col items-center step" data-step="<?php echo e($i+1); ?>">
                                    <div class="w-10 h-10 rounded-full flex items-center justify-center bg-gray-200 text-gray-700 border-2 border-blue-500 step-number transition-shadow shadow">
                                        <i class="<?php echo e($step['icon']); ?>"></i>
                                    </div>
                                    <div class="text-xs text-gray-500 mt-2 text-center step-label"><?php echo e($step['label']); ?></div>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                        <div class="absolute top-5 left-0 right-0 h-1 bg-gray-300 rounded z-0">
                            <div id="progressFill" class="h-1 bg-blue-500 rounded w-1/4 transition-all"></div>
                        </div>
                    </div>

                    <!-- FORM WIZARD -->
                    <form id="innovationForm" action="<?php echo e(route('akademisi.inovasi.store')); ?>" method="POST" enctype="multipart/form-data">
                        <?php echo csrf_field(); ?>

                        <input type="hidden" name="status" value="publication">

                        <!-- STEP 1 -->
                        <div class="step-section" data-step="1">
                            <h2 class="font-semibold text-lg mb-4">Informasi Dasar</h2>
                            <div class="space-y-4">
                                <div>
                                    <label class="block font-medium mb-1">Judul Inovasi *</label>
                                    <input type="text" name="title" required class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-400 focus:border-blue-500 transition">
                                </div>

                                <div>
                                    <label class="block font-medium mb-1">Kategori *</label>
                                    <select name="category" id="category" required class="w-full border rounded-lg px-4 py-2 bg-white focus:ring-2 focus:ring-blue-400 focus:border-blue-500 transition">
                                        <option value="">Pilih Kategori</option>
                                        <option value="Teknologi">Teknologi</option>
                                        <option value="Sosial">Sosial</option>
                                        <option value="Pendidikan">Pendidikan</option>
                                        <option value="Humaniora">Humaniora</option>
                                    </select>
                                </div>

                                <div>
                                    <label class="block font-medium mb-1">Subkategori *</label>
                                    <select name="subcategory" id="subcategory" required disabled class="w-full border rounded-lg px-4 py-2 bg-gray-50 focus:ring-2 focus:ring-blue-400 focus:border-blue-500 transition">
                                        <option value="">Pilih kategori terlebih dahulu</option>
                                    </select>
                                </div>

                                <div>
                                    <label class="block font-medium mb-1">Nama Penulis</label>
                                    <input type="text" name="author_name" value="<?php echo e(auth()->user()->name ?? ''); ?>" class="w-full border rounded-lg px-4 py-2 bg-gray-100 cursor-not-allowed" readonly>
                                </div>

                                <div>
                                    <label class="block font-medium mb-1">Institusi / Organisasi</label>
                                    <input type="text" name="institution" value="<?php echo e(auth()->user()->institution_name ?? ''); ?>" class="w-full border rounded-lg px-4 py-2 bg-gray-100 cursor-not-allowed" readonly>
                                </div>
                            </div>

                            <div class="flex justify-end mt-6">
                                <button type="button" class="btn-primary hover:bg-blue-600 transition" onclick="validateStep(1)">Selanjutnya</button>
                            </div>
                        </div>

                        <!-- STEP 2 -->
                        <div class="step-section hidden" data-step="2">
                            <h2 class="font-semibold text-lg mb-4">Detail Inovasi</h2>
                            <div class="space-y-4">
                                <div>
                                    <label class="block font-medium mb-1">Kata Kunci *</label>
                                    <input type="text" name="keywords" required class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-400 focus:border-blue-500 transition">
                                </div>

                                <div>
                                    <label class="block font-medium mb-1">Deskripsi *</label>
                                    <textarea name="description" rows="4" required class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-400 focus:border-blue-500 transition"></textarea>
                                </div>

                                <div>
                                    <label class="block font-medium mb-1">Tujuan Inovasi *</label>
                                    <textarea name="purpose" rows="3" required class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-400 focus:border-blue-500 transition"></textarea>
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
                                <button type="button" class="btn-outline hover:bg-gray-100 transition" onclick="goToStep(1)">Sebelumnya</button>
                                <button type="button" class="btn-primary hover:bg-blue-600 transition" onclick="validateStep(2)">Selanjutnya</button>
                            </div>
                        </div>

                        <!-- STEP 3 -->
                        <div class="step-section hidden" data-step="3">
                            <h2 class="font-semibold text-lg mb-4">Upload & Kontak</h2>
                            <div class="space-y-4">
                                <div>
                                    <label class="block font-medium mb-1">Gambar Inovasi *</label>
                                    <input type="file" name="image_path" required accept=".jpg,.jpeg,.png" class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-400 focus:border-blue-500 transition">
                                </div>

                                <div>
                                    <label class="block font-medium mb-1">Dokumen Pendukung *</label>
                                    <input type="file" name="document_path" required accept=".pdf" class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-400 focus:border-blue-500 transition">
                                </div>

                                <div>
                                    <label class="block font-medium mb-1">Video (Opsional)</label>
                                    <input type="url" name="video_url" placeholder="Link video YouTube" class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-400 focus:border-blue-500 transition">
                                </div>

                                <div>
                                    <label class="block font-medium mb-1">Kontak *</label>
                                    <input type="email" name="contact" value="<?php echo e(auth()->user()->email ?? ''); ?>" readonly class="w-full border rounded-lg px-4 py-2 bg-gray-100 cursor-not-allowed">
                                </div>
                            </div>

                            <div class="flex justify-between mt-6">
                                <button type="button" class="btn-outline hover:bg-gray-100 transition" onclick="goToStep(2)">Sebelumnya</button>
                                <button type="button" class="btn-primary hover:bg-blue-600 transition" onclick="validateStep(3)">Selanjutnya</button>
                            </div>
                        </div>

                        <!-- STEP 4 -->
                        <div class="step-section hidden" data-step="4">
                            <h2 class="font-semibold text-lg mb-4">Review & Submit</h2>
                            <div class="bg-gray-50 p-4 rounded space-y-2 mb-4">
                                <p><strong>Judul:</strong> <span id="reviewTitle">-</span></p>
                                <p><strong>Kategori:</strong> <span id="reviewCategory">-</span></p>
                                <p><strong>Subkategori:</strong> <span id="reviewSubcategory">-</span></p>
                                <p><strong>Penulis:</strong> <span id="reviewAuthor">-</span></p>
                                <p><strong>Institusi:</strong> <span id="reviewInstitution">-</span></p>
                                <p><strong>Kata Kunci:</strong> <span id="reviewKeywords">-</span></p>
                                <p><strong>TRL:</strong> <span id="reviewTRL">-</span></p>
                                <p><strong>Kontak:</strong> <span id="reviewContact">-</span></p>
                            </div>

                            <div class="flex justify-between mt-6">
                                <button type="button" class="btn-outline hover:bg-gray-100 transition" onclick="goToStep(3)">Sebelumnya</button>
                                <button type="submit" class="btn-primary hover:bg-blue-600 transition">Posting Inovasi</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- SIDEBAR -->
            <div class="w-full lg:w-5/12">
                <div class="bg-white rounded-2xl shadow-md p-6 sticky top-4 hover:shadow-lg transition">
                    <h2 class="font-bold text-xl mb-4">Inovasi Saya</h2>
                    <?php $__empty_1 = true; $__currentLoopData = $userInnovations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $year => $items): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <h3 class="font-semibold text-gray-700 mt-4 mb-2 border-b pb-1"><?php echo e($year); ?></h3>
                        <?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <a href="<?php echo e(route('akademisi.inovasi.show', $item->id)); ?>" class="block mb-3 p-3 border rounded hover:border-blue-500 hover:bg-blue-50 transition">
                                <h3 class="font-semibold"><?php echo e($item->title); ?></h3>
                                <p class="text-sm text-gray-500"><?php echo e($item->category); ?> - <?php echo e($item->subcategory); ?></p>
                            </a>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <p class="text-gray-400 text-sm">Belum ada inovasi.</p>
                    <?php endif; ?>
                </div>
            </div>

        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('styles'); ?>
<style>
    .step[data-step] .step-number { transition: all 0.3s ease; }
    .step[data-step].active .step-number {
        background-color: #3b82f6;
        color: white;
        transform: scale(1.1);
        box-shadow: 0 0 10px rgba(59,130,246,0.5);
    }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
let currentStep = 1;
const totalSteps = 4;

// Data subkategori manual
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

function goToStep(step) {
    document.querySelector(`.step-section[data-step="${currentStep}"]`).classList.add('hidden');
    document.querySelector(`.step-section[data-step="${step}"]`).classList.remove('hidden');
    currentStep = step;
    updateProgress();
    highlightStep();
    if(step === 4) populateReview();
    window.scrollTo({ top: 0, behavior: 'smooth' });
}

function highlightStep() {
    document.querySelectorAll('.step').forEach(el => el.classList.remove('active'));
    document.querySelector(`.step[data-step="${currentStep}"]`).classList.add('active');
}

function updateProgress() {
    document.getElementById('progressFill').style.width = `${(currentStep/totalSteps)*100}%`;
}

function validateStep(step) {
    const section = document.querySelector(`.step-section[data-step="${step}"]`);
    const inputs = section.querySelectorAll('[required]');
    let valid = true;

    inputs.forEach(input => {
        if (input.value.trim() === '') {
            input.classList.add('border-red-500');
            valid = false;
        } else {
            input.classList.remove('border-red-500');
        }
    });

    if (valid) goToStep(step + 1);
}

function populateReview() {
    document.getElementById('reviewTitle').textContent = document.querySelector('[name="title"]').value;
    document.getElementById('reviewCategory').textContent = document.querySelector('[name="category"]').value;
    document.getElementById('reviewSubcategory').textContent = document.querySelector('[name="subcategory"]').value;
    document.getElementById('reviewAuthor').textContent = document.querySelector('[name="author_name"]').value;
    document.getElementById('reviewInstitution').textContent = document.querySelector('[name="institution"]').value;
    document.getElementById('reviewKeywords').textContent = document.querySelector('[name="keywords"]').value;
    document.getElementById('reviewTRL').textContent = document.getElementById('technology_readiness_level').value;
    document.getElementById('reviewContact').textContent = document.querySelector('[name="contact"]').value;
}

// Event listener untuk kategori
document.getElementById('category').addEventListener('change', function(){
    const subcategorySelect = document.getElementById('subcategory');
    const selectedCategory = this.value;
    
    // Reset subkategori
    subcategorySelect.innerHTML = '<option value="">Pilih Subkategori</option>';
    subcategorySelect.disabled = true;
    
    if (selectedCategory && subcategories[selectedCategory]) {
        // Isi subkategori berdasarkan kategori yang dipilih
        subcategories[selectedCategory].forEach(sub => {
            const option = document.createElement('option');
            option.value = sub;
            option.textContent = sub;
            subcategorySelect.appendChild(option);
        });
        subcategorySelect.disabled = false;
    } else {
        subcategorySelect.innerHTML = '<option value="">Pilih kategori terlebih dahulu</option>';
        subcategorySelect.disabled = true;
    }
});

// Event listener untuk TRL slider
document.getElementById('technology_readiness_level').addEventListener('input', function(){
    document.getElementById('trlValue').textContent = this.value;
});

// Inisialisasi
updateProgress();
highlightStep();
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\laragon\www\dih_website\resources\views/akademisi/inovasi.blade.php ENDPATH**/ ?>