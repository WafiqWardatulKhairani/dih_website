{{-- resources/views/akademisi/dashboard.blade.php --}}

@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto mt-8 px-4 sm:px-6 lg:px-8">
<!-- Welcome section -->
<section 
    class="relative overflow-hidden rounded-2xl shadow-lg mx-4 sm:mx-8 lg:mx-16 mt-6"
    style="background-image: linear-gradient(rgba(30,64,175,0.85), rgba(30,58,138,0.9)), url('https://images.unsplash.com/photo-1523240795612-9a054b0db644?ixlib=rb-4.0.3&auto=format&fit=crop&w=1950&q=80'); 
           background-size: cover; 
           background-position: center;"
>
    <div class="px-6 sm:px-10 lg:px-16 py-12 text-white">
        <h1 class="text-3xl sm:text-4xl font-extrabold">
            Selamat Datang di Portal Akademisi!
        </h1>
        <p class="mt-3 max-w-2xl text-sm sm:text-base opacity-90">
            Ruang kolaborasi dan inovasi bagi para akademisi untuk berbagi ide, 
            mengembangkan riset, serta menciptakan solusi nyata bagi masa depan. 
            Mari bergabung, berinovasi, dan berkontribusi bersama komunitas akademisi terbaik.
        </p>

        <div class="mt-8 flex flex-col sm:flex-row gap-4 sm:gap-8">
            <div class="flex items-center gap-3 bg-white/10 rounded-xl px-4 py-3">
                <div class="w-10 h-10 rounded-full bg-white/20 flex items-center justify-center">
                    <i class="fas fa-users"></i>
                </div>
                <div>
                    <div class="text-xl font-bold">1,250+</div>
                    <div class="text-xs opacity-90">Akademisi Terdaftar</div>
                </div>
            </div>

            <div class="flex items-center gap-3 bg-white/10 rounded-xl px-4 py-3">
                <div class="w-10 h-10 rounded-full bg-white/20 flex items-center justify-center">
                    <i class="fas fa-lightbulb"></i>
                </div>
                <div>
                    <div class="text-xl font-bold">543</div>
                    <div class="text-xs opacity-90">Inovasi Terpublikasi</div>
                </div>
            </div>

            <div class="flex items-center gap-3 bg-white/10 rounded-xl px-4 py-3">
                <div class="w-10 h-10 rounded-full bg-white/20 flex items-center justify-center">
                    <i class="fas fa-handshake"></i>
                </div>
                <div>
                    <div class="text-xl font-bold">289</div>
                    <div class="text-xs opacity-90">Kolaborasi Aktif</div>
                </div>
            </div>
        </div>
    </div>
