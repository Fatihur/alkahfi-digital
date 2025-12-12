<?php $__env->startSection('title', 'Dashboard Bendahara'); ?>

<?php $__env->startSection('content'); ?>
    <div class="page-header"><div><h1 class="page-title">Dashboard Bendahara</h1><p class="page-subtitle">Ringkasan data keuangan SPP.</p></div></div>

    <div class="row">
        <div class="col-3">
            <div class="card stat-card">
                <div class="stat-header"><div class="stat-icon warning"><i class="bi bi-receipt"></i></div></div>
                <div class="stat-value">Rp <?php echo e(number_format($totalTagihanBelumBayar, 0, ',', '.')); ?></div>
                <div class="stat-label">Tagihan Belum Dibayar</div>
            </div>
        </div>
        <div class="col-3">
            <div class="card stat-card">
                <div class="stat-header"><div class="stat-icon success"><i class="bi bi-cash"></i></div></div>
                <div class="stat-value">Rp <?php echo e(number_format($totalPembayaranHariIni, 0, ',', '.')); ?></div>
                <div class="stat-label">Pembayaran Hari Ini</div>
            </div>
        </div>
        <div class="col-3">
            <div class="card stat-card">
                <div class="stat-header"><div class="stat-icon primary"><i class="bi bi-calendar-check"></i></div></div>
                <div class="stat-value">Rp <?php echo e(number_format($totalPembayaranBulanIni, 0, ',', '.')); ?></div>
                <div class="stat-label">Pembayaran Bulan Ini</div>
            </div>
        </div>
        <div class="col-3">
            <div class="card stat-card">
                <div class="stat-header"><div class="stat-icon" style="background: rgba(239,68,68,0.1); color: #ef4444;"><i class="bi bi-exclamation-triangle"></i></div></div>
                <div class="stat-value"><?php echo e($tagihanJatuhTempo); ?></div>
                <div class="stat-label">Tagihan Jatuh Tempo</div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header"><h3 class="card-title">Pembayaran Terbaru</h3><a href="<?php echo e(route('bendahara.pembayaran.index')); ?>" class="btn btn-sm btn-secondary">Lihat Semua</a></div>
        <div class="table-responsive">
            <table class="table">
                <thead><tr><th>No. Transaksi</th><th>Santri</th><th>Tagihan</th><th>Jumlah</th><th>Tanggal</th></tr></thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $pembayaranTerbaru; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td><code><?php echo e($p->nomor_transaksi); ?></code></td>
                            <td><?php echo e($p->santri->nama_lengkap); ?></td>
                            <td><?php echo e($p->tagihan->nama_tagihan); ?></td>
                            <td>Rp <?php echo e(number_format($p->jumlah_bayar, 0, ',', '.')); ?></td>
                            <td><?php echo e($p->tanggal_bayar->format('d/m/Y H:i')); ?></td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr><td colspan="5" class="text-center text-muted">Belum ada pembayaran</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.bendahara', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\ORDER\MASTARI\E-SPP\alkahfi-digital\resources\views/bendahara/dashboard.blade.php ENDPATH**/ ?>