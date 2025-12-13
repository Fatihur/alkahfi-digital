<?php $__env->startSection('sidebar-menu'); ?>
    <div class="menu-label">Menu Utama</div>
    <div class="nav-item">
        <a href="<?php echo e(route('admin.dashboard')); ?>" class="nav-link <?php echo e(request()->routeIs('admin.dashboard') ? 'active' : ''); ?>">
            <i class="bi bi-house-door"></i>
            <span>Dashboard</span>
        </a>
    </div>

    <div class="menu-label">Manajemen Data</div>
    <div class="nav-item">
        <a href="<?php echo e(route('admin.users.index')); ?>" class="nav-link <?php echo e(request()->routeIs('admin.users.*') ? 'active' : ''); ?>">
            <i class="bi bi-people"></i>
            <span>Pengguna</span>
        </a>
    </div>
    <div class="nav-item">
        <a href="<?php echo e(route('admin.santri.index')); ?>" class="nav-link <?php echo e(request()->routeIs('admin.santri.*') ? 'active' : ''); ?>">
            <i class="bi bi-person-badge"></i>
            <span>Santri</span>
        </a>
    </div>
    <div class="nav-item">
        <a href="<?php echo e(route('admin.wali-santri.index')); ?>" class="nav-link <?php echo e(request()->routeIs('admin.wali-santri.*') ? 'active' : ''); ?>">
            <i class="bi bi-people-fill"></i>
            <span>Wali Santri</span>
        </a>
    </div>
    <div class="nav-item">
        <a href="<?php echo e(route('admin.kelas.index')); ?>" class="nav-link <?php echo e(request()->routeIs('admin.kelas.*') ? 'active' : ''); ?>">
            <i class="bi bi-building"></i>
            <span>Kelas</span>
        </a>
    </div>
    <div class="nav-item">
        <a href="<?php echo e(route('admin.jurusan.index')); ?>" class="nav-link <?php echo e(request()->routeIs('admin.jurusan.*') ? 'active' : ''); ?>">
            <i class="bi bi-mortarboard"></i>
            <span>Jurusan</span>
        </a>
    </div>

    <div class="menu-label">Keuangan</div>
    <div class="nav-item">
        <a href="<?php echo e(route('admin.pembayaran.index')); ?>" class="nav-link <?php echo e(request()->routeIs('admin.pembayaran.*') ? 'active' : ''); ?>">
            <i class="bi bi-credit-card"></i>
            <span>Pembayaran</span>
        </a>
    </div>
    <div class="nav-item">
        <a href="<?php echo e(route('admin.laporan.index')); ?>" class="nav-link <?php echo e(request()->routeIs('admin.laporan.*') ? 'active' : ''); ?>">
            <i class="bi bi-file-earmark-bar-graph"></i>
            <span>Laporan</span>
        </a>
    </div>

    <div class="menu-label">Informasi</div>
    <div class="nav-item">
        <a href="<?php echo e(route('admin.pengumuman.index')); ?>" class="nav-link <?php echo e(request()->routeIs('admin.pengumuman.*') ? 'active' : ''); ?>">
            <i class="bi bi-megaphone"></i>
            <span>Pengumuman</span>
        </a>
    </div>

    <div class="nav-item">
        <a href="<?php echo e(route('admin.kegiatan.index')); ?>" class="nav-link <?php echo e(request()->routeIs('admin.kegiatan.*') ? 'active' : ''); ?>">
            <i class="bi bi-calendar-check"></i>
            <span>Kegiatan</span>
        </a>
    </div>

    <div class="menu-label">Landing Page</div>
    <div class="nav-item">
        <a href="<?php echo e(route('admin.landing.profil.index')); ?>" class="nav-link <?php echo e(request()->routeIs('admin.landing.profil.*') ? 'active' : ''); ?>">
            <i class="bi bi-building"></i>
            <span>Profil Sekolah</span>
        </a>
    </div>
    <div class="nav-item">
        <a href="<?php echo e(route('admin.landing.berita.index')); ?>" class="nav-link <?php echo e(request()->routeIs('admin.landing.berita.*') ? 'active' : ''); ?>">
            <i class="bi bi-newspaper"></i>
            <span>Berita</span>
        </a>
    </div>
    <div class="nav-item">
        <a href="<?php echo e(route('admin.landing.galeri.index')); ?>" class="nav-link <?php echo e(request()->routeIs('admin.landing.galeri.*') ? 'active' : ''); ?>">
            <i class="bi bi-images"></i>
            <span>Galeri</span>
        </a>
    </div>
    <div class="nav-item">
        <a href="<?php echo e(route('admin.landing.slider.index')); ?>" class="nav-link <?php echo e(request()->routeIs('admin.landing.slider.*') ? 'active' : ''); ?>">
            <i class="bi bi-collection-play"></i>
            <span>Slider</span>
        </a>
    </div>

    <div class="menu-label">Sistem</div>
    <div class="nav-item">
        <a href="<?php echo e(route('admin.log-aktivitas.index')); ?>" class="nav-link <?php echo e(request()->routeIs('admin.log-aktivitas.*') ? 'active' : ''); ?>">
            <i class="bi bi-clock-history"></i>
            <span>Log Aktivitas</span>
        </a>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\ORDER\MASTARI\E-SPP\alkahfi-digital\resources\views/layouts/admin.blade.php ENDPATH**/ ?>