</section>

    <!-- Main container -->
    <main class="px-0 sm:px-0 lg:px-0 -mt-6">
        <!-- Intro -->
        <div class="bg-white rounded-2xl p-6 shadow mt-6 border border-blue-50">
            <h2 class="text-2xl font-semibold text-slate-800">Mari Mulai Berkarya Hari Ini!</h2>
            <p class="text-sm text-slate-500 mt-2">Jelajahi fitur-fitur yang tersedia untuk mengembangkan ide dan berkolaborasi dengan akademisi lainnya.</p>

            <!-- Dashboard grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mt-6">
                <article class="rounded-xl p-5 shadow-sm border hover:shadow-lg transition-transform transform hover:-translate-y-1">
                    <div class="flex items-start gap-4">
                        <div class="w-12 h-12 rounded-full bg-gradient-to-br from-blue-400 to-cyan-400 text-white flex items-center justify-center">
                            <i class="fas fa-rocket"></i>
                        </div>
                        <div class="flex-1">
                            <h3 class="text-lg font-semibold text-slate-800">Posting Inovasi</h3>
                            <p class="text-sm text-slate-500 mt-1">Bagikan ide dan inovasi terbaru Anda. Dapatkan umpan balik berharga dari komunitas akademisi untuk menyempurnakan karya Anda.</p>
                            <div class="mt-3">
                                <a href="{{ route('akademisi.inovasi.create') ?? '#' }}" class="inline-flex items-center gap-2 text-sm font-medium text-blue-600 hover:text-cyan-600">Mulai Posting <i class="fas fa-arrow-right"></i></a>
                            </div>
                        </div>
                    </div>
                </article>

                <article class="rounded-xl p-5 shadow-sm border hover:shadow-lg transition-transform transform hover:-translate-y-1">
                    <div class="flex items-start gap-4">
                        <div class="w-12 h-12 rounded-full bg-gradient-to-br from-indigo-400 to-blue-400 text-white flex items-center justify-center">
                            <i class="fas fa-puzzle-piece"></i>
                        </div>
                        <div class="flex-1">
                            <h3 class="text-lg font-semibold text-slate-800">Bank Solusi</h3>
                            <p class="text-sm text-slate-500 mt-1">Temukan solusi untuk tantangan akademik dan penelitian Anda. Akses pengetahuan dari para ahli di berbagai bidang.</p>
                            <div class="mt-3">
                                <a href="{{ route('akademisi.kolaborasi') ?? '#' }}" class="inline-flex items-center gap-2 text-sm font-medium text-blue-600 hover:text-cyan-600">Jelajahi Solusi <i class="fas fa-arrow-right"></i></a>
                            </div>
                        </div>
                    </div>
                </article>

                <!-- Placeholder card for layout balance -->
                <article class="rounded-xl p-5 shadow-sm border bg-gradient-to-br from-white to-slate-50">
                    <div class="flex items-start gap-4">
                        <div class="w-12 h-12 rounded-full bg-gradient-to-br from-emerald-400 to-green-500 text-white flex items-center justify-center">
                            <i class="fas fa-chart-line"></i>
                        </div>
                        <div class="flex-1">
                            <h3 class="text-lg font-semibold text-slate-800">Statistik</h3>
                            <p class="text-sm text-slate-500 mt-1">Ringkasan aktivitas dan perkembangan proyek Anda dalam satu tampilan.</p>
                            <div class="mt-3">
                                <a href="#" class="inline-flex items-center gap-2 text-sm font-medium text-blue-600 hover:text-cyan-600">Lihat Statistik <i class="fas fa-arrow-right"></i></a>
                            </div>
                        </div>
                    </div>
                </article>
            </div>
        </div>

        <!-- Ruang Diskusi -->
        <section class="mt-8">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-xl font-semibold text-slate-800">Ruang Diskusi & Program Pemerintah</h3>
                    <p class="text-sm text-slate-500">Ikuti diskusi akademik dan program pemerintah yang relevan dengan bidang keahlian Anda.</p>
                </div>
            </div>

            <div class="mt-4 bg-white rounded-2xl shadow p-4 border">
                <div class="flex gap-2 border-b mb-4" id="tab-buttons">
                    <button data-target="diskusi-akademik" class="px-4 py-2 text-sm font-medium text-slate-600 border-b-2 border-transparent hover:text-slate-800 active">Diskusi Akademik</button>
                    <button data-target="program-pemerintah" class="px-4 py-2 text-sm font-medium text-slate-600 border-b-2 border-transparent hover:text-slate-800">Program Pemerintah (OPD)</button>
                </div>

                <div id="diskusi-akademik" class="tab-content grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    <!-- Diskusi Card -->
                    <article class="rounded-xl p-4 bg-slate-50 border-l-4 border-cyan-200">
                        <div class="flex items-center gap-3 mb-3">
                            <div class="w-10 h-10 rounded-full bg-blue-600 text-white flex items-center justify-center">RS</div>
                            <div>
                                <h4 class="font-semibold text-slate-800">Dr. Rina Sari</h4>
                                <span class="text-xs text-slate-500">2 jam yang lalu</span>
                            </div>
                        </div>
                        <p class="text-sm text-slate-600">Bagaimana pendapat Anda tentang penerapan AI dalam penelitian pendidikan? Apakah ada batasan etika yang perlu diperhatikan?</p>
                        <div class="flex gap-2 flex-wrap mt-3">
                            <span class="text-xs px-2 py-1 rounded-full bg-cyan-50 text-cyan-600">AI</span>
                            <span class="text-xs px-2 py-1 rounded-full bg-cyan-50 text-cyan-600">Pendidikan</span>
                            <span class="text-xs px-2 py-1 rounded-full bg-cyan-50 text-cyan-600">Etika</span>
                        </div>
                        <div class="flex items-center justify-between text-xs text-slate-500 mt-3">
                            <div class="flex items-center gap-2"><i class="far fa-comment"></i><span>24 Komentar</span></div>
                            <div class="flex items-center gap-2"><i class="far fa-eye"></i><span>156 Dilihat</span></div>
                        </div>
                    </article>

                    <article class="rounded-xl p-4 bg-slate-50 border-l-4 border-cyan-200">
                        <div class="flex items-center gap-3 mb-3">
                            <div class="w-10 h-10 rounded-full bg-indigo-600 text-white flex items-center justify-center">AP</div>
                            <div>
                                <h4 class="font-semibold text-slate-800">Prof. Andi Pratama</h4>
                                <span class="text-xs text-slate-500">5 jam yang lalu</span>
                            </div>
                        </div>
                        <p class="text-sm text-slate-600">Saya sedang meneliti dampak perubahan iklim terhadap biodiversitas. Ada yang tertarik berkolaborasi atau memiliki data relevan?</p>
                        <div class="flex gap-2 flex-wrap mt-3">
                            <span class="text-xs px-2 py-1 rounded-full bg-cyan-50 text-cyan-600">Perubahan Iklim</span>
                            <span class="text-xs px-2 py-1 rounded-full bg-cyan-50 text-cyan-600">Biodiversitas</span>
                            <span class="text-xs px-2 py-1 rounded-full bg-cyan-50 text-cyan-600">Kolaborasi</span>
                        </div>
                        <div class="flex items-center justify-between text-xs text-slate-500 mt-3">
                            <div class="flex items-center gap-2"><i class="far fa-comment"></i><span>18 Komentar</span></div>
                            <div class="flex items-center gap-2"><i class="far fa-eye"></i><span>98 Dilihat</span></div>
                        </div>
                    </article>

                    <article class="rounded-xl p-4 bg-slate-50 border-l-4 border-cyan-200">
                        <div class="flex items-center gap-3 mb-3">
                            <div class="w-10 h-10 rounded-full bg-rose-600 text-white flex items-center justify-center">SM</div>
                            <div>
                                <h4 class="font-semibold text-slate-800">Sari Mulyani, M.Si.</h4>
                                <span class="text-xs text-slate-500">1 hari yang lalu</span>
                            </div>
                        </div>
                        <p class="text-sm text-slate-600">Bagaimana strategi terbaik untuk mempublikasikan penelitian di jurnal internasional bereputasi? Mohon berbagi pengalaman.</p>
                        <div class="flex gap-2 flex-wrap mt-3">
                            <span class="text-xs px-2 py-1 rounded-full bg-cyan-50 text-cyan-600">Publikasi</span>
                            <span class="text-xs px-2 py-1 rounded-full bg-cyan-50 text-cyan-600">Jurnal Internasional</span>
                            <span class="text-xs px-2 py-1 rounded-full bg-cyan-50 text-cyan-600">Strategi</span>
                        </div>
                        <div class="flex items-center justify-between text-xs text-slate-500 mt-3">
                            <div class="flex items-center gap-2"><i class="far fa-comment"></i><span>32 Komentar</span></div>
                            <div class="flex items-center gap-2"><i class="far fa-eye"></i><span>210 Dilihat</span></div>
                        </div>
                    </article>
                </div>

                <div id="program-pemerintah" class="tab-content hidden grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    <article class="rounded-xl p-4 bg-emerald-50 border-l-4 border-emerald-200">
                        <div class="flex items-center gap-3 mb-3">
                            <div class="w-10 h-10 rounded-full bg-emerald-600 text-white flex items-center justify-center">DK</div>
                            <div>
                                <h4 class="font-semibold text-slate-800">Dinas Kesehatan</h4>
                                <span class="text-xs text-slate-500">3 hari yang lalu</span>
                            </div>
                            <span class="ml-auto inline-block text-xs bg-emerald-600 text-white px-2 py-1 rounded">OPD</span>
                        </div>
                        <p class="text-sm text-slate-600">Program "Sehat Bersama" membutuhkan penelitian tentang efektivitas intervensi kesehatan masyarakat di daerah perkotaan. Bergabunglah dengan kami!</p>
                        <div class="flex gap-2 flex-wrap mt-3">
                            <span class="text-xs px-2 py-1 rounded-full bg-emerald-100 text-emerald-600">Kesehatan Masyarakat</span>
                            <span class="text-xs px-2 py-1 rounded-full bg-emerald-100 text-emerald-600">Penelitian</span>
                            <span class="text-xs px-2 py-1 rounded-full bg-emerald-100 text-emerald-600">Kolaborasi</span>
                        </div>
                        <div class="flex items-center justify-between text-xs text-slate-500 mt-3">
                            <div class="flex items-center gap-2"><i class="far fa-calendar"></i><span>Deadline: 30 Nov 2023</span></div>
                            <div class="flex items-center gap-2"><i class="far fa-eye"></i><span>89 Dilihat</span></div>
                        </div>
                    </article>

                    <article class="rounded-xl p-4 bg-emerald-50 border-l-4 border-emerald-200">
                        <div class="flex items-center gap-3 mb-3">
                            <div class="w-10 h-10 rounded-full bg-emerald-600 text-white flex items-center justify-center">DP</div>
                            <div>
                                <h4 class="font-semibold text-slate-800">Dinas Pendidikan</h4>
                                <span class="text-xs text-slate-500">1 minggu yang lalu</span>
                            </div>
                            <span class="ml-auto inline-block text-xs bg-emerald-600 text-white px-2 py-1 rounded">OPD</span>
                        </div>
                        <p class="text-sm text-slate-600">Program "Digitalisasi Sekolah" membutuhkan ahli teknologi pendidikan untuk evaluasi implementasi platform pembelajaran digital.</p>
                        <div class="flex gap-2 flex-wrap mt-3">
                            <span class="text-xs px-2 py-1 rounded-full bg-emerald-100 text-emerald-600">Teknologi Pendidikan</span>
                            <span class="text-xs px-2 py-1 rounded-full bg-emerald-100 text-emerald-600">Evaluasi</span>
                            <span class="text-xs px-2 py-1 rounded-full bg-emerald-100 text-emerald-600">Digitalisasi</span>
                        </div>
                        <div class="flex items-center justify-between text-xs text-slate-500 mt-3">
                            <div class="flex items-center gap-2"><i class="far fa-calendar"></i><span>Deadline: 15 Des 2023</span></div>
                            <div class="flex items-center gap-2"><i class="far fa-eye"></i><span>124 Dilihat</span></div>
                        </div>
                    </article>

                    <article class="rounded-xl p-4 bg-emerald-50 border-l-4 border-emerald-200">
                        <div class="flex items-center gap-3 mb-3">
                            <div class="w-10 h-10 rounded-full bg-emerald-600 text-white flex items-center justify-center">DLH</div>
                            <div>
                                <h4 class="font-semibold text-slate-800">Dinas Lingkungan Hidup</h4>
                                <span class="text-xs text-slate-500">2 minggu yang lalu</span>
                            </div>
                            <span class="ml-auto inline-block text-xs bg-emerald-600 text-white px-2 py-1 rounded">OPD</span>
                        </div>
                        <p class="text-sm text-slate-600">Program "Kota Hijau" mengundang peneliti untuk studi tentang pengelolaan sampah berkelanjutan dan daur ulang di perkotaan.</p>
                        <div class="flex gap-2 flex-wrap mt-3">
                            <span class="text-xs px-2 py-1 rounded-full bg-emerald-100 text-emerald-600">Lingkungan</span>
                            <span class="text-xs px-2 py-1 rounded-full bg-emerald-100 text-emerald-600">Pengelolaan Sampah</span>
                            <span class="text-xs px-2 py-1 rounded-full bg-emerald-100 text-emerald-600">Berkelanjutan</span>
                        </div>
                        <div class="flex items-center justify-between text-xs text-slate-500 mt-3">
                            <div class="flex items-center gap-2"><i class="far fa-calendar"></i><span>Deadline: 10 Jan 2024</span></div>
                            <div class="flex items-center gap-2"><i class="far fa-eye"></i><span>167 Dilihat</span></div>
                        </div>
                    </article>
                </div>
            </div>
        </section>

        <!-- Project Saya -->
        <section class="mt-8 mb-8">
            <div class="bg-white rounded-2xl shadow p-6 border">
                <h3 class="text-xl font-semibold text-slate-800">Project Saya</h3>
                <p class="text-sm text-slate-500 mt-1">Ringkasan kontribusi dan aktivitas Anda di portal akademisi.</p>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mt-4">
                    <div class="rounded-xl p-4 bg-slate-50 border hover:shadow">
                        <div class="text-3xl font-extrabold text-blue-600">12</div>
                        <div class="text-sm text-slate-500">Inovasi</div>
                    </div>

                    <div class="rounded-xl p-4 bg-slate-50 border hover:shadow">
                        <div class="text-3xl font-extrabold text-blue-600">5</div>
                        <div class="text-sm text-slate-500">Kolaborasi</div>
                    </div>
                </div>

                <div class="mt-6 bg-white rounded-lg p-4 border">
                    <div class="flex items-center justify-between">
                        <div>
                            <h4 class="text-lg font-semibold text-slate-800">Statistik Project 1 Tahun Terakhir</h4>
                            <div class="text-xs text-slate-500">Oktober 2022 - September 2023</div>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mt-4">
                        <div class="p-3 rounded-lg bg-slate-50 border">
                            <div class="text-2xl font-bold text-slate-800">8</div>
                            <div class="text-xs text-slate-500">Project Diterbitkan</div>
                            <div class="text-xs text-emerald-600 mt-2">↑ 25% dari tahun lalu</div>
                        </div>

                        <div class="p-3 rounded-lg bg-slate-50 border">
                            <div class="text-2xl font-bold text-slate-800">1,245</div>
                            <div class="text-xs text-slate-500">Total Dilihat</div>
                            <div class="text-xs text-emerald-600 mt-2">↑ 42% dari tahun lalu</div>
                        </div>

                        <div class="p-3 rounded-lg bg-slate-50 border">
                            <div class="text-2xl font-bold text-slate-800">89</div>
                            <div class="text-xs text-slate-500">Komentar Diterima</div>
                            <div class="text-xs text-emerald-600 mt-2">↑ 18% dari tahun lalu</div>
                        </div>

                        <div class="p-3 rounded-lg bg-slate-50 border">
                            <div class="text-2xl font-bold text-slate-800">3</div>
                            <div class="text-xs text-slate-500">Kolaborasi Baru</div>
                            <div class="text-xs text-rose-600 mt-2">↓ 10% dari tahun lalu</div>
                        </div>
                    </div>

                    <div class="mt-4 h-56 flex items-center justify-center bg-gradient-to-br from-slate-100 to-slate-200 rounded-lg">
                        <div class="text-slate-500 text-sm flex items-center">
                            <i class="fas fa-chart-bar mr-3"></i>
                            <span>Grafik Perkembangan Project 1 Tahun Terakhir (placeholder)</span>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const buttons = document.querySelectorAll('#tab-buttons button');
        const contents = document.querySelectorAll('.tab-content');

        buttons.forEach(btn => {
            btn.addEventListener('click', () => {
                buttons.forEach(b => b.classList.remove('border-b-2', 'border-blue-500', 'text-slate-800', 'active'));
                btn.classList.add('border-b-2', 'border-blue-500', 'text-slate-800', 'active');

                contents.forEach(c => c.classList.add('hidden'));
                const target = document.getElementById(btn.getAttribute('data-target'));
                if (target) target.classList.remove('hidden');
            });
        });
    });
</script>
@endpush
