<?php $__env->startSection('title', 'Dashboard Akademisi'); ?>

<?php $__env->startPush('styles'); ?>
<script src="https://cdn.tailwindcss.com"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<style>
    body {
        background-color: #f9fafb;
        overflow-x: hidden;
    }
    .scrolling-wrapper {
        display: flex;
        overflow-x: auto;
        gap: 1rem;
        scroll-behavior: smooth;
        padding-bottom: 0.5rem;
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
        flex-shrink: 0;
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
        height: 180px;
        object-fit: cover;
        border-radius: 8px;
        margin-bottom: 12px;
    }
    .default-image {
        width: 100%;
        height: 180px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 8px;
        margin-bottom: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 14px;
    }
    .scroll-nav {
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    .scroll-btn {
        background: #3b82f6;
        color: white;
        border: none;
        border-radius: 50%;
        width: 32px;
        height: 32px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.3s ease;
    }
    .scroll-btn:hover {
        background: #2563eb;
        transform: scale(1.05);
    }
    .scroll-btn:disabled {
        background: #9ca3af;
        cursor: not-allowed;
    }
    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    /* FIX: Chart container styles */
    .chart-container {
        position: relative;
        height: 200px;
        width: 100%;
    }
    .chart-container-sm {
        position: relative;
        height: 180px;
        width: 100%;
    }
    /* Portrait card styles */
    .portrait-card {
        min-width: 200px;
        max-width: 200px;
        height: 320px;
        display: flex;
        flex-direction: column;
    }
    .portrait-image {
        width: 100%;
        height: 140px;
        object-fit: cover;
        border-radius: 8px 8px 0 0;
    }
    .portrait-default-image {
        width: 100%;
        height: 140px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 8px 8px 0 0;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 12px;
    }
    .portrait-content {
        flex: 1;
        display: flex;
        flex-direction: column;
        padding: 12px;
    }
    @media (max-width: 1024px) {
        .lg-sidebar {
            width: 100%;
            margin-top: 2rem;
        }
        .chart-container {
            height: 180px;
        }
        .chart-container-sm {
            height: 160px;
        }
        .portrait-card {
            min-width: 180px;
            max-width: 180px;
            height: 300px;
        }
    }
    @media (max-width: 768px) {
        .chart-container {
            height: 160px;
        }
        .chart-container-sm {
            height: 140px;
        }
        .portrait-card {
            min-width: 160px;
            max-width: 160px;
            height: 280px;
        }
    }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<div class="w-full px-4 py-8 mx-auto max-w-7xl">
    <div class="flex flex-col lg:flex-row gap-8">
        
        
        <div class="flex-1 w-full lg:w-3/4">
            
            <div class="bg-white rounded-2xl shadow-sm p-6 mb-8 gradient-bg text-white w-full">
                <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between">
                    <div class="w-full">
                        <h1 class="text-2xl lg:text-3xl font-bold mb-2">
                            Selamat Datang, <?php echo e(Auth::user()->name ?? 'Akademisi'); ?> 👋
                        </h1>
                        <p class="text-blue-100 opacity-90 text-sm lg:text-base">
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
                    <div class="mt-4 sm:mt-0 w-full sm:w-auto">
                        <div class="text-left sm:text-right">
                            <p class="text-blue-100 text-sm">Hari Ini</p>
                            <p class="text-lg lg:text-xl font-semibold"><?php echo e(now()->format('d F Y')); ?></p>
                        </div>
                    </div>
                </div>
            </div>

            
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-8 w-full">
                <div class="stat-card rounded-xl p-4 w-full">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs lg:text-sm text-gray-600">Inovasi Saya</p>
                            <p class="text-xl lg:text-2xl font-bold text-gray-800"><?php echo e($stat['inovasi'] ?? 0); ?></p>
                        </div>
                        <div class="w-10 h-10 lg:w-12 lg:h-12 bg-yellow-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-lightbulb text-yellow-600 text-lg"></i>
                        </div>
                    </div>
                </div>
                <div class="stat-card rounded-xl p-4 w-full">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs lg:text-sm text-gray-600">Ide Kolaborasi</p>
                            <p class="text-xl lg:text-2xl font-bold text-gray-800"><?php echo e($stat['kolaborasi_ide'] ?? 0); ?></p>
                        </div>
                        <div class="w-10 h-10 lg:w-12 lg:h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-users-gear text-blue-600 text-lg"></i>
                        </div>
                    </div>
                </div>
                <div class="stat-card rounded-xl p-4 w-full">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs lg:text-sm text-gray-600">Kolaborasi Diikuti</p>
                            <p class="text-xl lg:text-2xl font-bold text-gray-800"><?php echo e($stat['kolaborasi_member'] ?? 0); ?></p>
                        </div>
                        <div class="w-10 h-10 lg:w-12 lg:h-12 bg-indigo-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-people-group text-indigo-600 text-lg"></i>
                        </div>
                    </div>
                </div>
                <div class="stat-card rounded-xl p-4 w-full">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs lg:text-sm text-gray-600">Tugas Kolaborasi</p>
                            <p class="text-xl lg:text-2xl font-bold text-gray-800"><?php echo e($stat['kolaborasi_task'] ?? 0); ?></p>
                        </div>
                        <div class="w-10 h-10 lg:w-12 lg:h-12 bg-emerald-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-list-check text-emerald-600 text-lg"></i>
                        </div>
                    </div>
                </div>
            </div>

            
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8 w-full">
                
                <div class="bg-white p-4 lg:p-6 rounded-2xl shadow-sm border border-gray-100 w-full">
                    <h2 class="text-base lg:text-lg font-semibold text-blue-900 mb-3">Tren Inovasi & Kolaborasi 6 Bulan Terakhir</h2>
                    <div class="chart-container">
                        <canvas id="trendAllChart"></canvas>
                    </div>
                </div>
                <div class="bg-white p-4 lg:p-6 rounded-2xl shadow-sm border border-gray-100 w-full">
                    <h2 class="text-base lg:text-lg font-semibold text-blue-900 mb-3">Kategori Inovasi</h2>
                    <div class="chart-container">
                        <canvas id="kategoriAllChart"></canvas>
                    </div>
                </div>
            </div>

            
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8 w-full">
                <div class="bg-white p-4 lg:p-6 rounded-2xl shadow-sm border border-gray-100 w-full">
                    <h2 class="text-base lg:text-lg font-semibold text-blue-900 mb-3">Tren Inovasi & Kolaborasi Bulanan Saya</h2>
                    <div class="chart-container">
                        <canvas id="trendMyChart"></canvas>
                    </div>
                </div>
                <div class="bg-white p-4 lg:p-6 rounded-2xl shadow-sm border border-gray-100 w-full">
                    <h2 class="text-base lg:text-lg font-semibold text-blue-900 mb-3">Kategori Inovasi Terfavorit Saya</h2>
                    <div class="chart-container-sm">
                        <canvas id="kategoriMyChart"></canvas>
                    </div>
                </div>
            </div>

            
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8 w-full">
                
                <div class="bg-white p-4 lg:p-6 rounded-2xl shadow-sm border border-gray-100 w-full">
                    <div class="flex justify-between items-center mb-3">
                        <h2 class="text-base lg:text-lg font-semibold text-blue-900">Program Pemerintah Terbaru</h2>
                        <a href="<?php echo e(route('pemerintah.program') ?? '#'); ?>" class="text-xs lg:text-sm text-blue-600 hover:underline font-medium">Lihat Semua</a>
                    </div>
                    <div class="space-y-4">
                        <?php $__empty_1 = true; $__currentLoopData = $programPemerintah ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $program): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <a href="<?php echo e(route('pemerintah.program.store', $program->id) ?? '#'); ?>" target="_blank" class="block progress-link">
                            <div class="border border-gray-200 rounded-lg p-3 lg:p-4 hover:bg-gray-50 transition">
                                <div class="flex justify-between items-start mb-2">
                                    <h3 class="font-medium text-gray-800 text-sm lg:text-base"><?php echo e($program->title ?? 'Program Pemerintah'); ?></h3>
                                    <span class="text-xs px-2 py-1 rounded-full 
                                        <?php echo e(($program->status ?? '') == 'ongoing' ? 'bg-green-100 text-green-700' : 
                                           (($program->status ?? '') == 'planning' ? 'bg-yellow-100 text-yellow-700' : 'bg-gray-100 text-gray-700')); ?>">
                                        <?php if(($program->status ?? '') == 'ongoing'): ?> 🚀 Berjalan
                                        <?php elseif(($program->status ?? '') == 'planning'): ?> 📅 Perencanaan
                                        <?php else: ?> ✅ Selesai
                                        <?php endif; ?>
                                    </span>
                                </div>
                                <p class="text-xs lg:text-sm text-gray-600 mb-2"><?php echo e($program->opd_name ?? 'OPD'); ?></p>
                                <div class="flex justify-between text-xs mb-1">
                                    <span class="text-gray-500">Progress</span>
                                    <span class="text-blue-600"><?php echo e($program->progress ?? 0); ?>%</span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-2">
                                    <div class="bg-green-500 h-2 rounded-full" style="width: <?php echo e($program->progress ?? 0); ?>%"></div>
                                </div>
                                <div class="flex justify-between text-xs text-gray-500 mt-2">
                                    <span>Mulai: <?php echo e(isset($program->start_date) ? \Carbon\Carbon::parse($program->start_date)->format('d M Y') : '-'); ?></span>
                                    <span>Selesai: <?php echo e(isset($program->end_date) ? \Carbon\Carbon::parse($program->end_date)->format('d M Y') : '-'); ?></span>
                                </div>
                            </div>
                        </a>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <p class="text-gray-500 text-sm">Tidak ada program pemerintah</p>
                        <?php endif; ?>
                    </div>
                </div>

                
                <div class="bg-white p-4 lg:p-6 rounded-2xl shadow-sm border border-gray-100 w-full">
                    <h2 class="text-base lg:text-lg font-semibold text-blue-900 mb-3">Aktivitas Terbaru</h2>
                    <div class="space-y-3">
                        <?php $__empty_1 = true; $__currentLoopData = $aktivitasTerbaru ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $aktivitas): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <a href="<?php echo e($aktivitas['link'] ?? '#'); ?>" class="block activity-link p-2 rounded-lg transition">
                            <div class="flex items-start space-x-3">
                                <div class="w-2 h-2 bg-blue-500 rounded-full mt-2"></div>
                                <div class="flex-1">
                                    <p class="text-sm text-gray-700"><?php echo e($aktivitas['deskripsi'] ?? 'Aktivitas terbaru'); ?></p>
                                    <p class="text-xs text-gray-500"><?php echo e($aktivitas['waktu'] ?? now()->format('d M Y')); ?></p>
                                </div>
                            </div>
                        </a>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <p class="text-gray-500 text-sm">Belum ada aktivitas</p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            
            <div class="space-y-8 w-full">
                
                <div class="w-full">
                    <div class="flex justify-between items-center mb-3">
                        <h2 class="text-lg lg:text-xl font-semibold text-blue-900">Inovasi Saya</h2>
                        <div class="flex items-center gap-4">
                            <div class="scroll-nav">
                                <button class="scroll-btn scroll-left" data-target="inovasi-scroll">
                                    <i class="fas fa-chevron-left text-xs"></i>
                                </button>
                                <button class="scroll-btn scroll-right" data-target="inovasi-scroll">
                                    <i class="fas fa-chevron-right text-xs"></i>
                                </button>
                            </div>
                            <a href="<?php echo e(route('akademisi.inovasi.index') ?? '#'); ?>" class="text-xs lg:text-sm text-blue-600 hover:underline font-medium">Lihat Semua</a>
                        </div>
                    </div>
                    <div class="scrolling-wrapper pb-2" id="inovasi-scroll">
                        <?php $__empty_1 = true; $__currentLoopData = $inovasiSaya ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <a href="<?php echo e(route('akademisi.inovasi.show', $item->id) ?? '#'); ?>" class="card-link">
                                <div class="portrait-card bg-white rounded-xl shadow-sm card-shadow border border-gray-100 overflow-hidden">
                                    
                                    <?php if($item->image_path): ?>
                                        <img src="<?php echo e(asset('storage/' . $item->image_path)); ?>" alt="<?php echo e($item->title); ?>" class="portrait-image">
                                    <?php else: ?>
                                        <div class="portrait-default-image">
                                            <span>No Image</span>
                                        </div>
                                    <?php endif; ?>
                                    
                                    <div class="portrait-content">
                                        <div class="flex items-center justify-between mb-2">
                                            <span class="text-xs font-medium px-2 py-1 bg-blue-100 text-blue-700 rounded-full"><?php echo e($item->category ?? 'Umum'); ?></span>
                                            <span class="text-xs text-gray-500"><?php echo e($item->created_at->format('d M Y')); ?></span>
                                        </div>
                                        <h3 class="font-semibold text-gray-800 mb-2 line-clamp-2 text-sm"><?php echo e($item->title); ?></h3>
                                        <p class="text-xs text-gray-500 mb-2 line-clamp-2"><?php echo e($item->author_name ?? Auth::user()->name); ?></p>
                                        <div class="mt-auto">
                                            <p class="text-xs text-gray-600 mb-1">TKT: <?php echo e($item->technology_readiness_level ?? 1); ?></p>
                                            <div class="w-full bg-gray-200 rounded-full h-2">
                                                <div class="bg-blue-600 h-2 rounded-full" style="width: <?php echo e((($item->technology_readiness_level ?? 1) / 9) * 100); ?>%"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <div class="portrait-card bg-gray-50 rounded-xl p-6 text-center border border-gray-200 flex items-center justify-center">
                                <div>
                                    <p class="text-gray-500 text-sm">Belum ada inovasi yang diposting.</p>
                                    <a href="<?php echo e(route('akademisi.inovasi.create') ?? '#'); ?>" class="text-blue-600 text-sm font-medium mt-2 inline-block">Buat Inovasi Pertamamu</a>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                
                <div class="w-full">
                    <div class="flex justify-between items-center mb-3">
                        <h2 class="text-lg lg:text-xl font-semibold text-blue-900">Diskusi Terpopuler</h2>
                        <div class="flex items-center gap-4">
                            <div class="scroll-nav">
                                <button class="scroll-btn scroll-left" data-target="diskusi-scroll">
                                    <i class="fas fa-chevron-left text-xs"></i>
                                </button>
                                <button class="scroll-btn scroll-right" data-target="diskusi-scroll">
                                    <i class="fas fa-chevron-right text-xs"></i>
                                </button>
                            </div>
                            <a href="<?php echo e(route('forum-diskusi.index') ?? '#'); ?>" class="text-xs lg:text-sm text-blue-600 hover:underline font-medium">Lihat Semua</a>
                        </div>
                    </div>
                    <div class="scrolling-wrapper pb-2" id="diskusi-scroll">
                        <?php $__empty_1 = true; $__currentLoopData = $diskusiTerpopuler ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $diskusi): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <a href="<?php echo e(route('forum-diskusi.detail', ['type' => $diskusi->type ?? 'academic', 'id' => $diskusi->id]) ?? '#'); ?>" class="card-link">
                                <div class="portrait-card bg-white rounded-xl shadow-sm card-shadow border border-gray-100 overflow-hidden">
                                    
                                    <?php if($diskusi->image_path): ?>
                                        <img src="<?php echo e(asset('storage/' . $diskusi->image_path)); ?>" alt="<?php echo e($diskusi->title); ?>" class="portrait-image">
                                    <?php else: ?>
                                        <div class="portrait-default-image">
                                            <span>No Image</span>
                                        </div>
                                    <?php endif; ?>
                                    
                                    <div class="portrait-content">
                                        <div class="flex items-center justify-between mb-2">
                                            <span class="text-xs font-medium px-2 py-1 bg-purple-100 text-purple-700 rounded-full"><?php echo e(ucfirst($diskusi->type ?? 'academic')); ?></span>
                                            <span class="text-xs text-gray-500"><?php echo e($diskusi->formatted_created_at ?? $diskusi->created_at->format('d M Y')); ?></span>
                                        </div>
                                        <h3 class="font-semibold text-gray-800 mb-2 line-clamp-2 text-sm"><?php echo e($diskusi->title); ?></h3>
                                        <p class="text-xs text-gray-500 mb-2 line-clamp-2"><?php echo e($diskusi->author_name ?? 'Anonymous'); ?></p>
                                        <div class="mt-auto flex items-center justify-between">
                                            <span class="text-xs text-gray-600">
                                                <i class="fas fa-comment mr-1"></i>
                                                <?php echo e($diskusi->jumlah_komentar ?? 0); ?>

                                            </span>
                                            <span class="text-xs text-gray-600">
                                                <i class="fas fa-eye mr-1"></i>
                                                <?php echo e($diskusi->views ?? 0); ?>

                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <div class="portrait-card bg-gray-50 rounded-xl p-6 text-center border border-gray-200 flex items-center justify-center">
                                <p class="text-gray-500 text-sm">Belum ada diskusi populer.</p>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                
                <div class="w-full">
                    <div class="flex justify-between items-center mb-3">
                        <h2 class="text-lg lg:text-xl font-semibold text-blue-900">Kolaborasi Berjalan</h2>
                        <div class="flex items-center gap-4">
                            <div class="scroll-nav">
                                <button class="scroll-btn scroll-left" data-target="kolaborasi-scroll">
                                    <i class="fas fa-chevron-left text-xs"></i>
                                </button>
                                <button class="scroll-btn scroll-right" data-target="kolaborasi-scroll">
                                    <i class="fas fa-chevron-right text-xs"></i>
                                </button>
                            </div>
                            <a href="<?php echo e(route('kolaborasi.index') ?? '#'); ?>" class="text-xs lg:text-sm text-blue-600 hover:underline font-medium">Lihat Semua</a>
                        </div>
                    </div>
                    <div class="scrolling-wrapper pb-2" id="kolaborasi-scroll">
                        <?php $__empty_1 = true; $__currentLoopData = $kolaborasiBerjalan ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $kolab): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <?php if($kolab->is_active == 1): ?>
                            <a href="<?php echo e(route('kolaborasi.ide.show', $kolab->id) ?? '#'); ?>" class="card-link">
                                <div class="portrait-card bg-white rounded-xl shadow-sm card-shadow border border-gray-100 overflow-hidden">
                                    
                                    <?php if($kolab->image_path): ?>
                                        <img src="<?php echo e(asset('storage/' . $kolab->image_path)); ?>" alt="<?php echo e($kolab->judul); ?>" class="portrait-image">
                                    <?php else: ?>
                                        <div class="portrait-default-image">
                                            <span>No Image</span>
                                        </div>
                                    <?php endif; ?>
                                    
                                    <div class="portrait-content">
                                        <div class="flex items-center justify-between mb-2">
                                            <span class="text-xs font-medium px-2 py-1 bg-green-100 text-green-700 rounded-full">
                                                Aktif
                                            </span>
                                            <span class="text-xs text-gray-500"><?php echo e($kolab->formatted_created_at ?? $kolab->created_at->format('d M Y')); ?></span>
                                        </div>
                                        <h3 class="font-semibold text-gray-800 mb-2 line-clamp-2 text-sm"><?php echo e($kolab->judul); ?></h3>
                                        <p class="text-xs text-gray-500 mb-2 line-clamp-2"><?php echo e($kolab->deskripsi_singkat ?? $kolab->deskripsi); ?></p>
                                        <div class="mt-auto flex items-center justify-between">
                                            <span class="text-xs text-gray-600">
                                                <i class="fas fa-users mr-1"></i>
                                                <?php echo e($kolab->members_count ?? 0); ?>

                                            </span>
                                            <span class="text-xs text-gray-600">
                                                <i class="fas fa-tasks mr-1"></i>
                                                <?php echo e($kolab->tasks_count ?? 0); ?>

                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </a>
                            <?php endif; ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <div class="portrait-card bg-gray-50 rounded-xl p-6 text-center border border-gray-200 flex items-center justify-center">
                                <div>
                                    <p class="text-gray-500 text-sm">Belum ada kolaborasi berjalan.</p>
                                    <a href="<?php echo e(route('kolaborasi.ide.create') ?? '#'); ?>" class="text-blue-600 text-sm font-medium mt-2 inline-block">Buat Kolaborasi</a>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

        
        <div class="lg:w-1/4 lg-sidebar">
            <div class="sidebar-sticky">
                
                <div class="bg-white rounded-2xl shadow-sm p-4 lg:p-6 mb-6 border border-gray-100 w-full">
                    <h2 class="text-lg lg:text-xl font-semibold text-blue-900 mb-5">Akses Cepat</h2>
                    <div class="space-y-4">
                        <a href="<?php echo e(route('akademisi.inovasi.create') ?? '#'); ?>" 
                           class="quick-action-card block p-3 lg:p-4 rounded-lg border-l-4 border-blue-500">
                            <div class="flex items-center">
                                <div class="w-8 h-8 lg:w-10 lg:h-10 bg-blue-100 rounded-lg flex items-center justify-center mr-3">
                                    <i class="fas fa-plus text-blue-600 text-sm lg:text-base"></i>
                                </div>
                                <div>
                                    <h3 class="font-semibold text-gray-800 text-sm lg:text-base">Tambah Inovasi</h3>
                                    <p class="text-xs lg:text-sm text-gray-500">Buat inovasi baru</p>
                                </div>
                            </div>
                        </a>

                        <a href="<?php echo e(route('forum-diskusi.index') ?? '#'); ?>" 
                           class="quick-action-card block p-3 lg:p-4 rounded-lg border-l-4 border-indigo-500">
                            <div class="flex items-center">
                                <div class="w-8 h-8 lg:w-10 lg:h-10 bg-indigo-100 rounded-lg flex items-center justify-center mr-3">
                                    <i class="fas fa-comments text-indigo-600 text-sm lg:text-base"></i>
                                </div>
                                <div>
                                    <h3 class="font-semibold text-gray-800 text-sm lg:text-base">Bergabung Diskusi</h3>
                                    <p class="text-xs lg:text-sm text-gray-500">Diskusi terbaru</p>
                                </div>
                            </div>
                        </a>

                        <a href="<?php echo e(route('kolaborasi.ide.create') ?? '#'); ?>" 
                           class="quick-action-card block p-3 lg:p-4 rounded-lg border-l-4 border-emerald-500">
                            <div class="flex items-center">
                                <div class="w-8 h-8 lg:w-10 lg:h-10 bg-emerald-100 rounded-lg flex items-center justify-center mr-3">
                                    <i class="fas fa-users text-emerald-600 text-sm lg:text-base"></i>
                                </div>
                                <div>
                                    <h3 class="font-semibold text-gray-800 text-sm lg:text-base">Buat Kolaborasi</h3>
                                    <p class="text-xs lg:text-sm text-gray-500">Kolaborasi baru</p>
                                </div>
                            </div>
                        </a>

                        <a href="<?php echo e(route('akademisi.profil-akademik') ?? '#'); ?>" 
                           class="quick-action-card block p-3 lg:p-4 rounded-lg border-l-4 border-purple-500">
                            <div class="flex items-center">
                                <div class="w-8 h-8 lg:w-10 lg:h-10 bg-purple-100 rounded-lg flex items-center justify-center mr-3">
                                    <i class="fas fa-user text-purple-600 text-sm lg:text-base"></i>
                                </div>
                                <div>
                                    <h3 class="font-semibold text-gray-800 text-sm lg:text-base">Profil Saya</h3>
                                    <p class="text-xs lg:text-sm text-gray-500">Kelola profil</p>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>

                
                <div class="bg-white rounded-2xl shadow-sm p-4 lg:p-6 border border-gray-100 w-full">
                    <h2 class="text-lg lg:text-xl font-semibold text-blue-900 mb-4">Pencapaian</h2>
                    <div class="space-y-4">
                        <div class="flex items-center justify-between">
                            <span class="text-xs lg:text-sm text-gray-600">Inovasi Dibuat</span>
                            <span class="font-semibold text-blue-600"><?php echo e($stat['inovasi'] ?? 0); ?></span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-xs lg:text-sm text-gray-600">Kolaborasi Aktif</span>
                            <span class="font-semibold text-green-600"><?php echo e($stat['kolaborasi_aktif'] ?? 0); ?></span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-xs lg:text-sm text-gray-600">Diskusi Diikuti</span>
                            <span class="font-semibold text-purple-600"><?php echo e($stat['diskusi_diikuti'] ?? 0); ?></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Chart untuk seluruh user - 6 bulan terakhir
        const trendAllCtx = document.getElementById('trendAllChart');
        if (trendAllCtx) {
            new Chart(trendAllCtx, {
                type: 'bar',
                data: {
                    labels: <?php echo json_encode($trendAllLabels ?? [], 15, 512) ?>,
                    datasets: [
                        {
                            label: 'Inovasi',
                            data: <?php echo json_encode($trendAllInovasi ?? [], 15, 512) ?>,
                            backgroundColor: '#3b82f6',
                            borderColor: '#2563eb',
                            borderWidth: 1
                        },
                        {
                            label: 'Kolaborasi',
                            data: <?php echo json_encode($trendAllKolaborasi ?? [], 15, 512) ?>,
                            backgroundColor: '#10b981',
                            borderColor: '#059669',
                            borderWidth: 1
                        },
                        {
                            label: 'Program Pemerintah',
                            data: <?php echo json_encode($trendAllProgram ?? [], 15, 512) ?>,
                            backgroundColor: '#8b5cf6',
                            borderColor: '#7c3aed',
                            borderWidth: 1
                        },
                        {
                            label: 'Diskusi',
                            data: <?php echo json_encode($trendAllDiskusi ?? [], 15, 512) ?>,
                            backgroundColor: '#f59e0b',
                            borderColor: '#d97706',
                            borderWidth: 1
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: { 
                        legend: { 
                            display: true,
                            position: 'top'
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
        }

        // Bar chart untuk kategori seluruh user
        const kategoriAllCtx = document.getElementById('kategoriAllChart');
        if (kategoriAllCtx) {
            new Chart(kategoriAllCtx, {
                type: 'bar',
                data: {
                    labels: <?php echo json_encode($kategoriAllLabels ?? [], 15, 512) ?>,
                    datasets: [{
                        label: 'Jumlah Inovasi',
                        data: <?php echo json_encode($kategoriAllCounts ?? [], 15, 512) ?>,
                        backgroundColor: [
                            '#3b82f6',
                            '#ef4444',
                            '#10b981',
                            '#f59e0b'
                        ],
                        borderColor: [
                            '#2563eb',
                            '#dc2626',
                            '#059669',
                            '#d97706'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
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
        }

        // Chart untuk user yang login
        const trendMyCtx = document.getElementById('trendMyChart');
        if (trendMyCtx) {
            new Chart(trendMyCtx, {
                type: 'line',
                data: {
                    labels: <?php echo json_encode($trendMyLabels ?? [], 15, 512) ?>,
                    datasets: [
                        {
                            label: 'Inovasi Saya',
                            data: <?php echo json_encode($trendMyInovasi ?? [], 15, 512) ?>,
                            borderColor: '#8b5cf6',
                            backgroundColor: 'rgba(139,92,246,0.1)',
                            tension: 0.3,
                            fill: true
                        },
                        {
                            label: 'Kolaborasi Saya',
                            data: <?php echo json_encode($trendMyKolaborasi ?? [], 15, 512) ?>,
                            borderColor: '#f59e0b',
                            backgroundColor: 'rgba(245,158,11,0.1)',
                            tension: 0.3,
                            fill: true
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: { legend: { display: true } },
                    scales: { y: { beginAtZero: true } }
                }
            });
        }

        const kategoriMyCtx = document.getElementById('kategoriMyChart');
        if (kategoriMyCtx) {
            new Chart(kategoriMyCtx, {
                type: 'doughnut',
                data: {
                    labels: <?php echo json_encode($kategoriMyLabels ?? [], 15, 512) ?>,
                    datasets: [{
                        data: <?php echo json_encode($kategoriMyCounts ?? [], 15, 512) ?>,
                        backgroundColor: ['#8b5cf6', '#a78bfa', '#c4b5fd', '#ddd6fe', '#f3f4f6']
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: { legend: { position: 'bottom' } }
                }
            });
        }

        // Scroll functionality for cards
        const scrollContainers = ['inovasi-scroll', 'diskusi-scroll', 'kolaborasi-scroll'];
        
        scrollContainers.forEach(containerId => {
            const container = document.getElementById(containerId);
            const leftBtn = document.querySelector(`.scroll-left[data-target="${containerId}"]`);
            const rightBtn = document.querySelector(`.scroll-right[data-target="${containerId}"]`);
            
            if (container && leftBtn && rightBtn) {
                const scrollAmount = 300;
                
                leftBtn.addEventListener('click', () => {
                    container.scrollBy({ left: -scrollAmount, behavior: 'smooth' });
                });
                
                rightBtn.addEventListener('click', () => {
                    container.scrollBy({ left: scrollAmount, behavior: 'smooth' });
                });
                
                // Update button states based on scroll position
                container.addEventListener('scroll', () => {
                    leftBtn.disabled = container.scrollLeft <= 0;
                    rightBtn.disabled = container.scrollLeft + container.clientWidth >= container.scrollWidth;
                });
                
                // Initial state
                leftBtn.disabled = container.scrollLeft <= 0;
                rightBtn.disabled = container.scrollLeft + container.clientWidth >= container.scrollWidth;
            }
        });
    });
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\laragon\www\dih_website\resources\views/akademisi/index.blade.php ENDPATH**/ ?>