<?php $__env->startSection('title', 'Detail Diskusi Inovasi'); ?>

<?php
use Carbon\Carbon;
use App\Models\DiscussionComment;
use App\Models\KolaborasiIde;
?>

<?php $__env->startPush('styles'); ?>
<style>
    .gradient-bg {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    }
    
    .info-card {
        transition: all 0.3s ease;
        border-left: 4px solid;
    }
    
    .info-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(0,0,0,0.1);
    }
    
    .comment-avatar {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        object-fit: cover;
    }
    
    .status-badge {
        padding: 0.5rem 1rem;
        border-radius: 2rem;
        font-weight: 600;
        font-size: 0.875rem;
    }
    
    .keyword-tag {
        display: inline-block;
        background: #e0f2fe;
        color: #0369a1;
        padding: 0.375rem 0.75rem;
        border-radius: 1rem;
        font-size: 0.75rem;
        font-weight: 500;
        margin: 0.125rem;
        border: 1px solid #bae6fd;
    }
    
    .section-divider {
        border-bottom: 2px solid #e2e8f0;
        padding-bottom: 1rem;
        margin-bottom: 1.5rem;
    }
    
    .sidebar-card {
        transition: all 0.3s ease;
        border: 1px solid #e2e8f0;
    }
    
    .sidebar-card:hover {
        border-color: #3b82f6;
        transform: translateX(4px);
    }
    
    .progress-bar {
        height: 6px;
        border-radius: 3px;
        background: #f1f5f9;
        overflow: hidden;
    }
    
    .progress-fill {
        height: 100%;
        background: linear-gradient(90deg, #f59e0b, #f97316);
        border-radius: 3px;
    }
    
    .source-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.5rem 1rem;
        border-radius: 2rem;
        font-size: 0.75rem;
        font-weight: 600;
        text-transform: capitalize;
    }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col lg:flex-row gap-8">

            <!-- Konten Utama -->
            <div class="flex-1">
                <!-- Breadcrumb -->
                <nav class="mb-6">
                    <a href="<?php echo e(route('forum-diskusi.index')); ?>" 
                       class="inline-flex items-center text-sm text-gray-600 hover:text-blue-600 transition-colors duration-200">
                        <i class="fas fa-arrow-left mr-2"></i>
                        Kembali ke Forum Diskusi
                    </a>
                </nav>

                <!-- Card Utama -->
                <div class="bg-white rounded-2xl shadow-lg overflow-hidden border border-gray-100">
                    <!-- Header Gambar -->
                    <?php if($innovation->image_url || $innovation->image_path): ?>
                        <div class="w-full h-64 md:h-80 lg:h-96 relative">
                            <img src="<?php echo e($innovation->image_url ?? asset('storage/' . $innovation->image_path)); ?>" 
                                 alt="<?php echo e($innovation->title); ?>" 
                                 class="w-full h-full object-cover">
                            <div class="absolute inset-0 bg-black bg-opacity-20"></div>
                        </div>
                    <?php else: ?>
                        <div class="w-full h-48 bg-gradient-to-r from-blue-500 to-purple-600 flex items-center justify-center">
                            <div class="text-center text-white">
                                <i class="fas fa-lightbulb text-5xl mb-3"></i>
                                <p class="text-lg font-semibold">Diskusi Inovasi</p>
                            </div>
                        </div>
                    <?php endif; ?>

                    <div class="p-6 md:p-8 space-y-8">
                        <!-- Header Info -->
                        <div class="space-y-4">
                            <div class="flex items-center gap-3 flex-wrap">
                                <?php
                                    $sourceType = $innovation->source_type ?? $type ?? 'unknown';
                                    $sourceTypeColors = [
                                        'academic' => 'bg-green-100 text-green-800',
                                        'opd' => 'bg-amber-100 text-amber-800',
                                        'umkm' => 'bg-blue-100 text-blue-800',
                                        'unknown' => 'bg-gray-100 text-gray-800'
                                    ];
                                    $sourceTypeIcons = [
                                        'academic' => 'fas fa-graduation-cap',
                                        'opd' => 'fas fa-building',
                                        'umkm' => 'fas fa-store',
                                        'unknown' => 'fas fa-question'
                                    ];
                                    $sourceTypeText = [
                                        'academic' => 'Akademik',
                                        'opd' => 'OPD',
                                        'umkm' => 'UMKM',
                                        'unknown' => 'Tidak Diketahui'
                                    ];
                                    $color = $sourceTypeColors[$sourceType] ?? $sourceTypeColors['unknown'];
                                    $icon = $sourceTypeIcons[$sourceType] ?? $sourceTypeIcons['unknown'];
                                    $text = $sourceTypeText[$sourceType] ?? $sourceTypeText['unknown'];
                                ?>
                                
                                <span class="source-badge <?php echo e($color); ?>">
                                    <i class="<?php echo e($icon); ?>"></i>
                                    <?php echo e($text); ?>

                                </span>

                                <!-- Category Badge -->
                                <span class="px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-sm font-medium">
                                    <?php echo e($innovation->category ?? 'Umum'); ?>

                                </span>
                                
                                <!-- Subcategory Badge -->
                                <?php if(($innovation->subcategory_name && $innovation->subcategory_name != '-') || ($innovation->subcategory && $innovation->subcategory != '-')): ?>
                                <span class="px-3 py-1 bg-purple-100 text-purple-800 rounded-full text-sm font-medium">
                                    <?php echo e($innovation->subcategory_name ?? $innovation->subcategory ?? 'Subkategori'); ?>

                                </span>
                                <?php endif; ?>
                            </div>
                            
                            <h1 class="text-3xl md:text-4xl font-bold text-gray-900 leading-tight">
                                <?php echo e($innovation->title); ?>

                            </h1>

                            <div class="flex flex-wrap items-center gap-4 text-sm text-gray-600">
                                <div class="flex items-center gap-2">
                                    <i class="fas fa-user-circle text-blue-500"></i>
                                    <span><?php echo e($innovation->author_name ?? $innovation->user->name ?? 'Anonim'); ?></span>
                                </div>
                                <div class="flex items-center gap-2">
                                    <i class="far fa-calendar text-green-500"></i>
                                    <?php
                                        $createdAt = $innovation->created_at instanceof Carbon ? $innovation->created_at : Carbon::parse($innovation->created_at ?? now());
                                    ?>
                                    <span><?php echo e($createdAt->translatedFormat('d F Y')); ?></span>
                                </div>
                                <div class="flex items-center gap-2">
                                    <i class="far fa-clock text-purple-500"></i>
                                    <span><?php echo e($createdAt->diffForHumans()); ?></span>
                                </div>
                            </div>
                        </div>

                        <!-- Grid Informasi -->
                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                            <!-- Kolom Kiri -->
                            <div class="space-y-4">
                                <div class="info-card bg-blue-50 border-blue-400 p-5 rounded-lg">
                                    <div class="flex items-center gap-3 mb-2">
                                        <i class="fas fa-user-graduate text-blue-600"></i>
                                        <h5 class="font-semibold text-gray-800">Penemu / Penulis</h5>
                                    </div>
                                    <p class="text-gray-700 font-medium"><?php echo e($innovation->author_name ?? $innovation->user->name ?? '-'); ?></p>
                                </div>

                                <div class="info-card bg-green-50 border-green-400 p-5 rounded-lg">
                                    <div class="flex items-center gap-3 mb-2">
                                        <i class="fas fa-university text-green-600"></i>
                                        <h5 class="font-semibold text-gray-800">Institusi</h5>
                                    </div>
                                    <p class="text-gray-700 font-medium"><?php echo e($innovation->institution ?? $innovation->user->institution ?? '-'); ?></p>
                                </div>
                            </div>

                            <!-- Kolom Kanan -->
                            <div class="space-y-4">
                                <div class="info-card bg-amber-50 border-amber-400 p-5 rounded-lg">
                                    <div class="flex items-center gap-3 mb-2">
                                        <i class="fas fa-tags text-amber-600"></i>
                                        <h5 class="font-semibold text-gray-800">Kata Kunci</h5>
                                    </div>
                                    <div class="flex flex-wrap gap-1">
                                        <?php if($innovation->keywords): ?>
                                            <?php $__currentLoopData = explode(',', $innovation->keywords); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $keyword): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <span class="keyword-tag"><?php echo e(trim($keyword)); ?></span>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        <?php else: ?>
                                            <span class="text-gray-500 text-sm">Tidak ada kata kunci</span>
                                        <?php endif; ?>
                                    </div>
                                </div>

                                <div class="info-card bg-orange-50 border-orange-400 p-5 rounded-lg">
                                    <div class="flex items-center gap-3 mb-2">
                                        <i class="fas fa-chart-line text-orange-600"></i>
                                        <h5 class="font-semibold text-gray-800">Tingkat Kesiapan Teknologi (TRL)</h5>
                                    </div>
                                    <div class="space-y-2">
                                        <div class="flex justify-between items-center text-sm">
                                            <span class="text-gray-600">Level <?php echo e($innovation->technology_readiness_level ?? 0); ?> dari 9</span>
                                        </div>
                                        <div class="progress-bar">
                                            <div class="progress-fill" 
                                                 style="width: <?php echo e(($innovation->technology_readiness_level ?? 0) / 9 * 100); ?>%"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Deskripsi -->
                        <div>
                            <h2 class="text-2xl font-bold text-gray-900 section-divider">Deskripsi Inovasi</h2>
                            <div class="bg-gray-50 p-6 rounded-xl">
                                <p class="text-gray-700 leading-relaxed whitespace-pre-line">
                                    <?php echo e($innovation->description ?? 'Tidak ada deskripsi tersedia.'); ?>

                                </p>
                            </div>
                        </div>

                        <!-- Tujuan -->
                        <div>
                            <h2 class="text-2xl font-bold text-gray-900 section-divider">Tujuan Inovasi</h2>
                            <div class="bg-gray-50 p-6 rounded-xl">
                                <p class="text-gray-700 leading-relaxed whitespace-pre-line">
                                    <?php echo e($innovation->purpose ?? 'Tidak ada tujuan tersedia.'); ?>

                                </p>
                            </div>
                        </div>

                        <!-- Status & Kontak -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="info-card bg-indigo-50 border-indigo-400 p-5 rounded-lg">
                                <div class="flex items-center gap-3 mb-2">
                                    <i class="fas fa-phone text-indigo-600"></i>
                                    <h5 class="font-semibold text-gray-800">Kontak</h5>
                                </div>
                                <p class="text-gray-700 break-words"><?php echo e($innovation->contact ?? $innovation->user->email ?? 'Tidak tersedia'); ?></p>
                            </div>

                            <div class="info-card bg-gray-50 border-gray-400 p-5 rounded-lg">
                                <div class="flex items-center gap-3 mb-2">
                                    <i class="fas fa-info-circle text-gray-600"></i>
                                    <h5 class="font-semibold text-gray-800">Status</h5>
                                </div>
                                <?php
                                    $statusColors = [
                                        'draft' => 'bg-gray-100 text-gray-800',
                                        'submitted' => 'bg-blue-100 text-blue-800',
                                        'under_review' => 'bg-yellow-100 text-yellow-800',
                                        'approved' => 'bg-green-100 text-green-800',
                                        'publication' => 'bg-green-100 text-green-800',
                                        'rejected' => 'bg-red-100 text-red-800'
                                    ];
                                    $statusText = [
                                        'draft' => 'Draft',
                                        'submitted' => 'Terkirim',
                                        'under_review' => 'Dalam Review',
                                        'approved' => 'Disetujui',
                                        'publication' => 'Dipublikasikan',
                                        'rejected' => 'Ditolak'
                                    ];
                                    $status = strtolower($innovation->status ?? 'draft');
                                    $statusColor = $statusColors[$status] ?? 'bg-gray-100 text-gray-800';
                                    $statusDisplay = $statusText[$status] ?? ucfirst($status);
                                ?>
                                <span class="status-badge <?php echo e($statusColor); ?>">
                                    <?php echo e($statusDisplay); ?>

                                </span>
                            </div>
                        </div>

                        <!-- Media Files -->
                        <div class="space-y-6">
                            <?php if(!empty($innovation->video_url)): ?>
                            <div>
                                <h2 class="text-2xl font-bold text-gray-900 section-divider">Video Demonstrasi</h2>
                                <a href="<?php echo e($innovation->video_url); ?>" target="_blank" rel="noopener noreferrer"
                                   class="inline-flex items-center gap-2 px-6 py-3 bg-red-600 text-white rounded-lg hover:bg-red-700 transition duration-200 shadow-md hover:shadow-lg">
                                    <i class="fas fa-play"></i>
                                    Tonton Video Demonstrasi
                                </a>
                            </div>
                            <?php endif; ?>

                            <?php if(!empty($innovation->document_path)): ?>
                            <div>
                                <h2 class="text-2xl font-bold text-gray-900 section-divider">Dokumen Inovasi</h2>
                                <a href="<?php echo e(asset('storage/' . $innovation->document_path)); ?>" target="_blank"
                                   class="inline-flex items-center gap-2 px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition duration-200 shadow-md hover:shadow-lg">
                                    <i class="fas fa-download"></i>
                                    Unduh Dokumen
                                </a>
                            </div>
                            <?php endif; ?>
                        </div>

                        <!-- Komentar Section -->
                        <div>
                            <h2 class="text-2xl font-bold text-gray-900 section-divider">
                                Komentar 
                                <span class="text-lg text-gray-600">(<?php echo e($comments->count()); ?>)</span>
                            </h2>

                            <?php if(auth()->guard()->check()): ?>
                            <form action="<?php echo e(route('forum-diskusi.add-comment', ['type'=>$type,'id'=>$innovation->id])); ?>" method="POST" class="mb-8">
                                <?php echo csrf_field(); ?>
                                <div class="space-y-3">
                                    <textarea name="content" 
                                              placeholder="Bagikan pemikiran Anda tentang inovasi ini..." 
                                              class="w-full border border-gray-300 rounded-xl p-4 text-sm focus:ring-2 focus:ring-blue-300 focus:border-blue-500 transition duration-200"
                                              rows="4"
                                              required><?php echo e(old('content')); ?></textarea>
                                    <button type="submit" 
                                            class="bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition duration-200 font-medium">
                                        <i class="fas fa-paper-plane mr-2"></i>Kirim Komentar
                                    </button>
                                </div>
                            </form>
                            <?php else: ?>
                            <div class="bg-blue-50 border border-blue-200 rounded-xl p-4 mb-6">
                                <p class="text-blue-800 text-sm">
                                    <i class="fas fa-info-circle mr-2"></i>
                                    Silakan <a href="<?php echo e(route('login')); ?>" class="font-semibold underline hover:text-blue-900">login</a> untuk menulis komentar.
                                </p>
                            </div>
                            <?php endif; ?>

                            <!-- Daftar Komentar -->
                            <div class="space-y-4">
                                <?php if($comments->count()): ?>
                                    <?php $__currentLoopData = $comments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $comment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php
                                        $commentCreatedAt = $comment->created_at instanceof Carbon ? $comment->created_at : Carbon::parse($comment->created_at ?? now());
                                        $avatar = $comment->avatar_url ?? $comment->user->avatar_url ?? asset('images/default-avatar.png');
                                    ?>
                                    <div class="bg-white border border-gray-200 rounded-xl p-4 hover:shadow-md transition duration-200">
                                        <div class="flex items-start gap-4">
                                            <img src="<?php echo e($avatar); ?>" class="comment-avatar">
                                            <div class="flex-1">
                                                <div class="flex items-center justify-between mb-2">
                                                    <div>
                                                        <h4 class="font-semibold text-gray-800"><?php echo e($comment->user_name ?? $comment->user->name ?? 'Anonymous'); ?></h4>
                                                        <div class="flex items-center gap-2 text-xs text-gray-500 mt-1">
                                                            <span><?php echo e($comment->user_role ?? $comment->user->role ?? '-'); ?></span>
                                                            <span>•</span>
                                                            <span><?php echo e($commentCreatedAt->diffForHumans()); ?></span>
                                                        </div>
                                                    </div>
                                                    <?php if(auth()->check() && auth()->id() == $comment->user_id): ?>
                                                    <form action="<?php echo e(route('forum-diskusi.delete-comment', ['id'=>$comment->id])); ?>" method="POST">
                                                        <?php echo csrf_field(); ?>
                                                        <?php echo method_field('DELETE'); ?>
                                                        <button type="submit" 
                                                                class="text-red-500 hover:text-red-700 text-xs font-medium transition duration-200">
                                                            Hapus
                                                        </button>
                                                    </form>
                                                    <?php endif; ?>
                                                </div>
                                                <p class="text-gray-700 text-sm leading-relaxed"><?php echo e($comment->content); ?></p>
                                            </div>
                                        </div>
                                    </div>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php else: ?>
                                    <div class="text-center py-8">
                                        <i class="fas fa-comments text-4xl text-gray-300 mb-3"></i>
                                        <p class="text-gray-500">Belum ada komentar. Jadilah yang pertama berkomentar!</p>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <aside class="w-full lg:w-80 flex-shrink-0 space-y-6">
                <!-- Diskusi Lainnya -->
                <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6">
                    <h3 class="text-xl font-bold text-gray-900 mb-4 pb-3 border-b border-gray-200">
                        <i class="fas fa-fire text-orange-500 mr-2"></i>Diskusi Lainnya
                    </h3>
                    <div class="space-y-4">
                        <?php $__currentLoopData = $sidebarInnovations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php
                                // FIX: Mengambil komentar berdasarkan innovation_id tanpa memperdulikan tipe
                                $commentsCount = \App\Models\DiscussionComment::where('innovation_id', $item->id)->count();
                                $itemSourceType = $item->source_type ?? 'unknown';
                                $itemType = $itemSourceType != 'unknown' ? $itemSourceType : ($type ?? 'unknown');
                            ?>
                            <a href="<?php echo e(route('forum-diskusi.detail', ['type' => $itemType, 'id' => $item->id])); ?>" 
                               class="sidebar-card block p-4 rounded-xl hover:no-underline">
                                <h4 class="font-semibold text-gray-800 text-sm line-clamp-2 mb-2"><?php echo e($item->title); ?></h4>
                                <div class="flex items-center justify-between text-xs text-gray-500">
                                    <span><?php echo e($item->category ?? 'Umum'); ?></span>
                                    <div class="flex items-center gap-1">
                                        <i class="fas fa-comment"></i>
                                        <span><?php echo e($commentsCount); ?></span>
                                    </div>
                                </div>
                                <div class="text-xs text-gray-400 mt-2">
                                    Oleh: <?php echo e(Str::limit($item->author_name ?? $item->user->name ?? 'Anonim', 20)); ?>

                                </div>
                            </a>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>

                <!-- Pengajuan Kolaborasi -->
                <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6">
                    <h3 class="text-xl font-bold text-gray-900 mb-4 pb-3 border-b border-gray-200">
                        <i class="fas fa-handshake text-green-500 mr-2"></i>Kolaborasi
                    </h3>
                    <?php
                        $userId = auth()->id();
                        
                        // FIX: Query yang benar berdasarkan struktur tabel
                        $collaboration = KolaborasiIde::where('innovation_id', $innovation->id)
                            ->where('user_id', $userId)
                            ->first();
                            
                        $isOwner = $userId === ($innovation->user_id ?? null);
                        $hasCollaboration = KolaborasiIde::where('innovation_id', $innovation->id)->exists();
                        
                        // Ambil data kolaborasi untuk inovasi ini (untuk tombol "Lihat Kolaborasi")
                        $existingCollaboration = KolaborasiIde::where('innovation_id', $innovation->id)->first();
                    ?>
                    
                    <div class="space-y-4">
                        <?php if(!$hasCollaboration): ?>
                            <p class="text-gray-600 text-sm">Belum ada pengajuan kolaborasi.</p>
                            <?php if(!$isOwner): ?>
                                <a href="<?php echo e(route('kolaborasi.ide.create', ['innovation_id'=>$innovation->id])); ?>" 
                                   class="w-full inline-flex items-center justify-center gap-2 px-4 py-3 bg-gradient-to-r from-blue-500 to-blue-600 text-white rounded-lg hover:from-blue-600 hover:to-blue-700 transition duration-200 font-medium">
                                    <i class="fas fa-plus"></i>
                                    Ajukan Kolaborasi
                                </a>
                            <?php else: ?>
                                <p class="text-blue-600 text-sm font-medium">Ini adalah inovasi Anda.</p>
                            <?php endif; ?>
                        <?php else: ?>
                            <?php if($collaboration): ?>
                                <?php if($isOwner): ?>
                                    <p class="text-green-600 text-sm font-medium">📬 Ada pengajuan kolaborasi masuk!</p>
                                    <a href="<?php echo e(route('kolaborasi.ide.show', ['id'=>$collaboration->id])); ?>" 
                                       class="w-full inline-flex items-center justify-center gap-2 px-4 py-3 bg-green-600 text-white rounded-lg hover:bg-green-700 transition duration-200 font-medium">
                                        <i class="fas fa-eye"></i>
                                        Lihat Pengajuan
                                    </a>
                                <?php else: ?>
                                    <a href="<?php echo e(route('kolaborasi.ide.show', ['id'=>$collaboration->id])); ?>" 
                                       class="w-full inline-flex items-center justify-center gap-2 px-4 py-3 bg-amber-500 text-white rounded-lg hover:bg-amber-600 transition duration-200 font-medium">
                                        <i class="fas fa-edit"></i>
                                        Edit Pengajuan
                                    </a>
                                <?php endif; ?>
                            <?php else: ?>
                                <p class="text-purple-600 text-sm font-medium">👥 Sudah ada kolaborasi berjalan.</p>
                                <?php if($isOwner): ?>
                                    <a href="<?php echo e(route('kolaborasi.ide.index')); ?>?innovation_id=<?php echo e($innovation->id); ?>" 
                                       class="w-full inline-flex items-center justify-center gap-2 px-4 py-3 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition duration-200 font-medium">
                                        <i class="fas fa-users"></i>
                                        Kelola Kolaborasi
                                    </a>
                                <?php else: ?>
                                    <p class="text-gray-600 text-sm">Kolaborasi sudah diajukan oleh pengguna lain.</p>
                                    <!-- TAMBAHAN: Tombol Lihat Kolaborasi -->
                                    <?php if($existingCollaboration): ?>
                                        <a href="<?php echo e(route('kolaborasi.ide.show', ['id' => $existingCollaboration->id])); ?>" 
                                           class="w-full inline-flex items-center justify-center gap-2 px-4 py-3 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition duration-200 font-medium">
                                            <i class="fas fa-eye mr-2"></i>
                                            Lihat Kolaborasi
                                        </a>
                                    <?php endif; ?>
                                <?php endif; ?>
                            <?php endif; ?>
                        <?php endif; ?>
                    </div>
                </div>
            </aside>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\laragon\www\dih_website\resources\views/diskusi/diskusi-detail.blade.php ENDPATH**/ ?>