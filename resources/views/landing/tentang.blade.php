@extends('layouts.app')

@section('styles')
<style>
    .simple-hero {
        background: linear-gradient(135deg, #1e40af 0%, #3730a3 100%);
    }
    
    .card-hover {
        transition: transform 0.2s ease;
    }
    
    .card-hover:hover {
        transform: translateY(-2px);
    }
</style>
@endsection

@section('content')
<!-- Simple Hero Section -->
<section class="simple-hero text-white py-16">
    <div class="container mx-auto px-4 text-center">
        <h1 class="text-3xl md:text-4xl font-bold mb-4">
            Tentang Digital Innovation Hub
        </h1>
        <p class="text-lg opacity-90 max-w-2xl mx-auto">
            Platform kolaborasi antara pemerintah daerah dan akademisi untuk menciptakan solusi inovatif.
        </p>
    </div>
</section>

<!-- Stats Section -->
<section class="bg-white py-12 border-b">
    <div class="container mx-auto px-4">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            <div class="text-center p-4">
                <div class="text-2xl font-bold text-blue-600 mb-1">50+</div>
                <p class="text-gray-600 text-sm">OPD Terdaftar</p>
            </div>
            <div class="text-center p-4">
                <div class="text-2xl font-bold text-green-600 mb-1">{{ \App\Models\OpdProgram::count() }}</div>
                <p class="text-gray-600 text-sm">Program Aktif</p>
            </div>
            <div class="text-center p-4">
                <div class="text-2xl font-bold text-orange-500 mb-1">64</div>
                <p class="text-gray-600 text-sm">Solusi Implementasi</p>
            </div>
            <div class="text-center p-4">
                <div class="text-2xl font-bold text-purple-600 mb-1">35</div>
                <p class="text-gray-600 text-sm">Institusi Akademik</p>
            </div>
        </div>
    </div>
</section>

<!-- Visi Misi Section -->
<section class="bg-gray-50 py-16">
    <div class="container mx-auto px-4">
        <div class="max-w-4xl mx-auto">
            <!-- Visi -->
            <div class="bg-white rounded-lg p-6 mb-8 shadow-sm">
                <h2 class="text-2xl font-bold text-gray-900 mb-4 flex items-center">
                    <i class="fas fa-bullseye text-blue-600 mr-3"></i>
                    Visi Kami
                </h2>
                <p class="text-gray-700 leading-relaxed">
                    Menjadi platform terdepan dalam mendorong kolaborasi antara pemerintah daerah dan akademisi 
                    untuk menciptakan inovasi digital yang mempercepat transformasi digital daerah.
                </p>
            </div>
            
            <!-- Misi -->
            <div class="bg-white rounded-lg p-6 shadow-sm">
                <h2 class="text-2xl font-bold text-gray-900 mb-6 flex items-center">
                    <i class="fas fa-flag text-green-600 mr-3"></i>
                    Misi Kami
                </h2>
                <div class="space-y-4">
                    @foreach([
                        'Memfasilitasi pertemuan antara kebutuhan riil pemerintah daerah dengan solusi inovatif dari akademisi',
                        'Mendorong terciptanya ekosistem inovasi digital yang berkelanjutan di tingkat daerah',
                        'Mempercepat adopsi teknologi digital dalam pelayanan publik',
                        'Meningkatkan kapasitas digital pemerintah daerah melalui kolaborasi dengan akademisi'
                    ] as $mission)
                    <div class="flex items-start">
                        <i class="fas fa-check text-blue-500 mt-1 mr-3 flex-shrink-0"></i>
                        <p class="text-gray-700">{{ $mission }}</p>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Team Section -->
<section class="bg-white py-16">
    <div class="container mx-auto px-4">
        <div class="text-center mb-12">
            <h2 class="text-2xl font-bold text-gray-900 mb-2">Tim Kami</h2>
            <p class="text-gray-600">Dedicated team behind the platform</p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 max-w-4xl mx-auto">
            @foreach([
                ['name' => 'Dr. Sarah Wijaya', 'role' => 'Project Lead'],
                ['name' => 'Ahmad Fauzi, M.Kom', 'role' => 'Tech Lead'],
                ['name' => 'Diana Putri, S.Si', 'role' => 'UI/UX Designer'],
                ['name' => 'Rizki Maulana, M.T', 'role' => 'Data Scientist']
            ] as $member)
            <div class="bg-gray-50 rounded-lg p-4 text-center card-hover">
                <div class="w-16 h-16 bg-blue-500 rounded-full mx-auto mb-3 flex items-center justify-center text-white font-bold">
                    {{ substr($member['name'], 0, 1) }}
                </div>
                <h3 class="font-semibold text-gray-900 mb-1">{{ $member['name'] }}</h3>
                <p class="text-blue-600 text-sm">{{ $member['role'] }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Partners Section -->
<section class="bg-gray-50 py-16">
    <div class="container mx-auto px-4">
        <div class="text-center mb-8">
            <h2 class="text-2xl font-bold text-gray-900 mb-2">Mitra Kerja Sama</h2>
            <p class="text-gray-600">Berkolaborasi dengan institusi terkemuka</p>
        </div>
        
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 max-w-4xl mx-auto">
            @foreach(['Universitas Indonesia', 'ITB', 'UGM', 'ITS', 'BPPT', 'Kemenkominfo', 'Kemendagri', 'KemenPANRB'] as $partner)
            <div class="bg-white rounded-lg p-4 flex items-center justify-center h-20 card-hover">
                <span class="text-gray-500 text-sm text-center">{{ $partner }}</span>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Contact Section -->
<section class="bg-white py-16 border-t">
    <div class="container mx-auto px-4">
        <div class="max-w-2xl mx-auto text-center">
            <h2 class="text-2xl font-bold text-gray-900 mb-8">Hubungi Kami</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div>
                    <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center mx-auto mb-3">
                        <i class="fas fa-phone text-blue-600"></i>
                    </div>
                    <h3 class="font-semibold text-gray-900 mb-1">Telepon</h3>
                    <p class="text-gray-600 text-sm">(021) 123-4567</p>
                </div>
                
                <div>
                    <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center mx-auto mb-3">
                        <i class="fas fa-envelope text-green-600"></i>
                    </div>
                    <h3 class="font-semibold text-gray-900 mb-1">Email</h3>
                    <p class="text-gray-600 text-sm">info@innovationhub.id</p>
                </div>
                
                <div>
                    <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center mx-auto mb-3">
                        <i class="fas fa-map-marker-alt text-purple-600"></i>
                    </div>
                    <h3 class="font-semibold text-gray-900 mb-1">Lokasi</h3>
                    <p class="text-gray-600 text-sm">Jakarta, Indonesia</p>
                </div>
            </div>
            
            <a href="mailto:info@innovationhub.id" class="inline-flex items-center bg-blue-600 text-white px-6 py-3 rounded-lg font-medium hover:bg-blue-700 transition">
                <i class="fas fa-envelope mr-2"></i>
                Kirim Pesan
            </a>
        </div>
    </div>
</section>
@endsection