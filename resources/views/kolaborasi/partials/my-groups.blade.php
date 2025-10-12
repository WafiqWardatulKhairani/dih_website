<div class="space-y-6">
    <!-- Group Stats -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white rounded-xl p-6 shadow-sm border border-blue-100">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-users text-blue-600 text-xl"></i>
                </div>
                <div>
                    <p class="text-2xl font-bold text-gray-800">5</p>
                    <p class="text-gray-600 text-sm">Grup Aktif</p>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-xl p-6 shadow-sm border border-green-100">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-user-plus text-green-600 text-xl"></i>
                </div>
                <div>
                    <p class="text-2xl font-bold text-gray-800">12</p>
                    <p class="text-gray-600 text-sm">Total Anggota</p>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-xl p-6 shadow-sm border border-purple-100">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-comments text-purple-600 text-xl"></i>
                </div>
                <div>
                    <p class="text-2xl font-bold text-gray-800">47</p>
                    <p class="text-gray-600 text-sm">Pesan Baru</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Groups Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($myGroups as $group)
        <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-200 hover:border-blue-300 transition-colors">
            <!-- Group Header -->
            <div class="flex justify-between items-start mb-4">
                <div>
                    <h3 class="font-bold text-lg text-gray-800 mb-1">{{ $group['nama'] }}</h3>
                    <p class="text-gray-600 text-sm mb-2">{{ $group['deskripsi'] }}</p>
                    <span class="category-badge bg-blue-100 text-blue-800">
                        {{ $group['kategori'] }}
                    </span>
                </div>
                <span class="bg-green-100 text-green-800 px-2 py-1 rounded text-xs font-medium">
                    {{ $group['status'] }}
                </span>
            </div>

            <!-- Progress -->
            <div class="mb-4">
                <div class="flex justify-between text-sm text-gray-600 mb-2">
                    <span>Progress</span>
                    <span>{{ $group['progress'] }}%</span>
                </div>
                <div class="w-full bg-gray-200 rounded-full h-2">
                    <div class="progress-bar h-2 rounded-full" style="width: {{ $group['progress'] }}%"></div>
                </div>
            </div>

            <!-- Members -->
            <div class="mb-4">
                <div class="flex justify-between items-center mb-2">
                    <span class="text-sm text-gray-600">Anggota</span>
                    <span class="text-xs text-gray-500">{{ count($group['anggota']) }} orang</span>
                </div>
                <div class="flex -space-x-2">
                    @foreach($group['anggota'] as $index => $anggota)
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
            </div>

            <!-- Group Meta -->
            <div class="space-y-2 mb-4">
                <div class="flex items-center gap-2 text-sm text-gray-600">
                    <i class="fas fa-calendar"></i>
                    <span>Deadline: {{ $group['deadline'] }}</span>
                </div>
                <div class="flex items-center gap-2 text-sm text-gray-600">
                    <i class="fas fa-comment"></i>
                    <span>{{ $group['unread_messages'] }} pesan baru</span>
                </div>
                <div class="flex items-center gap-2 text-sm text-gray-600">
                    <i class="fas fa-tasks"></i>
                    <span>{{ $group['active_tasks'] }} tugas aktif</span>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex gap-2">
                <a href="{{ route('kolaborasi.show', $group['id']) }}" 
                   class="flex-1 bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors text-center">
                    Masuk Grup
                </a>
                <button class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-4 py-2 rounded-lg text-sm font-medium transition-colors">
                    <i class="fas fa-ellipsis-h"></i>
                </button>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Create New Group -->
    <div class="bg-gradient-to-r from-blue-500 to-purple-600 rounded-xl p-6 text-white">
        <div class="text-center">
            <i class="fas fa-users text-4xl mb-4"></i>
            <h3 class="font-bold text-xl mb-2">Buat Grup Kolaborasi Baru</h3>
            <p class="text-blue-100 mb-4">Mulai proyek kolaborasi baru dengan tim Anda</p>
            <button onclick="openCreateModal()" 
                    class="bg-white/20 hover:bg-white/30 backdrop-blur-sm text-white px-6 py-3 rounded-lg font-semibold transition-colors">
                <i class="fas fa-plus mr-2"></i>
                Buat Grup Baru
            </button>
        </div>
    </div>
</div>