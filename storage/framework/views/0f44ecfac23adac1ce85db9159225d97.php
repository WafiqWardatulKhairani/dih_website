<?php $__env->startSection('content'); ?>
<div class="min-h-screen bg-gradient-to-br from-blue-50 to-indigo-100 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Profil Saya</h1>
            <p class="text-gray-600 mt-2">Kelola informasi profil dan lihat aktivitas Anda</p>
        </div>

        <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
            <!-- Tab Navigation -->
            <div class="border-b border-gray-200">
                <nav class="flex space-x-8 px-6" aria-label="Tabs">
                    <button id="tab-profile" class="tab-button py-4 px-1 border-b-2 font-medium text-sm flex items-center space-x-2 transition-all duration-300 active text-blue-600 border-blue-500">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                        <span>Profil Saya</span>
                    </button>
                    <button id="tab-activity" class="tab-button py-4 px-1 border-b-2 font-medium text-sm flex items-center space-x-2 transition-all duration-300 text-gray-500 border-transparent">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                        </svg>
                        <span>Aktivitas Saya</span>
                    </button>
                </nav>
            </div>

            <!-- Content Area -->
            <div class="p-8">
                
                <div id="content-profile" class="space-y-6">
                    <!-- Header Profile -->
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-6">
                            <div class="relative">
                                <div class="w-20 h-20 bg-gradient-to-r from-blue-500 to-purple-600 rounded-full flex items-center justify-center text-white text-2xl font-bold shadow-lg">
                                    <?php echo e(strtoupper(substr($user->name, 0, 1))); ?>

                                </div>
                                <div class="absolute bottom-0 right-0 w-6 h-6 bg-green-500 border-2 border-white rounded-full"></div>
                            </div>
                            <div>
                                <h2 class="text-2xl font-bold text-gray-900"><?php echo e($user->name); ?></h2>
                                <p class="text-gray-600"><?php echo e($user->institution_name); ?></p>
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800 mt-2">
                                    <?php echo e(ucfirst($user->role)); ?>

                                </span>
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="text-sm text-gray-500">Bergabung sejak</p>
                            <p class="text-sm font-medium text-gray-900"><?php echo e($user->created_at->format('d M Y')); ?></p>
                            <p class="text-xs text-gray-400 mt-1">Member <?php echo e($user->created_at->diffForHumans()); ?></p>
                        </div>
                    </div>

                    <form action="<?php echo e(route('profile.update')); ?>" method="POST" enctype="multipart/form-data" class="space-y-6">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('PATCH'); ?>

                        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                            <!-- Kolom 1: Informasi Pribadi & Institusi -->
                            <div class="lg:col-span-2 space-y-6">
                                <!-- Informasi Pribadi -->
                                <div class="bg-white rounded-xl p-6 border border-gray-200 shadow-sm">
                                    <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center space-x-2">
                                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                        </svg>
                                        <span>Informasi Pribadi</span>
                                    </h3>

                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-2">Nama Lengkap *</label>
                                            <input type="text" name="name" value="<?php echo e(old('name', $user->name)); ?>" required
                                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-300"
                                                placeholder="Masukkan nama lengkap">
                                        </div>

                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                                            <input type="email" value="<?php echo e($user->email); ?>"
                                                class="w-full px-4 py-3 border border-gray-300 rounded-lg bg-gray-100 cursor-not-allowed" readonly>
                                            <p class="text-xs text-gray-500 mt-1">Email tidak dapat diubah</p>
                                        </div>

                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-2">Nomor HP</label>
                                            <input type="text" name="phone" value="<?php echo e(old('phone', $user->phone)); ?>"
                                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-300"
                                                placeholder="Contoh: 081234567890">
                                        </div>

                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-2">Role</label>
                                            <input type="text" value="<?php echo e(ucfirst($user->role)); ?>"
                                                class="w-full px-4 py-3 border border-gray-300 rounded-lg bg-gray-100 cursor-not-allowed" readonly>
                                        </div>
                                    </div>
                                </div>

                                <!-- Informasi Institusi -->
                                <div class="bg-white rounded-xl p-6 border border-gray-200 shadow-sm">
                                    <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center space-x-2">
                                        <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                        </svg>
                                        <span>Informasi Institusi</span>
                                    </h3>

                                    <div class="space-y-4">
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-2">Nama Institusi *</label>
                                            <input type="text" name="institution_name" value="<?php echo e(old('institution_name', $user->institution_name)); ?>" required
                                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-300"
                                                placeholder="Nama instansi/organisasi">
                                        </div>

                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-2">Alamat Institusi</label>
                                            <textarea name="address" rows="3"
                                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-300"
                                                placeholder="Alamat lengkap institusi"><?php echo e(old('address', $user->address)); ?></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Kolom 2: Dokumen & Info Akun -->
                            <div class="space-y-6">
                                <!-- Dokumen -->
                                <div class="bg-white rounded-xl p-6 border border-gray-200 shadow-sm">
                                    <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center space-x-2">
                                        <svg class="w-5 h-5 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                        </svg>
                                        <span>Dokumen Verifikasi</span>
                                    </h3>

                                    <div class="space-y-4">
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-2">Status Dokumen</label>
                                            <?php if($user->document_path): ?>
                                            <div class="bg-green-50 border border-green-200 rounded-lg p-4">
                                                <div class="flex items-center space-x-3">
                                                    <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                    </svg>
                                                    <div class="flex-1">
                                                        <p class="text-sm font-medium text-green-900">Dokumen Terverifikasi</p>
                                                        <p class="text-xs text-green-700">Dokumen Anda sudah diverifikasi sistem</p>
                                                    </div>
                                                </div>
                                                <div class="mt-3 flex space-x-2">
                                                    <a href="<?php echo e(asset('storage/' . $user->document_path)); ?>" target="_blank"
                                                        class="flex-1 text-center px-3 py-2 bg-green-600 text-white text-sm rounded-lg hover:bg-green-700 transition-colors">
                                                        📄 Lihat Dokumen
                                                    </a>
                                                </div>
                                            </div>
                                            <?php else: ?>
                                            <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 text-center">
                                                <svg class="w-12 h-12 text-yellow-500 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                                                </svg>
                                                <p class="text-sm font-medium text-yellow-800 mb-1">Belum Ada Dokumen</p>
                                                <p class="text-xs text-yellow-700">Upload dokumen untuk verifikasi akun</p>
                                            </div>
                                            <?php endif; ?>
                                        </div>

                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-2">Upload Dokumen Baru</label>
                                            <div class="border-2 border-dashed border-gray-300 rounded-lg p-4 hover:border-blue-400 transition-colors">
                                                <input type="file" name="document_path"
                                                    class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                                            </div>
                                            <div class="mt-2 text-xs text-gray-500 space-y-1">
                                                <p>📎 Format yang didukung: PDF, DOC, DOCX</p>
                                                <p>💾 Ukuran maksimal: 2MB</p>
                                                <p>✅ Dokumen: KTP, Surat Tugas, atau Kartu Identitas</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Info Akun -->
                                <div class="bg-blue-50 rounded-xl p-6 border border-blue-200">
                                    <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center space-x-2">
                                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        <span>Info Akun</span>
                                    </h3>

                                    <div class="space-y-3">
                                        <div class="flex justify-between items-center py-2 border-b border-blue-100">
                                            <span class="text-sm text-gray-600">Status Akun</span>
                                            <span class="px-2 py-1 bg-green-100 text-green-800 text-xs rounded-full font-medium">
                                                ✅ Aktif
                                            </span>
                                        </div>

                                        <div class="flex justify-between items-center py-2 border-b border-blue-100">
                                            <span class="text-sm text-gray-600">Verifikasi Email</span>
                                            <span class="px-2 py-1 bg-green-100 text-green-800 text-xs rounded-full font-medium">
                                                ✅ Terverifikasi
                                            </span>
                                        </div>

                                        <div class="flex justify-between items-center py-2">
                                            <span class="text-sm text-gray-600">Bergabung</span>
                                            <span class="text-sm text-gray-900"><?php echo e($user->created_at->diffForHumans()); ?></span>
                                        </div>

                                        <div class="mt-4 p-3 bg-white rounded-lg border border-blue-200">
                                            <p class="text-xs text-blue-700 text-center">
                                                💡 Pastikan informasi profil selalu terupdate untuk kelancaran aktivitas
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="flex justify-end space-x-4 pt-6 border-t border-gray-200">
                            <a href="<?php echo e(url()->previous()); ?>"
                                class="px-6 py-3 border border-gray-300 text-gray-700 rounded-lg font-medium hover:bg-gray-50 transition-colors">
                                ↶ Kembali
                            </a>
                            <button type="submit"
                                class="px-8 py-3 bg-blue-600 text-white rounded-lg font-medium hover:bg-blue-700 transition-colors shadow-sm hover:shadow-md flex items-center space-x-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                <span>Simpan Perubahan</span>
                            </button>
                        </div>
                    </form>
                </div>

                
                <div id="content-activity" class="hidden">
                    <?php if($user->role === 'pemerintah'): ?>
                    <!-- Statistik Cards -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                        <!-- Total Programs -->
                        <div class="bg-gradient-to-br from-blue-500 to-blue-600 text-white rounded-2xl p-6 shadow-lg">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-blue-100 text-sm font-medium">Total Program</p>
                                    <p class="text-3xl font-bold mt-2"><?php echo e($stats['total_programs'] ?? 0); ?></p>
                                    <p class="text-blue-200 text-xs mt-1">
                                        <?php echo e($stats['programs_last_year'] ?? 0); ?> dalam setahun
                                    </p>
                                </div>
                                <div class="bg-blue-400/20 p-3 rounded-xl">
                                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                    </svg>
                                </div>
                            </div>
                        </div>

                        <!-- Total Inovasi -->
                        <div class="bg-gradient-to-br from-green-500 to-green-600 text-white rounded-2xl p-6 shadow-lg">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-green-100 text-sm font-medium">Total Inovasi</p>
                                    <p class="text-3xl font-bold mt-2"><?php echo e($stats['total_innovations'] ?? 0); ?></p>
                                    <p class="text-green-200 text-xs mt-1">
                                        <?php echo e($stats['innovations_last_year'] ?? 0); ?> dalam setahun
                                    </p>
                                </div>
                                <div class="bg-green-400/20 p-3 rounded-xl">
                                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                    </svg>
                                </div>
                            </div>
                        </div>

                        <!-- Total Anggaran -->
                        <div class="bg-gradient-to-br from-purple-500 to-purple-600 text-white rounded-2xl p-6 shadow-lg">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-purple-100 text-sm font-medium">Total Anggaran</p>
                                    <p class="text-xl font-bold mt-2">
                                        <?php if(($stats['total_budget'] ?? 0) >= 1000000000): ?>
                                        Rp <?php echo e(number_format(($stats['total_budget'] ?? 0) / 1000000000, 1)); ?>M
                                        <?php elseif(($stats['total_budget'] ?? 0) >= 1000000): ?>
                                        Rp <?php echo e(number_format(($stats['total_budget'] ?? 0) / 1000000, 1)); ?>Jt
                                        <?php else: ?>
                                        Rp <?php echo e(number_format($stats['total_budget'] ?? 0, 0)); ?>

                                        <?php endif; ?>
                                    </p>
                                    <p class="text-purple-200 text-xs mt-1">Program aktif</p>
                                </div>
                                <div class="bg-purple-400/20 p-3 rounded-xl">
                                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex justify-between items-center mb-8">
                        <h3 class="text-2xl font-bold text-gray-900">Kontribusi Saya</h3>
                        <div class="flex space-x-3">
                            <a href="<?php echo e(route('pemerintah.program.create')); ?>"
                                class="inline-flex items-center px-5 py-2.5 bg-blue-600 text-white rounded-xl hover:bg-blue-700 transition-all duration-300 shadow-lg hover:shadow-xl">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                </svg>
                                Program Baru
                            </a>
                            <a href="<?php echo e(route('pemerintah.inovasi.create')); ?>"
                                class="inline-flex items-center px-5 py-2.5 bg-green-600 text-white rounded-xl hover:bg-green-700 transition-all duration-300 shadow-lg hover:shadow-xl">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                </svg>
                                Inovasi Baru
                            </a>
                        </div>
                    </div>

                    <!-- Program & Inovasi Grid -->
                    <div class="space-y-8">
                        <!-- Programs Grid -->
                        <div>
                            <div class="flex items-center justify-between mb-6">
                                <h4 class="text-xl font-bold text-gray-900 flex items-center">
                                    <svg class="w-6 h-6 text-blue-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                    </svg>
                                    Program OPD (<?php echo e($programs->total()); ?>)
                                </h4>
                            </div>

                            <?php if($programs->isEmpty()): ?>
                            <div class="text-center py-12 bg-gray-50 rounded-2xl border-2 border-dashed border-gray-300">
                                <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                </svg>
                                <p class="text-gray-500 text-lg mb-4">Belum ada program yang dibuat</p>
                                <a href="<?php echo e(route('pemerintah.program.create')); ?>"
                                    class="inline-flex items-center px-6 py-3 bg-blue-600 text-white rounded-xl hover:bg-blue-700 transition-colors font-medium">
                                    Buat Program Pertama
                                </a>
                            </div>
                            <?php else: ?>
                            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-4">
                                <?php $__currentLoopData = $programs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $program): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <a href="<?php echo e(route('program.detail', $program->id)); ?>" class="block">
                                    <div class="group bg-white rounded-xl p-4 border border-gray-200 hover:border-blue-300 hover:shadow-lg transition-all duration-300 h-full">
                                        <div class="flex justify-between items-start mb-3">
                                            <div class="flex-1 min-w-0">
                                                <h4 class="font-semibold text-gray-900 text-base mb-2 line-clamp-2 group-hover:text-blue-600 transition-colors">
                                                    <?php echo e($program->title); ?>

                                                </h4>
                                                <p class="text-gray-600 text-sm line-clamp-2 mb-3">
                                                    <?php echo e($program->description); ?>

                                                </p>
                                            </div>
                                        </div>

                                        <div class="flex items-center justify-between text-xs">
                                            <div class="flex items-center space-x-3">
                                                <span class="px-2 py-1 rounded-full font-medium 
                                                        <?php if($program->status === 'completed'): ?> bg-green-100 text-green-800
                                                        <?php elseif($program->status === 'ongoing'): ?> bg-blue-100 text-blue-800
                                                        <?php else: ?> bg-yellow-100 text-yellow-800 <?php endif; ?>">
                                                    <?php echo e(ucfirst($program->status)); ?>

                                                </span>
                                                <span class="text-gray-500"><?php echo e($program->progress ?? 0); ?>%</span>
                                            </div>
                                            <span class="text-gray-400 text-xs"><?php echo e($program->created_at->format('d M Y')); ?></span>
                                        </div>
                                    </div>
                                </a>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>

                            <!-- Pagination untuk Programs -->
                            <?php if($programs->total() > 0): ?>
                            <div class="mt-6">
                                <?php echo e($programs->links('vendor.pagination.tailwind')); ?>

                            </div>
                            <?php endif; ?>
                            <?php endif; ?>
                        </div>

                        <!-- Innovations Grid -->
                        <div>
                            <div class="flex items-center justify-between mb-6">
                                <h4 class="text-xl font-bold text-gray-900 flex items-center">
                                    <svg class="w-6 h-6 text-green-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                    </svg>
                                    Inovasi OPD (<?php echo e($innovations->total()); ?>)
                                </h4>
                            </div>

                            <?php if($innovations->isEmpty()): ?>
                            <div class="text-center py-12 bg-gray-50 rounded-2xl border-2 border-dashed border-gray-300">
                                <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                </svg>
                                <p class="text-gray-500 text-lg mb-4">Belum ada inovasi yang dibuat</p>
                                <a href="<?php echo e(route('pemerintah.inovasi.create')); ?>"
                                    class="inline-flex items-center px-6 py-3 bg-green-600 text-white rounded-xl hover:bg-green-700 transition-colors font-medium">
                                    Buat Inovasi Pertama
                                </a>
                            </div>
                            <?php else: ?>
                            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-4">
                                <?php $__currentLoopData = $innovations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $innovation): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <a href="<?php echo e(route('program.innovation.detail', $innovation->id)); ?>" class="block">
                                    <div class="group bg-white rounded-xl p-4 border border-gray-200 hover:border-green-300 hover:shadow-lg transition-all duration-300 h-full">
                                        <div class="flex justify-between items-start mb-3">
                                            <div class="flex-1 min-w-0">
                                                <h4 class="font-semibold text-gray-900 text-base mb-2 line-clamp-2 group-hover:text-green-600 transition-colors">
                                                    <?php echo e($innovation->title); ?>

                                                </h4>
                                                <p class="text-gray-600 text-sm line-clamp-2 mb-3">
                                                    <?php echo e($innovation->description); ?>

                                                </p>
                                            </div>
                                        </div>

                                        <div class="flex items-center justify-between text-xs">
                                            <div class="flex items-center space-x-3">
                                                <span class="px-2 py-1 rounded-full font-medium 
                                                        <?php if($innovation->status === 'published'): ?> bg-green-100 text-green-800
                                                        <?php elseif($innovation->status === 'draft'): ?> bg-gray-100 text-gray-800
                                                        <?php else: ?> bg-yellow-100 text-yellow-800 <?php endif; ?>">
                                                    <?php echo e(ucfirst($innovation->status)); ?>

                                                </span>
                                                <span class="text-gray-500"><?php echo e($innovation->category ?? 'General'); ?></span>
                                            </div>
                                            <span class="text-gray-400 text-xs"><?php echo e($innovation->created_at->format('d M Y')); ?></span>
                                        </div>
                                    </div>
                                </a>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>

                            <!-- Pagination untuk Innovations -->
                            <?php if($innovations->total() > 0): ?>
                            <div class="mt-6">
                                <?php echo e($innovations->links('vendor.pagination.tailwind')); ?>

                            </div>
                            <?php endif; ?>
                            <?php endif; ?>
                        </div>
                    </div>

                    <?php elseif($user->role === 'akademisi'): ?>
                    <!-- Statistik untuk Akademisi -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                        <!-- Total Inovasi -->
                        <div class="bg-gradient-to-br from-purple-500 to-purple-600 text-white rounded-2xl p-6 shadow-lg">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-purple-100 text-sm font-medium">Total Inovasi</p>
                                    <p class="text-3xl font-bold mt-2"><?php echo e($stats['total_innovations'] ?? 0); ?></p>
                                    <p class="text-purple-200 text-xs mt-1">
                                        <?php echo e($stats['innovations_last_year'] ?? 0); ?> dalam setahun
                                    </p>
                                </div>
                                <div class="bg-purple-400/20 p-3 rounded-xl">
                                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                    </svg>
                                </div>
                            </div>
                        </div>

                        <!-- Kategori Terbanyak -->
                        <div class="bg-gradient-to-br from-pink-500 to-pink-600 text-white rounded-2xl p-6 shadow-lg">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-pink-100 text-sm font-medium">Kategori Terbanyak</p>
                                    <p class="text-xl font-bold mt-2">
                                        <?php if(isset($stats['innovations_by_category']) && count($stats['innovations_by_category']) > 0): ?>
                                        <?php echo e(array_key_first($stats['innovations_by_category']->toArray())); ?>

                                        <?php else: ?>
                                        -
                                        <?php endif; ?>
                                    </p>
                                    <p class="text-pink-200 text-xs mt-1">Kategori favorit</p>
                                </div>
                                <div class="bg-pink-400/20 p-3 rounded-xl">
                                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons untuk Akademisi -->
                    <div class="flex justify-between items-center mb-8">
                        <h3 class="text-2xl font-bold text-gray-900">Karya Akademik Saya</h3>
                        <div class="flex space-x-3">
                            <a href="<?php echo e(route('akademisi.inovasi.create')); ?>"
                                class="inline-flex items-center px-5 py-2.5 bg-purple-600 text-white rounded-xl hover:bg-purple-700 transition-all duration-300 shadow-lg hover:shadow-xl">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                </svg>
                                Inovasi Baru
                            </a>
                        </div>
                    </div>

                    <!-- Innovations Grid untuk Akademisi -->
                    <div>
                        <div class="flex items-center justify-between mb-6">
                            <h4 class="text-xl font-bold text-gray-900 flex items-center">
                                <svg class="w-6 h-6 text-purple-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path>
                                </svg>
                                Inovasi Akademik (<?php echo e($innovations->total()); ?>)
                            </h4>
                        </div>

                        <?php if($innovations->isEmpty()): ?>
                        <div class="text-center py-12 bg-gray-50 rounded-2xl border-2 border-dashed border-gray-300">
                            <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path>
                            </svg>
                            <p class="text-gray-500 text-lg mb-4">Belum ada inovasi akademik yang dibuat</p>
                            <a href="<?php echo e(route('akademisi.inovasi.create')); ?>"
                                class="inline-flex items-center px-6 py-3 bg-purple-600 text-white rounded-xl hover:bg-purple-700 transition-colors font-medium">
                                Buat Inovasi Pertama
                            </a>
                        </div>
                        <?php else: ?>
                        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-4">
                            <?php $__currentLoopData = $innovations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $innovation): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <a href="<?php echo e(route('akademisi.inovasi.show', $innovation->id)); ?>" class="block">
                                <div class="group bg-white rounded-xl p-4 border border-gray-200 hover:border-purple-300 hover:shadow-lg transition-all duration-300 h-full">
                                    <div class="flex justify-between items-start mb-3">
                                        <div class="flex-1 min-w-0">
                                            <h4 class="font-semibold text-gray-900 text-base mb-2 line-clamp-2 group-hover:text-purple-600 transition-colors">
                                                <?php echo e($innovation->title); ?>

                                            </h4>
                                            <p class="text-gray-600 text-sm line-clamp-2 mb-3">
                                                <?php echo e($innovation->description); ?>

                                            </p>
                                        </div>
                                    </div>

                                    <div class="flex items-center justify-between text-xs">
                                        <div class="flex items-center space-x-3">
                                            <span class="px-2 py-1 rounded-full font-medium 
                                                    <?php if($innovation->status === 'published'): ?> bg-green-100 text-green-800
                                                    <?php elseif($innovation->status === 'draft'): ?> bg-gray-100 text-gray-800
                                                    <?php else: ?> bg-yellow-100 text-yellow-800 <?php endif; ?>">
                                                <?php echo e(ucfirst($innovation->status)); ?>

                                            </span>
                                            <span class="text-gray-500"><?php echo e($innovation->category ?? 'General'); ?></span>
                                        </div>
                                        <span class="text-gray-400 text-xs"><?php echo e($innovation->created_at->format('d M Y')); ?></span>
                                    </div>
                                </div>
                            </a>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>

                        <!-- Pagination untuk Innovations Akademisi -->
                        <?php if($innovations->total() > 0): ?>
                        <div class="mt-6">
                            <?php echo e($innovations->links('vendor.pagination.tailwind')); ?>

                        </div>
                        <?php endif; ?>
                        <?php endif; ?>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .tab-button {
        position: relative;
        transition: all 0.3s ease;
    }

    .tab-button.active {
        color: #2563eb;
        border-bottom-color: #2563eb;
    }

    .tab-button.active::after {
        content: '';
        position: absolute;
        bottom: -2px;
        left: 0;
        right: 0;
        height: 2px;
        background: linear-gradient(90deg, #3b82f6, #8b5cf6);
        border-radius: 2px;
    }

    .tab-button:hover {
        color: #374151;
        transform: translateY(-1px);
    }

    input:focus,
    textarea:focus {
        transform: translateY(-2px);
        box-shadow: 0 10px 25px -5px rgba(59, 130, 246, 0.1);
    }

    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const tabProfile = document.getElementById('tab-profile');
        const tabActivity = document.getElementById('tab-activity');
        const contentProfile = document.getElementById('content-profile');
        const contentActivity = document.getElementById('content-activity');

        // Function to switch tabs
        function switchToProfile() {
            contentProfile.classList.remove('hidden');
            contentActivity.classList.add('hidden');

            tabProfile.classList.add('active', 'text-blue-600', 'border-blue-500');
            tabProfile.classList.remove('text-gray-500', 'border-transparent');
            tabActivity.classList.add('text-gray-500', 'border-transparent');
            tabActivity.classList.remove('active', 'text-blue-600', 'border-blue-500');
        }

        function switchToActivity() {
            contentActivity.classList.remove('hidden');
            contentProfile.classList.add('hidden');

            tabActivity.classList.add('active', 'text-blue-600', 'border-blue-500');
            tabActivity.classList.remove('text-gray-500', 'border-transparent');
            tabProfile.classList.add('text-gray-500', 'border-transparent');
            tabProfile.classList.remove('active', 'text-blue-600', 'border-blue-500');
        }

        // Event listeners
        tabProfile.addEventListener('click', switchToProfile);
        tabActivity.addEventListener('click', switchToActivity);

        // Set initial state
        switchToProfile();
    });
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\xampp\htdocs\dih_website\resources\views/profile/edit.blade.php ENDPATH**/ ?>