<div class="min-h-screen bg-gradient-to-br from-blue-50 to-indigo-100 py-4 px-4">
    <div class="max-w-3xl mx-auto">
        <!-- Header -->
        <div class="text-center mb-4">
            <h1 class="text-xl font-bold text-gray-800">Daftar Akun</h1>
            <p class="text-gray-600 text-xs">Bergabung dengan platform kami</p>
        </div>

        <!-- Auto Approval Indicator -->
        <!--[if BLOCK]><![endif]--><?php if($approvalType === 'auto'): ?>
        <div class="bg-green-50 border border-green-200 rounded-lg p-2 mb-3">
            <div class="flex items-center gap-2">
                <div class="w-5 h-5 bg-green-100 rounded-full flex items-center justify-center text-green-600 text-xs">
                    ⚡
                </div>
                <div>
                    <p class="font-semibold text-green-800 text-xs">Auto Approval Terdeteksi</p>
                    <p class="text-green-600 text-xs">Email institusi Anda akan otomatis disetujui dalam 3 menit</p>
                </div>
            </div>
        </div>
        <?php else: ?>
        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

        <!-- Form -->
        <div class="bg-white rounded-lg shadow-md border border-gray-100 p-4">
            <form wire:submit="register" enctype="multipart/form-data">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
                    <!-- Kolom Kiri - Informasi Pribadi -->
                    <div class="space-y-3">
                        <div class="border-b border-gray-200 pb-1">
                            <h3 class="text-sm font-semibold text-gray-800 flex items-center gap-1">
                                <i class="fas fa-user text-blue-500 text-xs"></i>
                                Informasi Pribadi
                            </h3>
                        </div>

                        <!-- Name -->
                        <div>
                            <label class="block text-xs font-medium text-gray-700 mb-1">Nama Lengkap</label>
                            <input type="text" wire:model="name"
                                class="w-full px-2 py-1.5 border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-transparent transition-all text-xs">
                            <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-red-500 text-xs"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                        </div>

                        <!-- Phone -->
                        <div>
                            <label class="block text-xs font-medium text-gray-700 mb-1">Nomor Telepon</label>
                            <input type="tel" wire:model="phone"
                                class="w-full px-2 py-1.5 border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-transparent transition-all text-xs">
                            <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['phone'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-red-500 text-xs"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                        </div>

                        <!-- Address -->
                        <div>
                            <label class="block text-xs font-medium text-gray-700 mb-1">Alamat</label>
                            <textarea wire:model="address" rows="2"
                                class="w-full px-2 py-1.5 border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-transparent transition-all text-xs"></textarea>
                            <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['address'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-red-500 text-xs"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                        </div>

                        <!-- File Uploads -->
                        <div class="space-y-2 pt-1">
                            <!-- Avatar Upload -->
                            <div>
                                <label class="block text-xs font-medium text-gray-700 mb-1">
                                    Foto Profil <span class="text-red-500">*</span>
                                </label>
                                <div class="border border-dashed border-gray-300 rounded-md p-2 hover:border-blue-400 transition-colors">
                                    <label class="cursor-pointer block">
                                        <input type="file" wire:model="avatar" class="hidden">
                                        <div class="flex flex-col items-center text-center">
                                            <i class="fas fa-camera text-sm text-gray-400 mb-1"></i>
                                            <span class="text-xs font-medium text-gray-700">Upload Foto</span>
                                            <span class="text-xs text-gray-500">Wajib JPG/PNG, max 2MB</span>
                                        </div>
                                    </label>
                                    <!--[if BLOCK]><![endif]--><?php if($avatar): ?>
                                    <div class="mt-1 text-xs text-green-600 text-center">
                                        ✅ <?php echo e($avatar->getClientOriginalName()); ?>

                                    </div>
                                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                </div>
                                <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['avatar'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <span class="text-red-500 text-xs"><?php echo e($message); ?></span>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                            </div>

                            <!-- Document Upload -->
                            <div>
                                <label class="block text-xs font-medium text-gray-700 mb-1">Surat Tugas</label>
                                <div class="border border-dashed border-gray-300 rounded-md p-2 hover:border-blue-400 transition-colors">
                                    <label class="cursor-pointer block">
                                        <input type="file" wire:model="document" class="hidden">
                                        <div class="flex flex-col items-center text-center">
                                            <i class="fas fa-file-pdf text-sm text-gray-400 mb-1"></i>
                                            <span class="text-xs font-medium text-gray-700">Upload Dokumen</span>
                                            <span class="text-xs text-gray-500">PDF, max 2MB</span>
                                        </div>
                                    </label>
                                    <!--[if BLOCK]><![endif]--><?php if($document): ?>
                                    <div class="mt-1 text-xs text-green-600 text-center">
                                        ✅ <?php echo e($document->getClientOriginalName()); ?>

                                    </div>
                                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                </div>
                                <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['document'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-red-500 text-xs"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                            </div>
                        </div>
                    </div>

                    <!-- Kolom Kanan - Informasi Akun -->
                    <div class="space-y-3">
                        <div class="border-b border-gray-200 pb-1">
                            <h3 class="text-sm font-semibold text-gray-800 flex items-center gap-1">
                                <i class="fas fa-lock text-green-500 text-xs"></i>
                                Informasi Akun
                            </h3>
                        </div>

                        <!-- Institution -->
                        <div>
                            <label class="block text-xs font-medium text-gray-700 mb-1">Nama Instansi</label>
                            <input type="text" wire:model="institution_name"
                                class="w-full px-2 py-1.5 border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-transparent transition-all text-xs">
                            <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['institution_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-red-500 text-xs"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                        </div>

                        <!-- Email dengan real-time detection -->
                        <div>
                            <label class="block text-xs font-medium text-gray-700 mb-1">Email</label>
                            <input type="email" wire:model.live="email"
                                class="w-full px-2 py-1.5 border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-transparent transition-all text-xs">
                            <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-red-500 text-xs"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->

                            <!-- Email type indicator -->
                            <!--[if BLOCK]><![endif]--><?php if($email): ?>
                            <div class="mt-1 text-xs <?php echo e($approvalType === 'auto' ? 'text-green-600' : 'text-blue-600'); ?> flex items-center gap-1">
                                <!--[if BLOCK]><![endif]--><?php if($approvalType === 'auto'): ?>
                                <i class="fas fa-bolt text-xs"></i> Auto approval 3 menit
                                <?php else: ?>
                                <i class="fas fa-clock text-xs"></i> Verifikasi admin
                                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                            </div>
                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                        </div>

                        <!-- Role -->
                        <div>
                            <label class="block text-xs font-medium text-gray-700 mb-1">Jenis Akun</label>
                            <select wire:model="role"
                                class="w-full px-2 py-1.5 border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-transparent transition-all text-xs">
                                <option value="">Pilih Jenis Akun</option>
                                <option value="pemerintah">Pemerintah</option>
                                <option value="akademisi">Akademisi</option>
                            </select>
                            <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['role'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-red-500 text-xs"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                        </div>

                        <!-- Password -->
                        <div>
                            <label class="block text-xs font-medium text-gray-700 mb-1">Password</label>
                            <input type="password" wire:model="password"
                                class="w-full px-2 py-1.5 border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-transparent transition-all text-xs">
                            <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-red-500 text-xs"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                        </div>

                        <!-- Confirm Password -->
                        <div>
                            <label class="block text-xs font-medium text-gray-700 mb-1">Konfirmasi Password</label>
                            <input type="password" wire:model="password_confirmation"
                                class="w-full px-2 py-1.5 border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-transparent transition-all text-xs">
                        </div>

                        <!-- Submit Button -->
                        <div class="pt-3">
                            <button type="submit"
                                class="w-full bg-gradient-to-r from-blue-500 to-purple-600 text-white py-2 rounded-md font-semibold hover:from-blue-600 hover:to-purple-700 transition-all disabled:opacity-50 disabled:cursor-not-allowed flex items-center justify-center gap-2 text-xs"
                                wire:loading.attr="disabled">
                                <span wire:loading.remove>
                                    <i class="fas fa-rocket text-xs"></i>
                                    Daftar Sekarang
                                </span>
                                <span wire:loading>
                                    <i class="fas fa-spinner fa-spin text-xs"></i>
                                    Memproses...
                                </span>
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <!-- Info Box -->
        <div class="mt-3 bg-blue-50 border border-blue-200 rounded-lg p-2">
            <h4 class="font-semibold text-blue-800 mb-1 flex items-center gap-1 text-xs">
                <i class="fas fa-info-circle text-xs"></i>
                Info Pendaftaran:
            </h4>
            <ul class="text-blue-600 space-y-1 text-xs">
                <li class="flex items-center gap-1">
                    <i class="fas fa-bolt text-green-500 text-xs"></i>
                    Email <strong>@ac.id, @go.id, dll</strong> auto-approve 3 menit
                </li>
                <li class="flex items-center gap-1">
                    <i class="fas fa-clock text-blue-500 text-xs"></i>
                    Email lainnya verifikasi admin
                </li>
                <li class="flex items-center gap-1">
                    <i class="fas fa-shield-alt text-purple-500 text-xs"></i>
                    Dokumen diverifikasi keasliannya
                </li>
            </ul>
        </div>
    </div>
</div><?php /**PATH D:\xampp\htdocs\dih_website\resources\views/livewire/auth/user-register.blade.php ENDPATH**/ ?>