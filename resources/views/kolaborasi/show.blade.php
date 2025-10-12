@extends('layouts.app')

@section('title', 'Detail Kolaborasi')

@section('styles')
<style>
    .board-column {
        min-height: 600px;
        background: #f8fafc;
        border-radius: 12px;
    }
    .task-card {
        transition: all 0.3s ease;
        border-left: 4px solid #3b82f6;
    }
    .task-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }
    .task-priority-high { border-left-color: #ef4444; }
    .task-priority-medium { border-left-color: #f59e0b; }
    .task-priority-low { border-left-color: #10b981; }
    .progress-bar {
        background: linear-gradient(90deg, #3b82f6, #60a5fa);
        height: 6px;
        border-radius: 3px;
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
            <div class="flex justify-between items-start">
                <div>
                    <div class="flex items-center gap-3 mb-2">
                        <h1 class="text-3xl font-bold text-gray-800">{{ $kolaborasi['judul'] }}</h1>
                        <span class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm font-medium">
                            {{ $kolaborasi['kategori'] }}
                        </span>
                    </div>
                    <p class="text-gray-600 mb-4">{{ $kolaborasi['deskripsi'] }}</p>
                    
                    <!-- Progress & Info -->
                    <div class="flex items-center gap-6 text-sm text-gray-500">
                        <div class="flex items-center gap-2">
                            <i class="fas fa-calendar"></i>
                            <span>Deadline: {{ $kolaborasi['deadline'] }}</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <i class="fas fa-chart-line"></i>
                            <span>Progress: {{ $kolaborasi['progress'] }}%</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <i class="fas fa-users"></i>
                            <span>{{ count($kolaborasi['anggota']) }} Anggota</span>
                        </div>
                    </div>
                </div>
                
                <div class="flex gap-3">
                    <button onclick="openTaskModal()" 
                            class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-medium transition-colors flex items-center gap-2">
                        <i class="fas fa-plus"></i>
                        Tambah Task
                    </button>
                    <button class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg font-medium transition-colors flex items-center gap-2">
                        <i class="fas fa-users"></i>
                        Kelola Anggota
                    </button>
                </div>
            </div>
        </div>

        <!-- Progress Bar -->
        <div class="mb-8">
            <div class="flex justify-between text-sm text-gray-600 mb-2">
                <span>Progress Keseluruhan</span>
                <span>{{ $kolaborasi['progress'] }}%</span>
            </div>
            <div class="w-full bg-gray-200 rounded-full h-3">
                <div class="progress-bar h-3 rounded-full" style="width: {{ $kolaborasi['progress'] }}%"></div>
            </div>
        </div>

        <!-- Kanban Board -->
        <div class="grid grid-cols-1 lg:grid-cols-4 gap-6 mb-8">
            <!-- Column: To Do -->
            <div class="board-column p-4">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="font-bold text-gray-700">To Do</h3>
                    <span class="bg-gray-200 text-gray-700 px-2 py-1 rounded text-xs">{{ count($tasks['todo']) }}</span>
                </div>
                <div class="space-y-3" id="todo-column">
                    @foreach($tasks['todo'] as $task)
                    @include('kolaborasi.partials.task-card', ['task' => $task])
                    @endforeach
                </div>
            </div>

            <!-- Column: In Progress -->
            <div class="board-column p-4">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="font-bold text-gray-700">In Progress</h3>
                    <span class="bg-blue-200 text-blue-700 px-2 py-1 rounded text-xs">{{ count($tasks['progress']) }}</span>
                </div>
                <div class="space-y-3" id="progress-column">
                    @foreach($tasks['progress'] as $task)
                    @include('kolaborasi.partials.task-card', ['task' => $task])
                    @endforeach
                </div>
            </div>

            <!-- Column: Review -->
            <div class="board-column p-4">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="font-bold text-gray-700">Review</h3>
                    <span class="bg-yellow-200 text-yellow-700 px-2 py-1 rounded text-xs">{{ count($tasks['review']) }}</span>
                </div>
                <div class="space-y-3" id="review-column">
                    @foreach($tasks['review'] as $task)
                    @include('kolaborasi.partials.task-card', ['task' => $task])
                    @endforeach
                </div>
            </div>

            <!-- Column: Done -->
            <div class="board-column p-4">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="font-bold text-gray-700">Done</h3>
                    <span class="bg-green-200 text-green-700 px-2 py-1 rounded text-xs">{{ count($tasks['done']) }}</span>
                </div>
                <div class="space-y-3" id="done-column">
                    @foreach($tasks['done'] as $task)
                    @include('kolaborasi.partials.task-card', ['task' => $task])
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Discussion & Activity Section -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Discussion Thread -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-xl p-6 shadow-sm">
                    <h3 class="font-bold text-gray-800 mb-4">Diskusi</h3>
                    <div class="space-y-4">
                        @foreach($discussions as $discussion)
                        <div class="border border-gray-200 rounded-lg p-4">
                            <div class="flex items-start gap-3">
                                <div class="w-10 h-10 bg-gradient-to-r from-blue-500 to-purple-600 rounded-full flex items-center justify-center text-white font-bold">
                                    {{ substr($discussion['user'], 0, 1) }}
                                </div>
                                <div class="flex-1">
                                    <div class="flex justify-between items-start mb-2">
                                        <div>
                                            <p class="font-semibold text-gray-800">{{ $discussion['user'] }}</p>
                                            <p class="text-xs text-gray-500">{{ $discussion['time'] }}</p>
                                        </div>
                                        <button class="text-gray-400 hover:text-gray-600">
                                            <i class="fas fa-ellipsis-h"></i>
                                        </button>
                                    </div>
                                    <p class="text-gray-700">{{ $discussion['message'] }}</p>
                                    <div class="flex gap-4 mt-3">
                                        <button class="text-gray-400 hover:text-blue-500 text-sm flex items-center gap-1">
                                            <i class="fas fa-reply"></i>
                                            <span>Reply</span>
                                        </button>
                                        <button class="text-gray-400 hover:text-red-500 text-sm flex items-center gap-1">
                                            <i class="fas fa-heart"></i>
                                            <span>{{ $discussion['likes'] }}</span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    
                    <!-- Reply Form -->
                    <div class="mt-6">
                        <form class="flex gap-3">
                            <input type="text" placeholder="Tulis pesan..." 
                                   class="flex-1 px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-medium">
                                <i class="fas fa-paper-plane"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Activity & Members -->
            <div class="space-y-6">
                <!-- Team Members -->
                <div class="bg-white rounded-xl p-6 shadow-sm">
                    <h3 class="font-bold text-gray-800 mb-4">Anggota Tim</h3>
                    <div class="space-y-3">
                        @foreach($kolaborasi['anggota'] as $anggota)
                        <div class="flex items-center gap-3 p-3 bg-gray-50 rounded-lg">
                            <div class="w-10 h-10 bg-gradient-to-r from-blue-500 to-purple-600 rounded-full flex items-center justify-center text-white font-bold">
                                {{ substr($anggota['nama'], 0, 1) }}
                            </div>
                            <div class="flex-1">
                                <p class="font-medium text-gray-800">{{ $anggota['nama'] }}</p>
                                <p class="text-xs text-gray-500">{{ $anggota['role'] }}</p>
                            </div>
                            <span class="bg-green-100 text-green-800 px-2 py-1 rounded text-xs">Online</span>
                        </div>
                        @endforeach
                    </div>
                    <button class="w-full mt-4 bg-gray-100 hover:bg-gray-200 text-gray-700 py-2 rounded-lg font-medium transition-colors">
                        <i class="fas fa-user-plus mr-2"></i>
                        Tambah Anggota
                    </button>
                </div>

                <!-- Recent Activity -->
                <div class="bg-white rounded-xl p-6 shadow-sm">
                    <h3 class="font-bold text-gray-800 mb-4">Aktivitas Terbaru</h3>
                    <div class="space-y-3">
                        @foreach($activities as $activity)
                        <div class="flex items-start gap-3">
                            <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center text-blue-600 text-sm">
                                <i class="fas fa-{{ $activity['icon'] }}"></i>
                            </div>
                            <div class="flex-1">
                                <p class="text-sm text-gray-700">{{ $activity['message'] }}</p>
                                <p class="text-xs text-gray-500">{{ $activity['time'] }}</p>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Create Task -->
@include('kolaborasi.modals.create-task')
@endsection

@section('scripts')
<script>
function openTaskModal() {
    document.getElementById('taskModal').classList.remove('hidden');
    document.getElementById('taskModal').classList.add('flex');
    document.body.style.overflow = 'hidden';
}

function closeTaskModal() {
    document.getElementById('taskModal').classList.add('hidden');
    document.getElementById('taskModal').classList.remove('flex');
    document.body.style.overflow = 'auto';
}

// Drag & Drop functionality
document.addEventListener('DOMContentLoaded', function() {
    const taskCards = document.querySelectorAll('.task-card');
    const columns = document.querySelectorAll('[id$="-column"]');
    
    taskCards.forEach(card => {
        card.setAttribute('draggable', 'true');
        
        card.addEventListener('dragstart', (e) => {
            e.dataTransfer.setData('text/plain', card.id);
            card.classList.add('opacity-50');
        });
        
        card.addEventListener('dragend', () => {
            card.classList.remove('opacity-50');
        });
    });
    
    columns.forEach(column => {
        column.addEventListener('dragover', (e) => {
            e.preventDefault();
            column.classList.add('bg-blue-50');
        });
        
        column.addEventListener('dragleave', () => {
            column.classList.remove('bg-blue-50');
        });
        
        column.addEventListener('drop', (e) => {
            e.preventDefault();
            column.classList.remove('bg-blue-50');
            
            const taskId = e.dataTransfer.getData('text/plain');
            const task = document.getElementById(taskId);
            column.appendChild(task);
            
            // Here you would update the task status via AJAX
            const newStatus = column.id.replace('-column', '');
            updateTaskStatus(taskId, newStatus);
        });
    });
});

function updateTaskStatus(taskId, newStatus) {
    // AJAX call to update task status
    fetch(`/tasks/${taskId}`, {
        method: 'PUT',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({
            status: newStatus
        })
    }).then(response => response.json())
      .then(data => {
          console.log('Task updated:', data);
      });
}

// Close modal on outside click
window.addEventListener('click', function(e) {
    if (e.target === document.getElementById('taskModal')) {
        closeTaskModal();
    }
});
</script>
@endsection