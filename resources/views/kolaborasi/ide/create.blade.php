@extends('layouts.app')

@section('title', 'Buat Ide Kolaborasi')

@push('styles')
<style>
    .collab-container {
        max-width: 780px;
        margin: 3rem auto;
        background: #ffffff;
        border-radius: 16px;
        box-shadow: 0 8px 24px rgba(0,0,0,0.08);
        padding: 2.5rem 3rem;
    }

    .collab-container h1 {
        font-size: 1.9rem;
        font-weight: 700;
        color: #1e293b;
        margin-bottom: 2rem;
        text-align: center;
    }

    .form-label {
        font-weight: 600;
        color: #334155;
        display: block;
        margin-bottom: 0.5rem;
        font-size: 0.95rem;
    }

    .form-control {
        width: 100%;
        padding: 0.75rem 1rem;
        border: 1px solid #cbd5e1;
        border-radius: 8px;
        font-size: 0.95rem;
        color: #1e293b;
        transition: all 0.2s;
        background-color: #f8fafc;
    }

    .form-control[readonly] {
        background-color: #f1f5f9;
        cursor: not-allowed;
    }

    .form-control:focus {
        outline: none;
        border-color: #3b82f6;
        box-shadow: 0 0 0 2px rgba(59,130,246,0.15);
        background-color: #fff;
    }

    textarea.form-control {
        min-height: 150px;
        resize: vertical;
    }

    .range-container {
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    .range-container input[type=range] {
        flex-grow: 1;
        accent-color: #2563eb;
    }

    .range-value {
        min-width: 60px;
        font-weight: 600;
        text-align: right;
        color: #1e40af;
    }

    .btn-primary {
        background-color: #2563eb;
        color: white;
        border: none;
        border-radius: 8px;
        padding: 0.75rem 1.5rem;
        font-weight: 600;
        font-size: 0.95rem;
        transition: all 0.2s;
        display: inline-block;
    }

    .btn-primary:hover {
        background-color: #1d4ed8;
    }

    .btn-primary:active {
        transform: scale(0.97);
    }

    .form-section {
        margin-bottom: 1.5rem;
    }

    .alert-section {
        margin-bottom: 1.5rem;
    }

    .form-help {
        font-size: 0.875rem;
        color: #475569;
        margin-top: 0.25rem;
    }

    @media (max-width: 640px) {
        .collab-container {
            padding: 1.5rem;
        }
    }
</style>
@endpush

@section('content')
<div class="collab-container">
    <h1>Buat Ide Kolaborasi</h1>

    <div class="alert-section">
        @include('components.alert-kolaborasi')
    </div>

    <form action="{{ route('kolaborasi.ide.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        {{-- Nama & Role Pengaju --}}
        <div class="form-section">
            <label class="form-label">Nama Pengaju Kolaborasi</label>
            <input type="text" 
                   class="form-control" 
                   value="{{ auth()->user()->name ?? '-' }}" 
                   readonly>
        </div>

        <div class="form-section">
            <label class="form-label">Role Pengaju Kolaborasi</label>
            <input type="text" 
                   class="form-control" 
                   value="{{ ucfirst(auth()->user()->role ?? '-') }}" 
                   readonly>
        </div>

        {{-- Kategori dan Subkategori --}}
        <div class="form-section">
            <label class="form-label">Kategori</label>
            <input type="text" 
                   class="form-control" 
                   value="{{ $innovation->category ?? '-' }}" 
                   readonly>
        </div>

        <div class="form-section">
            <label class="form-label">Subkategori</label>
            <input type="text" 
                   class="form-control" 
                   value="{{ $innovation->subcategory ?? '-' }}" 
                   readonly>
        </div>

        {{-- Judul --}}
        <div class="form-section">
            <label class="form-label">Judul Kolaborasi</label>
            <input type="text" 
                   name="title" 
                   class="form-control" 
                   placeholder="Tuliskan judul ide kolaborasi Anda..."
                   required 
                   value="{{ old('title') }}">
            <p class="form-help">
                Buatkan judul yang sekreatif dan semenarik mungkin
            </p>
        </div>

        {{-- Deskripsi --}}
        <div class="form-section">
            <label class="form-label">Deskripsi Kolaborasi</label>
            <textarea name="description" 
                      class="form-control" 
                      placeholder="Jelaskan ide kolaborasi secara singkat dan jelas..."
                      required>{{ old('description') }}</textarea>
            <p class="form-help">
                Sertakan deskripsi lengkap, target, tujuan, uraian kegiatan (tasks), dan kebutuhan jumlah anggota tim dari kolaborasi yang ingin diajukan.
            </p>
        </div>

        {{-- Estimasi Durasi --}}
        <div class="form-section">
            <label class="form-label">Estimasi Durasi Kolaborasi</label>
            <div class="range-container">
                <input type="range" 
                       name="estimated_duration" 
                       id="durationRange" 
                       min="1" max="24" 
                       value="{{ old('estimated_duration', 6) }}">
                <div class="range-value"><span id="durationValue">6</span> bln</div>
            </div>
        </div>

        {{-- Upload Dokumen --}}
        <div class="form-section">
            <label class="form-label">Lampiran Dokumen (Opsional)</label>
            <input type="file" 
                   name="document" 
                   class="form-control"
                   accept=".pdf,.doc,.docx,.ppt,.pptx,.xls,.xlsx,.zip">
        </div>

        {{-- Upload Cover Image --}}
        <div class="form-section">
            <label class="form-label">Cover Image (Opsional)</label>
            <input type="file" 
                   name="cover_image" 
                   class="form-control"
                   accept=".jpg,.jpeg,.png,.webp">
            <p class="form-help">
                Format: jpg, jpeg, png, webp. Maksimal 5MB.
            </p>
        </div>

        {{-- Hidden: innovation_id --}}
        <input type="hidden" name="innovation_id" value="{{ $innovationId }}">

        <div class="text-center mt-5">
            <button class="btn-primary" type="submit">
                Simpan Ide Kolaborasi
            </button>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
    const durationRange = document.getElementById('durationRange');
    const durationValue = document.getElementById('durationValue');

    durationRange.addEventListener('input', function() {
        durationValue.textContent = this.value;
    });
</script>
@endpush
