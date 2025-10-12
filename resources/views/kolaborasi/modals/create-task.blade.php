<!-- Modal Create Task -->
<div id="taskModal" class="fixed inset-0 bg-black/50 hidden items-center justify-center z-50 p-4">
    <div class="bg-white rounded-xl shadow-lg w-full max-w-2xl max-h-[90vh] overflow-y-auto">
        <div class="p-6 border-b border-gray-200">
            <div class="flex justify-between items-center">
                <h3 class="text-xl font-bold text-gray-800">Tambah Task Baru</h3>
                <button onclick="closeTaskModal()" class="text-gray-500 hover:text-gray-700 text-2xl">
                    &times;
                </button>
            </div>
        </div>
        
        <form class="p-6 space-y-6">
            @csrf
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Judul Task *</label>
                <input type="text" placeholder="Contoh: Design UI Mockup" 
                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" required>
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Deskripsi</label>
                <textarea rows="3" placeholder="Jelaskan detail task..." 
                          class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"></textarea>
            </div>
            
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Prioritas</label>
                    <select class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option value="low">Low</option>
                        <option value="medium" selected>Medium</option>
                        <option value="high">High</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Story Points</label>
                    <select class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option value="1">1 point</option>
                        <option value="2">2 points</option>
                        <option value="3">3 points</option>
                        <option value="5">5 points</option>
                        <option value="8">8 points</option>
                        <option value="13">13 points</option>
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Deadline</label>
                    <input type="date" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                    <select class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option value="todo">To Do</option>
                        <option value="progress">In Progress</option>
                        <option value="review">Review</option>
                        <option value="done">Done</option>
                    </select>
                </div>
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Assign To</label>
                <div class="space-y-2">
                    @foreach($kolaborasi['anggota'] as $anggota)
                    <label class="flex items-center p-3 border border-gray-300 rounded-lg cursor-pointer hover:bg-gray-50">
                        <input type="checkbox" name="assignees[]" value="{{ $anggota['nama'] }}" class="text-blue-600 focus:ring-blue-500">
                        <div class="ml-3 flex items-center gap-3">
                            <div class="w-8 h-8 bg-gradient-to-r from-blue-500 to-purple-600 rounded-full flex items-center justify-center text-white text-xs font-bold">
                                {{ substr($anggota['nama'], 0, 1) }}
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-700">{{ $anggota['nama'] }}</p>
                                <p class="text-xs text-gray-500">{{ $anggota['role'] }}</p>
                            </div>
                        </div>
                    </label>
                    @endforeach
                </div>
            </div>
            
            <div class="flex gap-3 pt-4">
                <button type="button" onclick="closeTaskModal()" 
                        class="flex-1 bg-gray-100 hover:bg-gray-200 text-gray-700 py-3 rounded-lg font-semibold transition-colors">
                    Batal
                </button>
                <button type="submit" 
                        class="flex-1 bg-blue-600 hover:bg-blue-700 text-white py-3 rounded-lg font-semibold transition-colors">
                    Buat Task
                </button>
            </div>
        </form>
    </div>
</div>