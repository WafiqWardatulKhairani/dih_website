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
    .sidebar-sticky {
        position: sticky;
        top: 2rem;
    }
    .gradient-bg {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    }
    .stat-card {
        background: linear-gradient(135deg, #ffffff 0%, #f8faff 100%);
        border: 1px solid #e1e8ff;
    }
    .quick-action-card {
        background: white;
        border-left: 4px solid;
        transition: all 0.3s ease;
    }
    .quick-action-card:hover {
        transform: translateX(5px);
        box-shadow: 0 10px 25px rgba(0,0,0,0.1);
    }
    .activity-link:hover {
        background-color: #f8fafc;
        cursor: pointer;
    }
    .progress-link:hover {
        cursor: pointer;
    }
    .innovation-image {
        width: 100%;
        height: 120px;
        object-fit: cover;
        border-radius: 8px;
        margin-bottom: 12px;
    }
    .default-image {
        width: 100%;
        height: 120px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 8px;
        margin-bottom: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 14px;
    }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<div class="max-w-7xl mx-auto px-6 py-10">
    <div class="flex flex-col lg:flex-row gap-8">
        
        
        <div class="flex-1">
            
            <div class="bg-white rounded-2xl shadow-sm p-6 mb-8 gradient-bg text-white">
                <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between">
                    <div>
                        <h1 class="text-3xl font-bold mb-2">
                            Selamat Datang, <?php echo e(Auth::user()->name ?? 'Akademisi'); ?> 👋
                        </h1>
                        <p class="text-blue-100 opacity-90">
                            Berikut ringkasan aktivitas, inovasi, dan kolaborasi akademikmu di Digital Innovation Hub.
                        </p>
                        <div class="mt-3 flex flex-wrap gap-2">
                            <span class="inline-block bg-white bg-opacity-20 text-white px-3 py-1 text-xs font-medium rounded-full">
                                <?php echo e(ucfirst(Auth::user()->role ?? 'User')); ?>

                            </span>
                            <?php if(isset($badge)): ?>
                            <span class="inline-block bg-green-500 bg-opacity-20 text-white px-3 py-1 text-xs font-medium rounded-full">
                                <?php echo e($badge); ?>

                            </span>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="mt-4 sm:mt-0">
                        <div class="text-right">
                            <p class="text-blue-100 text-sm">Hari Ini</p>
                            <p class="text-xl font-semibold"><?php echo e(now()->format('d F Y')); ?></p>
                        </div>
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
                
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                    <h2 class="text-lg font-semibold text-blue-900 mb-3">Tren Inovasi & Kolaborasi Bulanan</h2>
                    <canvas id="trendAllChart" height="150"></canvas>
                </div>
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                    <h2 class="text-lg font-semibold text-blue-900 mb-3">Kategori Inovasi</h2>
                    <canvas id="kategoriAllChart" height="150"></canvas>
                </div>
            </div>

            
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-10">
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                    <h2 class="text-lg font-semibold text-blue-900 mb-3">Tren Inovasi & Kolaborasi Bulanan Saya</h2>
                    <canvas id="trendMyChart" height="150"></canvas>
                </div>
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                    <h2 class="text-lg font-semibold text-blue-900 mb-3">Kategori Inovasi Terfavorit Saya</h2>
                    <canvas id="kategoriMyChart" height="150"></canvas>
                </div>
            </div>

            
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-10">
                
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                    <h2 class="text-lg font-semibold text-blue-900 mb-3">Progress Kolaborasi Aktif</h2>
                    <div class="space-y-4">
                        <?php $__empty_1 = true; $__currentLoopData = $progressKolaborasi; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $progress): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <a href="<?php echo e(route('kolaborasi.ide.show', $progress->id)); ?>" class="block progress-link">
                            <div>
                                <div class="flex justify-between text-sm mb-1">
                                    <span class="font-medium text-gray-700"><?php echo e($progress->judul); ?></span>
                                    <span class="text-blue-600"><?php echo e($progress->progress); ?>%</span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-2">
                                    <div class="bg-green-500 h-2 rounded-full" style="width: <?php echo e($progress->progress); ?>%"></div>
                                </div>
                            </div>
                        </a>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <p class="text-gray-500 text-sm">Tidak ada kolaborasi aktif</p>
                        <?php endif; ?>
                    </div>
                </div>

                
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                    <h2 class="text-lg font-semibold text-blue-900 mb-3">Aktivitas Terbaru</h2>
                    <div class="space-y-3">
                        <?php $__empty_1 = true; $__currentLoopData = $aktivitasTerbaru; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $aktivitas): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <a href="<?php echo e($aktivitas->link ?? '#'); ?>" class="block activity-link p-2 rounded-lg transition">
                            <div class="flex items-start space-x-3">
                                <div class="w-2 h-2 bg-blue-500 rounded-full mt-2"></div>
                                <div class="flex-1">
                                    <p class="text-sm text-gray-700"><?php echo e($aktivitas->deskripsi); ?></p>
                                    <p class="text-xs text-gray-500"><?php echo e($aktivitas->waktu); ?></p>
                                </div>
                            </div>
                        </a>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <p class="text-gray-500 text-sm">Belum ada aktivitas</p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            
            <div class="space-y-10">
                
                <div>
                    <div class="flex justify-between items-center mb-3">
                        <h2 class="text-xl font-semibold text-blue-900">Inovasi Saya</h2>
                        <a href="<?php echo e(route('akademisi.inovasi.index')); ?>" class="text-sm text-blue-600 hover:underline font-medium">Lihat Semua</a>
                    </div>
                    <div class="scrolling-wrapper pb-2">
                        <?php $__empty_1 = true; $__currentLoopData = $inovasiSaya; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <a href="<?php echo e(route('akademisi.inovasi.show', $item->id)); ?>" class="card-link">
                                <div class="min-w-[280px] bg-white rounded-xl shadow-sm p-4 card-shadow border border-gray-100">
                                    
                                    <?php if($item->image_path): ?>
                                        <img src="<?php echo e(asset('storage/' . $item->image_path)); ?>" alt="<?php echo e($item->title); ?>" class="innovation-image">
                                    <?php else: ?>
                                        <div class="default-image">
                                            <span>No Image</span>
                                        </div>
                                    <?php endif; ?>
                                    
                                    <div class="flex items-center justify-between mb-2">
                                        <span class="text-xs font-medium px-2 py-1 bg-blue-100 text-blue-700 rounded-full"><?php echo e($item->kategori ?? 'Umum'); ?></span>
                                        <span class="text-xs text-gray-500"><?php echo e($item->created_at); ?></span>
                                    </div>
                                    <h3 class="font-semibold text-gray-800 mb-2 line-clamp-2"><?php echo e($item->title); ?></h3>
                                    <p class="text-sm text-gray-500 mb-3"><?php echo e($item->author_name); ?></p>
                                    <div class="mt-2">
                                        <p class="text-xs text-gray-600 mb-1">TKT: <?php echo e($item->technology_readiness_level); ?></p>
                                        <div class="w-full bg-gray-200 rounded-full h-2">
                                            <div class="bg-blue-600 h-2 rounded-full" style="width: <?php echo e(($item->technology_readiness_level ?? 0) * 10); ?>%"></div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <div class="min-w-[280px] bg-gray-50 rounded-xl p-6 text-center border border-gray-200">
                                <p class="text-gray-500 text-sm">Belum ada inovasi yang diposting.</p>
                                <a href="<?php echo e(route('akademisi.inovasi.index')); ?>" class="text-blue-600 text-sm font-medium mt-2 inline-block">Buat Inovasi Pertamamu</a>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                
                <div>
                    <div class="flex justify-between items-center mb-3">
                        <h2 class="text-xl font-semibold text-blue-900">Diskusi Terpopuler</h2>
                        <a href="<?php echo e(route('forum-diskusi.index')); ?>" class="text-sm text-blue-600 hover:underline font-medium">Lihat Semua</a>
                    </div>
                    <div class="scrolling-wrapper pb-2">
                        <?php $__empty_1 = true; $__currentLoopData = $diskusiTerpopuler; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $diskusi): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <a href="<?php echo e(route('forum-diskusi.detail', ['type' => $diskusi->type, 'id' => $diskusi->id])); ?>" class="card-link">
                                <div class="min-w-[280px] bg-white rounded-xl shadow-sm p-4 card-shadow border border-gray-100">
                                    
                                    <?php if($diskusi->image_path): ?>
                                        <img src="<?php echo e(asset('storage/' . $diskusi->image_path)); ?>" alt="<?php echo e($diskusi->title); ?>" class="innovation-image">
                                    <?php elseif($diskusi->image): ?>
                                        <img src="<?php echo e(asset('storage/' . $diskusi->image)); ?>" alt="<?php echo e($diskusi->title); ?>" class="innovation-image">
                                    <?php else: ?>
                                        <div class="default-image">
                                            <span>No Image</span>
                                        </div>
                                    <?php endif; ?>
                                    
                                    <div class="flex items-center justify-between mb-2">
                                        <span class="text-xs font-medium px-2 py-1 bg-purple-100 text-purple-700 rounded-full"><?php echo e(ucfirst($diskusi->type)); ?></span>
                                        <span class="text-xs text-gray-500"><?php echo e($diskusi->created_at); ?></span>
                                    </div>
                                    <h3 class="font-semibold text-gray-800 mb-2 line-clamp-2"><?php echo e($diskusi->title); ?></h3>
                                    <p class="text-sm text-gray-500 mb-1"><?php echo e($diskusi->author_name); ?></p>
                                    <div class="flex items-center justify-between mt-3">
                                        <span class="text-xs text-gray-600">
                                            <i class="fas fa-comment mr-1"></i>
                                            <?php echo e($diskusi->jumlah_komentar); ?> Komentar
                                        </span>
                                    </div>
                                </div>
                            </a>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <div class="min-w-[280px] bg-gray-50 rounded-xl p-6 text-center border border-gray-200">
                                <p class="text-gray-500 text-sm">Belum ada diskusi populer.</p>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                
                <div>
                    <div class="flex justify-between items-center mb-3">
                        <h2 class="text-xl font-semibold text-blue-900">Kolaborasi Berjalan</h2>
                        <a href="<?php echo e(route('kolaborasi.index')); ?>" class="text-sm text-blue-600 hover:underline font-medium">Lihat Semua</a>
                    </div>
                    <div class="scrolling-wrapper pb-2">
                        <?php $__empty_1 = true; $__currentLoopData = $kolaborasiBerjalan; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $kolab): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <a href="<?php echo e(route('kolaborasi.ide.show', $kolab->id)); ?>" class="card-link">
                                <div class="min-w-[280px] bg-white rounded-xl shadow-sm p-4 card-shadow border border-gray-100">
                                    <div class="flex items-center justify-between mb-2">
                                        <span class="text-xs font-medium px-2 py-1 
                                            <?php echo e($kolab->status == 'active' ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700'); ?> rounded-full">
                                            <?php echo e(ucfirst($kolab->status)); ?>

                                        </span>
                                        <span class="text-xs text-gray-500"><?php echo e($kolab->deadline ? 'Selesai: '.$kolab->deadline : 'Tanpa deadline'); ?></span>
                                    </div>
                                    <h3 class="font-semibold text-gray-800 mb-2"><?php echo e($kolab->judul); ?></h3>
                                    <p class="text-sm text-gray-500 mb-3"><?php echo e($kolab->deskripsi_singkat); ?></p>
                                    <div class="flex items-center justify-between">
                                        <span class="text-xs text-gray-600">
                                            <i class="fas fa-users mr-1"></i>
                                            <?php echo e($kolab->jumlah_anggota); ?> Anggota
                                        </span>
                                        <span class="text-xs text-gray-600">
                                            <i class="fas fa-tasks mr-1"></i>
                                            <?php echo e($kolab->jumlah_tugas); ?> Tugas
                                        </span>
                                    </div>
                                </div>
                            </a>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <div class="min-w-[280px] bg-gray-50 rounded-xl p-6 text-center border border-gray-200">
                                <p class="text-gray-500 text-sm">Belum ada kolaborasi berjalan.</p>
                                <a href="<?php echo e(route('kolaborasi.index')); ?>" class="text-blue-600 text-sm font-medium mt-2 inline-block">Temukan Kolaborasi</a>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

        
        <div class="lg:w-80">
            <div class="sidebar-sticky">
                
                <div class="bg-white rounded-2xl shadow-sm p-6 mb-6 border border-gray-100">
                    <h2 class="text-xl font-semibold text-blue-900 mb-5">Akses Cepat</h2>
                    <div class="space-y-4">
                        <a href="<?php echo e(route('akademisi.inovasi.create')); ?>" 
                           class="quick-action-card block p-4 rounded-lg border-l-4 border-blue-500">
                            <div class="flex items-center">
                                <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center mr-3">
                                    <i class="fas fa-plus text-blue-600"></i>
                                </div>
                                <div>
                                    <h3 class="font-semibold text-gray-800">Tambah Inovasi</h3>
                                    <p class="text-sm text-gray-500">Buat inovasi baru</p>
                                </div>
                            </div>
                        </a>

                        <a href="<?php echo e(route('forum-diskusi.index')); ?>" 
                           class="quick-action-card block p-4 rounded-lg border-l-4 border-indigo-500">
                            <div class="flex items-center">
                                <div class="w-10 h-10 bg-indigo-100 rounded-lg flex items-center justify-center mr-3">
                                    <i class="fas fa-comments text-indigo-600"></i>
                                </div>
                                <div>
                                    <h3 class="font-semibold text-gray-800">Bergabung Diskusi</h3>
                                    <p class="text-sm text-gray-500">Diskusi terbaru</p>
                                </div>
                            </div>
                        </a>

                        <a href="<?php echo e(route('kolaborasi.index')); ?>" 
                           class="quick-action-card block p-4 rounded-lg border-l-4 border-emerald-500">
                            <div class="flex items-center">
                                <div class="w-10 h-10 bg-emerald-100 rounded-lg flex items-center justify-center mr-3">
                                    <i class="fas fa-users text-emerald-600"></i>
                                </div>
                                <div>
                                    <h3 class="font-semibold text-gray-800">Buat Kolaborasi</h3>
                                    <p class="text-sm text-gray-500">Kolaborasi baru</p>
                                </div>
                            </div>
                        </a>

                        <a href="<?php echo e(route('akademisi.profil-akademik')); ?>" 
                           class="quick-action-card block p-4 rounded-lg border-l-4 border-purple-500">
                            <div class="flex items-center">
                                <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center mr-3">
                                    <i class="fas fa-user text-purple-600"></i>
                                </div>
                                <div>
                                    <h3 class="font-semibold text-gray-800">Profil Saya</h3>
                                    <p class="text-sm text-gray-500">Kelola profil</p>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>

                
                <div class="bg-white rounded-2xl shadow-sm p-6 border border-gray-100">
                    <h2 class="text-xl font-semibold text-blue-900 mb-4">Pencapaian</h2>
                    <div class="space-y-4">
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-600">Inovasi Dibuat</span>
                            <span class="font-semibold text-blue-600"><?php echo e($stat['inovasi']); ?></span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-600">Kolaborasi Aktif</span>
                            <span class="font-semibold text-green-600"><?php echo e($stat['kolaborasi_aktif'] ?? 0); ?></span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-600">Diskusi Diikuti</span>
                            <span class="font-semibold text-purple-600"><?php echo e($stat['diskusi_diikuti'] ?? 0); ?></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<script>
    // Chart untuk seluruh user
    const trendAllCtx = document.getElementById('trendAllChart');
    new Chart(trendAllCtx, {
        type: 'line',
        data: {
            labels: <?php echo json_encode($trendAllLabels, 15, 512) ?>,
            datasets: [
                {
                    label: 'Inovasi',
                    data: <?php echo json_encode($trendAllInovasi, 15, 512) ?>,
                    borderColor: '#2563eb',
                    backgroundColor: 'rgba(37,99,235,0.1)',
                    tension: 0.3,
                    fill: true
                },
                {
                    label: 'Kolaborasi',
                    data: <?php echo json_encode($trendAllKolaborasi, 15, 512) ?>,
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

    // Bar chart untuk kategori seluruh user
    const kategoriAllCtx = document.getElementById('kategoriAllChart');
    new Chart(kategoriAllCtx, {
        type: 'bar',
        data: {
            labels: <?php echo json_encode($kategoriAllLabels, 15, 512) ?>,
            datasets: [{
                label: 'Jumlah Inovasi',
                data: <?php echo json_encode($kategoriAllCounts, 15, 512) ?>,
                backgroundColor: '#3b82f6',
                borderColor: '#2563eb',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: { 
                legend: { 
                    display: false 
                } 
            },
            scales: { 
                y: { 
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1
                    }
                } 
            }
        }
    });

    // Chart untuk user yang login
    const trendMyCtx = document.getElementById('trendMyChart');
    new Chart(trendMyCtx, {
        type: 'line',
        data: {
            labels: <?php echo json_encode($trendMyLabels, 15, 512) ?>,
            datasets: [
                {
                    label: 'Inovasi Saya',
                    data: <?php echo json_encode($trendMyInovasi, 15, 512) ?>,
                    borderColor: '#8b5cf6',
                    backgroundColor: 'rgba(139,92,246,0.1)',
                    tension: 0.3,
                    fill: true
                },
                {
                    label: 'Kolaborasi Saya',
                    data: <?php echo json_encode($trendMyKolaborasi, 15, 512) ?>,
                    borderColor: '#f59e0b',
                    backgroundColor: 'rgba(245,158,11,0.1)',
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

    const kategoriMyCtx = document.getElementById('kategoriMyChart');
    new Chart(kategoriMyCtx, {
        type: 'doughnut',
        data: {
            labels: <?php echo json_encode($kategoriMyLabels, 15, 512) ?>,
            datasets: [{
                data: <?php echo json_encode($kategoriMyCounts, 15, 512) ?>,
                backgroundColor: ['#8b5cf6', '#a78bfa', '#c4b5fd', '#ddd6fe', '#f3f4f6']
            }]
        },
        options: {
            plugins: { legend: { position: 'bottom' } }
        }
    });
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\laragon\www\dih_website\resources\views/akademisi/index.blade.php ENDPATH**/ ?>