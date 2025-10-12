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
        
        <form action="{{ route('kolaborasi.store') }}" method="POST" class="p-6 space-y-6">
            @csrf
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Judul Kolaborasi *</label>
                <input type="text" name="judul" placeholder="Contoh: Sistem IoT Monitoring Banjir" 
                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" required>
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Deskripsi *</label>
                <textarea name="deskripsi" rows="3" placeholder="Jelaskan tujuan dan ruang lingkup kolaborasi..." 
                          class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" required></textarea>
            </div>
            
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Kategori *</label>
                    <select name="kategori" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" required>
                        <option value="">Pilih Kategori</option>
                        <option value="teknologi">Teknologi</option>
                        <option value="lingkungan">Lingkungan</option>
                        <option value="ekonomi">Ekonomi</option>
                        <option value="kesehatan">Kesehatan</option>
                        <option value="pendidikan">Pendidikan</option>
                        <option value="smart-city">Smart City</option>
                        <option value="layanan-publik">Layanan Publik</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Target Selesai *</label>
                    <input type="date" name="deadline" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" required>
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Tipe Kolaborasi</label>
                <div class="grid grid-cols-2 gap-4">
                    <label class="flex items-center p-3 border border-gray-300 rounded-lg cursor-pointer hover:bg-gray-50">
                        <input type="radio" name="tipe" value="public" class="text-blue-600 focus:ring-blue-500" checked>
                        <span class="ml-3 text-sm font-medium text-gray-700">Publik</span>
                        <span class="ml-auto text-xs text-gray-500">Terbuka untuk semua</span>
                    </label>
                    <label class="flex items-center p-3 border border-gray-300 rounded-lg cursor-pointer hover:bg-gray-50">
                        <input type="radio" name="tipe" value="private" class="text-blue-600 focus:ring-blue-500">
                        <span class="ml-3 text-sm font-medium text-gray-700">Privat</span>
                        <span class="ml-auto text-xs text-gray-500">Hanya dengan undangan</span>
                    </label>
                </div>
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Cari Partner (Opsional)</label>
                <input type="text" placeholder="Cari berdasarkan keahlian atau institusi..." 
                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                <div class="mt-2 space-y-2" id="partner-suggestions">
                    <!-- Partner suggestions will appear here -->
                </div>
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