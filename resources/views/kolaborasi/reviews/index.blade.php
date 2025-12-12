@extends('layouts.app')

@section('title', 'Review Kolaborasi')

@push('styles')
<script src="https://cdn.tailwindcss.com"></script>
<style>
.modal { display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.5); justify-content:center; align-items:center; z-index:50; }
.modal.show { display:flex; }
.modal-content { background:white; padding:2rem; border-radius:1rem; width:400px; max-width:90%; }
.star { color:#fbbf24; font-size:1.2rem; cursor:pointer; }
.star-gray { color:#d1d5db; font-size:1.2rem; cursor:pointer; }
.bg-success { background-color:#16a34a; }
.bg-success:hover { background-color:#15803d; }
.page-border {
    border: 1px solid #e5e7eb;
    border-radius: 1rem;
    box-shadow: 0 6px 16px rgba(0,0,0,0.06);
    background:white;
    overflow:hidden;
}
.table-no { width:5%; }
.table-member{ width:12%; }
.table-task{ width:20%; }
.table-desc{ width:28%; }
.table-rating{ width:10%; }
.table-comment{ width:15%; }
.table-aksi{ width:15%; }

/* Gradient untuk ikon kolaborasi */
.text-gradient {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

/* Style untuk komentar */
.comment-text {
    max-width: 200px;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
}
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.addEventListener('DOMContentLoaded', function(){

    let selectedRating = 0;
    const modal = document.getElementById('ratingModal');
    const modalReviewId = document.getElementById('modalReviewId');
    const modalRating = document.getElementById('modalRating');
    const modalComment = document.getElementById('modalComment');

    function updateStars(selectedRating){
        const stars = document.querySelectorAll('#ratingStars span');
        stars.forEach((s,i)=>{
            if(i < selectedRating) {
                s.classList.remove('star-gray');
                s.classList.add('star');
            } else {
                s.classList.remove('star');
                s.classList.add('star-gray');
            }
        });
    }

    // Open modal
    document.querySelectorAll('.open-rating-modal').forEach(btn => {
        btn.addEventListener('click', function(){
            const reviewId = this.dataset.review;
            const rating = this.dataset.rating || 0;
            const comment = this.dataset.comment || '';
            const taskTitle = this.dataset.task || '';

            if(!reviewId || reviewId==0){
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Review belum tersedia untuk task ini'
                });
                return;
            }

            modalReviewId.value = reviewId;
            modalRating.value = rating;
            modalComment.value = comment;
            selectedRating = parseInt(rating);
            updateStars(selectedRating);

            // Update modal title dengan task name
            document.getElementById('modalTitle').textContent = 'Review Task: ' + taskTitle;

            modal.classList.add('show');
        });
    });

    // Close modal
    document.getElementById('closeModalBtn').addEventListener('click', function(){
        modal.classList.remove('show');
    });

    // Set star (event delegation)
    document.getElementById('ratingStars').addEventListener('click', function(e){
        if(e.target.tagName === 'SPAN'){
            const stars = document.querySelectorAll('#ratingStars span');
            selectedRating = Array.from(stars).indexOf(e.target) + 1;
            modalRating.value = selectedRating;
            updateStars(selectedRating);
        }
    });

    // Submit modal
    document.getElementById('submitRatingBtn').addEventListener('click', function(){
        if(selectedRating===0 && modalComment.value===''){
            Swal.fire({
                icon: 'warning',
                title: 'Peringatan',
                text: 'Isi rating atau komentar terlebih dahulu'
            });
            return;
        }
        document.getElementById('ratingForm').submit();
    });

    // Handle delete review dengan SweetAlert
    document.querySelectorAll('.delete-review-btn').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            const form = this.closest('form');
            
            Swal.fire({
                title: 'Hapus Review?',
                text: "Data review akan dihapus permanen!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Tampilkan loading
                    Swal.fire({
                        title: 'Menghapus...',
                        text: 'Sedang menghapus review',
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });

                    // Submit form
                    form.submit();
                }
            });
        });
    });

    // Check for session messages and show SweetAlert
    @if(session('success'))
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: '{{ session('success') }}',
            timer: 3000,
            showConfirmButton: false
        });
    @endif

    @if(session('error'))
        Swal.fire({
            icon: 'error',
            title: 'Gagal!',
            text: '{{ session('error') }}',
            timer: 4000,
            showConfirmButton: true
        });
    @endif

    @if(session('warning'))
        Swal.fire({
            icon: 'warning',
            title: 'Peringatan!',
            text: '{{ session('warning') }}',
            timer: 3000,
            showConfirmButton: false
        });
    @endif

    @if($errors->any())
        Swal.fire({
            icon: 'error',
            title: 'Terjadi Kesalahan!',
            html: `{!! implode('<br>', $errors->all()) !!}`,
            showConfirmButton: true
        });
    @endif

});
</script>
@endpush

