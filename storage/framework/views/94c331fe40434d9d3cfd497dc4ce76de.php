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
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
    }
</style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<!-- Hero Section -->
<section class="hero-bg text-white py-12">
    <div class="container mx-auto px-6 md:px-12">
        <div class="flex items-center justify-between">
            <div>
                <a href="<?php echo e(route('pemerintah.program')); ?>" class="inline-flex items-center text-green-100 hover:text-white mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                    Kembali ke Inovasi
                </a>
                <h1 class="text-3xl md:text-4xl font-bold mb-2"><?php echo e($innovation->title); ?></h1>
                <p class="text-green-100 text-lg"><?php echo e($innovation->institution); ?></p>
            </div>
            <div class="text-right">
                <span class="bg-white text-green-600 px-4 py-2 rounded-full text-sm font-semibold mb-2 block">
                    <?php if($innovation->status == 'prototype'): ?> 🔧 Prototype
                    <?php elseif($innovation->status == 'ready'): ?> ✅ Siap Implementasi
                    <?php elseif($innovation->status == 'implemented'): ?> 🚀 Sudah Diimplementasikan
                    <?php else: ?> 🔬 Research
                    <?php endif; ?>
                </span>
                <?php if($innovation->is_verified): ?>
                <span class="bg-green-500 text-white px-3 py-1 rounded-full text-xs font-medium">
                    ✓ Terverifikasi
                </span>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>

<!-- Content Section -->
<section class="bg-white py-8">
    <div class="container mx-auto px-6 md:px-12">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Main Content -->
            <div class="lg:col-span-2">
                <?php if($innovation->image): ?>
                <div class="mb-6">
                    <img src="<?php echo e(asset('storage/' . $innovation->image)); ?>" alt="<?php echo e($innovation->title); ?>"
                        class="w-full h-64 object-cover rounded-lg shadow-md">
                </div>
                <?php endif; ?>

                <div class="prose max-w-none">
                    <h3 class="text-xl font-semibold mb-4">Deskripsi Inovasi</h3>
                    <p class="text-gray-700 leading-relaxed"><?php echo e($innovation->description); ?></p>
                </div>


            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                <!-- Info Box -->
                <div class="bg-green-50 border border-green-200 rounded-lg p-6">
                    <h4 class="font-semibold text-green-800 mb-4">Informasi Inovasi</h4>
                    <div class="space-y-3">
                        <div>
                            <span class="text-green-600 text-sm">Kategori:</span>
                            <p class="font-medium"><?php echo e($innovation->category); ?></p>
                        </div>
                        <div>
                            <span class="text-green-600 text-sm">Institusi:</span>
                            <p class="font-medium"><?php echo e($innovation->institution); ?></p>
                        </div>
                        <div>
                            <span class="text-green-600 text-sm">Jenis Inovasi:</span>
                            <p class="font-medium capitalize"><?php echo e($innovation->innovation_type); ?></p>
                        </div>
                        <div>
                            <span class="text-green-600 text-sm">Status Inovasi:</span>
                            <p class="font-medium">
                                <?php switch($innovation->status):
                                case ('draft'): ?>
                                <span class="text-gray-600">📝 Draft</span>
                                <?php break; ?>

                                <?php case ('review'): ?>
                                <span class="text-yellow-600">🔍 Sedang Direview</span>
                                <?php break; ?>

                                <?php case ('publication'): ?>
                                <span class="text-green-600">✅ Terpublikasi</span>
                                <?php break; ?>

                                <?php default: ?>
                                <span class="text-gray-600"><?php echo e(ucfirst($innovation->status)); ?></span>
                                <?php endswitch; ?>
                            </p>
                        </div>

                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="bg-white border border-gray-200 rounded-lg p-6">
                    <h4 class="font-semibold text-dark mb-4">Aksi</h4>
                    <div class="space-y-3">
                        <a href="<?php echo e(route('pemerintah.inovasi.edit', $innovation->id)); ?>"
                            class="w-full inline-flex justify-center items-center bg-primary text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">
                            ✏️ Edit Inovasi
                        </a>
                        <form action="<?php echo e(route('pemerintah.inovasi.destroy', $innovation->id)); ?>" method="POST" class="inline w-full">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('DELETE'); ?>
                            <button type="submit"
                                class="w-full inline-flex justify-center items-center bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700 transition"
                                onclick="return confirm('Yakin ingin menghapus inovasi ini?')">
                                🗑️ Hapus Inovasi
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Status Info -->
                <div class="bg-blue-50 border border-blue-200 rounded-lg p-6">
                    <h4 class="font-semibold text-blue-800 mb-2">Status Kesiapan Teknologi</h4>
                    <div class="flex items-center">
                        <div class="w-3 h-3 bg-blue-500 rounded-full mr-2"></div>
                        <span class="text-blue-700">
                            <?php if($innovation->technology_readiness_level <= 3): ?>
                                Dalam tahap penelitian
                                <?php elseif($innovation->technology_readiness_level <= 5): ?>
                                    Sudah memiliki prototype
                                    <?php elseif($innovation->technology_readiness_level <= 7): ?>
                                        Siap diimplementasikan
                                    <?php else: ?>
                                Sudah diimplementasikan
                            <?php endif; ?>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\xampp\htdocs\dih_website\resources\views/pemerintah/innovation-detail.blade.php ENDPATH**/ ?>