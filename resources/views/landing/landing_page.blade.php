@extends('layouts.app')

@section('content')
<!-- Hero Section -->
<section id="home" class="gradient-bg text-white pt-20 pb-32 relative overflow-hidden">
    <!-- Konten hero section -->
    <div class="absolute top-10 right-10 w-64 h-64 rounded-full bg-white opacity-10"></div>
    <div class="absolute bottom-20 left-10 w-80 h-80 rounded-full bg-white opacity-5"></div>

    <div class="container mx-auto px-4 relative">
        <div class="flex flex-col lg:flex-row items-center">
            <div class="lg:w-1/2 mb-12 lg:mb-0">
                <h1 class="text-4xl md:text-5xl font-bold mb-6 leading-tight">Bersama Membangun <span class="text-yellow-300">Inovasi</span> untuk Negeri</h1>
                <p class="text-lg mb-8 opacity-90 max-w-lg">Platform kolaborasi antara pemerintah dan akademisi untuk menciptakan solusi inovatif yang berdampak nyata bagi masyarakat.</p>
                <div class="flex flex-col sm:flex-row space-y-3 sm:space-y-0 sm:space-x-4">
                    <a href="#hub" class="px-6 py-3 bg-white text-blue-600 font-bold rounded-lg shadow-md hover:bg-gray-100 transition-colors flex items-center justify-center space-x-2">
                        <i class="fas fa-lightbulb"></i>
                        <span>Mulai Berinovasi</span>
                    </a>
                    <a href="#program" class="px-6 py-3 border-2 border-white text-white font-bold rounded-lg hover:bg-white hover:text-blue-600 transition-colors flex items-center justify-center space-x-2">
                        <i class="fas fa-search"></i>
                        <span>Telusuri Program</span>
                    </a>
                </div>
            </div>

            <div class="lg:w-1/2 flex justify-center">
                <div class="relative">
                    <img src="{{ asset('images/hero-image.jpeg') }}" alt="Ilustrasi kolaborasi digital" class="rounded-xl shadow-2xl floating relative z-10">
                    <div class="absolute -bottom-5 -right-5 w-full h-full border-2 border-blue-300 rounded-xl"></div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Stats Section -->
<section class="py-16 bg-white">
    <!-- Konten stats section yang sudah ada -->
    <div class="container mx-auto px-4">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
            <div class="bg-gray-50 p-6 rounded-xl text-center">
                <div class="text-3xl font-bold text-blue-600 mb-2 font-mono">50+</div>
                <p class="text-gray-600 font-medium">OPD Terdaftar</p>
            </div>
            <div class="bg-gray-50 p-6 rounded-xl text-center">
                <div class="text-3xl font-bold text-green-600 mb-2 font-mono">128</div>
                <p class="text-gray-600 font-medium">Program Aktif</p>
            </div>
            <div class="bg-gray-50 p-6 rounded-xl text-center">
                <div class="text-3xl font-bold text-orange-500 mb-2 font-mono">64</div>
                <p class="text-gray-600 font-medium">Solusi Terimplementasi</p>
            </div>
            <div class="bg-gray-50 p-6 rounded-xl text-center">
                <div class="text-3xl font-bold text-purple-600 mb-2 font-mono">35</div>
                <p class="text-gray-600 font-medium">Institusi Akademik</p>
            </div>
        </div>
    </div>
</section>

