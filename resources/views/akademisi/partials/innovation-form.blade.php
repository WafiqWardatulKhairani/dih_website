<div class="bg-white rounded-xl shadow-md p-6 mb-6">
    <h2 class="text-2xl font-bold text-gray-800 mb-2">Posting Inovasi Baru</h2>
    <p class="text-gray-600 mb-6">Bagikan inovasi Anda dengan komunitas akademisi Pekanbaru</p>

    <div id="successMessage" class="hidden mb-4 p-4 bg-green-50 border border-green-200 text-green-700 rounded-lg">
        <i class="fas fa-check-circle mr-2"></i>
        <span id="successText"></span>
    </div>

    <div id="errorMessage" class="hidden mb-4 p-4 bg-red-50 border border-red-200 text-red-700 rounded-lg">
        <i class="fas fa-exclamation-circle mr-2"></i>
        <span id="errorText"></span>
    </div>

    <form id="inovasiForm" method="POST" action="{{ route('akademisi.inovasi.store') }}" enctype="multipart/form-data">
        @csrf
        <!-- Copy seluruh step 1-4 form dari HTML kamu -->
        <!-- Tidak perlu ubah, hanya pastikan id/form-field tetap sama -->
    </form>
</div>
