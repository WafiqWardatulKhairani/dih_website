<?php $__env->startSection('title', 'Dashboard Akademisi'); ?>

<?php $__env->startPush('styles'); ?>
<script src="https://cdn.tailwindcss.com"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<style>
    body {
        background-color: #f9fafb;
    }
    .scrolling-wrapper {
        display: flex;
        overflow-x: auto;
        gap: 1rem;
        scroll-behavior: smooth;
    }
    .scrolling-wrapper::-webkit-scrollbar {
        height: 6px;
    }
    .scrolling-wrapper::-webkit-scrollbar-thumb {
        background: #93c5fd;
        border-radius: 4px;
    }
    .card-link { 
        display: block; 
        text-decoration: none; 
        color: inherit; 
    }
    .card-link:hover .card-shadow {
        box-shadow: 0 10px 25px rgba(0,0,0,0.12);
        transform: translateY(-2px);
        transition: all 0.3s ease-in-out;
    }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<div class="max-w-7xl mx-auto px-6 py-10">

    
    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between mb-8">
        <div>
            <h1 class="text-3xl font-bold text-blue-900 mb-2">
                Selamat Datang, <?php echo e(Auth::user()->name ?? 'Akademisi'); ?> 👋
            </h1>
            <p class="text-gray-600">
                Berikut ringkasan aktivitas, inovasi, dan kolaborasi akademikmu di Digital Innovation Hub.
            </p>
            <div class="mt-3">
                <span class="inline-block bg-blue-100 text-blue-700 px-3 py-1 text-xs font-medium rounded-full">
                    Role: <?php echo e(ucfirst(Auth::user()->role ?? 'User')); ?>

                </span>
                <?php if(isset($badge)): ?>
                <span class="inline-block bg-green-100 text-green-700 px-3 py-1 text-xs font-medium rounded-full ml-2">
                    <?php echo e($badge); ?>

                </span>
                <?php endif; ?>
            </div>
        </div>
    </div>

    
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">
        <?php if (isset($component)) { $__componentOriginal527fae77f4db36afc8c8b7e9f5f81682 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal527fae77f4db36afc8c8b7e9f5f81682 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.stat-card','data' => ['title' => 'Inovasi Saya','value' => ''.e($stat['inovasi']).'','icon' => 'fa-lightbulb','color' => 'yellow']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('stat-card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Inovasi Saya','value' => ''.e($stat['inovasi']).'','icon' => 'fa-lightbulb','color' => 'yellow']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal527fae77f4db36afc8c8b7e9f5f81682)): ?>
<?php $attributes = $__attributesOriginal527fae77f4db36afc8c8b7e9f5f81682; ?>
<?php unset($__attributesOriginal527fae77f4db36afc8c8b7e9f5f81682); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal527fae77f4db36afc8c8b7e9f5f81682)): ?>
<?php $component = $__componentOriginal527fae77f4db36afc8c8b7e9f5f81682; ?>
<?php unset($__componentOriginal527fae77f4db36afc8c8b7e9f5f81682); ?>
<?php endif; ?>
        <?php if (isset($component)) { $__componentOriginal527fae77f4db36afc8c8b7e9f5f81682 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal527fae77f4db36afc8c8b7e9f5f81682 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.stat-card','data' => ['title' => 'Ide Kolaborasi','value' => ''.e($stat['kolaborasi_ide']).'','icon' => 'fa-users-gear','color' => 'blue']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('stat-card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Ide Kolaborasi','value' => ''.e($stat['kolaborasi_ide']).'','icon' => 'fa-users-gear','color' => 'blue']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal527fae77f4db36afc8c8b7e9f5f81682)): ?>
<?php $attributes = $__attributesOriginal527fae77f4db36afc8c8b7e9f5f81682; ?>
<?php unset($__attributesOriginal527fae77f4db36afc8c8b7e9f5f81682); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal527fae77f4db36afc8c8b7e9f5f81682)): ?>
<?php $component = $__componentOriginal527fae77f4db36afc8c8b7e9f5f81682; ?>
<?php unset($__componentOriginal527fae77f4db36afc8c8b7e9f5f81682); ?>
<?php endif; ?>
        <?php if (isset($component)) { $__componentOriginal527fae77f4db36afc8c8b7e9f5f81682 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal527fae77f4db36afc8c8b7e9f5f81682 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.stat-card','data' => ['title' => 'Kolaborasi Diikuti','value' => ''.e($stat['kolaborasi_member']).'','icon' => 'fa-people-group','color' => 'indigo']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('stat-card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Kolaborasi Diikuti','value' => ''.e($stat['kolaborasi_member']).'','icon' => 'fa-people-group','color' => 'indigo']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal527fae77f4db36afc8c8b7e9f5f81682)): ?>
<?php $attributes = $__attributesOriginal527fae77f4db36afc8c8b7e9f5f81682; ?>
<?php unset($__attributesOriginal527fae77f4db36afc8c8b7e9f5f81682); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal527fae77f4db36afc8c8b7e9f5f81682)): ?>
<?php $component = $__componentOriginal527fae77f4db36afc8c8b7e9f5f81682; ?>
<?php unset($__componentOriginal527fae77f4db36afc8c8b7e9f5f81682); ?>
<?php endif; ?>
        <?php if (isset($component)) { $__componentOriginal527fae77f4db36afc8c8b7e9f5f81682 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal527fae77f4db36afc8c8b7e9f5f81682 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.stat-card','data' => ['title' => 'Tugas Kolaborasi','value' => ''.e($stat['kolaborasi_task']).'','icon' => 'fa-list-check','color' => 'emerald']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('stat-card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Tugas Kolaborasi','value' => ''.e($stat['kolaborasi_task']).'','icon' => 'fa-list-check','color' => 'emerald']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal527fae77f4db36afc8c8b7e9f5f81682)): ?>
<?php $attributes = $__attributesOriginal527fae77f4db36afc8c8b7e9f5f81682; ?>
<?php unset($__attributesOriginal527fae77f4db36afc8c8b7e9f5f81682); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal527fae77f4db36afc8c8b7e9f5f81682)): ?>
<?php $component = $__componentOriginal527fae77f4db36afc8c8b7e9f5f81682; ?>
<?php unset($__componentOriginal527fae77f4db36afc8c8b7e9f5f81682); ?>
<?php endif; ?>
    </div>

    
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-10">
        <div class="bg-white p-6 rounded-2xl shadow">
            <h2 class="text-lg font-semibold text-blue-900 mb-3">Tren Inovasi & Kolaborasi Bulanan</h2>
            <canvas id="trendChart" height="150"></canvas>
        </div>
        <div class="bg-white p-6 rounded-2xl shadow">
            <h2 class="text-lg font-semibold text-blue-900 mb-3">Kategori Inovasi Terfavorit</h2>
            <canvas id="kategoriChart" height="150"></canvas>
        </div>
    </div>

    
    <div class="space-y-10">

        
        <div>
            <div class="flex justify-between items-center mb-3">
                <h2 class="text-xl font-semibold text-blue-900">Inovasi Saya</h2>
                <a href="<?php echo e(route('akademisi.inovasi.index')); ?>" class="text-sm text-blue-600 hover:underline">Lihat Semua</a>
            </div>
            <div class="scrolling-wrapper pb-2">
                <?php $__empty_1 = true; $__currentLoopData = $inovasiSaya; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <a href="<?php echo e(route('akademisi.inovasi.show', $item->id)); ?>" class="card-link">
                        <div class="min-w-[260px] bg-white rounded-xl shadow p-4 card-shadow">
                            <h3 class="font-semibold text-gray-800"><?php echo e($item->title); ?></h3>
                            <p class="text-sm text-gray-500 mb-2"><?php echo e($item->author_name); ?></p>
                            <div class="mt-2">
                                <p class="text-xs text-gray-600 mb-1">TKT: <?php echo e($item->technology_readiness_level); ?></p>
                                <div class="w-full bg-gray-200 rounded-full h-2">
                                    <div class="bg-blue-600 h-2 rounded-full" style="width: <?php echo e(($item->technology_readiness_level ?? 0) * 10); ?>%"></div>
                                </div>
                            </div>
                        </div>
                    </a>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <p class="text-gray-500 text-sm">Belum ada inovasi yang diposting.</p>
                <?php endif; ?>
            </div>
        </div>

        
        <div>
            <div class="flex justify-between items-center mb-3">
                <h2 class="text-xl font-semibold text-blue-900">Diskusi Terpopuler</h2>
                <a href="<?php echo e(route('forum-diskusi.index')); ?>" class="text-sm text-blue-600 hover:underline">Lihat Semua</a>
            </div>
            <div class="scrolling-wrapper pb-2">
                <?php $__empty_1 = true; $__currentLoopData = $diskusiTerpopuler; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $diskusi): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
