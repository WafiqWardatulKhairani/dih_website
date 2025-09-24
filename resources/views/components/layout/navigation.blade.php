@php
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

$currentRoute = Route::currentRouteName();
$homeRoute = route('landing-page');

if (in_array($currentRoute, ['landing-page','tentang'])) {
// pakai menu guest/umum
$navItems = [
['href' => route('landing-page'), 'label' => 'Beranda'],
['href' => route('tentang'), 'label' => 'Tentang'],
];
} else {
// logika lama (role-based)
if (auth()->check()) {
$homeRoute = match(auth()->user()->role) {
'pemerintah' => route('pemerintah.index'),
'akademisi' => route('akademisi.index'),
'admin' => route('admin.index'),
default => route('landing-page'),
};

$navItems = match(auth()->user()->role) {
'pemerintah' => [
['href' => route('pemerintah.index'), 'label' => 'Dashboard'],
['href' => route('pemerintah.program'), 'label' => 'Program & Inovasi'],
['href' => route('pemerintah.diskusi'), 'label' => 'Ruang Diskusi'],
['href' => route('pemerintah.solusi'), 'label' => 'Solusi'],
['href' => route('pemerintah.inkubasi'), 'label' => 'Inkubasi'],
],
'akademisi' => [
['href' => route('akademisi.index'), 'label' => 'Dashboard'],
['href' => route('akademisi.post-inovasi.create'), 'label' => 'Inovasi'],
['href' => route('akademisi.kolaborasi'), 'label' => 'Solusi'],
['href' => route('akademisi.proyek-saya'), 'label' => 'Ruang Diskusi'],
['href' => route('akademisi.kolaborasi'), 'label' => 'Inkubasi'],
['href' => route('akademisi.kolaborasi'), 'label' => 'Kolaborasi'],
],
'admin' => [
['href' => route('admin.index'), 'label' => 'Dashboard'],
['href' => route('admin.users.index'), 'label' => 'Manajemen User'],
['href' => route('admin.moderasi-konten'), 'label' => 'Moderasi Konten'],
['href' => route('admin.statistik'), 'label' => 'Statistik'],
],
default => [
['href' => route('landing-page'), 'label' => 'Beranda'],
['href' => route('tentang'), 'label' => 'Tentang'],
],
};
} else {
$navItems = [
['href' => route('landing-page'), 'label' => 'Beranda'],
['href' => route('tentang'), 'label' => 'Tentang'],
];
}
}
@endphp


