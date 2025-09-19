@extends('layouts.app')

@section('content')
<section class="bg-white py-16">
    <div class="container mx-auto px-6 md:px-12">
        <h1 class="text-4xl font-bold text-center text-gray-800 mb-6">
            Portal OPD – Pemerintah
        </h1>
        <p class="text-center text-gray-600 max-w-2xl mx-auto mb-12">
            Selamat datang di Portal OPD Digital Innovation Hub.
            Di sini pemerintah daerah dapat mengelola program inovasi,
            berkolaborasi dengan akademisi,
            dan memantau perkembangan solusi digital untuk percepatan inovasi.
        </p>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="bg-gray-100 p-6 rounded-xl shadow hover:shadow-lg transition">
                <h3 class="text-xl font-semibold mb-3 text-gray-800">Program Prioritas</h3>
                <p class="text-gray-600 mb-4">
                    Kelola dan pantau program prioritas daerah secara terintegrasi.
                </p>
                <a href="#" class="text-blue-600 font-semibold hover:underline">Lihat Program →</a>
            </div>

            <div class="bg-gray-100 p-6 rounded-xl shadow hover:shadow-lg transition">
                <h3 class="text-xl font-semibold mb-3 text-gray-800">Bank Solusi</h3>
                <p class="text-gray-600 mb-4">
                    Temukan ide dan solusi inovatif dari berbagai pihak untuk diterapkan di daerah.
                </p>
                <a href="#" class="text-blue-600 font-semibold hover:underline">Jelajahi Solusi →</a>
            </div>

            <div class="bg-gray-100 p-6 rounded-xl shadow hover:shadow-lg transition">
                <h3 class="text-xl font-semibold mb-3 text-gray-800">Kolaborasi Akademisi</h3>
                <p class="text-gray-600 mb-4">
                    Ajak akademisi untuk penelitian bersama atau pendampingan program.
                </p>
                <a href="#" class="text-blue-600 font-semibold hover:underline">Cari Mitra →</a>
            </div>
        </div>
    </div>
</section>
@endsection