@section('content')
<div class="max-w-7xl mx-auto mt-10 mb-12 px-4 sm:px-6 lg:px-8">

    {{-- ==================== HALAMAN DETAIL - SAMA SEPERTI DI SHOW.BLADE.PHP ==================== --}}
    <div class="bg-white border border-white rounded-2xl shadow-xl overflow-hidden">

        {{-- Gambar Kolaborasi - SAMA SEPERTI DI SHOW.BLADE.PHP --}}
        <div class="w-full relative h-80 border-b border-gray-200 bg-gradient-to-br from-blue-50 to-indigo-100">
            @if($kolaborasi->image_path)
                <img src="{{ asset('storage/' . $kolaborasi->image_path) }}" 
                     alt="{{ $kolaborasi->judul }}" 
                     class="w-full h-full object-cover">
            @else
                <div class="w-full h-full flex flex-col items-center justify-center text-center p-8">
                    <div class="mb-4">
                        <i class="fas fa-hands-helping fa-4x text-gradient"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-700 mb-2">Kolaborasi Inovasi</h3>
                    <p class="text-gray-500 max-w-md">Bersama mewujudkan ide menjadi kenyataan melalui kolaborasi yang sinergis</p>
                </div>
            @endif
        </div>

        {{-- KONTEN UTAMA - GABUNG DALAM SATU DIV SEPERTI DI SHOW.BLADE.PHP --}}
        <div class="p-8">

            {{-- ==================== WRAPPER UTAMA REVIEW ==================== --}}
            <div class="page-border p-6 space-y-6">

                {{-- Header --}}
                <div class="flex justify-between items-center mb-4">
                    <div>
                        <h1 class="text-3xl font-bold text-primary">Review Kolaborasi</h1>
                        <p class="text-gray-600">
                            Kolaborasi: 
                            <span class="font-semibold text-secondary">
                                {{ $kolaborasi->judul ?? 'Tanpa Judul' }}
                            </span>
                        </p>
                        <p class="mt-1 text-gray-500">Berikan penilaian dan komentar untuk setiap task yang telah dikerjakan oleh anggota kolaborasi.</p>
                    </div>
                </div>

                {{-- Tombol Halaman Utama --}}
                <div class="flex flex-wrap items-center gap-3 mb-8">
                    <a href="{{ route('kolaborasi.detail', $kolaborasi->id) }}" 
                       class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                       <i class="fas fa-home"></i> Halaman Utama Kolaborasi
                    </a>
                </div>

                {{-- Tabel Review --}}
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-blue-50 text-gray-800">
                            <tr>
                                <th class="px-4 py-3 table-no">No</th>
                                <th class="px-4 py-3 table-member">Nama Anggota</th>
                                <th class="px-4 py-3 table-task">Task</th>
                                <th class="px-4 py-3 table-desc">Deskripsi</th>
                                <th class="px-4 py-3 table-rating">Rating</th>
                                <th class="px-4 py-3 table-comment">Komentar</th>
                                <th class="px-4 py-3 table-aksi">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 bg-graylight/40">
                            @forelse($tasks as $index => $task)
                            @php
                                $review = $reviews->firstWhere('kolaborasi_task_id', $task->id);
                                $review_id = $review->id ?? null;
                                $rating = $review->rating ?? 0;
                                $komentar = $review->komentar ?? '';
                                $member_name = $task->assignee->name ?? $kolaborasi_owner_name ?? 'Belum ditugaskan';
                            @endphp
                            <tr class="hover:bg-graylight transition">
                                <td class="px-4 py-4 text-center">{{ $index+1 }}</td>
                                <td class="px-4 py-4">{{ $member_name }}</td>
                                <td class="px-4 py-4">{{ $task->title }}</td>
                                <td class="px-4 py-4">{{ $task->description }}</td>
                                <td class="px-4 py-4 text-center">
                                    @for($i=1;$i<=5;$i++)
                                        <span class="{{ $i <= $rating ? 'star' : 'star-gray' }}">&#9733;</span>
                                    @endfor
                                </td>
                                <td class="px-4 py-4">
                                    @if($komentar)
                                        <div class="comment-text" title="{{ $komentar }}">
                                            {{ $komentar }}
                                        </div>
                                    @else
                                        <span class="text-gray-400 italic">Tidak ada komentar</span>
                                    @endif
                                </td>
                                <td class="px-4 py-4 text-center">
                                    <div class="flex flex-col gap-2 items-center">
                                        @if($role==='Pengaju Kolaborasi')
                                            @if($review_id)
                                                {{-- Tombol Edit/Submit --}}
                                                <button type="button"
                                                    class="open-rating-modal px-3 py-2 rounded bg-green-600 text-white text-sm hover:bg-green-700 transition w-full"
                                                    data-review="{{ $review_id }}"
                                                    data-rating="{{ $rating }}"
                                                    data-comment="{{ $komentar }}"
                                                    data-task="{{ $task->title }}">
                                                    <i class="fas fa-edit mr-1"></i> Edit Review
                                                </button>
                                                
                                                {{-- Tombol Hapus --}}
                                                <form action="{{ route('kolaborasi.reviews.destroy', $review_id) }}" method="POST" class="w-full">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" 
                                                            class="delete-review-btn px-3 py-2 rounded bg-red-600 text-white text-sm hover:bg-red-700 transition w-full">
                                                        <i class="fas fa-trash mr-1"></i> Hapus
                                                    </button>
                                                </form>
                                            @else
                                                {{-- Tombol Tambah Review Baru --}}
                                                <button type="button"
                                                    class="open-rating-modal px-3 py-2 rounded bg-blue-600 text-white text-sm hover:bg-blue-700 transition w-full"
                                                    data-review="0"
                                                    data-rating="0"
                                                    data-comment=""
                                                    data-task="{{ $task->title }}">
                                                    <i class="fas fa-plus mr-1"></i> Tambah Review
                                                </button>
                                            @endif
                                        @else
                                            <span class="text-gray-400 text-sm">-</span>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="text-center py-6 text-gray-500">Belum ada task.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div> {{-- end page-border --}}

        </div> {{-- end p-8 --}}

    </div> {{-- end bg-white border --}}

