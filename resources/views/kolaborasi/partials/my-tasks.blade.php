<div class="space-y-6">
    <!-- Task Stats -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <div class="bg-white rounded-xl p-6 shadow-sm border border-blue-100">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-tasks text-blue-600 text-xl"></i>
                </div>
                <div>
                    <p class="text-2xl font-bold text-gray-800">8</p>
                    <p class="text-gray-600 text-sm">Total Tugas</p>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-xl p-6 shadow-sm border border-yellow-100">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-yellow-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-spinner text-yellow-600 text-xl"></i>
                </div>
                <div>
                    <p class="text-2xl font-bold text-gray-800">3</p>
                    <p class="text-gray-600 text-sm">In Progress</p>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-xl p-6 shadow-sm border border-green-100">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-check-circle text-green-600 text-xl"></i>
                </div>
                <div>
                    <p class="text-2xl font-bold text-gray-800">5</p>
                    <p class="text-gray-600 text-sm">Selesai</p>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-xl p-6 shadow-sm border border-red-100">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-red-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-clock text-red-600 text-xl"></i>
                </div>
                <div>
                    <p class="text-2xl font-bold text-gray-800">2</p>
                    <p class="text-gray-600 text-sm">Deadline Mendekati</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Task List -->
    <div class="bg-white rounded-xl p-6 shadow-sm">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-xl font-bold text-gray-800">Tugas Saya</h2>
            <div class="flex gap-3">
                <select class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <option value="">Semua Status</option>
                    <option value="todo">To Do</option>
                    <option value="progress">In Progress</option>
                    <option value="review">Review</option>
                    <option value="done">Done</option>
                </select>
                <select class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <option value="">Semua Proyek</option>
                    <option value="1">IoT Monitoring Banjir</option>
                    <option value="2">Digitalisasi UMKM</option>
                </select>
            </div>
        </div>

        <div class="space-y-4">
            @foreach($myTasks as $task)
            <div class="border border-gray-200 rounded-lg p-4 hover:border-blue-300 transition-colors">
                <div class="flex justify-between items-start mb-3">
                    <div class="flex-1">
                        <div class="flex items-center gap-3 mb-2">
                            <h4 class="font-semibold text-gray-800">{{ $task['judul'] }}</h4>
                            <span class="bg-blue-100 text-blue-800 px-2 py-1 rounded text-xs font-medium">
                                {{ $task['project'] }}
                            </span>
                        </div>
                        <p class="text-gray-600 text-sm mb-3">{{ $task['deskripsi'] }}</p>
                        
                        <div class="flex items-center gap-4 text-sm text-gray-500">
                            <span class="flex items-center gap-1">
                                <i class="fas fa-flag"></i>
                                @if($task['priority'] == 'high')
                                    <span class="text-red-600">High Priority</span>
                                @elseif($task['priority'] == 'medium')
                                    <span class="text-yellow-600">Medium Priority</span>
                                @else
                                    <span class="text-green-600">Low Priority</span>
                                @endif
                            </span>
                            <span class="flex items-center gap-1">
                                <i class="fas fa-calendar"></i>
                                Deadline: {{ $task['deadline'] }}
                            </span>
                            <span class="flex items-center gap-1">
                                <i class="fas fa-star"></i>
                                {{ $task['points'] }} points
                            </span>
                        </div>
                    </div>
                    
                    <div class="flex flex-col items-end gap-2">
                        <span class="bg-{{ $task['status_color'] }}-100 text-{{ $task['status_color'] }}-800 px-2 py-1 rounded text-xs font-medium">
                            {{ $task['status'] }}
                        </span>
                        
                        @if($task['days_left'] < 3 && $task['status'] != 'done')
                        <span class="bg-red-100 text-red-800 px-2 py-1 rounded text-xs">
                            {{ $task['days_left'] }} hari lagi
                        </span>
                        @endif
                    </div>
                </div>
                
                <!-- Progress Bar -->
                @if($task['progress'] > 0)
                <div class="mb-3">
                    <div class="flex justify-between text-sm text-gray-600 mb-1">
                        <span>Progress</span>
                        <span>{{ $task['progress'] }}%</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2">
                        <div class="progress-bar h-2 rounded-full" style="width: {{ $task['progress'] }}%"></div>
                    </div>
                </div>
                @endif
                
                <div class="flex justify-between items-center">
                    <div class="flex gap-2">
                        <button class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors">
                            Update Progress
                        </button>
                        <button class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-4 py-2 rounded-lg text-sm font-medium transition-colors">
                            <i class="fas fa-comment"></i>
                        </button>
                    </div>
                    
                    <div class="flex gap-2">
                        @if($task['status'] == 'todo')
                        <button class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors">
                            Mulai Kerjakan
                        </button>
                        @elseif($task['status'] == 'progress')
                        <button class="bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors">
                            Minta Review
                        </button>
                        @elseif($task['status'] == 'review')
                        <button class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors">
                            Selesaikan
                        </button>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>