<?php $__env->startSection('sidebar-menu'); ?>
    <div class="menu-label">Menu Utama</div>
    <div class="nav-item">
        <a href="<?php echo e(route('wali.dashboard')); ?>" class="nav-link <?php echo e(request()->routeIs('wali.dashboard') ? 'active' : ''); ?>">
            <i class="bi bi-house-door"></i>
            <span>Dashboard</span>
        </a>
    </div>

    <div class="menu-label">Pembayaran SPP</div>
    <div class="nav-item">
        <a href="<?php echo e(route('wali.tagihan.index')); ?>" class="nav-link <?php echo e(request()->routeIs('wali.tagihan.*') ? 'active' : ''); ?>">
            <i class="bi bi-receipt"></i>
            <span>Tagihan</span>
        </a>
    </div>
    <div class="nav-item">
        <a href="<?php echo e(route('wali.pembayaran.index')); ?>" class="nav-link <?php echo e(request()->routeIs('wali.pembayaran.*') ? 'active' : ''); ?>">
            <i class="bi bi-credit-card"></i>
            <span>Riwayat Pembayaran</span>
        </a>
    </div>

    <div class="menu-label">Informasi Sekolah</div>
    <div class="nav-item">
        <a href="<?php echo e(route('wali.pengumuman.index')); ?>" class="nav-link <?php echo e(request()->routeIs('wali.pengumuman.*') ? 'active' : ''); ?>">
            <i class="bi bi-megaphone"></i>
            <span>Pengumuman</span>
        </a>
    </div>

    <div class="nav-item">
        <a href="<?php echo e(route('wali.kegiatan.index')); ?>" class="nav-link <?php echo e(request()->routeIs('wali.kegiatan.*') ? 'active' : ''); ?>">
            <i class="bi bi-calendar-check"></i>
            <span>Kegiatan</span>
        </a>
    </div>

    <div class="menu-label">Lainnya</div>
    <div class="nav-item">
        <a href="<?php echo e(route('wali.notifikasi.index')); ?>" class="nav-link <?php echo e(request()->routeIs('wali.notifikasi.*') ? 'active' : ''); ?>">
            <i class="bi bi-bell"></i>
            <span>Notifikasi</span>
            <?php
                $unreadCount = \App\Models\Notifikasi::where('user_id', auth()->id())->where('is_read', false)->count();
            ?>
            <?php if($unreadCount > 0): ?>
                <span class="badge badge-danger ms-auto"><?php echo e($unreadCount); ?></span>
            <?php endif; ?>
        </a>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\ORDER\MASTARI\E-SPP\alkahfi-digital\resources\views/layouts/wali.blade.php ENDPATH**/ ?>