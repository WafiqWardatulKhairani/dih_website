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
            Ruang <span class="text-secondary">Diskusi</span>
        </h1>
        <p class="text-xl md:text-2xl max-w-3xl mx-auto mb-10 leading-relaxed">
            Berkolaborasi dan diskusikan ide-ide inovatif dengan pemerintah daerah dan akademisi.
        </p>
    </div>
</section>

<!-- Discussion Categories -->
<section class="bg-white py-12">
    <div class="container mx-auto px-6 md:px-12">
        <h2 class="text-2xl font-bold text-dark mb-8 text-center">Kategori Diskusi</h2>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            @foreach(['Semua', 'Populer', 'Terbaru', 'Terjawab', 'Program', 'Solusi', 'Teknologi', 'Kebijakan'] as $category)
            <a href="#" class="bg-gray-50 p-4 rounded-xl text-center hover:bg-primary hover:text-white transition {{ $loop->first ? 'bg-primary text-white' : '' }}">
                <span class="font-medium">{{ $category }}</span>
            </a>
            @endforeach
        </div>
    </div>
</section>

<!-- Discussion List -->
<section class="bg-gray-50 py-16">
    <div class="container mx-auto px-6 md:px-12">
        <div class="flex flex-col md:flex-row justify-between items-center mb-8">
            <h2 class="text-2xl font-bold text-dark mb-4 md:mb-0">Diskusi Terbaru</h2>
            <a href="#" class="bg-primary text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
                </svg>
                Diskusi Baru
            </a>
        </div>
        
        <div class="space-y-6">
            @for ($i = 1; $i <= 5; $i++)
            <div class="bg-white rounded-xl p-6 shadow-sm card-hover">
                <div class="flex items-start mb-4">
                    <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center text-primary font-bold mr-4">
                        U{{ $i }}
                    </div>
                    <div class="flex-1">
                        <h3 class="text-xl font-semibold text-dark mb-2">Bagaimana implementasi smart city yang efektif untuk kota menengah?</h3>
                        <div class="flex flex-wrap items-center text-sm text-gray-500 mb-3">
                            <span class="mr-4">Oleh: User Name {{ $i }}</span>
                            <span class="mr-4">{{ now()->subHours($i*3)->diffForHumans() }}</span>
                            <span class="flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                                {{ $i * 5 }} Partisipan
                            </span>
                        </div>
                    </div>
                </div>
                <p class="text-gray-600 mb-6">Saya sedang meneliti implementasi smart city untuk kota dengan penduduk sekitar 500-800 ribu jiwa. Apa saja komponen kunci yang harus diprioritaskan dan bagaimana strategi implementasinya?</p>
                
                <div class="flex justify-between items-center">
                    <div class="flex items-center">
                        <span class="bg-blue-100 text-primary px-3 py-1 rounded-full text-sm font-medium mr-2">
                            Smart City
                        </span>
                        <span class="flex items-center text-sm text-gray-500">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z" />
                            </svg>
                            {{ $i * 12 }} Balasan
                        </span>
                    </div>
                    <a href="#" class="text-primary font-semibold hover:text-secondary transition flex items-center">
                        Ikuti Diskusi
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-1" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M12.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </a>
                </div>
            </div>
            @endfor
        </div>
        
        <!-- Pagination -->
        <div class="mt-12 flex justify-center">
            <nav class="flex items-center space-x-2">
                <a href="#" class="px-3 py-1 rounded border border-gray-300 text-gray-500 hover:bg-gray-50">&laquo;</a>
                <a href="#" class="px-3 py-1 rounded border border-primary bg-primary text-white">1</a>
                <a href="#" class="px-3 py-1 rounded border border-gray-300 text-gray-700 hover:bg-gray-50">2</a>
                <a href="#" class="px-3 py-1 rounded border border-gray-300 text-gray-700 hover:bg-gray-50">3</a>
                <a href="#" class="px-3 py-1 rounded border border-gray-300 text-gray-500 hover:bg-gray-50">&raquo;</a>
            </nav>
        </div>
    </div>
</section>

<!-- Popular Topics -->
<section class="bg-white py-16">
    <div class="container mx-auto px-6 md:px-12">
        <h2 class="text-2xl font-bold text-dark mb-8">Topik Populer</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @for ($i = 1; $i <= 3; $i++)
            <div class="bg-gray-50 rounded-xl p-6 card-hover">
                <div class="flex items-center mb-4">
                    <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center text-primary font-bold mr-3">
                        T{{ $i }}
                    </div>
                    <h3 class="font-semibold text-dark">Implementasi IoT untuk Smart City</h3>
                </div>
                <p class="text-gray-600 mb-4">Diskusi tentang penerapan Internet of Things dalam pengembangan smart city.</p>
                <div class="flex justify-between items-center text-sm text-gray-500">
                    <span>{{ $i * 24 }} Diskusi</span>
                    <span>{{ $i * 137 }} Partisipan</span>
                </div>
            </div>
            @endfor
        </div>
    </div>
</section>
@endsection