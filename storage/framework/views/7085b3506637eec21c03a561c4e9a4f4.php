<?php $__env->startSection('title', 'Laporan Transaksi'); ?>

<?php $__env->startSection('content'); ?>
    <div class="page-header">
        <div>
            <h1 class="page-title">Laporan Transaksi</h1>
            <p class="page-subtitle">Total: <strong>Rp <?php echo e(number_format($totalPembayaran, 0, ',', '.')); ?></strong></p>
        </div>
        <div class="btn-group">
            <a href="<?php echo e(route('bendahara.laporan.transaksi', array_merge(request()->query(), ['export' => 'excel']))); ?>" class="btn btn-primary">
                <i class="bi bi-file-earmark-excel"></i> Export Excel
            </a>
            <a href="<?php echo e(route('bendahara.laporan.transaksi', array_merge(request()->query(), ['export' => 'pdf']))); ?>" class="btn btn-danger">
                <i class="bi bi-file-earmark-pdf"></i> Export PDF
            </a>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <form action="" method="GET" class="d-flex gap-2">
                <input type="date" name="tanggal_dari" class="form-control" value="<?php echo e(request('tanggal_dari')); ?>" style="width:150px;">
                <input type="date" name="tanggal_sampai" class="form-control" value="<?php echo e(request('tanggal_sampai')); ?>" style="width:150px;">
                <button type="submit" class="btn btn-secondary">Filter</button>
            </form>
        </div>
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>No. Transaksi</th>
                        <th>Santri</th>
                        <th>Tagihan</th>
                        <th>Jumlah</th>
                        <th>Metode</th>
                        <th>Tanggal</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $pembayaran; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td><?php echo e($i + 1); ?></td>
                            <td><code><?php echo e($p->nomor_transaksi); ?></code></td>
                            <td><?php echo e($p->santri->nama_lengkap); ?></td>
                            <td><?php echo e($p->tagihan->nama_tagihan); ?></td>
                            <td>Rp <?php echo e(number_format($p->jumlah_bayar, 0, ',', '.')); ?></td>
                            <td><?php echo e(ucfirst($p->metode_pembayaran)); ?></td>
                            <td><?php echo e($p->tanggal_bayar?->format('d/m/Y H:i')); ?></td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr><td colspan="7" class="text-center text-muted">Tidak ada data transaksi</td></tr>
                    <?php endif; ?>
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="4" style="text-align:right;"><strong>Total</strong></td>
                        <td colspan="3"><strong>Rp <?php echo e(number_format($totalPembayaran, 0, ',', '.')); ?></strong></td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.bendahara', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\ORDER\MASTARI\E-SPP\alkahfi-digital\resources\views/bendahara/laporan/transaksi.blade.php ENDPATH**/ ?>