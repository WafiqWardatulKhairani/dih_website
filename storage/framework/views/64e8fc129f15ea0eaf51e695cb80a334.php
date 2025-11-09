<?php $__env->startSection('styles'); ?>
<style>
    .section-title {
        position: relative;
        padding-bottom: 1rem;
    }

    .section-title::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 50%;
        transform: translateX(-50%);
        width: 60px;
        height: 3px;
        background: #3b82f6;
        border-radius: 2px;
    }

    .card-hover {
        transition: all 0.3s ease;
    }

    .card-hover:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }

    .contact-icon {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1rem;
    }
</style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<!-- Hero Section -->
<section class="hero-section text-white py-16">
    <div class="container mx-auto px-4 text-center">
        <h1 class="text-3xl md:text-4xl font-bold mb-4">
            Tentang Digital Innovation Hub
        </h1>
        <p class="text-lg opacity-95 max-w-2xl mx-auto leading-relaxed mb-6">
            Platform kolaborasi inovatif antara pemerintah daerah dan akademisi untuk menciptakan solusi digital
            yang mempercepat transformasi digital daerah dan meningkatkan kualitas pelayanan publik.
        </p>
        <div class="mt-6">
            <a href="#contact" class="inline-flex items-center bg-white text-blue-700 px-5 py-2.5 rounded-lg font-semibold hover:bg-blue-50 transition duration-300 shadow-sm text-sm">
                <i class="fas fa-comments mr-2"></i>
                Hubungi Kami
            </a>
        </div>
    </div>
</section>

<!-- About Content -->
<section class="bg-gray-50 py-12">
    <div class="container mx-auto px-4">
        <div class="max-w-3xl mx-auto">
            <div class="text-center mb-8">
                <h2 class="text-2xl font-bold text-gray-900 mb-3 section-title">Digital Innovation Hub</h2>
                <p class="text-gray-700 max-w-xl mx-auto text-sm">
                    Digital Innovation Hub merupakan platform kolaborasi yang menghubungkan pemerintah daerah dengan
                    dunia akademik untuk menciptakan solusi inovatif dalam menghadapi tantangan digitalisasi pemerintahan.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                <div class="bg-white rounded-lg p-5 shadow-sm card-hover">
                    <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center mb-3">
                        <i class="fas fa-handshake text-blue-600"></i>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 mb-2">Kolaborasi Strategis</h3>
                    <p class="text-gray-700 text-sm">
                        Menjembatani kebutuhan riil pemerintah daerah dengan kemampuan riset dan inovasi dari institusi akademik.
                    </p>
                </div>

                <div class="bg-white rounded-lg p-5 shadow-sm card-hover">
                    <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center mb-3">
                        <i class="fas fa-lightbulb text-green-600"></i>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 mb-2">Inovasi Berkelanjutan</h3>
                    <p class="text-gray-700 text-sm">
                        Menciptakan ekosistem inovasi yang berkelanjutan melalui program-program terstruktur dan terukur.
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Visi Misi Section -->
<section class="bg-white py-12">
    <div class="container mx-auto px-4">
        <div class="max-w-3xl mx-auto">
            <!-- Visi -->
            <div class="border-l-4 border-blue-500 rounded-lg p-6 mb-6 shadow-sm card-hover bg-white">
                <div class="flex items-start">
                    <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center mr-3 flex-shrink-0">
                        <i class="fas fa-bullseye text-blue-600"></i>
                    </div>
                    <div>
                        <h2 class="text-xl font-bold text-gray-900 mb-2">Visi</h2>
                        <p class="text-gray-700 leading-relaxed text-sm">
                            Menjadi platform terdepan dalam mendorong kolaborasi antara pemerintah daerah dan akademisi
                            untuk menciptakan inovasi digital yang mempercepat transformasi digital daerah dan meningkatkan
                            kualitas pelayanan publik secara berkelanjutan.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Misi -->
            <div class="border-l-4 border-green-500 rounded-lg p-6 shadow-sm card-hover bg-white">
                <div class="flex items-start">
                    <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center mr-3 flex-shrink-0">
                        <i class="fas fa-flag text-green-600"></i>
                    </div>
                    <div>
                        <h2 class="text-xl font-bold text-gray-900 mb-3">Misi</h2>
                        <div class="space-y-3">
                            <?php $__currentLoopData = [
                            'Memfasilitasi pertemuan antara kebutuhan riil pemerintah daerah dengan solusi inovatif dari akademisi',
                            'Mendorong terciptanya ekosistem inovasi digital yang berkelanjutan di tingkat daerah',
                            'Mempercepat adopsi teknologi digital dalam pelayanan publik',
                            'Meningkatkan kapasitas digital pemerintah daerah melalui kolaborasi dengan akademisi',
                            'Mengembangkan model kolaborasi yang efektif antara pemerintah, akademisi, dan masyarakat'
                            ]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $mission): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="flex items-start">
                                <i class="fas fa-check-circle text-green-500 mt-0.5 mr-2 flex-shrink-0 text-sm"></i>
                                <p class="text-gray-700 text-sm"><?php echo e($mission); ?></p>
                            </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Team Section -->
