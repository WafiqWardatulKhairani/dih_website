<div class="task-card bg-white rounded-lg p-4 shadow-sm border task-priority-{{ $task['priority'] }}" 
     id="task-{{ $task['id'] }}">
    <div class="flex justify-between items-start mb-2">
        <h4 class="font-semibold text-gray-800 text-sm">{{ $task['judul'] }}</h4>
        <div class="flex gap-1">
            <button class="text-gray-400 hover:text-blue-500 text-xs">
                <i class="fas fa-edit"></i>
            </button>
            <button class="text-gray-400 hover:text-red-500 text-xs">
                <i class="fas fa-trash"></i>
            </button>
        </div>
    </div>
    
    <p class="text-gray-600 text-xs mb-3">{{ $task['deskripsi'] }}</p>
    
    <!-- Task Meta -->
    <div class="space-y-2">
        <!-- Priority -->
        <div class="flex items-center gap-2 text-xs">
            <span class="text-gray-500">Priority:</span>
            @if($task['priority'] == 'high')
                <span class="bg-red-100 text-red-800 px-2 py-1 rounded">High</span>
            @elseif($task['priority'] == 'medium')
                <span class="bg-yellow-100 text-yellow-800 px-2 py-1 rounded">Medium</span>
            @else
                <span class="bg-green-100 text-green-800 px-2 py-1 rounded">Low</span>
            @endif
        </div>
        
        <!-- Deadline -->
        <div class="flex items-center gap-2 text-xs">
            <i class="fas fa-calendar text-gray-400"></i>
            <span class="text-gray-500">{{ $task['deadline'] }}</span>
        </div>
        
        <!-- Assignee -->
        <div class="flex items-center justify-between">
            <div class="flex -space-x-2">
                @foreach($task['assignees'] as $assignee)
                <div class="tooltip" data-tip="{{ $assignee }}">
                    <div class="member-avatar bg-gradient-to-r from-blue-500 to-purple-600 rounded-full flex items-center justify-center text-white text-xs font-bold">
                        {{ substr($assignee, 0, 1) }}
                    </div>
                </div>
                @endforeach
            </div>
            
            <!-- Task Points -->
            <span class="bg-gray-100 text-gray-700 px-2 py-1 rounded text-xs">
                {{ $task['points'] }} pts
            </span>
        </div>
    </div>
</div>