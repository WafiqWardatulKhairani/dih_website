<nav class="bg-white shadow-sm sticky top-0 z-50">
    <div class="container mx-auto px-4 py-3 flex justify-between items-center">
        <div class="flex items-center">
            <!-- Logo yang diperbesar -->
            <img src="{{ asset('images/logo.png') }}" alt="Logo DIH" class="h-12 md:h-20">
        </div>

        <div class="hidden md:flex items-center space-x-8">
            <a href="#home" class="font-medium hover:text-blue-600 transition-colors">Beranda</a>
            <a href="#program" class="font-medium hover:text-blue-600 transition-colors">Posting Inovasi</a>
            <a href="#solusi" class="font-medium hover:text-blue-600 transition-colors">Media Diskusi Publik</a>
            <a href="{{ route('innovation.hub') }}" class="font-medium text-blue-600">
                Innovation Hub
            </a> <a href="#tentang" class="font-medium hover:text-blue-600 transition-colors">Tentang</a>
        </div>
        <button id="mobile-menu-toggle" class="md:hidden text-gray-700">
            <i class="fas fa-bars text-xl"></i>
        </button>
    </div>

    <!-- Mobile Menu -->
    <div id="mobile-menu" class="hidden md:hidden bg-white py-2 px-4 border-t">
        <a href="#home" class="block py-2 font-medium">Beranda</a>
        <a href="#program" class="block py-2 font-medium">Posting Inovasi</a>
        <a href="#solusi" class="block py-2 font-medium">Media Diskusi Publik</a>
        <a href="#hub" class="block py-2 font-medium text-blue-600">Innovation Hub</a>
        <a href="#tentang" class="block py-2 font-medium">Tentang</a>
    </div>
</nav>