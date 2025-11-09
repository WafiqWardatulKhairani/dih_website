<?php $__env->startSection('styles'); ?>
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
    .compact-card {
        height: fit-content;
        min-height: 380px;
    }
</style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<!-- Hero Section - Lebih Compact -->
<section class="hero-bg text-white py-12">
    <div class="container mx-auto px-4 md:px-6 text-center">
        <h1 class="text-3xl md:text-4xl font-bold mb-3 leading-tight">
            Semua <span class="text-yellow-300">Program</span>
        </h1>
        <p class="text-base md:text-lg max-w-2xl mx-auto leading-relaxed opacity-90">
            Temukan semua program prioritas daerah yang sedang berjalan.
        </p>
        <a href="<?php echo e(route('pemerintah.program.create')); ?>" 
           class="inline-flex items-center bg-green-500 text-white px-5 py-2.5 rounded-lg font-semibold hover:bg-green-600 transition mt-4 text-sm">
            📋 Posting Program Baru
        </a>
    </div>
</section>

<!-- Filter Section - Lebih Compact -->
<section class="bg-gray-50 py-6">
    <div class="container mx-auto px-4 md:px-6">
        <div class="flex flex-col md:flex-row justify-between items-center gap-4">
            <h2 class="text-xl font-bold text-dark">Daftar Program Prioritas</h2>
            <div class="flex flex-wrap gap-3">
                <select class="px-3 py-1.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary text-sm">
                    <option>Semua Kategori</option>
                    <option>Infrastruktur Digital</option>
                    <option>Smart City</option>
                    <option>Pelayanan Publik</option>
                    <option>Ekonomi Digital</option>
                </select>
                <select class="px-3 py-1.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary text-sm">
                    <option>Semua Status</option>
                    <option>Perencanaan</option>
                    <option>Berjalan</option>
                    <option>Selesai</option>
                </select>
                <button class="bg-primary text-white px-3 py-1.5 rounded-lg hover:bg-blue-700 transition text-sm">
                    🔍 Cari
                </button>
            </div>
        </div>
    </div>
</section>

<!-- Program List - 4 Cards per Row -->
<section class="bg-white py-8">
    <div class="container mx-auto px-4 md:px-6">
        <?php if($programs->count() > 0): ?>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4 md:gap-6">
                <?php $__currentLoopData = $programs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $program): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="bg-white rounded-lg shadow-md border border-gray-100 overflow-hidden card-hover compact-card">
                    <!-- Header Image -->
                    <div class="h-28 bg-gradient-to-r from-primary to-secondary relative">
                        <?php if($program->image): ?>
                            <img src="<?php echo e(asset('storage/' . $program->image)); ?>" alt="<?php echo e($program->title); ?>" class="w-full h-full object-cover">
                        <?php endif; ?>
                        <span class="absolute top-2 right-2 bg-white text-primary px-2 py-1 rounded-full text-xs font-semibold shadow-sm">
                            <?php if($program->status == 'planning'): ?> 📅 
                            <?php elseif($program->status == 'ongoing'): ?> 🚀 
                            <?php else: ?> ✅ 
                            <?php endif; ?>
                        </span>
                        <div class="absolute bottom-2 left-2">
                            <span class="bg-black/20 text-white px-1.5 py-0.5 rounded text-xs">Program</span>
                        </div>
                    </div>
                    
                    <!-- Content -->
                    <div class="p-4">
                        <!-- OPD Info -->
                        <div class="flex items-center mb-3">
                            <div class="w-8 h-8 rounded-full bg-blue-100 flex items-center justify-center text-primary font-bold text-sm">
                                <?php echo e(substr($program->opd_name, 0, 1)); ?>

                            </div>
                            <div class="ml-2">
                                <p class="text-xs font-medium text-dark truncate max-w-[120px]"><?php echo e($program->opd_name); ?></p>
                                <p class="text-xs text-gray-500">Pemkab</p>
                            </div>
                        </div>
                        
                        <!-- Title & Description -->
                        <h3 class="text-sm font-semibold text-dark mb-2 line-clamp-2 leading-tight"><?php echo e($program->title); ?></h3>
                        <p class="text-gray-600 text-xs mb-3 line-clamp-2 leading-relaxed"><?php echo e(Str::limit($program->description, 80)); ?></p>
                        
                        <!-- Progress Bar -->
                        <div class="mb-3">
                            <div class="flex justify-between text-xs text-gray-600 mb-1">
                                <span>Progress</span>
                                <span><?php echo e($program->progress); ?>%</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-1.5">
                                <div class="bg-green-500 h-1.5 rounded-full" style="width: <?php echo e($program->progress); ?>%"></div>
                            </div>
                        </div>
                        
                        <!-- Date & Budget -->
                        <div class="flex items-center justify-between mb-3">
                            <div class="flex items-center text-xs text-gray-500">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                <?php echo e($program->start_date->format('d M')); ?>

                            </div>
                            <?php if($program->budget): ?>
                            <span class="bg-green-100 text-green-700 px-1.5 py-0.5 rounded text-xs font-medium">
                                💰 <?php echo e(number_format($program->budget / 1000000, 0)); ?>JT
                            </span>
                            <?php endif; ?>
                        </div>
                        
                        <!-- Category & Actions -->
                        <div class="flex justify-between items-center pt-2 border-t border-gray-100">
                            <span class="text-xs text-gray-500 truncate max-w-[80px]"><?php echo e($program->category); ?></span>
                            <div class="flex gap-2">
                                <a href="<?php echo e(route('pemerintah.program.edit', $program->id)); ?>" 
                                   class="text-blue-600 hover:text-blue-800 text-xs font-medium">
                                    ✏️
                                </a>
                                <form action="<?php echo e(route('pemerintah.program.destroy', $program->id)); ?>" method="POST" class="inline">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('DELETE'); ?>
                                    <button type="submit" 
                                            class="text-red-600 hover:text-red-800 text-xs font-medium"
                                            onclick="return confirm('Yakin ingin menghapus program ini?')">
                                        🗑️
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
            
            <!-- Pagination - Lebih Compact -->
            <div class="mt-8">
                <?php echo e($programs->links()); ?>

            </div>
        <?php else: ?>
            <div class="text-center py-12">
                <div class="text-gray-400 text-5xl mb-3">📋</div>
                <p class="text-gray-500 text-base mb-4">Belum ada program yang diposting.</p>
                <a href="<?php echo e(route('pemerintah.program.create')); ?>" class="inline-block bg-primary text-white px-5 py-2.5 rounded-lg hover:bg-blue-700 transition text-sm">
                    📋 Posting Program Pertama
                </a>
            </div>
        <?php endif; ?>
    </div>
</section>

<style>
.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

/* Responsive adjustments */
@media (max-width: 640px) {
    .compact-card {
        min-height: 350px;
    }
}

@media (min-width: 1280px) {
    .xl\:grid-cols-4 {
        grid-template-columns: repeat(4, minmax(0, 1fr));
    }
}
</style>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\xampp\htdocs\dih_website\resources\views/pemerintah/program-list.blade.php ENDPATH**/ ?>