<section class="bg-gray-50 py-12">
    <div class="container mx-auto px-4">
        <div class="text-center mb-8">
            <h2 class="text-2xl font-bold text-gray-900 mb-2 section-title">Tim Pengelola</h2>
            <p class="text-gray-600 max-w-xl mx-auto text-sm">
                Dikelola oleh tim profesional yang berdedikasi untuk memastikan keberhasilan kolaborasi antara pemerintah dan akademisi.
            </p>
        </div>

        <div class="max-w-6xl mx-auto">
            <!-- Desktop View -->
            <div class="hidden md:grid md:grid-cols-3 lg:grid-cols-5 gap-4">
                <?php $__currentLoopData = [
                ['name' => 'Yanti Andriyani', 'role' => 'Project Lead', 'color' => 'from-blue-500 to-blue-600', 'icon' => 'fas fa-users'],
                ['name' => 'Sonya Meitarice', 'role' => 'Tech Lead', 'color' => 'from-purple-500 to-purple-600', 'icon' => 'fas fa-laptop-code'],
                ['name' => 'Yulia Andriani', 'role' => 'Tech Lead', 'color' => 'from-orange-500 to-orange-600', 'icon' => 'fas fa-chart-line'],
                ['name' => 'Mirdatul Husnah', 'role' => 'UI/UX Designer', 'color' => 'from-pink-500 to-pink-600', 'icon' => 'fas fa-palette'],
                ['name' => 'Intan Nabilah', 'role' => 'UI/UX Designer', 'color' => 'from-red-500 to-red-600', 'icon' => 'fas fa-chart-bar']
                ]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $member): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="bg-white rounded-lg p-4 text-center card-hover">
                    <div class="w-16 h-16 bg-gradient-to-br <?php echo e($member['color']); ?> rounded-full mx-auto mb-3 flex items-center justify-center text-white shadow-md">
                        <i class="<?php echo e($member['icon']); ?>"></i>
                    </div>
                    <h3 class="font-bold text-gray-900 text-sm mb-1"><?php echo e($member['name']); ?></h3>
                    <p class="text-blue-600 font-medium text-xs"><?php echo e($member['role']); ?></p>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>

            <div class="hidden md:grid md:grid-cols-2 lg:grid-cols-4 gap-4 mt-4">
                <?php $__currentLoopData = [
                ['name' => 'Reni Fitriyani', 'role' => 'Programmer', 'color' => 'from-green-500 to-green-600', 'icon' => 'fas fa-code'],
                ['name' => 'Wafiq Wardatul Khairani', 'role' => 'Programmer', 'color' => 'from-teal-500 to-teal-600', 'icon' => 'fas fa-database'],
                ['name' => 'Mutia Rizkianti Ruslan', 'role' => 'Programmer', 'color' => 'from-indigo-500 to-indigo-600', 'icon' => 'fas fa-mobile-alt'],
                ['name' => 'Rahmat Hidayat', 'role' => 'Programmer', 'color' => 'from-emerald-500 to-emerald-600', 'icon' => 'fas fa-server']
                ]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $member): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="bg-white rounded-lg p-4 text-center card-hover">
                    <div class="w-16 h-16 bg-gradient-to-br <?php echo e($member['color']); ?> rounded-full mx-auto mb-3 flex items-center justify-center text-white shadow-md">
                        <i class="<?php echo e($member['icon']); ?>"></i>
                    </div>
                    <h3 class="font-bold text-gray-900 text-sm mb-1"><?php echo e($member['name']); ?></h3>
                    <p class="text-green-600 font-medium text-xs"><?php echo e($member['role']); ?></p>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>

            <!-- Mobile View -->
            <div class="md:hidden flex space-x-4 overflow-x-auto pb-4 -mx-4 px-4">
                <?php $__currentLoopData = [
                ['name' => 'Yanti Andriyani', 'role' => 'Project Lead', 'color' => 'from-blue-500 to-blue-600', 'icon' => 'fas fa-users'],
                ['name' => 'Sonya Meitarice', 'role' => 'Tech Lead', 'color' => 'from-purple-500 to-purple-600', 'icon' => 'fas fa-laptop-code'],
                ['name' => 'Yulia Andriani', 'role' => 'Tech Lead', 'color' => 'from-orange-500 to-orange-600', 'icon' => 'fas fa-laptop-code'],
                ['name' => 'Mirdatul Husnah', 'role' => 'UI/UX Designer', 'color' => 'from-pink-500 to-pink-600', 'icon' => 'fas fa-palette'],
                ['name' => 'Intan Nabilah', 'role' => 'UI/UX Designer', 'color' => 'from-red-500 to-red-600', 'icon' => 'fas fa-palette'],
                ['name' => 'Reni Fitriyani', 'role' => 'Programmer', 'color' => 'from-green-500 to-green-600', 'icon' => 'fas fa-code'],
                ['name' => 'Wafiq Wardatul Khairani', 'role' => 'Programmer', 'color' => 'from-teal-500 to-teal-600', 'icon' => 'fas fa-code'],
                ['name' => 'Mutia Rizkianti Ruslan', 'role' => 'Programmer', 'color' => 'from-indigo-500 to-indigo-600', 'icon' => 'fas fa-code'],
                ['name' => 'Rahmat Hidayat', 'role' => 'Programmer', 'color' => 'from-emerald-500 to-emerald-600', 'icon' => 'fas fa-code']
                ]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $member): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="bg-white rounded-lg p-4 text-center card-hover min-w-[140px] flex-shrink-0">
                    <div class="w-12 h-12 bg-gradient-to-br <?php echo e($member['color']); ?> rounded-full mx-auto mb-2 flex items-center justify-center text-white shadow-sm">
                        <i class="<?php echo e($member['icon']); ?> text-sm"></i>
                    </div>
                    <h3 class="font-semibold text-gray-900 text-xs mb-1 leading-tight"><?php echo e($member['name']); ?></h3>
                    <p class="text-blue-600 font-medium text-xs"><?php echo e($member['role']); ?></p>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>
    </div>
