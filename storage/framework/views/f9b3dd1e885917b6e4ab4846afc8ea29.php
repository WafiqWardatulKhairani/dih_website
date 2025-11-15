<?php $__env->startSection('title', 'Dokumen Kolaborasi'); ?>

<?php $__env->startPush('styles'); ?>
<script src="https://cdn.tailwindcss.com"></script>
<script>
tailwind.config = {
    theme: {
        extend: {
            colors: {
                primary: '#1e3a8a',
                secondary: '#3b82f6',
                accent: '#60a5fa',
                success: '#16a34a',
                warning: '#f59e0b',
                danger: '#dc2626',
                graylight: '#f3f4f6',
            },
        },
    },
};
</script>
<style>
.page-border {
    border: 1px solid #e5e7eb;
    border-radius: 1rem;
    box-shadow: 0 6px 16px rgba(0,0,0,0.06);
    background-color: white;
    overflow: hidden;
}
td, th {
    text-align: left;
}
.table-no { width: 5%; }
.table-title { width: 40%; }
.table-uploader { width: 25%; }
.table-file { width: 20%; }
.table-category { width: 10%; }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('scripts'); ?>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
// Flash messages
<?php if(session('success')): ?>
Swal.fire({
    icon: 'success',
    title: 'Sukses',
    text: '<?php echo e(session('success')); ?>',
});
<?php endif; ?>

<?php if(session('error')): ?>
Swal.fire({
    icon: 'error',
    title: 'Gagal',
    text: '<?php echo e(session('error')); ?>',
});
<?php endif; ?>
</script>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<div class="max-w-7xl mx-auto px-4 py-8">

    <?php if(!isset($kolaborasi)): ?>
        <div class="text-center py-20 text-red-600 font-semibold">
            Kolaborasi tidak ditemukan.
        </div>
    <?php else: ?>

    
    <div class="w-full relative h-80 border-b border-gray-200 mb-8 rounded-xl overflow-hidden">
        <?php if($kolaborasi->image_path): ?>
            <img src="<?php echo e(asset('storage/' . $kolaborasi->image_path)); ?>" 
                 alt="<?php echo e($kolaborasi->title ?? 'Kolaborasi'); ?>" 
                 class="w-full h-full object-cover">
        <?php else: ?>
            <div class="w-full h-full bg-gradient-to-r from-[rgba(30,64,175,0.85)] to-[rgba(30,58,138,0.9)] flex items-center justify-center">
                <i class="fas fa-file-alt fa-3x text-blue-100 opacity-70"></i>
            </div>
        <?php endif; ?>
        <div class="absolute inset-0 bg-gradient-to-t from-[rgba(30,64,175,0.85)] to-[rgba(30,58,138,0.9)] mix-blend-multiply"></div>
    </div>

    <div class="page-border p-6 space-y-8">

        
        <div class="flex justify-between items-center mb-4">
            <div>
                <h1 class="text-3xl font-bold text-primary">Lampiran Kolaborasi</h1>
                <p class="text-gray-600">
                    Kolaborasi: 
                    <span class="font-semibold text-secondary">
                        <?php echo e($kolaborasi->title ?? 'Tanpa Judul'); ?>

                    </span>
                </p>
            </div>
        </div>

        
        <div class="flex flex-wrap items-center gap-3 mb-8">
            <a href="<?php echo e(route('kolaborasi.detail', $kolaborasi->id)); ?>" 
               class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                <i class="fas fa-home"></i> Halaman Utama Kolaborasi
            </a>
        </div>

        
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-blue-50 text-gray-800">
                    <tr>
                        <th class="px-4 py-3 text-left text-sm font-semibold table-no">No</th>
                        <th class="px-4 py-3 text-left text-sm font-semibold table-title">Judul Dokumen</th>
                        <th class="px-4 py-3 text-left text-sm font-semibold table-uploader">Uploader</th>
                        <th class="px-4 py-3 text-left text-sm font-semibold table-file">File</th>
                        <th class="px-4 py-3 text-left text-sm font-semibold table-category">Kategori</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 bg-graylight/40">
                    <?php $__empty_1 = true; $__currentLoopData = $kolaborasi->documents->sortBy('category')->sortBy('title'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $doc): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <?php
                            // Judul rapi: jika title kosong, ambil nama file tanpa extension
                            $title = $doc->title ?: pathinfo($doc->file_path, PATHINFO_FILENAME);
                            // Tambahkan prefix kategori
                            $displayTitle = '[' . ucfirst($doc->category) . '] ' . $title;
                        ?>
                        <tr class="hover:bg-graylight transition">
                            <td class="px-4 py-4"><?php echo e($loop->iteration); ?></td>
                            <td class="px-4 py-4"><?php echo e(\Illuminate\Support\Str::limit($displayTitle, 50, '...')); ?></td>
                            <td class="px-4 py-4"><?php echo e($doc->uploader->name ?? '-'); ?></td>
                            <td class="px-4 py-4">
                                <a href="<?php echo e(asset('storage/' . $doc->file_path)); ?>" target="_blank" class="text-blue-600 underline">
                                    Lihat Lampiran
                                </a>
                            </td>
                            <td class="px-4 py-4"><?php echo e(ucfirst($doc->category)); ?></td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="5" class="text-center py-6 text-gray-500">Belum ada dokumen yang diunggah.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

    </div>
    <?php endif; ?>

</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\xampp\htdocs\dih_website\resources\views/kolaborasi/documents/index.blade.php ENDPATH**/ ?>