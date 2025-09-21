@extends('admin.layout')

@section('title', 'Manajemen User - Pending Verification')

@section('content')
<div class="bg-white rounded-lg shadow p-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">User Menunggu Verifikasi</h1>
        <a href="{{ route('admin.users.index') }}" class="bg-gray-600 text-white px-4 py-2 rounded hover:bg-gray-700">
            Kembali ke Semua User
        </a>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    @if($users->isEmpty())
        <div class="bg-blue-100 border border-blue-400 text-blue-700 px-4 py-3 rounded">
            Tidak ada user yang menunggu verifikasi.
        </div>
    @else
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white">
                <thead>
                    <tr>
                        <th class="px-4 py-2 border">Nama</th>
                        <th class="px-4 py-2 border">Email</th>
                        <th class="px-4 py-2 border">Institusi</th>
                        <th class="px-4 py-2 border">Role</th>
                        <th class="px-4 py-2 border">Dokumen</th>
                        <th class="px-4 py-2 border">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                    <tr>
                        <td class="px-4 py-2 border">{{ $user->name }}</td>
                        <td class="px-4 py-2 border">{{ $user->email }}</td>
                        <td class="px-4 py-2 border">{{ $user->institution_name }}</td>
                        <td class="px-4 py-2 border">
                            <span class="px-2 py-1 text-xs rounded-full 
                                {{ $user->role == 'pemerintah' ? 'bg-green-200 text-green-800' : 'bg-blue-200 text-blue-800' }}">
                                {{ $user->role }}
                            </span>
                        </td>
                        <td class="px-4 py-2 border">
                            <a href="{{ asset('storage/' . $user->document_path) }}" target="_blank" 
                               class="text-blue-600 hover:text-blue-800 underline text-sm">
                                Lihat Dokumen
                            </a>
                        </td>
                        <td class="px-4 py-2 border">
                            <form action="{{ route('admin.users.verify', $user->id) }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" class="bg-green-600 text-white px-3 py-1 rounded text-sm hover:bg-green-700">
                                    Setujui
                                </button>
                            </form>
                            <form action="{{ route('admin.users.reject', $user->id) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-red-600 text-white px-3 py-1 rounded text-sm hover:bg-red-700" 
                                    onclick="return confirm('Yakin ingin menolak user ini? Semua data akan dihapus.')">
                                    Tolak
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
@endsection