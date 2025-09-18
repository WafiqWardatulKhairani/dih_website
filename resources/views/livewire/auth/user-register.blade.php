<div class="max-w-lg mx-auto bg-white shadow-lg rounded-xl p-6 my-10">
    <h2 class="text-2xl font-bold mb-6 text-center text-blue-600">Registrasi Akun</h2>

    @if (session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            {{ session('error') }}
        </div>
    @endif

    <form wire:submit.prevent="register" class="space-y-4" enctype="multipart/form-data">
        <!-- Nama -->
        <div>
            <input type="text" wire:model="name" placeholder="Nama Lengkap" 
                   class="w-full border border-gray-300 px-4 py-3 rounded-lg">
            @error('name') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
        </div>

        <!-- Instansi -->
        <div>
            <input type="text" wire:model="institution_name" placeholder="Nama Instansi" 
                   class="w-full border border-gray-300 px-4 py-3 rounded-lg">
            @error('institution_name') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
        </div>

        <!-- Telepon -->
        <div>
            <input type="tel" wire:model="phone" placeholder="Nomor Telepon" 
                   class="w-full border border-gray-300 px-4 py-3 rounded-lg">
            @error('phone') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
        </div>

        <!-- Alamat -->
        <div>
            <textarea wire:model="address" placeholder="Alamat Lengkap" 
                      class="w-full border border-gray-300 px-4 py-3 rounded-lg"></textarea>
            @error('address') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
        </div>

        <!-- Email -->
        <div>
            <input type="email" wire:model="email" placeholder="Email" 
                   class="w-full border border-gray-300 px-4 py-3 rounded-lg">
            @error('email') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
        </div>

        <!-- Password & Konfirmasi -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
            <div>
                <input type="password" wire:model="password" placeholder="Password" 
                       class="w-full border border-gray-300 px-4 py-3 rounded-lg">
            </div>
            <div>
                <input type="password" wire:model="password_confirmation" placeholder="Konfirmasi Password" 
                       class="w-full border border-gray-300 px-4 py-3 rounded-lg">
            </div>
        </div>
        @error('password') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror

        <!-- Role -->
        <div>
            <select wire:model="role" class="w-full border border-gray-300 px-4 py-3 rounded-lg">
                <option value="">-- Pilih Role --</option>
                <option value="pemerintah">Pemerintah</option>
                <option value="akademisi">Akademisi</option>
            </select>
            @error('role') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
        </div>

        <!-- Dokumen -->
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">
                Upload Surat Tugas (Wajib PDF)
            </label>
            <input type="file" wire:model="document" accept=".pdf,.jpg,.jpeg,.png"
                   class="w-full border border-gray-300 px-4 py-2 rounded-lg">
            <div wire:loading wire:target="document" class="text-sm text-gray-500">Uploading document...</div>
            @error('document') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
        </div>

        <!-- Avatar / Foto Profil -->
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">
                Upload Foto Profil (Wajib)
            </label>
            <input type="file" wire:model="avatar" accept=".jpg,.jpeg,.png"
                   class="w-full border border-gray-300 px-4 py-2 rounded-lg">
            <div wire:loading wire:target="avatar" class="text-sm text-gray-500">Uploading avatar...</div>
            @error('avatar') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror

            <!-- Preview Avatar -->
            @if ($avatar)
                <div class="mt-2">
                    <span class="text-sm text-gray-600">Preview:</span>
                    <img src="{{ $avatar->temporaryUrl() }}" alt="Avatar Preview" class="mt-1 w-24 h-24 rounded-full object-cover border">
                </div>
            @endif
        </div>

        <button type="submit" class="w-full bg-blue-600 text-white py-3 rounded-lg font-semibold">
            Daftar Sekarang
        </button>
    </form>
</div>
