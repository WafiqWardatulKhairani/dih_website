@php
use Illuminate\Support\Facades\Storage;
@endphp

<nav class="bg-white shadow-sm sticky top-0 z-50">
    <div class="container mx-auto px-4 py-3 flex justify-between items-center">
        <!-- Logo -->
        <div class="flex items-center">
            <img src="{{ asset('images/logo.png') }}" alt="Logo DIH" class="h-12 md:h-20">
        </div>

        <!-- Desktop Menu -->
        <div class="hidden md:flex items-center space-x-8">
            <a href="#home" class="font-medium hover:text-blue-600 transition-colors">Beranda</a>
            <a href="#program" class="font-medium hover:text-blue-600 transition-colors">Program</a>
            <a href="#solusi" class="font-medium hover:text-blue-600 transition-colors">Solusi</a>
            <a href="#hub" class="font-medium text-blue-600">Innovation Hub</a>
            <a href="#tentang" class="font-medium hover:text-blue-600 transition-colors">Tentang</a>

            <!-- Avatar + Logout -->
            @auth
            <div class="flex items-center space-x-3 ml-6">
                <!-- Avatar -->
                <div class="w-10 h-10 rounded-full overflow-hidden border-2 border-gray-300">
                    <img src="{{ auth()->user()->avatar 
                        ? asset('storage/' . auth()->user()->avatar) 
                        : asset('images/default-avatar.png') }}"
                        alt="Avatar"
                        class="w-full h-full object-cover">
                </div>

                <!-- Logout -->
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
                <a href="{{ route('login') }}"
                    class="px-5 py-2 rounded-full border-2 border-blue-600 text-blue-600 font-semibold 
                          hover:bg-blue-600 hover:text-white transition">
                    Login
                </a>
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
        <a href="#home" class="block py-2 font-medium">Beranda</a>
        <a href="#program" class="block py-2 font-medium">Program</a>
        <a href="#solusi" class="block py-2 font-medium">Solusi</a>
        <a href="#hub" class="block py-2 font-medium text-blue-600">Innovation Hub</a>
        <a href="#tentang" class="block py-2 font-medium">Tentang</a>

        @auth
        <div class="mt-3 flex flex-col space-y-2 items-start">
            <!-- Avatar -->
            <div class="w-10 h-10 rounded-full overflow-hidden border-2 border-gray-300 mb-2">
                <div class="w-10 h-10 rounded-full overflow-hidden border-2 border-gray-300">
                    <img src="{{ auth()->user()->avatar 
                        ? asset('storage/' . auth()->user()->avatar) 
                        : asset('images/default-avatar.png') }}"
                        alt="Avatar"
                        class="w-full h-full object-cover">
                </div>
            </div>
            <!-- Logout -->
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
            <a href="{{ route('login') }}"
                class="w-full text-center px-4 py-2 rounded-lg bg-gradient-to-r from-blue-600 to-green-500 
                      text-white font-semibold shadow-md hover:opacity-90 transition">
                Login
            </a>
            <a href="{{ route('user.register') }}"
                class="w-full text-center px-4 py-2 rounded-lg border-2 border-blue-600 text-blue-600 font-semibold 
                      hover:bg-blue-600 hover:text-white transition">
                Register
            </a>
        </div>
        @endguest
    </div>
</nav>

<script>
    // Toggle mobile menu
    document.getElementById('mobile-menu-toggle').addEventListener('click', function() {
        const menu = document.getElementById('mobile-menu');
        menu.classList.toggle('hidden');
    });
</script>