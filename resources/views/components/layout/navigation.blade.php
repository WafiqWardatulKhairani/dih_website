@php
use Illuminate\Support\Facades\Storage;

// tentukan home sesuai role
$homeRoute = route('landing-page');
if (auth()->check()) {
    $homeRoute = match(auth()->user()->role) {
        'pemerintah' => route('pemerintah.index'),
        'akademisi'  => route('akademisi.index'),
        'admin'      => route('admin.users.index'),
        default      => route('landing-page'),
    };
}
@endphp

<nav class="bg-white shadow-sm sticky top-0 z-50">
    <div class="container mx-auto px-4 py-3 flex justify-between items-center">
        <!-- Logo -->
        <div class="flex items-center">
            <a href="{{ $homeRoute }}">
                <img src="{{ asset('images/logo.png') }}" alt="Logo DIH" class="h-12 md:h-20">
            </a>
        </div>

        <!-- Desktop Menu -->
        <div class="hidden md:flex items-center space-x-8">
            <a href="{{ $homeRoute }}" class="font-medium hover:text-blue-600 transition-colors">Beranda</a>
            <a href="#program" class="font-medium hover:text-blue-600 transition-colors">Program</a>
            <a href="#solusi" class="font-medium hover:text-blue-600 transition-colors">Solusi</a>
            <a href="#hub" class="font-medium text-blue-600">Innovation Hub</a>
            <a href="#tentang" class="font-medium hover:text-blue-600 transition-colors">Tentang</a>

            <!-- Avatar + Logout -->
            @auth
            <div class="flex items-center space-x-3 ml-6">
                <div class="w-10 h-10 rounded-full overflow-hidden border-2 border-gray-300">
                    <img src="{{ auth()->user()->avatar
                        ? asset('storage/' . auth()->user()->avatar)
                        : asset('images/default-avatar.png') }}"
                        alt="Avatar"
                        class="w-full h-full object-cover">
                </div>

                <form method="POST" action="{{ route('logout') }}" class="inline">
                    @csrf
                    <button type="submit"
                        class="px-5 py-2 rounded-full border-2 border-red-600 text-red-600 font-semibold 
                                   hover:bg-red-600 hover:text-white transition">
                        Logout
                    </button>
                </form>
            </div>
            @endauth

            @guest
            <div class="flex items-center space-x-3 ml-6">
                <button class="px-5 py-2 rounded-full border-2 border-blue-600 text-blue-600 font-semibold 
                        hover:bg-blue-600 hover:text-white transition open-login-modal">
                    Login
                </button>
                <a href="{{ route('user.register') }}"
                    class="px-5 py-2 rounded-full bg-gradient-to-r from-blue-600 to-green-500 
                          text-white font-semibold shadow-md hover:opacity-90 transition">
                    Register
                </a>
            </div>
            @endguest
        </div>

        <!-- Mobile menu button -->
        <button id="mobile-menu-toggle" class="md:hidden text-gray-700">
            <i class="fas fa-bars text-xl"></i>
        </button>
    </div>

    <!-- Mobile Menu -->
    <div id="mobile-menu" class="hidden md:hidden bg-white py-2 px-4 border-t">
        <a href="{{ $homeRoute }}" class="block py-2 font-medium">Beranda</a>
        <a href="#program" class="block py-2 font-medium">Program</a>
        <a href="#solusi" class="block py-2 font-medium">Solusi</a>
        <a href="#hub" class="block py-2 font-medium text-blue-600">Innovation Hub</a>
        <a href="#tentang" class="block py-2 font-medium">Tentang</a>

        @auth
        <div class="mt-3 flex flex-col space-y-2 items-start">
            <div class="w-10 h-10 rounded-full overflow-hidden border-2 border-gray-300 mb-2">
                <img src="{{ auth()->user()->avatar
                    ? asset('storage/' . auth()->user()->avatar)
                    : asset('images/default-avatar.png') }}"
                    alt="Avatar"
                    class="w-full h-full object-cover">
            </div>
            <form method="POST" action="{{ route('logout') }}" class="w-full">
                @csrf
                <button type="submit"
                    class="w-full px-4 py-2 rounded-lg border-2 border-red-600 text-red-600 font-semibold 
                               hover:bg-red-600 hover:text-white transition">
                    Logout
                </button>
            </form>
        </div>
        @endauth

        @guest
        <div class="mt-3 flex flex-col space-y-2">
            <button class="w-full text-center px-4 py-2 rounded-lg bg-gradient-to-r from-blue-600 to-green-500 
                    text-white font-semibold shadow-md hover:opacity-90 transition open-login-modal">
                Login
            </button>
            <a href="{{ route('user.register') }}"
                class="w-full text-center px-4 py-2 rounded-lg border-2 border-blue-600 text-blue-600 font-semibold 
                      hover:bg-blue-600 hover:text-white transition">
                Register
            </a>
        </div>
        @endguest
    </div>
</nav>

<!-- LOGIN MODAL -->
<div id="loginModal" class="fixed inset-0 bg-black/50 hidden items-center justify-center z-50">
    <div class="bg-white rounded-xl shadow-lg w-full max-w-md p-6 relative">
        <button id="closeModal" class="absolute top-3 right-3 text-gray-500 hover:text-gray-800">&times;</button>
        <h2 class="text-2xl font-bold mb-6 text-center text-blue-600">Login Akun</h2>

        <form method="POST" action="{{ route('login') }}" class="space-y-4">
            @csrf
            <div>
                <input type="email" name="email" placeholder="Email" required
                       class="w-full border border-gray-300 px-4 py-3 rounded-lg">
            </div>
            <div>
                <input type="password" name="password" placeholder="Password" required
                       class="w-full border border-gray-300 px-4 py-3 rounded-lg">
            </div>
            <div class="flex items-center justify-between">
                <label class="flex items-center text-sm text-gray-600">
                    <input type="checkbox" name="remember" class="mr-2 rounded"> Remember me
                </label>
                <a href="{{ route('password.request') }}" class="text-sm text-blue-600 hover:underline">Lupa password?</a>
            </div>
            <button type="submit"
                    class="w-full bg-blue-600 hover:bg-blue-700 text-white py-3 rounded-lg font-semibold">
                Login
            </button>
        </form>

        <p class="text-center mt-4 text-gray-600">
            Belum Punya Akun?
            <a href="{{ route('user.register') }}" class="text-blue-600 font-medium hover:underline">
                Daftar Sekarang
            </a>
        </p>
    </div>
</div>

<script>
    // Toggle mobile menu
    document.getElementById('mobile-menu-toggle').addEventListener('click', function() {
        const menu = document.getElementById('mobile-menu');
        menu.classList.toggle('hidden');
    });

    // Login modal
    const modal = document.getElementById('loginModal');
    const openButtons = document.querySelectorAll('.open-login-modal');
    const closeBtn = document.getElementById('closeModal');

    openButtons.forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        });
    });

    closeBtn.addEventListener('click', function() {
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    });

    window.addEventListener('click', function(e) {
        if (e.target == modal) {
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }
    });
</script>