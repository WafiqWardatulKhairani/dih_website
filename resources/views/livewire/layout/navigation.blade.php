<nav class="bg-white shadow-sm sticky top-0 z-50">
    <div class="container mx-auto px-4 py-3 flex justify-between items-center">
        <div class="flex items-center">
            <!-- Logo -->
            <img src="{{ asset('images/logo.png') }}" alt="Logo DIH" class="h-12 md:h-20">
        </div>
        
        <div class="hidden md:flex items-center space-x-8">
            <a href="#home" class="font-medium hover:text-blue-600 transition-colors">Beranda</a>
            <a href="#program" class="font-medium hover:text-blue-600 transition-colors">Program</a>
            <a href="#solusi" class="font-medium hover:text-blue-600 transition-colors">Solusi</a>
            <a href="#hub" class="font-medium text-blue-600">Innovation Hub</a>
            <a href="#tentang" class="font-medium hover:text-blue-600 transition-colors">Tentang</a>

            {{-- Tambahan untuk Login / Profile --}}
            @auth
                <div class="relative group">
                    <button class="flex items-center space-x-2">
                        <img src="{{ Auth::user()->avatar ?? asset('images/default-avatar.png') }}" 
                             class="w-8 h-8 rounded-full">
                        <span>{{ Auth::user()->name }}</span>
                    </button>
                    <div class="absolute right-0 mt-2 w-40 bg-white border rounded-lg shadow-lg hidden group-hover:block">
                        <div class="px-4 py-2 text-sm text-gray-600">Role: {{ Auth::user()->role }}</div>
                        <a href="{{ route('profile') }}" class="block px-4 py-2 hover:bg-gray-100">Profile</a>
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="w-full text-left px-4 py-2 hover:bg-gray-100">Logout</button>
                        </form>
                    </div>
                </div>
            @else
                <a href="#" class="px-4 py-2 bg-blue-600 text-white rounded-lg">Login</a>
                <a href="#" class="px-4 py-2 border border-blue-600 text-blue-600 rounded-lg">Daftar</a>
            @endauth
        </div>

        <!-- Mobile menu toggle -->
        <button id="mobile-menu-toggle" class="md:hidden text-gray-700">
            <i class="fas fa-bars text-xl"></i>
        </button>
    </div>
</nav>
