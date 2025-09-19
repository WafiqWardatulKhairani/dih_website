<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Digital Innovation Hub') }}</title>
    <link rel="icon" href="{{ asset('images/logo.png') }}" type="image/png">


    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Custom CSS (jika masih dipakai) -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

    <!-- Vite -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- Livewire Style --}}
    @livewireStyles

    @stack('styles')
    
</head>

<body class="font-sans antialiased">
    <div class="min-h-screen bg-gray-100">
        {{-- Navigation --}}
        @if(isset($customNavigation) && $customNavigation)
            {{ $customNavigation }}
        @else
            @include('components.layout.navigation')
        @endif

        {{-- Page Content --}}
        <main>
            @yield('content')
        </main>

        {{-- Footer --}}
        @if(isset($customFooter) && $customFooter)
            {{ $customFooter }}
        @else
            @include('components.layout.footer')
        @endif
    </div>

    @stack('scripts')

    {{-- SweetAlert --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    {{-- Livewire Script --}}
    @livewireScripts

    <script>
    document.addEventListener('DOMContentLoaded', function () {
        // data dari backend
        const errors  = @json($errors->all());
        const success = @json(session('success'));
        const error   = @json(session('error'));

        // tampilkan error validasi
        if (errors && errors.length > 0) {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                html: errors.join('<br>'),
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'Mengerti'
            });
        }

        // pesan sukses
        if (success) {
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: success,
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'Oke'
            });
        }

        // pesan gagal
        if (error) {
            Swal.fire({
                icon: 'error',
                title: 'Gagal!',
                text: error,
                confirmButtonColor: '#d33',
                confirmButtonText: 'Coba Lagi'
            });
        }
    });

    // Handle Livewire events untuk v3
    document.addEventListener('livewire:initialized', () => {
        Livewire.on('swal:success', (data) => {
            Swal.fire({
                icon: 'success',
                title: data.title || 'Berhasil!',
                text: data.message || '',
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'Oke',
                timer: data.timer || 10000,
                timerProgressBar: true,
                willClose: () => {
                    if (data.redirect) {
                        window.location.href = data.redirect;
                    }
                }
            }).then((result) => {
                if (data.redirect && (result.dismiss === Swal.DismissReason.timer || result.isConfirmed)) {
                    window.location.href = data.redirect;
                }
            });
        });

        Livewire.on('swal:error', (data) => {
            Swal.fire({
                icon: 'error',
                title: data.title || 'Gagal!',
                text: data.message || '',
                confirmButtonColor: '#d33',
                confirmButtonText: 'Coba Lagi'
            });
        });
    });
    </script>
</body>
</html>