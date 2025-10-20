@extends('layouts.app')

@section('title', 'Diskusi Inovasi')

<!-- Fonts & Tailwind -->
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<script src="https://cdn.tailwindcss.com"></script>

@section('content')
<!-- Hero Section -->
<section class="relative h-screen bg-cover bg-center" style="background-image: url('/images/hero.jpg')">
    <div class="absolute inset-0 bg-black bg-opacity-40 flex flex-col justify-center items-center text-white">
        <h1 class="text-5xl font-bold mb-6">Jelajahi Inovasi Terkini</h1>
        <a href="#diskusi-list" class="px-6 py-3 bg-blue-600 hover:bg-blue-700 rounded">Mulai Jelajahi</a>
    </div>
</section>

<!-- Filter & Search -->
<section class="my-8 px-6">
    <form method="GET" action="{{ route('forum-diskusi.index') }}" class="flex gap-2 flex-wrap items-center">
        <!-- Kategori -->
        <select name="category" id="category" class="border rounded px-3 py-2">
            <option value="">Pilih Kategori</option>
            @foreach($categories as $cat)
                <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>
                    {{ $cat->name }}
                </option>
            @endforeach
        </select>

        <!-- Subkategori -->
        <select name="subcategory" id="subcategory" class="border rounded px-3 py-2">
            <option value="">Pilih Subkategori</option>
            @if(isset($subcategories) && $subcategories->count())
                @foreach($subcategories as $sub)
                    <option value="{{ $sub->id }}" {{ request('subcategory') == $sub->id ? 'selected' : '' }}>
                        {{ $sub->name }}
                    </option>
                @endforeach
            @endif
        </select>

        <!-- Search -->
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari inovasi..." class="border rounded px-3 py-2 flex-1">
        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Search</button>
        
        <!-- Reset Filter -->
        <a href="{{ route('forum-diskusi.index') }}" class="px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600">
            Reset
        </a>
    </form>
</section>

<!-- Statistik -->
<section class="my-8 px-6 grid grid-cols-1 sm:grid-cols-3 gap-4 text-center">
    <div class="bg-gray-100 p-6 rounded">Inovasi Berkolaborasi: {{ $totalCollaborations ?? 0 }}</div>
    <div class="bg-gray-100 p-6 rounded">Total Inovasi: {{ $totalInnovations ?? 0 }}</div>
    <div class="bg-gray-100 p-6 rounded">Total Pengguna: {{ $totalUsers ?? 0 }}</div>
</section>

<!-- Top Users -->
@if(isset($topUsers) && $topUsers->count())
<section class="my-8 px-6">
    <h2 class="text-xl font-bold mb-4">Top 5 User Aktif</h2>
    <div class="grid grid-cols-2 sm:grid-cols-5 gap-4">
        @foreach($topUsers as $user)
            <div class="bg-gray-100 p-4 rounded text-center hover:shadow transition">
                <div class="font-semibold">{{ $user->name }}</div>
                <div class="text-sm text-gray-600">{{ $user->email ?? '-' }}</div>
                <div class="text-sm">Komentar: {{ $user->total_comments ?? 0 }}</div>
            </div>
        @endforeach
    </div>
</section>
@endif

<!-- Filter Tambahan -->
<section class="my-8 px-6 flex gap-4 flex-wrap">
    @php
        $currentQuery = request()->query();
        unset($currentQuery['filter']);
    @endphp
    @foreach(['Semua', 'Terpopuler', 'Terbaru', 'Berkolaborasi'] as $item)
        <a href="{{ route('forum-diskusi.index', array_merge($currentQuery, ['filter' => $item])) }}" 
           class="px-4 py-2 {{ $filter == $item ? 'bg-blue-600 text-white' : 'bg-gray-200' }} rounded hover:bg-gray-300">
           {{ $item }}
        </a>
    @endforeach
</section>

