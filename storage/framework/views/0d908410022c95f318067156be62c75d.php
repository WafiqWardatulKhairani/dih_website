<?php $__env->startSection('title', 'Tugas Kolaborasi'); ?>

<?php $__env->startPush('styles'); ?>
<script src="https://cdn.tailwindcss.com"></script>
<script>
tailwind.config = {
    theme: {
        extend: {
            colors: {
                primary: '#1e3a8a',
                secondary: '#3b82f6',
                accent: '#60a5fa',
                success: '#16a34a',
                warning: '#f59e0b',
                danger: '#dc2626',
                graylight: '#f3f4f6',
            },
        },
    },
};
</script>
<style>
.page-border {
    border: 1px solid #e5e7eb;
    border-radius: 1rem;
    box-shadow: 0 6px 16px rgba(0,0,0,0.06);
    background-color: white;
    overflow: hidden;
}
.status-badge {
    padding: 0.25rem 0.5rem;
    border-radius: 0.375rem;
    font-size: 0.75rem;
    font-weight: 600;
    text-transform: uppercase;
}
.todo { background-color: #fef3c7; color: #b45309; }
.in-progress { background-color: #bfdbfe; color: #1d4ed8; }
.done { background-color: #d1fae5; color: #065f46; }

/* Revisi kolom agar No, Judul, dan Deskripsi lebih kecil */
.table-no { width: 4%; }
.table-title { width: 20%; }
.table-desc { width: 26%; }
.table-assignee { width: 15%; }
.table-deadline { width: 15%; }
.table-status { width: 15%; }
.table-action { width: 5%; }

.progress-bar {
    height: 1rem;
    border-radius: 0.5rem;
    background-color: #e5e7eb;
    overflow: hidden;
    margin-bottom: 1rem;
}
.progress-bar-inner {
    height: 100%;
    background-color: #1e3a8a;
    text-align: center;
    color: white;
    font-size: 0.75rem;
    line-height: 1rem;
    font-weight: 600;
}
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<div class="max-w-7xl mx-auto px-4 py-8">

    
    <div class="w-full relative h-80 border-b border-gray-200 mb-8 rounded-xl overflow-hidden">
        <?php if($kolaborasi->image_path): ?>
            <img src="<?php echo e(asset('storage/' . $kolaborasi->image_path)); ?>" 
                 alt="<?php echo e($kolaborasi->title ?? 'Kolaborasi'); ?>" 
                 class="w-full h-full object-cover">
        <?php else: ?>
            <div class="w-full h-full bg-gradient-to-r from-[rgba(30,64,175,0.85)] to-[rgba(30,58,138,0.9)] flex items-center justify-center">
                <i class="fas fa-lightbulb fa-3x text-blue-100 opacity-70"></i>
            </div>
        <?php endif; ?>
        <div class="absolute inset-0 bg-gradient-to-t from-[rgba(30,64,175,0.85)] to-[rgba(30,58,138,0.9)] mix-blend-multiply"></div>
    </div>

    
    <div class="page-border p-6 space-y-8">

        <!-- Header -->
        <div class="flex justify-between items-center mb-4">
            <div>
                <h1 class="text-3xl font-bold text-primary">Daftar Tugas Kolaborasi</h1>
                <p class="text-gray-600">
                    Kolaborasi: 
                    <span class="font-semibold text-secondary">
                        <?php echo e($kolaborasi->title ?? 'Tanpa Judul'); ?>

                    </span>
                </p>

                
                <?php
                    $totalTasks = $tasks->count();
                    $doneTasks = $tasks->where('status', 'done')->count();
                    $progressPercent = $totalTasks > 0 ? round(($doneTasks / $totalTasks) * 100) : 0;
                ?>
                <div class="mt-4">
                    <p class="text-sm text-gray-700 mb-1">Total Progress: <?php echo e($progressPercent); ?>% (<?php echo e($doneTasks); ?> dari <?php echo e($totalTasks); ?> tugas selesai)</p>
                    <div class="progress-bar">
                        <div class="progress-bar-inner" style="width: <?php echo e($progressPercent); ?>%">
                            <?php echo e($progressPercent); ?>%
                        </div>
                    </div>
                </div>
            </div>
            <button onclick="toggleTaskForm()" class="bg-primary text-white px-4 py-2 rounded-xl shadow hover:bg-secondary transition">
                + Tambah Tugas
            </button>
        </div>

        <?php echo $__env->make('components.alert-kolaborasi', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

        <!-- Form Tambah Tugas -->
        <div id="taskForm" class="hidden bg-graylight p-6 rounded-xl border border-gray-200">
            <form action="<?php echo e(route('kolaborasi.tasks.store', $kolaborasi->id)); ?>" method="POST" class="space-y-4">
                <?php echo csrf_field(); ?>
                <div>
                    <label class="block text-sm font-semibold mb-1">Judul Tugas</label>
                    <input type="text" name="title" class="w-full border-gray-300 rounded-lg p-2" placeholder="Judul tugas..." required>
                </div>
                <div>
                    <label class="block text-sm font-semibold mb-1">Deskripsi</label>
                    <textarea name="description" class="w-full border-gray-300 rounded-lg p-2" rows="3" placeholder="Deskripsi tugas..."></textarea>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-sm font-semibold mb-1">Assign ke</label>
                        <select name="assigned_to" class="w-full border-gray-300 rounded-lg p-2">
                            <option value="">Pilih anggota...</option>
                            <?php $__currentLoopData = $members; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $member): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($member->user_id); ?>"><?php echo e(optional($member->user)->name ?? 'Tanpa Nama'); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php if($leader): ?>
                                <option value="<?php echo e($leader->user_id); ?>"><?php echo e(optional($leader->user)->name ?? 'Leader'); ?></option>
                            <?php endif; ?>
                            <?php if($pemilikIde): ?>
                                <option value="<?php echo e($pemilikIde->id); ?>"><?php echo e($pemilikIde->name ?? 'Pemilik Ide'); ?></option>
                            <?php endif; ?>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold mb-1">Deadline</label>
                        <input type="date" name="deadline" class="w-full border-gray-300 rounded-lg p-2">
                    </div>
                    <div class="flex items-end">
                        <button class="bg-success text-white px-4 py-2 rounded-lg shadow hover:bg-green-600 w-full">Simpan Tugas</button>
                    </div>
                </div>
            </form>
        </div>

        <!-- Daftar Tugas -->
        <div class="overflow-x-auto">
            <div class="flex flex-wrap items-center gap-3 mb-8">
                
                <a href="<?php echo e(route('kolaborasi.detail', $kolaborasi->id)); ?>" 
                   class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                    <i class="fas fa-home"></i> Halaman Utama Kolaborasi
                </a>
            </div>
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-blue-50 text-gray-800">
                    <tr>
                        <th class="px-3 py-3 text-left text-sm font-semibold table-no">No</th>
                        <th class="px-3 py-3 text-left text-sm font-semibold table-title">Judul</th>
                        <th class="px-3 py-3 text-left text-sm font-semibold table-desc">Deskripsi</th>
                        <th class="px-3 py-3 text-left text-sm font-semibold table-assignee">Assignee</th>
                        <th class="px-3 py-3 text-left text-sm font-semibold table-deadline">Deadline</th>
                        <th class="px-3 py-3 text-left text-sm font-semibold table-status">Status</th>
                        <th class="px-3 py-3 text-center text-sm font-semibold table-action">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 bg-graylight/40">
                    <?php $__empty_1 = true; $__currentLoopData = $tasks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $task): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr class="hover:bg-graylight transition">
                            <td class="px-3 py-4"><?php echo e($loop->iteration); ?></td>
                            <td class="px-3 py-4 font-semibold text-gray-800"><?php echo e($task->title); ?></td>
                            <td class="px-3 py-4 text-gray-700"><?php echo e($task->description); ?></td>
                            <td class="px-3 py-4"><?php echo e(optional($task->assignee)->name ?? '-'); ?></td>
                            <td class="px-3 py-4 text-gray-600">
                                <?php echo e($task->deadline ? \Carbon\Carbon::parse($task->deadline)->format('d M Y') : '-'); ?>

                            </td>
                            <td class="px-3 py-4">
                                <?php
                                    $status = $task->status ?? 'todo';
                                    $badgeColor = match($status) {
                                        'done' => 'bg-success',
                                        'in_progress' => 'bg-warning',
                                        default => 'bg-gray-400'
                                    };
                                ?>
                                <span class="text-white px-3 py-1 rounded-full text-xs font-semibold <?php echo e($badgeColor); ?>">
                                    <?php echo e(ucfirst($status)); ?>

                                </span>
                            </td>
                            <td class="px-3 py-4 text-center">
                                <form action="<?php echo e(route('kolaborasi.tasks.destroy', $task->id)); ?>" method="POST" onsubmit="return confirm('Yakin ingin menghapus tugas ini?')">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('DELETE'); ?>
                                    <button class="bg-danger text-white px-3 py-1 rounded-lg text-xs hover:bg-red-700 transition">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="7" class="text-center py-6 text-gray-500">Belum ada tugas yang dibuat.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

    </div> 

</div>

<!-- JS: Toggle form -->
<script>
function toggleTaskForm() {
    const form = document.getElementById('taskForm');
    form.classList.toggle('hidden');
}
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\xampp\htdocs\dih_website\resources\views/kolaborasi/tasks/index.blade.php ENDPATH**/ ?>