<div class="bg-white rounded-xl p-6 shadow-sm">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-xl font-bold text-gray-800">Daftar Ide Kolaborasi</h2>
        <a href="{{ route('kolaborasi.ide.create') }}" 
           class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg font-medium transition-colors flex items-center gap-2">
            <i class="fas fa-plus"></i>
            Ajukan Ide Baru
        </a>
    </div>

    <div class="space-y-4">
        @foreach($ideKolaborasi as $ide)
        <div class="border border-gray-200 rounded-lg p-4 hover:border-blue-300 transition-colors">
            <div class="flex justify-between items-start mb-3">
                <div class="flex-1">
                    <h4 class="font-semibold text-gray-800 text-lg mb-1">{{ $ide['judul'] }}</h4>
                    <p class="text-gray-600 mb-2">{{ $ide['deskripsi'] }}</p>
                    
                    <div class="flex items-center gap-4 text-sm text-gray-500">
                        <span class="flex items-center gap-1">
                            <i class="fas fa-user"></i>
                            Oleh: {{ $ide['pemilik'] }}
                        </span>
                        <span class="category-badge bg-purple-100 text-purple-800">
                            {{ $ide['kategori'] }}
                        </span>
                        <span class="flex items-center gap-1">
                            <i class="fas fa-calendar"></i>
                            {{ $ide['tanggal'] }}
                        </span>
                    </div>
                </div>
                
                <div class="flex flex-col items-end gap-2">
                    <span class="bg-green-100 text-green-800 px-2 py-1 rounded text-xs font-medium">
                        {{ $ide['status'] }}
                    </span>
                    
                    <!-- Voting Stats -->
                    <div class="flex items-center gap-2 text-sm">
                        <button class="text-gray-400 hover:text-red-500 transition-colors flex items-center gap-1">
                            <i class="fas fa-heart"></i>
                            <span>{{ $ide['vote'] }}</span>
                        </button>
                        <span class="text-gray-400">•</span>
                        <span class="text-gray-500 text-xs">{{ $ide['vote_progress'] }}%</span>
                    </div>
                </div>
            </div>
            
            <!-- Progress Bar -->
            <div class="mb-3">
                <div class="flex justify-between text-sm text-gray-600 mb-1">
                    <span>Progress Voting</span>
                    <span>{{ $ide['vote'] }}/{{ $ide['vote_target'] }} votes</span>
                </div>
                <div class="w-full bg-gray-200 rounded-full h-2">
                    <div class="progress-bar h-2 rounded-full" style="width: {{ $ide['vote_progress'] }}%"></div>
                </div>
            </div>
            
            <div class="flex justify-between items-center">
                <div class="flex gap-2">
                    <button class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors">
                        Lihat Detail
                    </button>
                    <button class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-4 py-2 rounded-lg text-sm font-medium transition-colors">
                        <i class="fas fa-comment"></i>
                        <span class="ml-1">{{ $ide['comments'] }}</span>
                    </button>
                </div>
                
                <div class="flex gap-2">
                    @if($ide['status'] == 'open')
                    <button class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors">
                        Vote Sekarang
                    </button>
                    @elseif($ide['status'] == 'approved')
                    <button class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors">
                        Gabung Kolaborasi
                    </button>
                    @endif
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Load More -->
    <div class="text-center mt-6">
        <button class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-6 py-3 rounded-lg font-medium transition-colors">
            Muat Lebih Banyak Ide
        </button>
    </div>
</div>