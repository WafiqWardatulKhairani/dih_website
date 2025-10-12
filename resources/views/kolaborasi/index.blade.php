@extends('layouts.app')

@section('title', 'Ruang Kolaborasi')

@section('styles')
<style>
    .collab-card {
        transition: all 0.3s ease;
        border: 1px solid #e2e8f0;
    }
    .collab-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1);
    }
    .progress-bar {
        background: linear-gradient(90deg, #3b82f6, #60a5fa);
    }
    .category-badge {
        font-size: 0.75rem;
        padding: 4px 8px;
        border-radius: 12px;
    }
    .member-avatar {
        width: 32px;
        height: 32px;
        border: 2px solid white;
    }
</style>
@endsection

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="container mx-auto px-4">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex justify-between items-center">
                <div>
                    <h1 class="text-3xl font-bold text-gray-800 mb-2">Ruang Kolaborasi</h1>
                    <p class="text-gray-600">Temukan partner dan bangun solusi inovatif bersama</p>
                </div>
                <button onclick="openCreateModal()" 
                        class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-semibold transition-colors flex items-center gap-2">
                    <i class="fas fa-plus"></i>
                    Mulai Kolaborasi Baru
                </button>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <div class="bg-white rounded-xl p-6 shadow-sm border border-blue-100">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-users text-blue-600 text-xl"></i>
                    </div>
                    <div>
                        <p class="text-2xl font-bold text-gray-800">12</p>
                        <p class="text-gray-600 text-sm">Kolaborasi Aktif</p>
                    </div>
                </div>
            </div>
            
            <div class="bg-white rounded-xl p-6 shadow-sm border border-green-100">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-lightbulb text-green-600 text-xl"></i>
                    </div>
                    <div>
                        <p class="text-2xl font-bold text-gray-800">47</p>
                        <p class="text-gray-600 text-sm">Ide Terposting</p>
                    </div>
                </div>
            </div>
            
            <div class="bg-white rounded-xl p-6 shadow-sm border border-purple-100">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-check-circle text-purple-600 text-xl"></i>
                    </div>
                    <div>
                        <p class="text-2xl font-bold text-gray-800">8</p>
                        <p class="text-gray-600 text-sm">Proyek Selesai</p>
                    </div>
                </div>
            </div>
            
            <div class="bg-white rounded-xl p-6 shadow-sm border border-orange-100">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 bg-orange-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-handshake text-orange-600 text-xl"></i>
                    </div>
                    <div>
                        <p class="text-2xl font-bold text-gray-800">156</p>
                        <p class="text-gray-600 text-sm">Anggota Aktif</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Kolaborasi Aktif -->
            <div class="space-y-6">
                <div class="flex justify-between items-center">
                    <h2 class="text-xl font-bold text-gray-800">Kolaborasi Aktif</h2>
                    <span class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm font-medium">
                        {{ count($kolaborasiAktif) }} Proyek
                    </span>
                </div>

                @foreach($kolaborasiAktif as $kolab)
                <div class="collab-card bg-white rounded-xl p-6 shadow-sm">
                    <div class="flex justify-between items-start mb-4">
                        <div>
                            <h3 class="font-bold text-lg text-gray-800 mb-1">{{ $kolab['judul'] }}</h3>
                            <p class="text-gray-600 text-sm mb-2">{{ $kolab['deskripsi'] }}</p>
                            <span class="category-badge bg-blue-100 text-blue-800">
                                {{ $kolab['kategori'] }}
                            </span>
                        </div>
                        <span class="bg-green-100 text-green-800 px-2 py-1 rounded text-xs font-medium">
                            {{ $kolab['status'] }}
                        </span>
                    </div>

                    <!-- Progress Bar -->
                    <div class="mb-4">
                        <div class="flex justify-between text-sm text-gray-600 mb-2">
                            <span>Progress</span>
                            <span>{{ $kolab['progress'] }}%</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            <div class="progress-bar h-2 rounded-full" style="width: {{ $kolab['progress'] }}%"></div>
                        </div>
                    </div>

                    <!-- Anggota Tim -->
                    <div class="flex justify-between items-center">
                        <div class="flex -space-x-2">
                            @foreach($kolab['anggota'] as $index => $anggota)
                            <div class="tooltip" data-tip="{{ $anggota['nama'] }} - {{ $anggota['role'] }}">
                                <div class="member-avatar bg-gradient-to-r from-blue-500 to-purple-600 rounded-full flex items-center justify-center text-white text-xs font-bold">
                                    {{ substr($anggota['nama'], 0, 1) }}
                                </div>
                            </div>
                            @endforeach
                            <div class="member-avatar bg-gray-300 rounded-full flex items-center justify-center text-gray-600 text-xs">
                                +
                            </div>
                        </div>
                        
                        <div class="flex gap-2">
                            <a href="{{ route('kolaborasi.index') }}/{{ $kolab['id'] }}" 
                               class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors">
                                Lihat Detail
                            </a>
                            <button class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-4 py-2 rounded-lg text-sm font-medium transition-colors">
                                <i class="fas fa-comment"></i>
                            </button>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Ide Kolaborasi & Fitur Cepat -->
            <div class="space-y-6">
                <!-- Ide Kolaborasi Terpopuler -->
                <div class="bg-white rounded-xl p-6 shadow-sm">
                    <div class="flex justify-between items-center mb-4">
                        <h2 class="text-xl font-bold text-gray-800">Ide Kolaborasi</h2>
                        <a href="#" class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                            Lihat Semua →
                        </a>
                    </div>

                    <div class="space-y-4">
                        @foreach($ideKolaborasi as $ide)
                        <div class="border border-gray-200 rounded-lg p-4 hover:border-blue-300 transition-colors">
                            <div class="flex justify-between items-start mb-2">
                                <h4 class="font-semibold text-gray-800">{{ $ide['judul'] }}</h4>
                                <span class="bg-green-100 text-green-800 px-2 py-1 rounded text-xs">
                                    {{ $ide['status'] }}
                                </span>
                            </div>
                            <p class="text-gray-600 text-sm mb-3">{{ $ide['deskripsi'] }}</p>
                            <div class="flex justify-between items-center">
                                <div class="flex items-center gap-4 text-sm text-gray-500">
                                    <span>Oleh: {{ $ide['pemilik'] }}</span>
                                    <span class="category-badge bg-purple-100 text-purple-800">
                                        {{ $ide['kategori'] }}
                                    </span>
                                </div>
                                <div class="flex items-center gap-2">
                                    <button class="text-gray-400 hover:text-red-500 transition-colors">
                                        <i class="fas fa-heart"></i>
                                        <span class="text-xs ml-1">{{ $ide['vote'] }}</span>
                                    </button>
                                    <button class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-1 rounded text-sm">
                                        Ajukan Solusi
                                    </button>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

                <!-- Fitur Cepat -->
                <div class="bg-gradient-to-r from-blue-500 to-purple-600 rounded-xl p-6 text-white">
                    <h3 class="font-bold text-lg mb-4">Mulai Kolaborasi</h3>
                    <div class="grid grid-cols-2 gap-4">
                        <button onclick="openCreateModal()" 
                                class="bg-white/20 hover:bg-white/30 backdrop-blur-sm rounded-lg p-4 text-center transition-colors">
                            <i class="fas fa-plus text-2xl mb-2"></i>
                            <p class="text-sm font-medium">Buat Proyek Baru</p>
                        </button>
                        <button class="bg-white/20 hover:bg-white/30 backdrop-blur-sm rounded-lg p-4 text-center transition-colors">
                            <i class="fas fa-search text-2xl mb-2"></i>
                            <p class="text-sm font-medium">Cari Partner</p>
                        </button>
                        <button class="bg-white/20 hover:bg-white/30 backdrop-blur-sm rounded-lg p-4 text-center transition-colors">
                            <i class="fas fa-lightbulb text-2xl mb-2"></i>
                            <p class="text-sm font-medium">Ajukan Ide</p>
                        </button>
                        <button class="bg-white/20 hover:bg-white/30 backdrop-blur-sm rounded-lg p-4 text-center transition-colors">
                            <i class="fas fa-chart-line text-2xl mb-2"></i>
                            <p class="text-sm font-medium">Progress Saya</p>
                        </button>
                    </div>
                </div>

                <!-- Notifikasi Cepat -->
                <div class="bg-white rounded-xl p-6 shadow-sm">
                    <h3 class="font-bold text-gray-800 mb-4">Aktivitas Terbaru</h3>
                    <div class="space-y-3">
                        <div class="flex items-center gap-3 p-3 bg-blue-50 rounded-lg">
                            <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                                <i class="fas fa-tasks text-blue-600 text-sm"></i>
                            </div>
                            <div class="flex-1">
                                <p class="text-sm text-gray-700">Task "Design UI" telah diselesaikan</p>
                                <p class="text-xs text-gray-500">2 jam yang lalu</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-3 p-3 bg-green-50 rounded-lg">
                            <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center">
                                <i class="fas fa-comment text-green-600 text-sm"></i>
                            </div>
                            <div class="flex-1">
                                <p class="text-sm text-gray-700">Pesan baru di Smart Parking System</p>
                                <p class="text-xs text-gray-500">5 jam yang lalu</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Create Collaboration -->
<div id="createModal" class="fixed inset-0 bg-black/50 hidden items-center justify-center z-50 p-4">
    <div class="bg-white rounded-xl shadow-lg w-full max-w-2xl max-h-[90vh] overflow-y-auto">
        <div class="p-6 border-b border-gray-200">
            <div class="flex justify-between items-center">
                <h3 class="text-xl font-bold text-gray-800">Buat Kolaborasi Baru</h3>
                <button onclick="closeCreateModal()" class="text-gray-500 hover:text-gray-700 text-2xl">
                    &times;
                </button>
            </div>
        </div>
        
        <form class="p-6 space-y-6">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Judul Kolaborasi</label>
                <input type="text" placeholder="Contoh: Sistem IoT Monitoring Banjir" 
                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Deskripsi</label>
                <textarea rows="3" placeholder="Jelaskan tujuan dan ruang lingkup kolaborasi..." 
                          class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"></textarea>
            </div>
            
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Kategori</label>
                    <select class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option value="">Pilih Kategori</option>
                        <option value="teknologi">Teknologi</option>
                        <option value="lingkungan">Lingkungan</option>
                        <option value="ekonomi">Ekonomi</option>
                        <option value="kesehatan">Kesehatan</option>
                        <option value="pendidikan">Pendidikan</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Target Selesai</label>
                    <input type="date" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                </div>
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Cari Partner (Opsional)</label>
                <input type="text" placeholder="Cari berdasarkan keahlian atau institusi..." 
                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
            </div>
            
            <div class="flex gap-3 pt-4">
                <button type="button" onclick="closeCreateModal()" 
                        class="flex-1 bg-gray-100 hover:bg-gray-200 text-gray-700 py-3 rounded-lg font-semibold transition-colors">
                    Batal
                </button>
                <button type="submit" 
                        class="flex-1 bg-blue-600 hover:bg-blue-700 text-white py-3 rounded-lg font-semibold transition-colors">
                    Buat Kolaborasi
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
function openCreateModal() {
    document.getElementById('createModal').classList.remove('hidden');
    document.getElementById('createModal').classList.add('flex');
    document.body.style.overflow = 'hidden';
}

function closeCreateModal() {
    document.getElementById('createModal').classList.add('hidden');
    document.getElementById('createModal').classList.remove('flex');
    document.body.style.overflow = 'auto';
}

// Close modal on outside click
window.addEventListener('click', function(e) {
    if (e.target === document.getElementById('createModal')) {
        closeCreateModal();
    }
});
</script>
@endsection