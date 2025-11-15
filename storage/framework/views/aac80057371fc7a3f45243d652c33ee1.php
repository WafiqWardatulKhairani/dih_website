<?php $__env->startSection('title', 'DIH - Inovasi Akademisi'); ?>

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
<style>
    /* HERO TEXT SHADOW */
    .hero-text-shadow {
        text-shadow: 2px 2px 8px rgba(0,0,0,0.7);
    }

    /* CARD STYLE */
    .innovation-card {
        transition: all 0.3s ease;
    }
    .innovation-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(0,0,0,0.15);
    }

    /* CARD IMAGE */
    .innovation-card .card-image {
        height: 13rem; /* fixed height */
        overflow: hidden;
        border-top-left-radius: 0.75rem;
        border-top-right-radius: 0.75rem;
    }
    .innovation-card .card-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.3s ease;
    }
    .innovation-card .card-image img:hover {
        transform: scale(1.05);
    }

    /* LINE CLAMP */
    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    .line-clamp-3 {
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    /* PAGINATION */
    .pagination {
        display: flex;
        gap: 0.5rem;
        justify-content: center;
        margin-top: 2rem;
    }
    .pagination a, .pagination span {
        padding: 0.5rem 0.75rem;
        border-radius: 0.375rem;
        border: 1px solid #cbd5e1;
        color: #1e3a8a;
        font-weight: 500;
        transition: all 0.2s;
    }
    .pagination a:hover {
        background-color: #1e40af;
        color: white;
        border-color: #1e40af;
    }
    .pagination .active {
        background-color: #1e3a8a;
        color: white;
        border-color: #1e3a8a;
    }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<div class="w-full">

    <!-- HERO SECTION -->
    <section class="relative text-white py-28 overflow-hidden">
        <div class="absolute inset-0 z-0"
             style="background: linear-gradient(rgba(30,64,175,0.85), rgba(30,58,138,0.9));">
            <img src="https://plus.unsplash.com/premium_photo-1727009856408-0ed31ef1e28d?ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&q=80&w=1932"
                 alt="Inovasi Akademisi"
                 class="w-full h-full object-cover opacity-40">
        </div>
        <div class="relative container mx-auto px-4 text-center z-10">
            <h1 class="text-4xl md:text-5xl font-extrabold mb-4 leading-tight hero-text-shadow">
                Inovasi Akademisi Pekanbaru
            </h1>
            <p class="max-w-3xl mx-auto text-lg md:text-xl mb-10 opacity-90 hero-text-shadow">
                Mulailah berpartisipasi dalam memberikan inovasimu!
            </p>

            <div class="flex flex-col sm:flex-row gap-4 justify-center items-center mb-8">
                <a href="<?php echo e(route('akademisi.inovasi.create')); ?>"
                   class="flex items-center gap-2 px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg transition-all transform hover:-translate-y-1 shadow-lg">
                    <i class="fas fa-plus"></i> Posting Inovasi Baru
                </a>
                <a href="#inovasi-saya"
                   class="flex items-center gap-2 px-6 py-3 bg-white text-blue-700 font-semibold rounded-lg hover:bg-gray-100 transition transform hover:scale-105">
                    <i class="fas fa-arrow-down"></i> Lihat Inovasi Saya
                </a>
            </div>

            <!-- SEARCH BAR -->
            <div class="bg-white/20 backdrop-blur-md p-6 rounded-xl max-w-4xl mx-auto shadow-lg">
                <form action="<?php echo e(route('akademisi.inovasi.index')); ?>" method="GET" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-1 gap-4">
                    <input type="text" name="q" value="<?php echo e(request('q')); ?>"
                           placeholder="Cari inovasi berdasarkan judul..."
                           class="w-full p-3 rounded-lg border border-white/30 bg-white/10 placeholder-white/70 text-white focus:outline-none focus:border-white/50 focus:bg-white/20 transition">
                    <div class="flex justify-center md:justify-start">
                        <button type="submit"
                                class="px-6 py-2 bg-blue-600 text-white font-semibold rounded-lg flex items-center gap-2 text-sm hover:bg-blue-700 transition transform hover:-translate-y-1">
                            <i class="fas fa-search"></i> Cari
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </section>

    <!-- MAIN CONTENT: Inovasi Saya -->
    <div class="container mx-auto px-4 py-14 mt-8" id="inovasi-saya">
        <div class="flex justify-between items-center mb-8">
            <div class="flex items-center gap-4">
                <div class="bg-green-500 p-4 rounded-lg text-white text-2xl">
                    <i class="fas fa-lightbulb text-yellow-300"></i>
                </div>
                <div>
                    <h2 class="text-2xl font-bold text-gray-800">Inovasi Saya</h2>
                    <p class="text-gray-600 text-sm mt-1">Kelola dan lihat semua inovasi yang telah Anda posting</p>
                </div>
            </div>
        </div>

        <?php if(request('q')): ?>
            <div class="mb-6 text-gray-700">
                <p>
                    Menampilkan hasil pencarian untuk judul: <span class="font-semibold"><?php echo e(request('q')); ?></span>
                </p>
            </div>
        <?php endif; ?>

        <div class="grid gap-6 grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4">
            <?php $__empty_1 = true; $__currentLoopData = $paginatedInnovations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <div class="bg-indigo-50 rounded-xl shadow innovation-card flex flex-col overflow-hidden">
                    <div class="card-image relative">
                        <?php if($item->image_path): ?>
                            <img src="<?php echo e(asset('storage/'.$item->image_path)); ?>" alt="<?php echo e($item->title); ?>" loading="lazy">
                        <?php else: ?>
                            <div class="w-full h-full bg-blue-500 flex items-center justify-center text-yellow-300 text-4xl">
                                <i class="fas fa-lightbulb"></i>
                            </div>
                        <?php endif; ?>
                        <span class="absolute top-3 right-3 px-2 py-1 rounded text-xs font-semibold text-white
                            <?php echo e($item->status == 'published' ? 'bg-yellow-400' : 'bg-green-500'); ?>">
                            <?php echo e(ucfirst($item->status)); ?>

                        </span>
                    </div>
                    <div class="p-4 flex flex-col flex-1">
                        <h3 class="font-semibold text-gray-800 text-lg line-clamp-2"><?php echo e($item->title); ?></h3>
                        <p class="text-gray-600 text-sm line-clamp-3 my-2 mb-8">
                            <?php echo e(Str::limit($item->description, 120)); ?>

                        </p>
                        <div class="mt-auto flex gap-2">
                            <a href="<?php echo e(route('akademisi.inovasi.show', $item->id)); ?>"
                               class="flex-1 bg-blue-600 text-white text-sm font-semibold py-2 rounded-lg text-center hover:bg-blue-700 transition">
                                Lihat
                            </a>
                            <a href="<?php echo e(route('akademisi.inovasi.edit', $item->id)); ?>"
                               class="flex-1 bg-indigo-200 text-gray-700 text-sm font-semibold py-2 rounded-lg text-center hover:bg-indigo-300 transition">
                                Edit
                            </a>
                        </div>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <div class="bg-indigo-50 rounded-xl p-12 text-center border-2 border-dashed border-indigo-300 col-span-full">
                    <i class="fas fa-lightbulb text-5xl text-yellow-300 mb-4"></i>
                    <?php if(request('q')): ?>
                        <h3 class="text-xl font-semibold text-gray-700 mb-2">Tidak ditemukan inovasi dengan judul:</h3>
                        <p class="text-gray-500 mb-6 font-semibold"><?php echo e(request('q')); ?></p>
                    <?php else: ?>
                        <h3 class="text-xl font-semibold text-gray-700 mb-2">Belum Ada Inovasi</h3>
                        <p class="text-gray-500 mb-6">
                            Mulai bagikan karya dan penelitian Anda sekarang! Posting inovasi pertama Anda dan inspirasi komunitas.
                        </p>
                    <?php endif; ?>
                    <a href="<?php echo e(route('akademisi.inovasi.create')); ?>"
                       class="inline-flex items-center gap-2 px-6 py-3 bg-blue-600 text-white font-semibold rounded-lg shadow hover:bg-blue-700 transition transform hover:-translate-y-1">
                        <i class="fas fa-plus"></i> Posting Inovasi
                    </a>
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

<?php $__env->startPush('scripts'); ?>
<script>
    // Smooth scroll ke bagian "Inovasi Saya"
    const scrollLink = document.querySelector('a[href="#inovasi-saya"]');
    if(scrollLink){
        scrollLink.addEventListener('click', function(e){
            e.preventDefault();
            document.querySelector('#inovasi-saya').scrollIntoView({ behavior: 'smooth' });
        });
    }
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\laragon\www\dih_website\resources\views/akademisi/inovasi_index.blade.php ENDPATH**/ ?>