<?php $__env->startSection('title', 'Riwayat Pembayaran'); ?>

<?php $__env->startSection('content'); ?>
    <div class="page-header">
        <div>
            <h1 class="page-title">Riwayat Pembayaran</h1>
            <p class="page-subtitle">Daftar pembayaran yang telah dilakukan.</p>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <table class="table" id="dataTable" style="width:100%">
                <thead>
                    <tr>
                        <th>No. Transaksi</th>
                        <th>Santri</th>
                        <th>Tagihan</th>
                        <th>Jumlah</th>
                        <th>Tanggal</th>
                        <th>Status</th>
                        <th width="60">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $pembayaran; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td><code><?php echo e($p->nomor_transaksi); ?></code></td>
                            <td><?php echo e($p->santri->nama_lengkap); ?></td>
                            <td><?php echo e($p->tagihan->nama_tagihan); ?></td>
                            <td>Rp <?php echo e(number_format($p->jumlah_bayar, 0, ',', '.')); ?></td>
                            <td data-order="<?php echo e($p->tanggal_bayar?->format('Y-m-d H:i:s') ?? ''); ?>">
                                <?php echo e($p->tanggal_bayar?->format('d/m/Y H:i') ?? '-'); ?>

                            </td>
                            <td>
                                <span class="badge badge-<?php echo e($p->status == 'berhasil' ? 'success' : 'warning'); ?>">
                                    <?php echo e(ucfirst($p->status)); ?>

                                </span>
                            </td>
                            <td>
                                <?php if($p->status == 'berhasil'): ?>
                                    <a href="<?php echo e(route('wali.pembayaran.cetak', $p)); ?>" class="btn btn-sm btn-primary" target="_blank" title="Cetak Bukti">
                                        <i class="bi bi-printer"></i>
                                    </a>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
    $(document).ready(function() {
        $('#dataTable').DataTable({
            order: [[4, 'desc']],
            columnDefs: [
                { orderable: false, targets: -1 }
            ]
        });
    });
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.wali', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\ORDER\MASTARI\E-SPP\alkahfi-digital\resources\views/wali/pembayaran/index.blade.php ENDPATH**/ ?>