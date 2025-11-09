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
    <link rel="stylesheet" href="{{ asset('css/pemerintah.css') }}">
    <link rel="stylesheet" href="{{ asset('css/akademisi.css') }}">
    <link rel="stylesheet" href="{{ asset('css/kolaborasi.css') }}">

    <!-- Vite -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- Livewire Style --}}
    @livewireStyles

    @stack('styles')
</head>

<body class="font-sans antialiased" style="background-color: transparent;">
    <div class="min-h-screen @yield('body-bg', 'bg-gray-100')">
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
    // Track jika notif sudah ditampilkan
    let notificationShown = false;

    document.addEventListener('DOMContentLoaded', function () {
        // Skip jika page di-load dari cache (back/forward button)
        if (performance.navigation.type === 2 || window.performance.getEntriesByType("navigation")[0]?.type === 'back_forward') {
            return;
        }

        // Skip jika notif sudah pernah ditampilkan di session ini
        if (sessionStorage.getItem('notificationShown') === 'true') {
            return;
        }

        // Data dari backend
        const errors  = @json($errors->all());
        const success = @json(session('success'));
        const error   = @json(session('error'));

        // Tampilkan error validasi
        if (errors && errors.length > 0) {
            showErrorAlert('Oops...', errors.join('<br>'));
            markNotificationShown();
        }

        // Pesan sukses - AUTO CLOSE & CLEAR SESSION
        if (success && !notificationShown) {
            showSuccessAlert('Berhasil!', success);
            markNotificationShown();
            
            // Clear session success setelah ditampilkan
            setTimeout(() => {
                clearSessionSuccess();
            }, 100);
        }

        // Pesan gagal
        if (error && !notificationShown) {
            showErrorAlert('Gagal!', error);
            markNotificationShown();
        }
    });

    // Handle browser navigation
    window.addEventListener('pageshow', function(event) {
        if (event.persisted) {
            // Page di-load dari cache (back button)
            clearNotificationState();
        }
    });

    // Handle sebelum page unload (refresh/tutup tab)
    window.addEventListener('beforeunload', function() {
        clearNotificationState();
    });

    // ========== FUNCTIONS ==========

    function showSuccessAlert(title, message) {
        Swal.fire({
            icon: 'success',
            title: title,
            text: message,
            confirmButtonColor: '#3085d6',
            confirmButtonText: 'Oke',
            timer: 4000, // Auto close setelah 4 detik
            timerProgressBar: true,
            allowOutsideClick: true,
            allowEscapeKey: true,
            didOpen: () => {
                notificationShown = true;
            },
            didClose: () => {
                clearNotificationState();
            }
        });
    }

    function showErrorAlert(title, message) {
        Swal.fire({
            icon: 'error',
            title: title,
            html: message,
            confirmButtonColor: '#d33',
            confirmButtonText: 'Mengerti',
            allowOutsideClick: true,
            allowEscapeKey: true,
            didOpen: () => {
                notificationShown = true;
            }
        });
    }

    function markNotificationShown() {
        notificationShown = true;
        sessionStorage.setItem('notificationShown', 'true');
    }

    function clearNotificationState() {
        notificationShown = false;
        sessionStorage.removeItem('notificationShown');
    }

    function clearSessionSuccess() {
        // Clear session via AJAX (optional)
        fetch('/clear-session-success', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({})
        }).catch(err => console.log('Clear session error:', err));
    }

    // Handle Livewire events untuk v3
    document.addEventListener('livewire:initialized', () => {
        Livewire.on('swal:success', (data) => {
            showSuccessAlert(data.title || 'Berhasil!', data.message || '');
            
            if (data.redirect) {
                setTimeout(() => {
                    window.location.href = data.redirect;
                }, data.timer || 4000);
            }
        });

        Livewire.on('swal:error', (data) => {
            showErrorAlert(data.title || 'Gagal!', data.message || '');
        });
    });

    // Global function untuk manual trigger alert
    window.showAlert = {
        success: (message, title = 'Berhasil!') => showSuccessAlert(title, message),
        error: (message, title = 'Gagal!') => showErrorAlert(title, message)
    };
    </script>

    {{-- Tambah route untuk clear session (optional) --}}
    @php
    // Ini bisa dipindah ke routes/web.php kalau mau permanen
    if(request()->is('clear-session-success')) {
        session()->forget('success');
        session()->forget('error');
    }
    @endphp
</body>
</html>