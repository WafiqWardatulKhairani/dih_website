@php
use Illuminate\Support\Facades\Route;

$currentRoute = Route::currentRouteName();
$homeRoute = route('landing-page');

// Tentukan menu
if (in_array($currentRoute, ['landing-page','tentang'])) {
<<<<<<< HEAD
// pakai menu guest/umum
=======
>>>>>>> 3a3b19a02ea70279d2c48163dad999b84268997c
$navItems = [
['href' => route('landing-page'), 'label' => 'Beranda'],
['href' => route('tentang'), 'label' => 'Tentang'],
];
} else {
<<<<<<< HEAD
// logika lama (role-based)
=======
>>>>>>> 3a3b19a02ea70279d2c48163dad999b84268997c
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
<<<<<<< HEAD
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
=======
['href' => route('pemerintah.solusi'), 'label' => 'Solusi'],
['href' => route('pemerintah.inkubasi'), 'label' => 'Inkubasi'],
['href' => route('pemerintah.diskusi'), 'label' => 'Diskusi'],
],
'akademisi' => [
['href' => route('akademisi.index'), 'label' => 'Dashboard'],
['href' => route('akademisi.post-inovasi.create'), 'label' => 'Post Inovasi'],
['href' => route('akademisi.proyek-saya'), 'label' => 'Proyek Saya'],
['href' => route('akademisi.kolaborasi'), 'label' => 'Kolaborasi'],
['href' => route('akademisi.profil-akademik'), 'label' => 'Profil Akademik'],
>>>>>>> 3a3b19a02ea70279d2c48163dad999b84268997c
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
<<<<<<< HEAD
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
=======
            <div id="status-wrapper" class="ml-5">
                @if(auth()->user()->status === 'pending')
                {{-- tombol verifikasi sementara --}}
                <button id="verifyBtn"
                    class="px-4 py-1 rounded-full border-2 border-gray-400 text-gray-400 font-semibold cursor-not-allowed"
                    disabled>
                    Akun Anda Sedang Diverifikasi
                </button>
                @else
                {{-- Avatar normal --}}
                <div id="avatar-block" class="relative">
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
                        <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">
                            Edit Profile
                        </a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="w-full text-left px-4 py-2 text-red-600 hover:bg-gray-100">
                                Logout
                            </button>
                        </form>
                    </div>
>>>>>>> 3a3b19a02ea70279d2c48163dad999b84268997c
                </div>
                @endif
            </div>
<<<<<<< HEAD
=======

            {{-- === Polling script (hanya untuk user yang pending) === --}}
            @if(auth()->user()->status === 'pending')
            <script>
                (function() {
                    // gunakan string Blade biasa agar editor tidak memprotes
                    const statusUrl = "{{ route('user.status') }}";
                    const dashboardUrl = "{{ route('dashboard') }}"; // pakai route dashboard yang sudah ada

                    // helper untuk menggantikan tombol verifikasi dengan link dashboard
                    function showDashboardButton() {
                        const wrapper = document.getElementById('status-wrapper');
                        if (!wrapper) return;

                        wrapper.innerHTML = `
                        <a id="dashboardBtn" href="${dashboardUrl}"
                           class="px-4 py-1 rounded-full bg-blue-600 hover:bg-blue-700 text-white font-semibold">
                           Akun Terverifikasi
                        </a>
                    `;
                    }

                    // tampilkan pesan akun ditolak
                    function showRejectedNotice() {
                        const wrapper = document.getElementById('status-wrapper');
                        if (!wrapper) return;

                        wrapper.innerHTML = `
        <div class="px-4 py-1 rounded-full bg-red-600 text-white font-semibold">
            Akun Anda Ditolak
        </div>
    `;
                    }

                    // polling function
                    async function checkStatus() {
                        try {
                            const res = await fetch(statusUrl, {
                                headers: {
                                    'X-Requested-With': 'XMLHttpRequest'
                                },
                                credentials: 'same-origin'
                            });
                            if (!res.ok) return;
                            const data = await res.json();
                            if (data.status === 'verified') {
                                showDashboardButton();
                                clearInterval(window._userStatusInterval);
                            } else if (data.status === 'rejected') {
                                showRejectedNotice();
                                clearInterval(window._userStatusInterval);
                            }

                        } catch (err) {
                            // silent fail (network / auth)
                        }
                    }

                    // jalankan segera lalu set interval
                    checkStatus();
                    window._userStatusInterval = setInterval(checkStatus, 5000); // cek tiap 5 detik
                })();
            </script>
>>>>>>> 3a3b19a02ea70279d2c48163dad999b84268997c
            @endif
            @endauth

            @guest
<<<<<<< HEAD
            {{-- === LOGIN / REGISTER normal === --}}
=======
            {{-- === LOGIN / REGISTER === --}}
>>>>>>> 3a3b19a02ea70279d2c48163dad999b84268997c
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

<<<<<<< HEAD
    {{-- ===== Mobile Menu ===== --}}
=======
    {{-- Mobile Menu --}}
>>>>>>> 3a3b19a02ea70279d2c48163dad999b84268997c
    <div id="mobile-menu" class="hidden md:hidden bg-white border-t">
        @foreach($navItems as $item)
        <a href="{{ $item['href'] }}" class="block py-3 px-4 font-medium hover:bg-gray-100">
            {{ $item['label'] }}
        </a>
        @endforeach

        @auth
<<<<<<< HEAD
        @if(auth()->user()->status === 'pending')
        {{-- === TOMBOL VERIFIKASI MOBILE (disabled) === --}}
        <div class="border-t mt-2 p-4">
=======
        <div id="status-wrapper-mobile" class="border-t mt-2 p-4">
            @if(auth()->user()->status === 'pending')
>>>>>>> 3a3b19a02ea70279d2c48163dad999b84268997c
            <button disabled
                class="w-full text-center px-4 py-2 rounded-lg border-2 border-gray-400 text-gray-400 font-semibold cursor-not-allowed">
                Akun Anda Sedang Diverifikasi
            </button>
<<<<<<< HEAD
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
=======
            @elseif(auth()->user()->status === 'verified')
            <div class="flex items-center space-x-3 mb-2">
                <div class="w-10 h-10 rounded-full overflow-hidden border-2 border-gray-300">
                    <img src="{{ auth()->user()->avatar
                                    ? asset('storage/'.auth()->user()->avatar)
                                    : asset('images/default-avatar.png') }}"
                        alt="Avatar" class="w-full h-full object-cover">
>>>>>>> 3a3b19a02ea70279d2c48163dad999b84268997c
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
<<<<<<< HEAD
                                   hover:bg-red-600 hover:text-white transition">
=======
                               hover:bg-red-600 hover:text-white transition">
>>>>>>> 3a3b19a02ea70279d2c48163dad999b84268997c
                    Logout
                </button>
            </form>
            @elseif(auth()->user()->status === 'rejected')
            <div class="w-full text-center px-4 py-2 rounded-lg bg-red-600 text-white font-semibold">
                Akun Anda Ditolak
            </div>
            @endif
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
<<<<<<< HEAD
                          hover:bg-blue-600 hover:text-white transition">
=======
                     hover:bg-blue-600 hover:text-white transition">
>>>>>>> 3a3b19a02ea70279d2c48163dad999b84268997c
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