<!-- Daftar Inovasi -->
<section id="diskusi-list" class="my-8 px-6 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
    @forelse($paginatedInnovations as $innovation)
        <div class="bg-white rounded shadow p-4 flex flex-col">
            <img src="{{ $innovation->image_path ?? '/images/default-innovation.jpg' }}" 
                 class="w-full h-32 object-cover rounded mb-2"
                 onerror="this.src='/images/default-innovation.jpg'">
            
            <h3 class="font-bold line-clamp-2">{{ $innovation->title }}</h3>
            <p class="text-sm mt-1">
                @php
                    $categoryName = $categories->firstWhere('id', $innovation->category)->name ?? 'Kategori';
                    $subcategoryName = $subcategories->firstWhere('id', $innovation->subcategory)->name ?? 'Subkategori';
                @endphp
                {{ $categoryName }} > {{ $subcategoryName }}
            </p>
            <p class="text-sm mt-1">TRL: {{ $innovation->technology_readiness_level ?? '-' }}</p>
            <p class="text-sm mt-1">Oleh: {{ $innovation->author_name ?? 'Anonim' }}</p>
            <p class="text-xs text-gray-500 mt-1">{{ \Carbon\Carbon::parse($innovation->created_at)->diffForHumans() }}</p>
            
            <a href="{{ route('forum-diskusi.detail', ['type' => $innovation->author_role, 'id' => $innovation->id]) }}" 
               class="text-blue-600 mt-3 inline-block font-medium hover:underline">
               Lihat Diskusi
            </a>
        </div>
    @empty
        <div class="col-span-4 text-center text-gray-500 py-8">
            Tidak ada inovasi yang ditemukan.
            @if(request()->anyFilled(['search', 'category', 'subcategory']))
                <a href="{{ route('forum-diskusi.index') }}" class="text-blue-600 underline ml-2">Tampilkan semua inovasi</a>
            @endif
        </div>
    @endforelse
</section>

<!-- Pagination -->
<section class="px-6 my-8">
    {{ $paginatedInnovations->withQueryString()->links() }}
</section>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const categorySelect = document.getElementById('category');
    const subcategorySelect = document.getElementById('subcategory');
    const currentSubcategory = "{{ request('subcategory') }}";

    function loadSubcategories(categoryId, selectedSubcategory = '') {
        if (!categoryId) {
            subcategorySelect.innerHTML = '<option value="">Pilih Subkategori</option>';
            subcategorySelect.disabled = true;
            return;
        }

        subcategorySelect.innerHTML = '<option value="">Memuat subkategori...</option>';
        subcategorySelect.disabled = true;

        fetch(`{{ route('forum-diskusi.ajax-subcategories') }}?category=${categoryId}`)
            .then(response => response.json())
            .then(data => {
                subcategorySelect.innerHTML = '<option value="">Pilih Subkategori</option>';
                if (data.length > 0) {
                    data.forEach(subcategory => {
                        const option = document.createElement('option');
                        option.value = subcategory.id;
                        option.textContent = subcategory.name;
                        if (selectedSubcategory && subcategory.id == selectedSubcategory) {
                            option.selected = true;
                        }
                        subcategorySelect.appendChild(option);
                    });
                    subcategorySelect.disabled = false;
                } else {
                    subcategorySelect.innerHTML = '<option value="">Tidak ada subkategori</option>';
                    subcategorySelect.disabled = true;
                }
            })
            .catch(error => {
                console.error('Error loading subcategories:', error);
                subcategorySelect.innerHTML = '<option value="">Gagal memuat subkategori</option>';
                subcategorySelect.disabled = true;
            });
    }

    categorySelect.addEventListener('change', function() {
        const selectedCategoryId = this.value;
        loadSubcategories(selectedCategoryId);
        this.form.submit();
    });

    subcategorySelect.addEventListener('change', function() {
        this.form.submit();
    });

    const initialCategoryId = categorySelect.value;
    if (initialCategoryId) {
        loadSubcategories(initialCategoryId, currentSubcategory);
    }
});
</script>
@endsection