</section>

<!-- Partners Section -->
<section class="bg-white py-12">
    <div class="container mx-auto px-4">
        <div class="text-center mb-8">
            <h2 class="text-2xl font-bold text-gray-900 mb-2 section-title">Mitra Kerja Sama</h2>
            <p class="text-gray-600 max-w-xl mx-auto text-sm">
                Berkolaborasi dengan institusi pendidikan dan pemerintah terkemuka untuk menciptakan solusi inovatif.
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 max-w-2xl mx-auto">
            <?php $__currentLoopData = [
            ['name' => 'Badan Penelitian dan Pengembangan', 'abbr' => 'Badan Penelitian dan Pengembangan'],
            ['name' => 'Usaha Mikro Kecil Menengah', 'abbr' => 'Usaha Mikro Kecil Menengah Pekanbaru'],
            ['name' => 'Fakultas Matematika dan Ilmu Pengetahuan', 'abbr' => 'Fakultas Matematika dan Ilmu Pengetahuan'],
            ['name' => 'Universitas Riau', 'abbr' => 'Universitas Riau'],
            ]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $partner): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="bg-gray-50 rounded-lg p-4 flex items-center justify-center h-20 card-hover border border-gray-200">
                <span class="text-gray-700 font-medium text-center text-xs leading-tight"><?php echo e($partner['abbr']); ?></span>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
</section>

<!-- Contact Section -->
<section id="contact" class="bg-gray-50 py-12">
    <div class="container mx-auto px-4">
        <div class="max-w-3xl mx-auto">
            <div class="text-center mb-8">
                <h2 class="text-2xl font-bold text-gray-900 mb-2 section-title">Hubungi Kami</h2>
                <p class="text-gray-600 max-w-xl mx-auto text-sm">
                    Mari berkolaborasi untuk menciptakan solusi inovatif bagi daerah Anda.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div class="text-center">
                    <div class="contact-icon bg-blue-100">
                        <i class="fas fa-phone text-blue-600"></i>
                    </div>
                    <h3 class="font-semibold text-gray-900 text-sm mb-1">Telepon</h3>
                    <p class="text-gray-600 text-sm">(021) 123-4567</p>
                    <p class="text-gray-500 text-xs mt-1">Senin - Jumat, 08:00 - 17:00 WIB</p>
                </div>

                <div class="text-center">
                    <div class="contact-icon bg-green-100">
                        <i class="fas fa-envelope text-green-600"></i>
                    </div>
                    <h3 class="font-semibold text-gray-900 text-sm mb-1">Email</h3>
                    <p class="text-gray-600 text-sm">info@digitalinnovationhub.go.id</p>
                    <p class="text-gray-500 text-xs mt-1">Respon dalam 1-2 hari kerja</p>
                </div>

                <div class="text-center">
                    <div class="contact-icon bg-purple-100">
                        <i class="fas fa-map-marker-alt text-purple-600"></i>
                    </div>
                    <h3 class="font-semibold text-gray-900 text-sm mb-1">Lokasi</h3>
                    <p class="text-gray-600 text-sm">Gedung Kementerian XYZ</p>
                    <p class="text-gray-500 text-xs mt-1">Jl. Merdeka No. 123, Jakarta Pusat</p>
                </div>
            </div>

            <div class="text-center">
                <a href="mailto:info@digitalinnovationhub.go.id" class="inline-flex items-center bg-blue-600 text-white px-6 py-2 rounded-lg font-semibold hover:bg-blue-700 transition duration-300 shadow-sm text-sm mr-3">
                    <i class="fas fa-envelope mr-1"></i>
                    Kirim Pesan
                </a>
                <a href="#" class="inline-flex items-center bg-white text-blue-600 border border-blue-600 px-6 py-2 rounded-lg font-semibold hover:bg-blue-50 transition duration-300 text-sm">
                    <i class="fas fa-download mr-1"></i>
                    Unduh Profil
                </a>
            </div>
        </div>
    </div>
</section>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\xampp\htdocs\dih_website\resources\views/landing/tentang.blade.php ENDPATH**/ ?>