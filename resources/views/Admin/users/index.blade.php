@extends('admin.layout')

@section('title', 'Manajemen User - Pending Verification')

@section('content')
<div class="bg-white rounded-xl shadow-md p-5">
    {{-- Header --}}
    <div class="flex justify-between items-center mb-4">
        <h1 class="text-lg md:text-xl font-semibold text-gray-800">
            User Menunggu Verifikasi
        </h1>
        <a href="{{ route('admin.users.index') }}"
            class="inline-flex items-center px-3 py-1.5 text-sm border border-gray-400 rounded-md
                  text-gray-700 hover:bg-gray-100 transition">
            ← Kembali
        </a>
    </div>

    {{-- Flash message --}}
    @if(session('success'))
    <div class="mb-4 px-4 py-2 text-sm text-green-700 bg-green-100 border border-green-300 rounded">
        {{ session('success') }}
    </div>
    @endif

    {{-- Table --}}
    @if($users->isEmpty())
    <div class="px-4 py-3 text-sm text-blue-700 bg-blue-100 border border-blue-300 rounded">
        Tidak ada user yang menunggu verifikasi.
    </div>
    @else
    <div class="overflow-x-auto">
        <table class="w-auto mx-auto text-sm border border-gray-200 rounded-lg">
            <thead class="bg-gray-100 text-gray-700">
                <tr>
                    <th class="px-2 py-1 border-b">Nama</th>
                    <th class="px-2 py-1 border-b">Email</th>
                    <th class="px-2 py-1 border-b">Institusi</th>
                    <th class="px-2 py-1 border-b">Role</th>
                    <th class="px-2 py-1 border-b">Dokumen</th>
                    <th class="px-2 py-1 border-b text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @foreach($users as $user)
                <tr class="hover:bg-gray-50">
                    <td class="px-2 py-1">{{ $user->name }}</td>
                    <td class="px-2 py-1">{{ $user->email }}</td>
                    <td class="px-2 py-1">{{ $user->institution_name }}</td>
                    <td class="px-2 py-1">
                        <span class="px-2 py-0.5 rounded-full text-xs font-medium
                        {{ $user->role == 'pemerintah'
                           ? 'bg-green-100 text-green-800'
                           : 'bg-blue-100 text-blue-800' }}">
                            {{ ucfirst($user->role) }}
                        </span>
                    </td>
                    <td class="px-2 py-1">
                        <a href="{{ asset('storage/' . $user->document_path) }}"
                            target="_blank"
                            class="text-blue-600 hover:text-blue-800 underline">
                            Lihat
                        </a>
                    </td>
                    <td class="px-2 py-1 text-center">
                        <div class="flex justify-center gap-1">
                            <form action="{{ route('admin.users.verify', $user->id) }}" method="POST">
                                @csrf
                                <button type="submit"
                                    class="px-2 py-1 rounded-md bg-green-500 text-white text-xs hover:bg-green-600">
                                    ✔ Setujui
                                </button>
                            </form>
                            <form action="{{ route('admin.users.reject', $user->id) }}"
                                method="POST"
                                onsubmit="return confirm('Yakin menolak user ini? Data akan dihapus.');">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="px-2 py-1 rounded-md bg-red-500 text-white text-xs hover:bg-red-600">
                                    ✖ Tolak
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    @endif
</div>
@endsection