<nav class="bg-white/90 backdrop-blur-md shadow-md sticky top-0 z-50 -mt-1">
    <div class="max-w-6xl mx-auto px-4 py-1.5 flex justify-between items-center">
        {{-- ===== Logo ===== --}}
        <div class="flex items-center ml-8 md:ml-12">
            <a href="{{ $homeRoute }}" class="flex items-center space-x-2">
                <img src="{{ asset('images/logoKecil.png') }}"
                    alt="Logo DIH"
                    class="h-12 md:h-16 transition-transform duration-300 hover:scale-105">
            </a>
        </div>

        {{-- ===== Desktop Menu ===== --}}
        <div class="hidden md:flex items-center space-x-5">
            @foreach($navItems as $item)
            <a href="{{ $item['href'] }}"
                class="relative font-medium text-gray-700 hover:text-blue-600 transition-colors px-1
                          after:content-[''] after:absolute after:left-0 after:-bottom-1
                          after:w-0 after:h-[2px] after:bg-blue-600
                          hover:after:w-full after:transition-all after:duration-300">
                {{ $item['label'] }}
            </a>
            @endforeach

            {{-- ===== Avatar & Auth ===== --}}
            @auth
            @if(auth()->user()->status === 'pending')
            {{-- === TOMBOL VERIFIKASI (disabled) === --}}
            <div class="ml-5">
                <button disabled
                    class="px-4 py-1 rounded-full border-2 border-gray-400 text-gray-400 font-semibold cursor-not-allowed">
                    Akun Anda Sedang Diverifikasi
                </button>
            </div>
            @else
            {{-- === Avatar normal === --}}
            <div class="relative ml-5">
                <button id="avatarBtn"
                    class="w-10 h-10 rounded-full overflow-hidden border-2 border-gray-300 focus:outline-none">
                    <img src="{{ auth()->user()->avatar
                                        ? asset('storage/'.auth()->user()->avatar)
                                        : asset('images/default-avatar.png') }}"
                        alt="Avatar"
                        class="w-full h-full object-cover">
                </button>

                <div id="avatarDropdown"
                    class="absolute right-0 mt-2 w-40 bg-white rounded-md shadow-lg border hidden">
                    <a href="{{ route('profile.edit') }}"
                        class="block px-4 py-2 text-gray-700 hover:bg-gray-100">
                        Edit Profile
                    </a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"
                            class="w-full text-left px-4 py-2 text-red-600 hover:bg-gray-100">
                            Logout
                        </button>
                    </form>
                </div>
            </div>
            @endif
            @endauth

            @guest
            {{-- === LOGIN / REGISTER normal === --}}
            <div class="flex items-center space-x-3 ml-5">
                <button class="px-4 py-1 rounded-full border-2 border-blue-600 text-blue-600 font-semibold
                                   hover:bg-blue-600 hover:text-white transition open-login-modal">
                    Login
                </button>
                <a href="{{ route('user.register') }}"
                    class="px-4 py-1 rounded-full bg-gradient-to-r from-blue-600 to-green-500
                              text-white font-semibold shadow-md hover:opacity-90 transition">
                    Register
                </a>
            </div>
            @endguest
        </div>

        {{-- ===== Mobile Toggle ===== --}}
        <button id="mobile-menu-toggle" class="md:hidden text-gray-700 focus:outline-none">
            <i class="fas fa-bars text-2xl"></i>
        </button>
    </div>

    {{-- ===== Mobile Menu ===== --}}
    <div id="mobile-menu" class="hidden md:hidden bg-white border-t">
        @foreach($navItems as $item)
        <a href="{{ $item['href'] }}" class="block py-3 px-4 font-medium hover:bg-gray-100">
            {{ $item['label'] }}
        </a>
        @endforeach

        @auth
        @if(auth()->user()->status === 'pending')
        {{-- === TOMBOL VERIFIKASI MOBILE (disabled) === --}}
        <div class="border-t mt-2 p-4">
            <button disabled
                class="w-full text-center px-4 py-2 rounded-lg border-2 border-gray-400 text-gray-400 font-semibold cursor-not-allowed">
                Akun Anda Sedang Diverifikasi
            </button>
        </div>
        @else
        {{-- === Avatar & Logout Mobile === --}}
        <div class="border-t mt-2 p-4 flex flex-col space-y-2">
            <div class="flex items-center space-x-3">
                <div class="w-10 h-10 rounded-full overflow-hidden border-2 border-gray-300">
                    <img src="{{ auth()->user()->avatar
                                        ? asset('storage/'.auth()->user()->avatar)
                                        : asset('images/default-avatar.png') }}"
                        alt="Avatar"
                        class="w-full h-full object-cover">
                </div>
                <div class="flex-1">
                    <a href="{{ route('profile.edit') }}"
                        class="block text-blue-600 font-medium hover:underline">
                        Edit Profile
                    </a>
                </div>
            </div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                    class="w-full mt-2 px-4 py-2 rounded-lg border-2 border-red-600 text-red-600 font-semibold
                                   hover:bg-red-600 hover:text-white transition">
                    Logout
                </button>
            </form>
        </div>
        @endif
        @endauth

        @guest
        {{-- === LOGIN / REGISTER normal mobile === --}}
        <div class="border-t mt-2 p-4 flex flex-col space-y-2">
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
            <input type="email" name="email" placeholder="Email" required
                class="w-full border border-gray-300 px-4 py-3 rounded-lg">
            <input type="password" name="password" placeholder="Password" required
                class="w-full border border-gray-300 px-4 py-3 rounded-lg">
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
    document.getElementById('mobile-menu-toggle')
        .addEventListener('click', () => {
            document.getElementById('mobile-menu').classList.toggle('hidden');
        });

    // Login modal
    const modal = document.getElementById('loginModal');
    const openButtons = document.querySelectorAll('.open-login-modal');
    const closeBtn = document.getElementById('closeModal');

    openButtons.forEach(btn => {
        btn.addEventListener('click', e => {
            e.preventDefault();
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        });
    });

    closeBtn.addEventListener('click', () => {
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    });

    window.addEventListener('click', e => {
        if (e.target === modal) {
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }
    });

    // Avatar dropdown click toggle
    const avatarBtn = document.getElementById('avatarBtn');
    const avatarDropdown = document.getElementById('avatarDropdown');

    if (avatarBtn) {
        avatarBtn.addEventListener('click', (e) => {
            e.stopPropagation();
            avatarDropdown.classList.toggle('hidden');
        });
        document.addEventListener('click', (e) => {
            if (!avatarDropdown.classList.contains('hidden') && !avatarDropdown.contains(e.target)) {
                avatarDropdown.classList.add('hidden');
            }
        });
    }
</script>