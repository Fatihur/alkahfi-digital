<?php $__env->startSection('title', 'Dashboard Wali Santri'); ?>

<?php $__env->startSection('content'); ?>
    <div class="page-header"><div><h1 class="page-title">Selamat Datang, <?php echo e(auth()->user()->name); ?></h1><p class="page-subtitle">Lihat tagihan SPP dan informasi sekolah.</p></div></div>

    <?php if($totalTagihan > 0): ?>
    <div class="alert alert-warning">
        <i class="bi bi-exclamation-triangle"></i>
        <span>Anda memiliki tagihan yang belum dibayar sebesar <strong>Rp <?php echo e(number_format($totalTagihan, 0, ',', '.')); ?></strong></span>
    </div>
    <?php endif; ?>

    <div class="row">
        <div class="col-8">
            <div class="card">
                <div class="card-header"><h3 class="card-title">Tagihan Belum Dibayar</h3><a href="<?php echo e(route('wali.tagihan.index')); ?>" class="btn btn-sm btn-secondary">Lihat Semua</a></div>
                <div class="table-responsive">
                    <table class="table">
                        <thead><tr><th>Santri</th><th>Tagihan</th><th>Total</th><th>Jatuh Tempo</th><th>Aksi</th></tr></thead>
                        <tbody>
                            <?php $__empty_1 = true; $__currentLoopData = $tagihanBelumBayar; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $t): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <tr>
                                    <td><?php echo e($t->santri->nama_lengkap); ?></td>
                                    <td><?php echo e($t->nama_tagihan); ?></td>
                                    <td>Rp <?php echo e(number_format($t->total_bayar, 0, ',', '.')); ?></td>
                                    <td>
                                        <?php echo e($t->tanggal_jatuh_tempo->format('d/m/Y')); ?>

                                        <?php if($t->status == 'jatuh_tempo'): ?>
                                            <span class="badge badge-danger">Jatuh Tempo</span>
                                        <?php endif; ?>
                                    </td>
                                    <td><a href="<?php echo e(route('wali.pembayaran.bayar', $t)); ?>" class="btn btn-sm btn-primary">Bayar</a></td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <tr><td colspan="5" class="text-center text-muted">Tidak ada tagihan</td></tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-4">
            <div class="card">
                <div class="card-header"><h3 class="card-title">Pengumuman Terbaru</h3></div>
                <div class="card-body">
                    <?php $__empty_1 = true; $__currentLoopData = $pengumumanTerbaru; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <div style="margin-bottom: 16px; padding-bottom: 16px; border-bottom: 1px solid var(--border-color);">
                            <h4 style="font-size: 0.9rem; margin-bottom: 4px;"><?php echo e($p->judul); ?></h4>
                            <p class="text-muted" style="font-size: 0.8rem; margin: 0;"><?php echo e($p->created_at->format('d M Y')); ?></p>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <p class="text-muted text-center">Tidak ada pengumuman</p>
                    <?php endif; ?>
                </div>
            </div>
            <div class="card">
                <div class="card-header"><h3 class="card-title">Kegiatan Mendatang</h3></div>
                <div class="card-body">
                    <?php $__empty_1 = true; $__currentLoopData = $kegiatanMendatang; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <div style="margin-bottom: 16px; padding-bottom: 16px; border-bottom: 1px solid var(--border-color);">
                            <h4 style="font-size: 0.9rem; margin-bottom: 4px;"><?php echo e($k->nama_kegiatan); ?></h4>
                            <p class="text-muted" style="font-size: 0.8rem; margin: 0;"><?php echo e($k->tanggal_pelaksanaan->format('d M Y')); ?></p>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <p class="text-muted text-center">Tidak ada kegiatan</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.wali', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\ORDER\MASTARI\E-SPP\alkahfi-digital\resources\views/wali/dashboard.blade.php ENDPATH**/ ?>