<a href="<?php echo e(route('forum-diskusi.detail', ['type' => $diskusi->type, 'id' => $diskusi->id])); ?>" class="card-link">
                        <div class="min-w-[260px] bg-white rounded-xl shadow p-4 card-shadow">
                            <h3 class="font-semibold text-gray-800"><?php echo e($diskusi->title); ?></h3>
                            <p class="text-sm text-gray-500 mb-1"><?php echo e($diskusi->author_name); ?></p>
                            <p class="text-xs text-gray-600">Komentar: <?php echo e($diskusi->jumlah_komentar); ?></p>
                        </div>
                    </a>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <p class="text-gray-500 text-sm">Belum ada diskusi populer.</p>
                <?php endif; ?>
            </div>
        </div>

        
        <div>
            <div class="flex justify-between items-center mb-3">
                <h2 class="text-xl font-semibold text-blue-900">Kolaborasi Berjalan</h2>
                <a href="<?php echo e(route('kolaborasi.index')); ?>" class="text-sm text-blue-600 hover:underline">Lihat Semua</a>
            </div>
            <div class="scrolling-wrapper pb-2">
                <?php $__empty_1 = true; $__currentLoopData = $kolaborasiBerjalan; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $kolab): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <a href="<?php echo e(route('kolaborasi.ide.show', $kolab->id)); ?>" class="card-link">
                        <div class="min-w-[260px] bg-white rounded-xl shadow p-4 card-shadow">
                            <h3 class="font-semibold text-gray-800"><?php echo e($kolab->judul); ?></h3>
                            <p class="text-sm text-gray-500 mb-1">Status: <?php echo e(ucfirst($kolab->status)); ?></p>
                            <p class="text-xs text-gray-600">Progress aktif</p>
                        </div>
                    </a>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <p class="text-gray-500 text-sm">Belum ada kolaborasi berjalan.</p>
                <?php endif; ?>
            </div>
        </div>

        
        <div>
            <div class="flex justify-between items-center mb-3">
                <h2 class="text-xl font-semibold text-blue-900">Kolaborasi Masih Mencari Anggota</h2>
                <a href="<?php echo e(route('kolaborasi.index')); ?>" class="text-sm text-blue-600 hover:underline">Lihat Semua</a>
            </div>
            <div class="scrolling-wrapper pb-2">
                <?php $__empty_1 = true; $__currentLoopData = $kolaborasiHiring; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $hire): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <a href="<?php echo e(route('kolaborasi.show', $hire->id)); ?>" class="card-link">
                        <div class="min-w-[260px] bg-white rounded-xl shadow p-4 card-shadow">
                            <h3 class="font-semibold text-gray-800"><?php echo e($hire->judul); ?></h3>
                            <p class="text-sm text-gray-500 mb-1">Anggota saat ini: <?php echo e($hire->jumlah_anggota); ?>/4</p>
                            <p class="text-xs text-gray-600">Masih membuka kolaborator</p>
                        </div>
                    </a>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <p class="text-gray-500 text-sm">Tidak ada kolaborasi yang sedang membuka anggota.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>

    
    <div class="mt-14 bg-white shadow rounded-2xl p-6">
        <h2 class="text-xl font-semibold text-blue-900 mb-5">Akses Cepat</h2>
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
            <a href="<?php echo e(route('akademisi.inovasi.index')); ?>"
                class="bg-blue-600 hover:bg-blue-700 text-white text-center rounded-xl p-5 font-medium transition">
                Tambah Inovasi
            </a>
            <a href="<?php echo e(route('forum-diskusi.index')); ?>"
                class="bg-indigo-600 hover:bg-indigo-700 text-white text-center rounded-xl p-5 font-medium transition">
                Bergabung Diskusi
            </a>
            <a href="<?php echo e(route('kolaborasi.index')); ?>"
                class="bg-emerald-600 hover:bg-emerald-700 text-white text-center rounded-xl p-5 font-medium transition">
                Buat Kolaborasi
            </a>
        </div>
    </div>
