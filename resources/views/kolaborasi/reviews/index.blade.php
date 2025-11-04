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
.table-aksi{ width:10%; }

/* Hero Section */
.hero {
    background: linear-gradient(to right, rgba(30,64,175,0.85), rgba(30,58,138,0.9));
    border-radius: 1rem;
    padding: 2rem;
    display: flex;
    align-items: center;
    gap: 1.5rem;
    color: white;
    margin-bottom: 2rem;
}
.hero-icon {
    font-size: 3rem;
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
            if(i < selectedRating) s.classList.remove('star-gray');
            else s.classList.add('star-gray');
        });
    }

    // Open modal
    document.querySelectorAll('.open-rating-modal').forEach(btn => {
        btn.addEventListener('click', function(){
            const reviewId = this.dataset.review;
            const rating = this.dataset.rating || 0;
            const comment = this.dataset.comment || '';

            if(!reviewId || reviewId==0){
                Swal.fire('Oops','Review belum tersedia untuk task ini','error');
                return;
            }

            modalReviewId.value = reviewId;
            modalRating.value = rating;
            modalComment.value = comment;
            selectedRating = parseInt(rating);
            updateStars(selectedRating);

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
            Swal.fire('Peringatan','Isi rating atau komentar terlebih dahulu','warning');
            return;
        }
        document.getElementById('ratingForm').submit();
    });

});
</script>
@endpush

@section('content')
<div class="max-w-7xl mx-auto px-4 py-8">

    {{-- Hero Section --}}
    <div class="hero">
        <i class="hero-icon fas fa-star"></i>
        <div>
            <h1 class="text-3xl font-bold">Review Kolaborasi #{{ $kolaborasi_judul }}</h1>
            <p class="mt-1 text-white/90">Berikan penilaian dan komentar untuk setiap task yang telah dikerjakan oleh anggota kolaborasi.</p>
        </div>
    </div>

    <div class="page-border p-6 space-y-6">

        {{-- Tombol Halaman Utama --}}
        <div class="flex flex-wrap items-center gap-3 mb-8">
            <a href="{{ route('kolaborasi.detail', $kolaborasi_id) }}" 
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
                        <td class="px-4 py-4">{{ $index+1 }}</td>
                        <td class="px-4 py-4">{{ $member_name }}</td>
                        <td class="px-4 py-4">{{ $task->title }}</td>
                        <td class="px-4 py-4">{{ $task->description }}</td>
                        <td class="px-4 py-4">
                            @for($i=1;$i<=5;$i++)
                                <span class="star {{ $i <= $rating ? '' : 'star-gray' }}">&#9733;</span>
                            @endfor
                        </td>
                        <td class="px-4 py-4">
                            @if($review_id)
                            <button type="button"
                                class="open-rating-modal px-2 py-1 rounded bg-gray-200 hover:bg-gray-300 text-sm"
                                data-review="{{ $review_id }}"
                                data-rating="{{ $rating }}"
                                data-comment="{{ $komentar }}">
                                Tambah
                            </button>
                            @else
                            <span class="text-gray-400">Belum tersedia</span>
                            @endif
                        </td>
                        <td class="px-4 py-4 text-center">
                            @if($role==='Pengaju Kolaborasi' && $review_id)
                                <button type="button"
                                    class="open-rating-modal px-2 py-1 rounded bg-success text-white text-xs mb-1"
                                    data-review="{{ $review_id }}"
                                    data-rating="{{ $rating }}"
                                    data-comment="{{ $komentar }}">
                                    Submit
                                </button>
                                <form action="{{ route('kolaborasi.reviews.destroy', $review_id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="px-2 py-1 rounded bg-red-500 text-white hover:bg-red-600 text-xs">Hapus</button>
                                </form>
                            @else
                                -
                            @endif
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
    </div>
</div>

{{-- Modal Pop-up Rating/Comment --}}
<div id="ratingModal" class="modal">
    <div class="modal-content">
        <h2 class="text-xl font-bold text-primary mb-4">Tambah Rating / Komentar</h2>
        <form id="ratingForm" action="{{ route('kolaborasi.reviews.store', $kolaborasi_id) }}" method="POST">
            @csrf
            <input type="hidden" name="review_id" id="modalReviewId" value="">
            <input type="hidden" name="rating" id="modalRating" value="0">

            <label class="block mb-1">Pilih Rating</label>
            <div id="ratingStars" class="flex gap-1 mb-3">
                @for($i=1;$i<=5;$i++)
                    <span class="star star-gray">&#9733;</span>
                @endfor
            </div>

            <label class="block mb-1">Komentar</label>
            <textarea name="komentar" id="modalComment" rows="3" class="w-full border-gray-300 rounded p-2 mb-3"></textarea>

            <div class="flex justify-end gap-3">
                <button type="button" id="closeModalBtn" class="px-4 py-2 rounded bg-gray-300 hover:bg-gray-400">Batal</button>
                <button type="button" id="submitRatingBtn" class="px-4 py-2 rounded bg-success text-white">Submit</button>
            </div>
        </form>
    </div>
</div>
@endsection
