@extends('layouts.app')

@section('content')

{{-- ========== HERO ========== --}}
<section class="relative bg-gradient-to-br from-slate-700 via-slate-600 to-slate-500 text-white">
    <div class="container mx-auto px-6 md:px-12 py-24 text-center">
        <h1 class="text-5xl md:text-6xl font-extrabold mb-6">
            Portal OPD – Pemerintah
        </h1>
        <p class="text-lg md:text-xl max-w-3xl mx-auto leading-relaxed text-slate-100">
            Selamat datang di <span class="font-semibold">Portal OPD Digital Innovation Hub</span>.<br>
            Pemerintah daerah dapat mengelola program inovasi, berkolaborasi dengan akademisi,
            dan memantau perkembangan solusi digital untuk percepatan inovasi.
        </p>
    </div>
</section>

{{-- ========== FITUR ========== --}}
<section class="bg-white py-16">
    <div class="container mx-auto px-6 md:px-12">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            @php
            $cards = [
                ['title'=>'Program Prioritas','desc'=>'Kelola dan pantau program prioritas daerah.','icon'=>'M9 17v-6h13V7a2 2 0 00-2-2H9V3L1 9l8 6v-2h4v2z'],
                ['title'=>'Bank Solusi','desc'=>'Temukan ide dan solusi inovatif dari berbagai pihak.','icon'=>'M12 8c-1.657 0-3 1.343-3 3...'],
                ['title'=>'Kolaborasi Akademisi','desc'=>'Ajak akademisi untuk penelitian bersama atau pendampingan program.','icon'=>'M17 20h5V4H2v16...'],
            ];
            @endphp
            @foreach($cards as $c)
            <div class="bg-gray-50 border border-gray-200 p-8 rounded-xl shadow-sm hover:shadow-md transition">
                <div class="flex items-center justify-center mb-5 text-slate-600">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-12 h-12" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $c['icon'] }}" />
                    </svg>
                </div>
                <h3 class="text-xl font-semibold mb-3 text-gray-800">{{ $c['title'] }}</h3>
                <p class="text-gray-600 mb-6">{{ $c['desc'] }}</p>
                <a href="#"
                   class="inline-block bg-slate-700 text-white px-5 py-2 rounded-full font-medium hover:bg-slate-800 transition">
                   Selengkapnya
                </a>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ========== STATISTIK ========== --}}
<section class="bg-gray-100 py-16">
    <div class="container mx-auto px-6 md:px-12">
        <h2 class="text-3xl font-bold text-center text-gray-800 mb-12">Statistik Inovasi Daerah</h2>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-8 text-center">
            @foreach ([['Program Prioritas','12'],['Kebutuhan Terdata','5'],['Solusi Terkirim','8'],['Kolaborasi Aktif','3']] as [$label, $val])
            <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-8">
                <div class="text-4xl font-extrabold text-slate-700 mb-2">{{ $val }}</div>
                <p class="text-gray-700">{{ $label }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ========== PROGRAM TERBARU & CTA ========== --}}
<section class="bg-white py-16">
    <div class="container mx-auto px-6 md:px-12">
        <h2 class="text-3xl font-bold text-center text-gray-800 mb-12">Program & Kebutuhan Terbaru</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
            @for ($i = 1; $i <= 4; $i++)
            <div class="bg-gray-50 border border-gray-200 p-8 rounded-xl shadow hover:shadow-md transition">
                <span class="inline-block mb-3 px-3 py-1 text-xs font-medium bg-slate-200 text-slate-700 rounded-full">
                    Program Prioritas
                </span>
                <h3 class="text-xl font-semibold text-gray-800 mb-2">
                    Peningkatan Infrastruktur Digital {{ $i }}
                </h3>
                <p class="text-gray-600 mb-4">
                    Deskripsi singkat kebutuhan atau program inovasi daerah yang dapat dikerjasamakan
                    dengan akademisi.
                </p>
                <a href="#" class="text-slate-700 font-semibold hover:underline">Detail →</a>
            </div>
            @endfor
        </div>
    </div>
</section>

<section class="bg-gradient-to-r from-emerald-700 to-emerald-600 text-white py-16 text-center">
    <h3 class="text-2xl font-bold mb-4">Akademisi? Mari Berkolaborasi!</h3>
    <p class="max-w-xl mx-auto mb-8 text-emerald-100">
        Bergabunglah untuk penelitian bersama atau pendampingan program prioritas daerah.
    </p>
    <a href="#"
       class="inline-block bg-white text-emerald-700 px-8 py-3 rounded-full font-semibold hover:bg-gray-100 transition">
       Lihat Kebutuhan Penelitian
    </a>
</section>

@endsection
