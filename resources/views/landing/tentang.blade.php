@extends('layouts.app')

@section('styles')
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#1e40af',
                        secondary: '#0ea5e9',
                        accent: '#3b82f6',
                        dark: '#1e293b',
                        light: '#f8fafc'
                    }
                }
            }
        }
    </script>
    <style>
        .hero-bg {
            background: linear-gradient(135deg, #1e40af 0%, #0ea5e9 100%);
        }
        .card-hover {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .card-hover:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1);
        }
    </style>
@endsection

@section('content')
<!-- Hero Section -->
<section class="hero-bg text-white py-24 md:py-32">
    <div class="container mx-auto px-6 md:px-12 text-center">
        <h1 class="text-4xl md:text-6xl font-extrabold mb-6 leading-tight">
            Tentang <span class="text-secondary">Digital Innovation Hub</span>
        </h1>
        <p class="text-xl md:text-2xl max-w-3xl mx-auto mb-10 leading-relaxed">
            Menghubungkan pemerintah daerah dengan akademisi untuk menciptakan inovasi digital yang berdampak.
        </p>
    </div>
</section>

<!-- About Content -->
<section class="bg-white py-16">
    <div class="container mx-auto px-6 md:px-12">
        <div class="max-w-4xl mx-auto">
            <h2 class="text-3xl font-bold text-dark mb-8 text-center">Visi dan Misi</h2>
            
            <div class="bg-blue-50 rounded-2xl p-8 mb-12">
                <h3 class="text-2xl font-semibold text-primary mb-4">Visi Kami</h3>
                <p class="text-gray-700 text-lg">Menjadi platform terdepan dalam mendorong kolaborasi antara pemerintah daerah dan akademisi untuk menciptakan inovasi digital yang mempercepat transformasi digital daerah.</p>
            </div>
            
            <div class="mb-12">
                <h3 class="text-2xl font-semibold text-dark mb-6">Misi Kami</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    @foreach([
                        'Memfasilitasi pertemuan antara kebutuhan riil pemerintah daerah dengan solusi inovatif dari akademisi',
                        'Mendorong terciptanya ekosistem inovasi digital yang berkelanjutan di tingkat daerah',
                        'Mempercepat adopsi teknologi digital dalam pelayanan publik',
                        'Meningkatkan kapasitas digital pemerintah daerah melalui kolaborasi dengan akademisi'
                    ] as $mission)
                    <div class="bg-gray-50 rounded-xl p-6 card-hover">
                        <div class="flex items-start">
                            <div class="w-8 h-8 bg-primary rounded-full flex items-center justify-center text-white mr-4 flex-shrink-0">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <p class="text-gray-700">{{ $mission }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Team Section -->
<section class="bg-gray-50 py-16">
    <div class="container mx-auto px-6 md:px-12">
        <h2 class="text-3xl font-bold text-dark mb-12 text-center">Tim Kami</h2>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
            @for ($i = 1; $i <= 4; $i++)
            <div class="bg-white rounded-xl p-6 text-center card-hover">
                <div class="w-24 h-24 bg-blue-100 rounded-full mx-auto mb-6 flex items-center justify-center text-primary text-2xl font-bold">
                    TM{{ $i }}
                </div>
                <h3 class="text-xl font-semibold text-dark mb-2">Nama Tim {{ $i }}</h3>
                <p class="text-gray-600 mb-4">Peran Tim {{ $i }}</p>
                <div class="flex justify-center space-x-4">
                    <a href="#" class="text-gray-400 hover:text-primary transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z"/>
                        </svg>
                    </a>
                    <a href="#" class="text-gray-400 hover:text-primary transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723 10 10 0 01-3.127 1.184 4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/>
                        </svg>
                    </a>
                </div>
            </div>
            @endfor
        </div>
    </div>
</section>

<!-- Partners Section -->
<section class="bg-white py-16">
    <div class="container mx-auto px-6 md:px-12">
        <h2 class="text-3xl font-bold text-dark mb-12 text-center">Mitra Kerja Sama</h2>
        
        <div class="grid grid-cols-2 md:grid-cols-4 gap-8 items-center">
            @for ($i = 1; $i <= 8; $i++)
            <div class="bg-gray-50 rounded-xl p-8 flex items-center justify-center h-32">
                <span class="text-gray-400 font-semibold">Mitra {{ $i }}</span>
            </div>
            @endfor
        </div>
    </div>
</section>

<!-- Contact Section -->
<section class="bg-gradient-to-r from-primary to-secondary py-16 text-white">
    <div class="container mx-auto px-6 md:px-12">
        <div class="max-w-4xl mx-auto text-center">
            <h2 class="text-3xl font-bold mb-6">Hubungi Kami</h2>
            <p class="mb-8">Kami selalu terbuka untuk diskusi dan kolaborasi dengan semua pemangku kepentingan.</p>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-12">
                <div>
                    <div class="w-12 h-12 bg-white/20 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                        </svg>
                    </div>
                    <h3 class="font-semibold mb-2">Telepon</h3>
                    <p class="text-blue-100">(021) 123-4567</p>
                </div>
                <div>
                    <div class="w-12 h-12 bg-white/20 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <h3 class="font-semibold mb-2">Email</h3>
                    <p class="text-blue-100">info@portalopd.example</p>
                </div>
                <div>
                    <div class="w-12 h-12 bg-white/20 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                    </div>
                    <h3 class="font-semibold mb-2">Lokasi</h3>
                    <p class="text-blue-100">Jl. Contoh No. 123, Kota Contoh</p>
                </div>
            </div>
            
            <a href="mailto:info@portalopd.example" class="inline-flex items-center bg-white text-primary px-6 py-3 rounded-lg font-semibold hover:bg-blue-50 transition">
                Kirim Pesan
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-8.707l-3-3a1 1 0 00-1.414 0l-3 3a1 1 0 001.414 1.414L9 9.414V13a1 1 0 102 0V9.414l1.293 1.293a1 1 0 001.414-1.414z" clip-rule="evenodd" />
                </svg>
            </a>
        </div>
    </div>
</section>
@endsection