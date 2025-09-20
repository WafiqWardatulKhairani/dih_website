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
    </style>
@endsection

@section('content')
<!-- Hero Section -->
<section class="hero-bg text-white py-24 md:py-32">
    <div class="container mx-auto px-6 md:px-12 text-center">
        <h1 class="text-4xl md:text-6xl font-extrabold mb-6 leading-tight">
            Solusi <span class="text-secondary">Inkubasi</span>
        </h1>
        <p class="text-xl md:text-2xl max-w-3xl mx-auto mb-10 leading-relaxed">
            Halaman ini sedang dalam pengembangan. Segera hadir!
        </p>
        <div class="mt-8">
            <a href="{{ route('home') }}" class="inline-flex items-center bg-white text-primary px-6 py-3 rounded-lg font-semibold hover:bg-blue-50 transition">
                Kembali ke Beranda
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M9.707 14.707a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 1.414L7.414 9H15a1 1 0 110 2H7.414l2.293 2.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                </svg>
            </a>
        </div>
    </div>
</section>

<!-- Coming Soon Section -->
<section class="bg-white py-20">
    <div class="container mx-auto px-6 md:px-12 text-center">
        <div class="max-w-2xl mx-auto">
            <div class="w-32 h-32 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-8">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z" />
                </svg>
            </div>
            <h2 class="text-3xl font-bold text-dark mb-6">Sedang Dalam Pengembangan</h2>
            <p class="text-gray-600 mb-8">Kami sedang bekerja keras untuk menyiapkan halaman Inkubasi yang akan membantu proses pengembangan solusi inovatif dari tahap ide hingga implementasi.</p>
            
            <div class="bg-gray-50 rounded-xl p-6 mb-8">
                <h3 class="text-xl font-semibold text-dark mb-4">Fitur yang Akan Hadir:</h3>
                <ul class="text-left grid grid-cols-1 md:grid-cols-2 gap-3 text-gray-600">
                    <li class="flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-500 mr-2" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                        </svg>
                        Program mentoring solusi
                    </li>
                    <li class="flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-500 mr-2" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                        </svg>
                        Pendampingan teknis
                    </li>
                    <li class="flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-500 mr-2" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                        </svg>
                        Akses ke pakar industri
                    </li>
                    <li class="flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-500 mr-2" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                        </svg>
                        Program piloting solusi
                    </li>
                </ul>
            </div>
            
            <p class="text-gray-600">Silakan kembali lagi nanti atau hubungi kami untuk informasi lebih lanjut.</p>
        </div>
    </div>
</section>
@endsection