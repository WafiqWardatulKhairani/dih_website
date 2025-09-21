@extends('admin.layout')

@section('title', 'Manajemen User')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-2xl font-semibold text-gray-900">Manajemen User</h1>
            <p class="text-gray-600 mt-1">Kelola data pengguna sistem</p>
        </div>
        <a href="{{ route('admin.users.create') }}" 
           class="mt-4 sm:mt-0 inline-flex items-center px-4 py-2 bg-gray-900 border border-transparent rounded-md font-medium text-white hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-colors duration-200">
            <i class="fas fa-plus mr-2"></i>
            Tambah User
        </a>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="bg-white p-5 rounded-lg border border-gray-200 shadow-sm">
            <div class="flex items-center">
                <div class="p-3 bg-blue-50 rounded-lg">
                    <i class="fas fa-users text-blue-600"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm text-gray-600">Total Users</p>
                    <p class="text-2xl font-semibold text-gray-900">{{ $users->count() }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white p-5 rounded-lg border border-gray-200 shadow-sm">
            <div class="flex items-center">
                <div class="p-3 bg-green-50 rounded-lg">
                    <i class="fas fa-check-circle text-green-600"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm text-gray-600">Terverifikasi</p>
                    <p class="text-2xl font-semibold text-gray-900">{{ $users->where('status', 'verified')->count() }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white p-5 rounded-lg border border-gray-200 shadow-sm">
            <div class="flex items-center">
                <div class="p-3 bg-amber-50 rounded-lg">
                    <i class="fas fa-clock text-amber-600"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm text-gray-600">Pending</p>
                    <p class="text-2xl font-semibold text-gray-900">{{ $users->where('status', 'pending')->count() }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white p-5 rounded-lg border border-gray-200 shadow-sm">
            <div class="flex items-center">
                <div class="p-3 bg-purple-50 rounded-lg">
                    <i class="fas fa-shield-alt text-purple-600"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm text-gray-600">Admin</p>
                    <p class="text-2xl font-semibold text-gray-900">{{ $users->where('role', 'admin')->count() }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Table Section -->
    <div class="bg-white rounded-lg border border-gray-200 shadow-sm overflow-hidden">
        <!-- Table Header with Search -->
        <div class="px-6 py-4 border-b border-gray-200">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                <div class="relative w-full sm:w-64 mb-3 sm:mb-0">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-search text-gray-400"></i>
                    </div>
                    <input type="text" id="searchInput" placeholder="Cari user..." 
                           class="pl-10 pr-4 py-2 border border-gray-300 rounded-lg w-full focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                </div>
                <div class="flex space-x-2">
                    <select class="border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option>Semua Role</option>
                        <option>Admin</option>
                        <option>Pemerintah</option>
                        <option>Akademisi</option>
                    </select>
                    <select class="border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option>Semua Status</option>
                        <option>Verified</option>
                        <option>Pending</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- Table -->
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            User
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Role
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Status
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Tanggal Daftar
                        </th>
                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Aksi
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($users as $user)
                    <tr class="hover:bg-gray-50 transition-colors duration-150">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-10 w-10">
                                    <img class="h-10 w-10 rounded-full object-cover" 
                                         src="{{ $user->avatar ? asset('storage/' . $user->avatar) : asset('images/default-avatar.png') }}" 
                                         alt="{{ $user->name }}">
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-medium text-gray-900">{{ $user->name }}</div>
                                    <div class="text-sm text-gray-500">{{ $user->email }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                {{ $user->role == 'admin' ? 'bg-purple-100 text-purple-800' : 
                                   ($user->role == 'pemerintah' ? 'bg-green-100 text-green-800' : 
                                   'bg-blue-100 text-blue-800') }}">
                                {{ $user->role }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                {{ $user->status == 'verified' ? 'bg-green-100 text-green-800' : 'bg-amber-100 text-amber-800' }}">
                                {{ $user->status }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $user->created_at->format('d M Y') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <div class="flex items-center justify-end space-x-2">
                                @if($user->status == 'pending')
                                <form action="{{ route('admin.users.verify', $user->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" 
                                        class="text-green-600 hover:text-green-800 p-2 rounded-lg hover:bg-green-50 transition-colors duration-200"
                                        title="Verifikasi User">
                                        <i class="fas fa-check"></i>
                                    </button>
                                </form>
                                @endif
                                
                                <a href="{{ route('admin.users.edit', $user->id) }}" 
                                   class="text-blue-600 hover:text-blue-800 p-2 rounded-lg hover:bg-blue-50 transition-colors duration-200"
                                   title="Edit User">
                                    <i class="fas fa-edit"></i>
                                </a>
                                
                                <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                        onclick="return confirm('Yakin ingin menghapus user ini?')"
                                        class="text-red-600 hover:text-red-800 p-2 rounded-lg hover:bg-red-50 transition-colors duration-200"
                                        title="Hapus User">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Empty State -->
        @if($users->count() == 0)
        <div class="text-center py-12">
            <div class="mx-auto w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                <i class="fas fa-users text-gray-400 text-xl"></i>
            </div>
            <h3 class="text-lg font-medium text-gray-900">Belum ada user</h3>
            <p class="text-gray-500 mt-1">Mulai dengan menambahkan user pertama</p>
            <a href="{{ route('admin.users.create') }}" 
               class="mt-4 inline-flex items-center px-4 py-2 bg-gray-900 border border-transparent rounded-md font-medium text-white hover:bg-gray-800">
                <i class="fas fa-plus mr-2"></i> Tambah User
            </a>
        </div>
        @endif
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('searchInput');
    const tableRows = document.querySelectorAll('tbody tr');
    
    if (searchInput) {
        searchInput.addEventListener('input', function(e) {
            const searchTerm = e.target.value.toLowerCase();
            
            tableRows.forEach(row => {
                const userName = row.querySelector('.text-gray-900').textContent.toLowerCase();
                const userEmail = row.querySelector('.text-gray-500').textContent.toLowerCase();
                
                if (userName.includes(searchTerm) || userEmail.includes(searchTerm)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });
    }
});
</script>
@endsection