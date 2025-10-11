@extends('layouts.app')

@section('title', 'Inovasi Saya - Platform Inovasi')

@section('content')
<div class="w-full">

    <!-- Hero Section -->
<section class="relative text-white py-24 overflow-hidden bg-gradient-to-br from-blue-600 to-blue-500">
    <!-- Overlay untuk efek pudar bawah -->
    <div class="absolute inset-0 bg-gradient-to-b from-transparent to-blue-500 opacity-40 pointer-events-none"></div>    
    <!-- Decorative SVG -->
    <div class="absolute inset-0 opacity-5">            
        <svg class="w-full h-full" xmlns="http://www.w3.org/2000/svg">
                <defs><pattern id="dots" x="0" y="0" width="60" height="60" patternUnits="userSpaceOnUse"><circle cx="30" cy="30" r="2" fill="white" /></pattern></defs>
                <rect width="100%" height="100%" fill="url(#dots)" />
            </svg>
        </div>

<div class="relative container mx-auto px-4 text-center z-10">
    <h1 class="text-4xl md:text-5xl font-extrabold mb-4">
        Temukan <span class="bg-gradient-to-r from-blue-400 to-purple-300 bg-clip-text">Inovasi Terbaru</span>
    </h1>
    <p class="max-w-2xl mx-auto text-lg md:text-xl mb-8 opacity-90">
        Akademisi Pekanbaru, bagikan karya dan ide inovatif Anda! 
        Posting inovasi Anda sekarang dan inspirasi komunitas kreatif di kota ini.
    </p>
