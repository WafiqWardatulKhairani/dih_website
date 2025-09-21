<!DOCTYPE html>
<html lang="id" class="h-full">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Portal - Digital Innovation Hub</title>
    <link rel="icon" href="{{ asset('images/logo.png') }}" type="image/png">

    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: {
                            50: '#f0f9ff',
                            100: '#e0f2fe',
                            500: '#0ea5e9',
                            600: '#0284c7',
                            700: '#0369a1',
                            800: '#075985',
                            900: '#0c4a6e',
                        }
                    }
                }
            }
        }
    </script>
</head>

<body class="h-full bg-gray-50">
    <div class="flex h-screen">
        <!-- Sidebar -->
        <div class="w-64 bg-primary-900 text-white flex flex-col">
            <div class="p-6 border-b border-primary-800">
                <h1 class="text-xl font-semibold">Admin Portal</h1>
                <p class="text-sm text-primary-300 mt-1">Digital Innovation Hub</p>
            </div>

            <nav class="flex-1 px-4 py-6">
                <div class="space-y-2">
                    <a href="{{ route('admin.index') }}" class="flex items-center px-4 py-3 rounded-lg text-sm font-medium transition-colors duration-200 {{ request()->is('admin') ? 'bg-primary-800 text-white' : 'text-primary-200 hover:bg-primary-800 hover:text-white' }}">
                        <i class="fas fa-tachometer-alt w-5 mr-3"></i>
                        Dashboard
                    </a>
                    <a href="{{ route('admin.users.index') }}" class="flex items-center px-4 py-3 rounded-lg text-sm font-medium transition-colors duration-200 {{ request()->is('admin/users*') ? 'bg-primary-800 text-white' : 'text-primary-200 hover:bg-primary-800 hover:text-white' }}">
                        <i class="fas fa-users w-5 mr-3"></i>
                        Manajemen User
                    </a>
                    <a href="{{ route('admin.moderasi-konten') }}" class="flex items-center px-4 py-3 rounded-lg text-sm font-medium transition-colors duration-200 {{ request()->is('admin/moderasi-konten*') ? 'bg-primary-800 text-white' : 'text-primary-200 hover:bg-primary-800 hover:text-white' }}">
                        <i class="fas fa-shield-alt w-5 mr-3"></i>
                        Moderasi Konten
                    </a>
                    <a href="{{ route('admin.statistik') }}" class="flex items-center px-4 py-3 rounded-lg text-sm font-medium transition-colors duration-200 {{ request()->is('admin/statistik*') ? 'bg-primary-800 text-white' : 'text-primary-200 hover:bg-primary-800 hover:text-white' }}">
                        <i class="fas fa-chart-bar w-5 mr-3"></i>
                        Statistik
                    </a>
                    <a href="{{ route('admin.pengaturan-sistem') }}" class="flex items-center px-4 py-3 rounded-lg text-sm font-medium transition-colors duration-200 {{ request()->is('admin/pengaturan-sistem*') ? 'bg-primary-800 text-white' : 'text-primary-200 hover:bg-primary-800 hover:text-white' }}">
                        <i class="fas fa-cog w-5 mr-3"></i>
                        Pengaturan
                    </a>
                </div>
            </nav>

            <div class="p-4 border-t border-primary-800">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full flex items-center px-4 py-3 rounded-lg text-sm font-medium text-primary-200 hover:bg-primary-800 hover:text-white transition-colors duration-200">
                        <i class="fas fa-sign-out-alt w-5 mr-3"></i>
                        Logout
                    </button>
                </form>
            </div>
        </div>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <header class="bg-white border-b border-gray-200">
                <div class="flex items-center justify-between px-6 py-4">
                    <h2 class="text-xl font-semibold text-gray-900">@yield('title', 'Dashboard Admin')</h2>
                    <div class="flex items-center space-x-3">
                        <span class="text-sm text-gray-600">Hello, {{ Auth::user()->name }}</span>
                        <div class="w-8 h-8 bg-primary-600 rounded-full flex items-center justify-center text-white font-medium">
                            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                        </div>
                    </div>
                </div>
            </header>

            <main class="flex-1 overflow-y-auto p-6">
                @if(session('success'))
                <div class="bg-green-50 border border-green-200 rounded-lg p-4 mb-6">
                    <div class="flex items-center">
                        <i class="fas fa-check-circle text-green-500 mr-3"></i>
                        <p class="text-green-700 text-sm font-medium">{{ session('success') }}</p>
                    </div>
                </div>
                @endif

                @if(session('error'))
                <div class="bg-red-50 border border-red-200 rounded-lg p-4 mb-6">
                    <div class="flex items-center">
                        <i class="fas fa-exclamation-circle text-red-500 mr-3"></i>
                        <p class="text-red-700 text-sm font-medium">{{ session('error') }}</p>
                    </div>
                </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>

    <script>
        // Simple search functionality
        document.addEventListener('DOMContentLoaded', function() {
            const searchInputs = document.querySelectorAll('input[type="search"]');

            searchInputs.forEach(input => {
                input.addEventListener('input', function(e) {
                    const searchTerm = e.target.value.toLowerCase();
                    const tableId = this.getAttribute('data-table');
                    const table = document.getElementById(tableId);

                    if (table) {
                        const rows = table.querySelectorAll('tbody tr');

                        rows.forEach(row => {
                            const textContent = row.textContent.toLowerCase();
                            if (textContent.includes(searchTerm)) {
                                row.style.display = '';
                            } else {
                                row.style.display = 'none';
                            }
                        });
                    }
                });
            });
        });
    </script>
</body>

</html>