<?php $__env->startSection('sidebar-menu'); ?>
    <div class="menu-label">Menu Utama</div>
    <div class="nav-item">
        <a href="<?php echo e(route('bendahara.dashboard')); ?>" class="nav-link <?php echo e(request()->routeIs('bendahara.dashboard') ? 'active' : ''); ?>">
            <i class="bi bi-house-door"></i>
            <span>Dashboard</span>
        </a>
    </div>

    <div class="menu-label">Keuangan</div>
    <div class="nav-item">
        <a href="<?php echo e(route('bendahara.tagihan.index')); ?>" class="nav-link <?php echo e(request()->routeIs('bendahara.tagihan.*') ? 'active' : ''); ?>">
            <i class="bi bi-receipt"></i>
            <span>Tagihan</span>
        </a>
    </div>
    <div class="nav-item">
        <a href="<?php echo e(route('bendahara.pembayaran.index')); ?>" class="nav-link <?php echo e(request()->routeIs('bendahara.pembayaran.*') ? 'active' : ''); ?>">
            <i class="bi bi-credit-card"></i>
            <span>Pembayaran</span>
        </a>
    </div>
    <div class="nav-item">
        <a href="<?php echo e(route('bendahara.laporan.index')); ?>" class="nav-link <?php echo e(request()->routeIs('bendahara.laporan.*') ? 'active' : ''); ?>">
            <i class="bi bi-file-earmark-bar-graph"></i>
            <span>Laporan</span>
        </a>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\ORDER\MASTARI\E-SPP\alkahfi-digital\resources\views/layouts/bendahara.blade.php ENDPATH**/ ?>