</div>

            <div class="flex flex-col sm:flex-row gap-4 justify-center items-center mb-8">
                <a href="{{ route('akademisi.inovasi.create') }}" class="flex items-center gap-2 px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg transition-all transform hover:-translate-y-1 shadow-lg">
                    <i class="fas fa-plus"></i> Posting Inovasi Baru
                </a>
                <a href="#inovasi-saya" class="flex items-center gap-2 px-6 py-3 bg-white text-blue-700 font-semibold rounded-lg hover:bg-gray-100 transition transform hover:scale-105">
                    <i class="fas fa-arrow-down"></i> Lihat Inovasi Saya
                </a>
            </div>

            <!-- Search Form -->
            <div class="bg-white/10 backdrop-blur-md p-6 rounded-xl max-w-4xl mx-auto">
                <form action="{{ route('akademisi.inovasi.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <div class="flex flex-col">
                        <label class="text-white font-medium text-sm mb-1">Cari Inovasi</label>
                        <input type="text" name="q" value="{{ request('q') }}" placeholder="Ketik kata kunci..." class="p-3 rounded-lg border border-white/30 bg-white/10 placeholder-white/70 focus:outline-none focus:border-white/50 focus:bg-white/20 transition">
                    </div>
                    <div class="flex flex-col">
                        <label class="text-white font-medium text-sm mb-1">Kategori</label>
                        <select name="category" class="p-3 rounded-lg border border-white/30 bg-white text-black cursor-pointer focus:outline-none focus:border-white/50 transition">
                            <option value="">Semua Kategori</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat }}" {{ request('category') == $cat ? 'selected' : '' }}>{{ $cat }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="flex flex-col">
                        <label class="text-white font-medium text-sm mb-1">Subkategori</label>
                        <select name="subcategory" class="p-3 rounded-lg border border-white/30 bg-white text-black cursor-pointer focus:outline-none focus:border-white/50 transition" {{ request('category') ? '' : 'disabled' }}>
                            <option value="">Semua Subkategori</option>
                            @if(request('category') && $subcategories ?? false)
                                @foreach($subcategories as $sub)
                                    <option value="{{ $sub }}" {{ request('subcategory') == $sub ? 'selected' : '' }}>{{ $sub }}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                    <button type="submit" class="p-3 bg-blue-600 text-white font-semibold rounded-lg flex items-center justify-center gap-2 hover:bg-blue-700 transition transform hover:-translate-y-1">
                        <i class="fas fa-search"></i> Cari
                    </button>
                </form>
            </div>
        </div>
    </section>

    <!-- Main Content -->
    <div class="container mx-auto px-4 py-14 mt-8" id="inovasi-saya">
        <div class="flex justify-between items-center mb-8">
            <div class="flex items-center gap-4">
                <div class="bg-green-500 p-4 rounded-lg text-white text-2xl">
                    <i class="fas fa-lightbulb text-yellow-300"></i>
                </div>
                <div>
                    <h2 class="text-2xl font-bold text-gray-800">Inovasi Saya</h2>
                    <p class="text-gray-600 text-sm mt-1">Kelola dan lihat semua inovasi yang telah Anda posting</p>
                </div>
            </div>
        </div>

        @forelse($userInnovations as $year => $items)
        <div class="mb-12">
            <h3 class="text-xl font-semibold text-gray-700 border-b-4 border-gray-200 inline-block mb-6">Tahun {{ $year }}</h3>
            <div class="grid gap-6 grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4">
                @foreach($items as $item)
                <div class="bg-indigo-50 rounded-xl shadow hover:shadow-xl transition transform hover:-translate-y-2 flex flex-col overflow-hidden">
                    <div class="relative h-52 w-full">
                        @if($item->image_path)
                            <img src="{{ asset('storage/'.$item->image_path) }}" alt="{{ $item->title }}" class="w-full h-full object-cover transition transform hover:scale-105" loading="lazy">
                        @else
                            <div class="w-full h-full bg-blue-500 flex items-center justify-center text-yellow-300 text-4xl">
                                <i class="fas fa-lightbulb"></i>
                            </div>
                        @endif
                        <span class="absolute top-3 left-3 bg-green-500 text-white px-3 py-1 rounded-full text-xs font-semibold">{{ $item->category }}</span>
                        <span class="absolute top-3 right-3 px-2 py-1 rounded text-xs font-semibold text-white {{ $item->status == 'published' ? 'bg-green-500' : 'bg-yellow-400' }}">{{ ucfirst($item->status) }}</span>
                    </div>
                    <div class="p-4 flex flex-col flex-1">
                        <h3 class="font-semibold text-gray-800 text-lg line-clamp-2">{{ $item->title }}</h3>
                        <p class="text-gray-600 text-sm line-clamp-3 my-2 mb-8">{{ Str::limit($item->description, 120) }}</p>
                        <div class="mt-auto flex gap-2">
                            <a href="{{ route('akademisi.inovasi.show', $item->id) }}" class="flex-1 bg-blue-600 text-white text-sm font-semibold py-2 rounded-lg text-center hover:bg-blue-700 transition">Lihat</a>
                            <a href="{{ route('akademisi.inovasi.edit', $item->id) }}" class="flex-1 bg-indigo-200 text-gray-700 text-sm font-semibold py-2 rounded-lg text-center hover:bg-indigo-300 transition">Edit</a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @empty
        <div class="bg-indigo-50 rounded-xl p-12 text-center border-2 border-dashed border-indigo-300">
            <i class="fas fa-lightbulb text-5xl text-yellow-300 mb-4"></i>
            <h3 class="text-xl font-semibold text-gray-700 mb-2">Belum Ada Inovasi</h3>
            <p class="text-gray-500 mb-6">Mulai bagikan karya dan penelitian Anda sekarang! Posting inovasi pertama Anda dan inspirasi komunitas.</p>
            <a href="{{ route('akademisi.inovasi.create') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-blue-600 text-white font-semibold rounded-lg shadow hover:bg-blue-700 transition transform hover:-translate-y-1">
                <i class="fas fa-plus"></i> Posting Inovasi Pertama
            </a>
        </div>
        @endforelse
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Dynamic subcategory loading
    const categorySelect = document.querySelector('select[name="category"]');
    const subcategorySelect = document.querySelector('select[name="subcategory"]');

    categorySelect.addEventListener('change', function() {
        const category = this.value;
        subcategorySelect.innerHTML = '<option value="">Memuat...</option>';
        subcategorySelect.disabled = true;

        if(!category){
            subcategorySelect.innerHTML = '<option value="">Semua Subkategori</option>';
            subcategorySelect.disabled = true;
            return;
        }

        fetch(`{{ route('akademisi.inovasi.subcategories') }}?category=${encodeURIComponent(category)}`)
            .then(res => res.json())
            .then(data => {
                subcategorySelect.innerHTML = '<option value="">Semua Subkategori</option>';
                data.forEach(sub => {
                    const selected = sub === '{{ request('subcategory') }}' ? 'selected' : '';
                    subcategorySelect.innerHTML += `<option value="${sub}" ${selected}>${sub}</option>`;
                });
                subcategorySelect.disabled = false;
            })
            .catch(() => {
                subcategorySelect.innerHTML = '<option value="">Gagal memuat</option>';
                subcategorySelect.disabled = true;
            });
    });

    // Smooth scroll
    document.querySelector('a[href="#inovasi-saya"]').addEventListener('click', function(e) {
        e.preventDefault();
        document.querySelector('#inovasi-saya').scrollIntoView({ behavior: 'smooth' });
    });
</script>
@endpush
