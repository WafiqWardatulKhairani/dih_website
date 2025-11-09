<?php $__env->startSection('title', 'Detail Kolaborasi Inovasi'); ?>

<?php $__env->startPush('styles'); ?>
<script src="https://cdn.tailwindcss.com"></script>
<script>
tailwind.config = {
    theme: {
        extend: {
            colors: {
                primary: '#1e3a8a',
                secondary: '#1e40af',
                accent: '#3b82f6',
                dark: '#1e293b',
                light: '#f8fafc',
                success: '#059669',
                warning: '#d97706',
                danger: '#dc2626'
            }
        }
    }
}
</script>
<style>
.section-title {
    font-size: 1.75rem;
    font-weight: 800;
    color: #1e3a8a;
    text-align: center;
    margin-bottom: 2rem;
    text-transform: uppercase;
    letter-spacing: 0.05em;
}
.menu-card {
    background: white;
    border-radius: 1rem;
    box-shadow: 0 6px 16px rgba(0,0,0,0.08);
    overflow: hidden;
    transition: all 0.3s ease;
    text-align: center;
    padding: 2rem 1.5rem;
    display: flex;
    flex-direction: column;
    justify-content: center;
}
.menu-card:hover {
    transform: translateY(-6px);
    box-shadow: 0 12px 22px rgba(0,0,0,0.15);
}
.menu-card i {
    font-size: 2.5rem;
    color: #3b82f6;
    margin-bottom: 1rem;
}
.menu-card h3 {
    font-size: 1.125rem;
    font-weight: 700;
    color: #1e293b;
    margin-bottom: 0.75rem;
}
.menu-card p {
    font-size: 0.9rem;
    color: #64748b;
    margin-bottom: 1.25rem;
}
.menu-card a, .menu-card button {
    background-color: #1e3a8a;
    color: white;
    font-weight: 600;
    border-radius: 0.5rem;
    padding: 0.5rem 1rem;
    transition: all 0.3s;
}
.menu-card a:hover, .menu-card button:hover {
    background-color: #1e40af;
}
.menu-card.opacity-60 button {
    background-color: #9ca3af !important;
    cursor: not-allowed;
}
.hero-header {
    background: linear-gradient(to right, #1e40af, #1e3a8a);
    color: white;
    text-align: center;
    padding: 4rem 1rem 3rem;
    border-bottom-left-radius: 3rem;
    border-bottom-right-radius: 3rem;
    position: relative;
    overflow: hidden;
}
.hero-header::after {
    content: '';
    position: absolute;
    bottom: -40px;
    left: 0;
    right: 0;
    height: 80px;
    background: white;
    border-top-left-radius: 50%;
    border-top-right-radius: 50%;
}
.hero-header h1 {
    font-size: 2.25rem;
    font-weight: 800;
    margin-bottom: 0.5rem;
}
.hero-header p {
    opacity: 0.9;
    font-size: 1.1rem;
}
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<?php
use Illuminate\Support\Facades\Auth;
use App\Models\KolaborasiMember;
use App\Models\AcademicInnovation;
use App\Models\OpdInnovation;

$user = Auth::user();
$isLeader = false;
$isMemberOrPengaju = false;
$isOwner = false;

// ✅ Pastikan hanya dicek jika kolaborasi tersedia dan user login
if ($user && isset($kolaborasi->id)) {
    $membership = KolaborasiMember::where('kolaborasi_id', $kolaborasi->id)
        ->where('user_id', $user->id)
        ->where('status', 'active')
        ->first();

    if ($membership) {
        $role = $membership->role;
        $isLeader = ($role === 'leader');
        $isMemberOrPengaju = in_array($role, ['leader', 'member', 'pengaju']);
    }

    // ✅ Cek apakah user adalah Pemilik Ide Inovasi
    $academicOwner = AcademicInnovation::find($kolaborasi->innovation_id);
    $opdOwner = OpdInnovation::find($kolaborasi->innovation_id);
    $ownerId = $academicOwner?->user_id ?? $opdOwner?->user_id ?? null;

    if ($user->id === $ownerId) {
        $isOwner = true;
        $isMemberOrPengaju = true; // Pemilik ide juga bisa akses progress
    }
}
?>

<div class="w-full">

    <!-- HERO SECTION -->
    <section class="hero-header">
        <div class="relative z-10">
            <h1>Detail Kolaborasi</h1>
            <p>Eksplor setiap aspek kolaborasi — dari ide, tim, hingga progres dan review akhir.</p>
        </div>
    </section>

    <!-- MAIN CONTENT -->
    <div class="container mx-auto px-6 py-16">
        <h2 class="section-title">Menu Kolaborasi</h2>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
            <!-- Detail Ide Kolaborasi -->
            <div class="menu-card">
                <i class="fas fa-lightbulb"></i>
                <h3>Detail Ide Kolaborasi</h3>
                <p>Lihat detail ide utama dari kolaborasi ini, termasuk deskripsi dan tujuan inovasinya.</p>
                <a href="<?php echo e(route('kolaborasi.ide.show', $kolaborasi->id)); ?>">Buka</a>
            </div>

            <!-- Anggota Kolaborasi -->
            <div class="menu-card">
                <i class="fas fa-users"></i>
                <h3>Anggota Kolaborasi</h3>
                <p>Kelola dan lihat siapa saja anggota yang terlibat dalam kolaborasi ini.</p>
                <a href="<?php echo e(route('kolaborasi.members.index', $kolaborasi->id)); ?>">Buka</a>
            </div>

            <!-- Pembagian Tugas Kolaborasi (Hanya Leader) -->
            <?php if($isLeader): ?>
                <div class="menu-card">
                    <i class="fas fa-tasks"></i>
                    <h3>Pembagian Tugas Kolaborasi</h3>
                    <p>Atur dan pantau pembagian tugas antar anggota kolaborasi secara efisien.</p>
                    <a href="<?php echo e(route('kolaborasi.tasks.index', $kolaborasi->id)); ?>">Buka</a>
                </div>
            <?php else: ?>
                <div class="menu-card opacity-60 cursor-not-allowed">
                    <i class="fas fa-tasks"></i>
                    <h3>Pembagian Tugas Kolaborasi</h3>
                    <p>Hanya dapat diakses oleh Leader kolaborasi.</p>
                    <button disabled class="bg-gray-400 text-white font-semibold rounded-md px-4 py-2 cursor-not-allowed">
                        Tidak Tersedia
                    </button>
                </div>
            <?php endif; ?>

            <!-- Progress Kolaborasi (Leader, Pengaju, Member, Pemilik Ide) -->
            <?php if($isMemberOrPengaju): ?>
                <div class="menu-card">
                    <i class="fas fa-chart-line"></i>
                    <h3>Progress Kolaborasi</h3>
                    <p>Pantau perkembangan setiap tahap pelaksanaan tugas untuk ide inovasi secara real-time.</p>
                    <a href="<?php echo e(route('kolaborasi.progress.index', $kolaborasi->id)); ?>">Buka</a>
                </div>
            <?php else: ?>
                <div class="menu-card opacity-60 cursor-not-allowed">
                    <i class="fas fa-chart-line"></i>
                    <h3>Progress Kolaborasi</h3>
                    <p>Hanya dapat diakses oleh anggota aktif kolaborasi.</p>
                    <button disabled class="bg-gray-400 text-white font-semibold rounded-md px-4 py-2 cursor-not-allowed">
                        Tidak Tersedia
                    </button>
                </div>
            <?php endif; ?>

            <!-- Dokumen Lampiran Kolaborasi -->
            <div class="menu-card">
                <i class="fas fa-folder-open"></i>
                <h3>Dokumen Lampiran Kolaborasi</h3>
                <p>Akses seluruh dokumen pendukung seperti laporan, foto kegiatan, atau file PDF yang diunggah oleh pihak terkait.</p>
                <a href="<?php echo e(route('kolaborasi.documents.index', $kolaborasi->id)); ?>">Buka</a>
            </div>

            <!-- Review Kolaborasi -->
            <div class="menu-card">
                <i class="fas fa-comments"></i>
                <h3>Review Kolaborasi</h3>
                <p>Lihat ulasan dan evaluasi dari hasil akhir kolaborasi yang telah dilakukan.</p>
                <a href="<?php echo e(route('kolaborasi.reviews.index', $kolaborasi->id)); ?>">Buka</a>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\xampp\htdocs\dih_website\resources\views/kolaborasi/index-detail.blade.php ENDPATH**/ ?>