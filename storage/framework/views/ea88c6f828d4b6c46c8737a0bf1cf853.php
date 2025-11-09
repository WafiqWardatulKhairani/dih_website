<?php if(session('success')): ?>
    <div class="alert alert-success"><?php echo e(session('success')); ?></div>
<?php endif; ?>

<?php if(session('error')): ?>
    <div class="alert alert-danger"><?php echo e(session('error')); ?></div>
<?php endif; ?>

<?php if(session('info')): ?>
    <div class="alert alert-info"><?php echo e(session('info')); ?></div>
<?php endif; ?>
<?php /**PATH D:\xampp\htdocs\dih_website\resources\views/components/alert-kolaborasi.blade.php ENDPATH**/ ?>