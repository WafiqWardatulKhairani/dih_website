<?php $__env->startSection('title', 'Diskusi Inovasi'); ?>

<?php $__env->startPush('styles'); ?>
<script src="https://cdn.tailwindcss.com"></script>
<script>
tailwind.config = {
    theme: {
        extend: {
            colors: {
                primary: '#1e3a8a',
                secondary: '#1e40af',
                accent: '#3b82f6',
                dark: '#1e293b',
                light: '#f8fafc',
                success: '#059669',
                warning: '#d97706'
            }
        }
    }
}
</script>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<div class="w-full">

    <!-- HERO SECTION -->
    <section class="relative text-white py-16 overflow-hidden">
        <div class="absolute inset-0 z-0"
             style="background: linear-gradient(rgba(30,64,175,0.85), rgba(30,58,138,0.9));">
            <img src="https://i.pinimg.com/1200x/34/4b/08/344b08abcafb830d2e90193586ded579.jpg"
                 alt="Diskusi Inovasi"
                 class="w-full h-full object-cover opacity-40">
        </div>
        <div class="relative container mx-auto px-4 text-center z-10">
            <h1 class="text-2xl md:text-3xl font-bold mb-3 leading-tight hero-text-shadow">
                Jelajahi Forum Diskusi!
            </h1>
            <p class="max-w-2xl mx-auto text-sm md:text-base mb-6 opacity-90 hero-text-shadow">
                Temukan ide dan karya terbaru dari akademisi dan OPD Pekanbaru!
            </p>

            <div class="flex flex-col sm:flex-row gap-2 justify-center items-center mb-4">
                <a href="#diskusi-list"
                   class="flex items-center gap-1 px-4 py-2 bg-white text-blue-700 font-semibold rounded-lg hover:bg-gray-100 transition transform hover:scale-105 text-xs">
                    <i class="fas fa-arrow-down text-xs"></i> Lihat Diskusi
                </a>
            </div>

            <!-- SEARCH BAR -->
            <div class="bg-white/20 backdrop-blur-md p-3 rounded-lg max-w-2xl mx-auto shadow-lg">
                <form action="<?php echo e(route('forum-diskusi.index')); ?>" method="GET" class="flex gap-2">
                    <input type="text" name="search" value="<?php echo e(request('search')); ?>"
                           placeholder="Cari diskusi berdasarkan judul..."
                           class="flex-1 p-2 rounded-lg border border-white/30 bg-white/10 placeholder-white/70 text-white focus:outline-none focus:border-white/50 focus:bg-white/20 transition text-xs">
                    <button type="submit"
                            class="px-3 py-2 bg-blue-600 text-white font-semibold rounded-lg flex items-center gap-1 text-xs hover:bg-blue-700 transition">
                        <i class="fas fa-search text-xs"></i> Cari
                    </button>
                </form>
            </div>
        </div>
    </section>

    <!-- MAIN CONTENT: Daftar Diskusi -->
    <div class="container mx-auto px-3 py-6" id="diskusi-list">
        <div class="grid gap-3 grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5">
            <?php $__empty_1 = true; $__currentLoopData = $paginatedInnovations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $innovation): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <div class="innovation-card">
                   <!-- IMAGE -->
<div class="card-image relative">
    <?php if($innovation->image_path): ?>
        <img src="<?php echo e(asset('storage/'.$innovation->image_path)); ?>" 
             alt="<?php echo e($innovation->title); ?>" loading="lazy">
    <?php else: ?>
        <div class="w-full h-full bg-gradient-to-br from-blue-400 to-blue-500 flex items-center justify-center text-white text-xl">
            <i class="fas fa-lightbulb"></i>
        </div>
    <?php endif; ?>
    <span class="source-badge text-white
        <?php echo e($innovation->source_type == 'academic' ? 'bg-green-500' : 'bg-amber-500'); ?>">
        <?php echo e($innovation->source_type == 'academic' ? 'Akademik' : 'OPD'); ?>

    </span>
</div>

                    <!-- CONTENT -->
                    <div class="card-content">
                        <h3 class="card-title line-clamp-2"><?php echo e($innovation->title); ?></h3>

                        <!-- CATEGORY BADGE -->
                        <div class="flex flex-wrap gap-1">
                            <?php if($innovation->category): ?>
                                <span class="badge bg-blue-50 text-blue-700 border border-blue-200"><?php echo e(Str::limit($innovation->category, 12)); ?></span>
                            <?php endif; ?>
                        </div>

                        <!-- TRL PROGRESS -->
                        <div>
                            <div class="flex justify-between items-center text-xs text-gray-600 mb-1">
                                <span class="font-medium text-[0.6rem]">TRL:</span>
                                <span class="font-semibold text-[0.6rem]"><?php echo e($innovation->technology_readiness_level ?? '0'); ?>/9</span>
                            </div>
                            <div class="trl-bar">
                                <?php
                                    $trl = $innovation->technology_readiness_level ?? 0;
                                    $trlPercent = min(max(($trl / 9) * 100, 0), 100);
                                ?>
                                <div class="trl-fill" style="width: <?php echo e($trlPercent); ?>%"></div>
                            </div>
                        </div>

                        <!-- USER & COMMENT INFO -->
                        <div class="flex items-center justify-between mt-1">
                            <div class="user-info">
                                <i class="fas fa-user"></i>
                                <span class="truncate max-w-[60px]"><?php echo e(Str::limit($innovation->author_name ?? 'Anonim', 8)); ?></span>
                            </div>
                            
                            <?php
                                $commentCount = \DB::table('discussion_comments')
                                    ->where('innovation_id', $innovation->id)
                                    ->count();
                            ?>
                            <div class="comment-count">
                                <i class="fas fa-comment"></i>
                                <span><?php echo e($commentCount); ?></span>
                            </div>
                        </div>

                        <!-- DETAIL LINK -->
                        <a href="<?php echo e(route('forum-diskusi.detail', ['type' => $innovation->source_type, 'id' => $innovation->id])); ?>"
                           class="w-full bg-blue-600 text-white text-[0.65rem] font-semibold py-1.5 rounded text-center hover:bg-blue-700 transition mt-1 flex items-center justify-center gap-1">
                           <i class="fas fa-eye text-[0.6rem]"></i> Detail
                        </a>

                        <!-- TIMESTAMP -->
                        <div class="card-meta">
                            <span class="text-[0.6rem] text-gray-500">
                                <i class="fas fa-clock mr-0.5"></i>
                                <?php echo e(\Carbon\Carbon::parse($innovation->created_at)->shortRelativeDiffForHumans()); ?>

                            </span>
                        </div>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <div class="bg-blue-50 rounded-lg p-6 text-center border-2 border-dashed border-blue-200 col-span-full">
                    <i class="fas fa-lightbulb text-3xl text-blue-400 mb-2"></i>
                    <h3 class="text-base font-semibold text-gray-700 mb-1">Belum Ada Diskusi</h3>
                    <p class="text-gray-500 text-xs">
                        Mulai jelajahi ide dan karya terbaru dari akademisi dan OPD Pekanbaru.
                    </p>
                </div>
            <?php endif; ?>
        </div>

        <!-- PAGINATION -->
        <div class="pagination">
            <?php echo e($paginatedInnovations->appends(request()->query())->links()); ?>

        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\laragon\www\dih_website\resources\views/diskusi/diskusi.blade.php ENDPATH**/ ?>