<!-- Program Prioritas Section -->
<section id="program" class="py-20 bg-gray-50">
    <div class="container mx-auto px-4">
        <div class="text-center mb-16">
            <h2 class="text-3xl font-bold mb-4 relative inline-block">
                <span class="relative z-10">Program Prioritas Daerah</span>
                <span class="absolute bottom-0 left-0 w-full h-2 bg-yellow-200 opacity-50 -z-0" style="bottom: 5px;"></span>
            </h2>
            <p class="text-gray-600 max-w-2xl mx-auto">
                Temukan program-program unggulan yang membutuhkan solusi inovatif dari para peneliti dan akademisi.
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach ($programs as $program)
            <div class="bg-white rounded-xl overflow-hidden shadow-sm card-hover">
                <div class="relative h-48 overflow-hidden">
                    <img src="{{ $program->image ?? 'https://via.placeholder.com/400x300' }}"
                        alt="{{ $program->title }}"
                        class="w-full h-full object-cover">

                    @if($program->status)
                    <div class="absolute top-3 left-3 bg-white/90 text-xs font-bold px-3 py-1 rounded-full shadow-sm">
                        <span class="text-blue-600">{{ $program->status }}</span>
                    </div>
                    @endif
                </div>
                <div class="p-6">
                    <div class="flex justify-between items-start mb-2">
                        <span class="bg-blue-100 text-blue-800 text-xs font-bold px-3 py-1 rounded-full">
                            {{ $program->category }}
                        </span>
                        <span class="text-xs text-gray-500">{{ $program->created_at->diffForHumans() }}</span>
                    </div>
                    <h3 class="text-xl font-bold mb-3">{{ $program->title }}</h3>
                    <p class="text-gray-600 mb-4">{{ $program->description }}</p>
                    <div class="flex justify-between items-center">
                        <span class="text-sm font-medium text-gray-500">OPD: {{ $program->opd }}</span>
                        <a href="#" class="text-blue-600 hover:text-blue-800 font-medium flex items-center">
                            Lihat Detail <i class="fas fa-arrow-right ml-1 text-sm"></i>
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <div class="text-center mt-16">
            <a href="{{ route('program.list') }}"
                class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-blue-600 to-blue-500 text-white font-bold rounded-lg shadow-md hover:shadow-lg transition-all">
                Jelajahi Semua Program
                <i class="fas fa-arrow-right ml-2"></i>
            </a>
        </div>
    </div>
</section>


