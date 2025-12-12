<?php $__env->startSection('title', 'Detail Pembayaran'); ?>

<?php $__env->startSection('content'); ?>
    <div class="page-header">
        <div><h1 class="page-title">Detail Pembayaran</h1></div>
        <div class="d-flex gap-2">
            <?php if($pembayaran->status === 'berhasil'): ?>
                <a href="<?php echo e(route('bendahara.pembayaran.cetak', $pembayaran)); ?>" class="btn btn-secondary" target="_blank"><i class="bi bi-printer"></i> Cetak</a>
            <?php endif; ?>
            <a href="<?php echo e(route('bendahara.pembayaran.index')); ?>" class="btn btn-secondary">Kembali</a>
        </div>
    </div>

    <div class="row">
        <div class="col-6">
            <div class="card">
                <div class="card-header"><h3 class="card-title">Informasi Pembayaran</h3></div>
                <div class="card-body">
                    <table class="table">
                        <tr><td><strong>No. Transaksi</strong></td><td><code><?php echo e($pembayaran->nomor_transaksi); ?></code></td></tr>
                        <tr><td><strong>Tagihan</strong></td><td><?php echo e($pembayaran->tagihan->nama_tagihan); ?></td></tr>
                        <tr><td><strong>Jumlah Bayar</strong></td><td><strong>Rp <?php echo e(number_format($pembayaran->jumlah_bayar, 0, ',', '.')); ?></strong></td></tr>
                        <tr><td><strong>Metode</strong></td><td><?php echo e(ucfirst($pembayaran->metode_pembayaran)); ?></td></tr>
                        <tr><td><strong>Tanggal Bayar</strong></td><td><?php echo e($pembayaran->tanggal_bayar?->format('d/m/Y H:i') ?? '-'); ?></td></tr>
                        <tr><td><strong>Status</strong></td><td>
                            <?php switch($pembayaran->status):
                                case ('berhasil'): ?> <span class="badge badge-success">Berhasil</span> <?php break; ?>
                                <?php case ('pending'): ?> <span class="badge badge-warning">Pending</span> <?php break; ?>
                                <?php case ('gagal'): ?> <span class="badge badge-danger">Gagal</span> <?php break; ?>
                            <?php endswitch; ?>
                        </td></tr>
                        <?php if($pembayaran->verifiedBy): ?>
                            <tr><td><strong>Diverifikasi oleh</strong></td><td><?php echo e($pembayaran->verifiedBy->name); ?></td></tr>
                        <?php endif; ?>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-6">
            <div class="card">
                <div class="card-header"><h3 class="card-title">Informasi Santri</h3></div>
                <div class="card-body">
                    <table class="table">
                        <tr><td><strong>NIS</strong></td><td><?php echo e($pembayaran->santri->nis); ?></td></tr>
                        <tr><td><strong>Nama</strong></td><td><?php echo e($pembayaran->santri->nama_lengkap); ?></td></tr>
                        <tr><td><strong>Kelas</strong></td><td><?php echo e($pembayaran->santri->kelas->nama_kelas ?? '-'); ?></td></tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.bendahara', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\ORDER\MASTARI\E-SPP\alkahfi-digital\resources\views/bendahara/pembayaran/show.blade.php ENDPATH**/ ?>