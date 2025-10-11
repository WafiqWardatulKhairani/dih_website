<div class="min-h-screen bg-gradient-to-br from-blue-50 to-indigo-100 py-8 px-4">
    <div class="max-w-md mx-auto">
        <!-- Header -->
        <div class="text-center mb-8">
            <div class="w-16 h-16 bg-gradient-to-r from-blue-500 to-purple-600 rounded-2xl flex items-center justify-center text-white text-2xl font-bold mx-auto mb-4 shadow-lg">
                🚀
            </div>
            <h1 class="text-3xl font-bold text-gray-800 mb-2">Daftar Akun</h1>
            <p class="text-gray-600">Bergabung dengan platform kami</p>
        </div>

        <!-- Auto Approval Indicator -->
        @if($approvalType === 'auto')
        <div class="bg-green-50 border border-green-200 rounded-xl p-4 mb-6">
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center text-green-600">
                    ⚡
                </div>
                <div>
                    <p class="font-semibold text-green-800">Auto Approval Terdeteksi</p>
                    <p class="text-green-600 text-sm">Email institusi Anda akan otomatis disetujui dalam 3 menit</p>
                </div>
            </div>
        </div>
        @else
        <div class="bg-blue-50 border border-blue-200 rounded-xl p-4 mb-6">
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center text-blue-600">
                    ⏳
                </div>
                <div>
                    <p class="font-semibold text-blue-800">Manual Approval</p>
                    <p class="text-blue-600 text-sm">Akun Anda akan diverifikasi oleh admin</p>
                </div>
            </div>
        </div>
        @endif

        <!-- Form -->
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6">
            <form wire:submit="register" enctype="multipart/form-data">
                <!-- Name -->
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Nama Lengkap</label>
                    <input type="text" wire:model="name" 
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all">
                    @error('name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <!-- Institution -->
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Nama Instansi</label>
                    <input type="text" wire:model="institution_name" 
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all">
                    @error('institution_name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <!-- Email dengan real-time detection -->
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                    <!-- ✅ PERBAIKAN: Ganti jadi wire:model.live -->
                    <input type="email" wire:model.live="email" 
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all">
                    @error('email') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <!-- Phone -->
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Nomor Telepon</label>
                    <input type="tel" wire:model="phone" 
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all">
                    @error('phone') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <!-- Address -->
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Alamat</label>
                    <textarea wire:model="address" rows="3"
                              class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all"></textarea>
                    @error('address') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <!-- Role -->
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Jenis Akun</label>
                    <select wire:model="role" 
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all">
                        <option value="">Pilih Jenis Akun</option>
                        <option value="pemerintah">Pemerintah</option>
                        <option value="akademisi">Akademisi</option>
                    </select>
                    @error('role') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <!-- Password -->
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Password</label>
                    <input type="password" wire:model="password" 
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all">
                    @error('password') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <!-- Confirm Password -->
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Konfirmasi Password</label>
                    <input type="password" wire:model="password_confirmation" 
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all">
                </div>

                <!-- Avatar Upload -->
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Foto Profil</label>
                    <input type="file" wire:model="avatar" 
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all">
                    @error('avatar') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    @if($avatar)
                        <div class="mt-2 text-sm text-green-600">
                            ✅ File terpilih: {{ $avatar->getClientOriginalName() }}
                        </div>
                    @endif
                </div>

                <!-- Document Upload -->
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Dokumen Identitas (PDF)</label>
                    <input type="file" wire:model="document" 
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all">
                    @error('document') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    @if($document)
                        <div class="mt-2 text-sm text-green-600">
                            ✅ File terpilih: {{ $document->getClientOriginalName() }}
                        </div>
                    @endif
                </div>

                <!-- Submit Button -->
                <button type="submit" 
                        class="w-full bg-gradient-to-r from-blue-500 to-purple-600 text-white py-4 rounded-xl font-semibold hover:from-blue-600 hover:to-purple-700 transition-all transform hover:scale-105 shadow-lg disabled:opacity-50 disabled:cursor-not-allowed"
                        wire:loading.attr="disabled">
                    <span wire:loading.remove>🚀 Daftar Sekarang</span>
                    <span wire:loading>⏳ Memproses...</span>
                </button>
            </form>

        </div>

        <!-- Info Box -->
        <div class="mt-6 bg-blue-50 border border-blue-200 rounded-xl p-4">
            <h4 class="font-semibold text-blue-800 mb-2">Info Pendaftaran:</h4>
            <ul class="text-sm text-blue-600 space-y-1">
                <li>• Email <strong>@ac.id, @go.id, dll</strong> akan auto-approve dalam 3 menit</li>
                <li>• Email lainnya menunggu verifikasi admin</li>
                <li>• Dokumen akan diverifikasi keasliannya</li>
            </ul>
        </div>
    </div>
</div>