<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GovInnovate - Pusat Inovasi Pemerintah & Akademisi</title>
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Styles CSS -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    
    <!-- Livewire Styles -->
    @livewireStyles
</head>
<body class="text-gray-800 font-poppins">
    <!-- Floating Background Elements -->
    <div class="fixed inset-0 overflow-hidden -z-10">
        <div class="absolute top-20 left-10 w-32 h-32 rounded-full bg-blue-100 opacity-20 blur-xl"></div>
        <div class="absolute bottom-20 right-10 w-40 h-40 rounded-full bg-green-100 opacity-20 blur-xl"></div>
    </div>

    @include('components.layout.navigation')
    
    <main>
        @yield('content')
    </main>
    
    @include('components.layout.footer')

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
    @livewireScripts
</body>
</html>