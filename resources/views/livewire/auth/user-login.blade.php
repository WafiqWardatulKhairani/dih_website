<div class="max-w-lg mx-auto bg-white shadow-lg rounded-xl p-6 my-10">
    <h2 class="text-2xl font-bold mb-6 text-center text-blue-600">Login Akun</h2>

    @if (session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            {{ session('error') }}
        </div>
    @endif

    <form wire:submit.prevent="login" class="space-y-4">
        <!-- Email -->
        <div>
            <input type="email" wire:model.defer="email" placeholder="Email"
                   class="w-full border border-gray-300 px-4 py-3 rounded-lg">
            @error('email') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
        </div>

        <!-- Password -->
        <div>
            <input type="password" wire:model.defer="password" placeholder="Password"
                   class="w-full border border-gray-300 px-4 py-3 rounded-lg">
            @error('password') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
        </div>

        <!-- Remember Me & Forgot -->
        <div class="flex items-center justify-between">
            <label class="flex items-center text-sm text-gray-600">
                <input type="checkbox" wire:model="remember" class="mr-2 rounded">
                Remember me
            </label>

            <a href="{{ route('password.request') }}"
               class="text-sm text-blue-600 hover:underline">
               Lupa password?
            </a>
        </div>

        <!-- Submit -->
        <button type="submit"
                class="w-full bg-blue-600 hover:bg-blue-700 text-white py-3 rounded-lg font-semibold">
            Login
        </button>
    </form>

    <!-- Avatar setelah login -->
@auth
    <div class="mt-6 text-center">
        <h3 class="text-lg font-semibold mb-2">
            Selamat datang, {{ auth()->user()->name }}!
        </h3>
        <img src="{{ auth()->user()->avatar
                    ? asset('storage/' . auth()->user()->avatar)
                    : asset('storage/default-avatar.png') }}"
             alt="Avatar"
             class="mx-auto w-24 h-24 rounded-full object-cover border">
    </div>
@endauth

</div>