</div>


<script>
    const trendCtx = document.getElementById('trendChart');
    new Chart(trendCtx, {
        type: 'line',
        data: {
            labels: <?php echo json_encode($trendLabels, 15, 512) ?>,
            datasets: [
                {
                    label: 'Inovasi',
                    data: <?php echo json_encode($trendInovasi, 15, 512) ?>,
                    borderColor: '#2563eb',
                    backgroundColor: 'rgba(37,99,235,0.1)',
                    tension: 0.3,
                    fill: true
                },
                {
                    label: 'Kolaborasi',
                    data: <?php echo json_encode($trendKolaborasi, 15, 512) ?>,
                    borderColor: '#10b981',
                    backgroundColor: 'rgba(16,185,129,0.1)',
                    tension: 0.3,
                    fill: true
                }
            ]
        },
        options: {
            responsive: true,
            plugins: { legend: { display: true } },
            scales: { y: { beginAtZero: true } }
        }
    });

    const kategoriCtx = document.getElementById('kategoriChart');
    new Chart(kategoriCtx, {
        type: 'doughnut',
        data: {
            labels: <?php echo json_encode($kategoriLabels, 15, 512) ?>,
            datasets: [{
                data: <?php echo json_encode($kategoriCounts, 15, 512) ?>,
                backgroundColor: ['#2563eb', '#3b82f6', '#60a5fa', '#93c5fd', '#bfdbfe']
            }]
        },
        options: {
            plugins: { legend: { position: 'bottom' } }
        }
    });
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\xampp\htdocs\dih_website\resources\views/akademisi/index.blade.php ENDPATH**/ ?>