</div>

{{-- Modal Pop-up Rating/Comment --}}
<div id="ratingModal" class="modal">
    <div class="modal-content">
        <h2 class="text-xl font-bold text-primary mb-4" id="modalTitle">Tambah Rating / Komentar</h2>
        <form id="ratingForm" action="{{ route('kolaborasi.reviews.store', $kolaborasi->id) }}" method="POST">
            @csrf
            <input type="hidden" name="review_id" id="modalReviewId" value="">
            <input type="hidden" name="rating" id="modalRating" value="0">

            <label class="block mb-1 font-medium text-gray-700">Pilih Rating</label>
            <div id="ratingStars" class="flex gap-1 mb-4">
                @for($i=1;$i<=5;$i++)
                    <span class="star-gray">&#9733;</span>
                @endfor
            </div>

            <label class="block mb-1 font-medium text-gray-700">Komentar</label>
            <textarea name="komentar" id="modalComment" rows="3" class="w-full border border-gray-300 rounded-lg p-3 mb-4 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"></textarea>

            <div class="flex justify-end gap-3">
                <button type="button" id="closeModalBtn" class="px-4 py-2 rounded-lg bg-gray-300 hover:bg-gray-400 transition text-gray-700">Batal</button>
                <button type="button" id="submitRatingBtn" class="px-4 py-2 rounded-lg bg-green-600 text-white hover:bg-green-700 transition">Submit Review</button>
            </div>
        </form>
    </div>
</div>
@endsection