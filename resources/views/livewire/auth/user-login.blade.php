<div>
    <form wire:submit="login" class="space-y-4">
        <!-- Email -->
        <div>
            <input type="email" wire:model="email" placeholder="Email" required
                   class="w-full border border-gray-300 px-4 py-3 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition
                          @error('email') border-red-500 @enderror">
            @error('email') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
        </div>

        <!-- Password -->
        <div>
            <input type="password" wire:model="password" placeholder="Password" required
                   class="w-full border border-gray-300 px-4 py-3 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition
                          @error('password') border-red-500 @enderror">
            @error('password') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
        </div>

        <!-- Remember Me -->
        <div class="flex items-center justify-between">
            <label class="flex items-center text-sm text-gray-600">
                <input type="checkbox" wire:model="remember" class="mr-2 rounded"> Remember me
            </label>
            <a href="#" class="text-sm text-blue-600 hover:underline">Lupa password?</a>
        </div>

        <!-- Submit Button -->
        <button type="submit" 
                wire:loading.attr="disabled"
                class="w-full bg-blue-600 hover:bg-blue-700 text-white py-3 rounded-lg font-semibold transition-colors disabled:opacity-50">
            <span wire:loading.remove>Login</span>
            <span wire:loading>Memproses...</span>
        </button>
    </form>

    <p class="text-center mt-4 text-gray-600">
        Belum Punya Akun?
        <a href="{{ route('user.register') }}" class="text-blue-600 font-medium hover:underline">
            Daftar Sekarang
        </a>
    </p>
</div>