<!-- Innovation Hub Section -->
<section id="hub" class="py-20 bg-white">
    <!-- Konten innovation hub section yang sudah ada -->
    <div class="container mx-auto px-4">
        <div class="text-center mb-16">
            <h2 class="text-3xl font-bold mb-4 relative inline-block">
                <span class="relative z-10">Innovation Hub</span>
                <span class="absolute bottom-0 left-0 w-full h-2 bg-blue-200 opacity-50 -z-0" style="bottom: 5px;"></span>
            </h2>
            <p class="text-gray-600 max-w-3xl mx-auto">Platform kolaborasi antara UMKM, pemerintah daerah dan akademisi untuk menciptakan solusi inovatif berbasis penelitian dan kebutuhan nyata.</p>
        </div>
        <!-- Baris pertama: 2 card -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
            <!-- OPD Card -->
            <div class="bg-gradient-to-br from-blue-50 to-white rounded-xl p-8 shadow-sm card-hover">
                <div class="bg-blue-600 text-white w-16 h-16 rounded-xl flex items-center justify-center mb-6 shadow-md">
                    <i class="fas fa-building text-2xl"></i>
                </div>
                <h3 class="text-xl font-bold mb-4 text-blue-800">Untuk OPD</h3>
                <p class="text-gray-600 mb-6">Publikasikan tantangan dan program prioritas Anda, dapatkan solusi berbasis penelitian dari para ahli.</p>
                <a href="#" class="text-blue-600 font-medium flex items-center open-login-modal">
                    Pelajari Lebih Lanjut
                    <i class="fas fa-arrow-right ml-2 group-hover:translate-x-1 transition-transform"></i>
                </a>
            </div>

            <!-- Akademisi Card -->
            <div class="bg-gradient-to-br from-green-50 to-white rounded-xl p-8 shadow-sm card-hover">
                <div class="bg-green-600 text-white w-16 h-16 rounded-xl flex items-center justify-center mb-6 shadow-md">
                    <i class="fas fa-graduation-cap text-2xl"></i>
                </div>
                <h3 class="text-xl font-bold mb-4 text-green-800">Untuk Akademisi</h3>
                <p class="text-gray-600 mb-6">Temukan masalah nyata sebagai bahan penelitian dan pengabdian masyarakat, bangun kolaborasi dengan OPD dan UMKM.</p>
                <a href="#" class="text-blue-600 font-medium flex items-center open-login-modal">
                    Pelajari Lebih Lanjut
                    <i class="fas fa-arrow-right ml-2 group-hover:translate-x-1 transition-transform"></i>
                </a>
            </div>
        </div>
    </div>
    <!-- Baris kedua: 2 card -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-16">
        <!-- UMKM Card -->
        <div class="bg-gradient-to-br from-orange-50 to-white rounded-xl p-8 shadow-sm card-hover">
            <div class="bg-orange-600 text-white w-16 h-16 rounded-xl flex items-center justify-center mb-6 shadow-md">
                <i class="fas fa-store text-2xl"></i>
            </div>
            <h3 class="text-xl font-bold mb-4 text-orange-800">Untuk UMKM</h3>
            <p class="text-gray-600 mb-6">Ajukan permasalahan bisnis yang dihadapi, dapatkan solusi inovatif dari akademisi dan dukungan kebijakan dari pemerintah.</p>
            <a href="#" class="text-orange-600 font-medium flex items-center group">
                Pelajari Lebih Lanjut
                <i class="fas fa-arrow-right ml-2 group-hover:translate-x-1 transition-transform"></i>
            </a>
        </div>
        <!-- Kolaborasi Card -->
        <div class="bg-gradient-to-br from-purple-50 to-white rounded-xl p-8 shadow-sm card-hover">
            <div class="bg-purple-600 text-white w-16 h-16 rounded-xl flex items-center justify-center mb-6 shadow-md">
                <i class="fas fa-users text-2xl"></i>
            </div>
            <h3 class="text-xl font-bold mb-4 text-purple-800">Proses Kolaborasi</h3>
            <p class="text-gray-600 mb-6">Temukan bagaimana kolaborasi antara pemerintah, akademisi, dan UMKM dapat menghasilkan solusi yang berdampak.</p>
            <a href="#" class="text-purple-600 font-medium flex items-center group">
                Pelajari Lebih Lanjut
                <i class="fas fa-arrow-right ml-2 group-hover:translate-x-1 transition-transform"></i>
            </a>
        </div>
    </div>
    <!-- How It Works -->
    <div class="bg-gray-50 rounded-2xl p-8 lg:p-12 mb-16">
        <h3 class="text-2xl font-bold text-center mb-12">Bagaimana Platform Ini Bekerja?</h3>
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
            <!-- Step 1 -->
            <div class="text-center">
                <div class="bg-white w-24 h-24 rounded-full flex items-center justify-center mx-auto mb-4 shadow-lg pulse">
                    <div class="w-20 h-20 bg-blue-100 rounded-full flex items-center justify-center text-blue-600 font-bold text-2xl">1</div>
                </div>
                <h4 class="font-bold mb-2">Identifikasi Masalah</h4>
                <p class="text-gray-600 text-sm">OPD dan UMKM mendaftarkan masalah atau program prioritas yang membutuhkan solusi inovatif.</p>
            </div>
            <!-- Step 2 -->
            <div class="text-center">
                <div class="bg-white w-24 h-24 rounded-full flex items-center justify-center mx-auto mb-4 shadow-lg">
                    <div class="w-20 h-20 bg-green-100 rounded-full flex items-center justify-center text-green-600 font-bold text-2xl">2</div>
                </div>
                <h4 class="font-bold mb-2">Eksplorasi Solusi</h4>
                <p class="text-gray-600 text-sm">Akademisi mengeksplorasi masalah dan mengajukan proposal solusi berbasis penelitian.</p>
            </div>
            <!-- Step 3 -->
            <div class="text-center">
                <div class="bg-white w-24 h-24 rounded-full flex items-center justify-center mx-auto mb-4 shadow-lg">
                    <div class="w-20 h-20 bg-yellow-100 rounded-full flex items-center justify-center text-yellow-600 font-bold text-2xl">3</div>
                </div>
                <h4 class="font-bold mb-2">Diskusi Kolaboratif</h4>
                <p class="text-gray-600 text-sm">Terjadi diskusi mendalam antara OPD, akademisi, dan UMKM untuk menyempurnakan solusi.</p>
            </div>
            <!-- Step 4 -->
            <div class="text-center">
                <div class="bg-white w-24 h-24 rounded-full flex items-center justify-center mx-auto mb-4 shadow-lg">
                    <div class="w-20 h-20 bg-purple-100 rounded-full flex items-center justify-center text-purple-600 font-bold text-2xl">4</div>
                </div>
                <h4 class="font-bold mb-2">Implementasi</h4>
                <p class="text-gray-600 text-sm">Solusi diimplementasikan dan dimonitor dampaknya terhadap masyarakat dan dunia usaha.</p>
            </div>
        </div>
    </div>
    <!-- Testimonials -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        <!-- Testimonial 1 -->
        <div class="bg-blue-50 rounded-xl p-8">
            <div class="flex items-start mb-6">
                <img src="{{ asset('images/testimonial-1.jpeg') }}" alt="Kepala Dinas Kesehatan" class="h-16 w-16 rounded-full object-cover mr-4 border-2 border-white shadow-sm">
                <div>
                    <div class="flex items-center mb-1">
                        <i class="fas fa-star text-yellow-400 mr-1"></i>
                        <i class="fas fa-star text-yellow-400 mr-1"></i>
                        <i class="fas fa-star text-yellow-400 mr-1"></i>
                        <i class="fas fa-star text-yellow-400 mr-1"></i>
                        <i class="fas fa-star text-yellow-400"></i>
                    </div>
                    <h4 class="font-bold text-blue-800">dr. Rina Septiani, M.Kes</h4>
                    <p class="text-sm text-gray-600">Kepala Dinas Kesehatan Kota</p>
                </div>
            </div>
            <p class="text-gray-700 italic">"Kolaborasi dengan tim peneliti melalui platform ini telah membantu kami mengembangkan sistem pemantauan kesehatan digital yang sangat bermanfaat di masa pandemi."</p>
        </div>
        <!-- Testimonial 2 -->
        <div class="bg-green-50 rounded-xl p-8">
            <div class="flex items-start mb-6">
                <img src="{{ asset('images/testimonial-2.jpeg') }}" alt="Dosen Teknik Informatika" class="h-16 w-16 rounded-full object-cover mr-4 border-2 border-white shadow-sm">
                <div>
                    <div class="flex items-center mb-1">
                        <i class="fas fa-star text-yellow-400 mr-1"></i>
                        <i class="fas fa-star text-yellow-400 mr-1"></i>
                        <i class="fas fa-star text-yellow-400 mr-1"></i>
                        <i class="fas fa-star text-yellow-400 mr-1"></i>
                        <i class="fas fa-star text-yellow-400"></i>
                    </div>
                    <h4 class="font-bold text-green-800">Prof. Andi Wijaya, Ph.D</h4>
                    <p class="text-sm text-gray-600">Dosen Teknik Informatika</p>
                </div>
            </div>
            <p class="text-gray-700 italic">"Platform ini memberikan akses langsung ke masalah nyata di masyarakat, membuat penelitian kami lebih relevan dan berdampak nyata bagi pembangunan daerah."</p>
        </div>
    </div>
    </div>
</section>
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
@endsection




@push('scripts')
<script>
    // Smooth scrolling
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function(e) {
            e.preventDefault();
            const targetId = this.getAttribute('href');
            if (targetId === '#') return;
            const targetElement = document.querySelector(targetId);
            if (targetElement) targetElement.scrollIntoView({
                behavior: 'smooth'
            });
        });
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

<script>
    // Smooth scrolling for anchor links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function(e) {
            e.preventDefault();

            const targetId = this.getAttribute('href');
            if (targetId === '#') return;

            const targetElement = document.querySelector(targetId);
            if (targetElement) {
                targetElement.scrollIntoView({
                    behavior: 'smooth'
                });

                // Close mobile menu if open
                const mobileMenu = document.getElementById('mobile-menu');
                if (mobileMenu && !mobileMenu.classList.contains('hidden')) {
                    mobileMenu.classList.add('hidden');
                }
            }
        });
    });
</script>
@endpush