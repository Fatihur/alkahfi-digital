<?php $__env->startSection('title', 'Manajemen Pembayaran'); ?>

<?php $__env->startSection('content'); ?>
    <div class="page-header">
        <div>
            <h1 class="page-title">Riwayat Pembayaran</h1>
            <p class="page-subtitle">Lihat riwayat pembayaran SPP santri.</p>
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
                        <th>Metode</th>
                        <th>Tanggal</th>
                        <th>Status</th>
                        <th width="80">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $pembayaran; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td><code><?php echo e($p->nomor_transaksi); ?></code></td>
                            <td>
                                <?php echo e($p->santri->nama_lengkap); ?>

                                <br><small class="text-muted"><?php echo e($p->santri->nis); ?></small>
                            </td>
                            <td><?php echo e($p->tagihan->nama_tagihan); ?></td>
                            <td>Rp <?php echo e(number_format($p->jumlah_bayar, 0, ',', '.')); ?></td>
                            <td><?php echo e(ucfirst(str_replace('_', ' ', $p->metode_pembayaran))); ?></td>
                            <td data-order="<?php echo e($p->tanggal_bayar?->format('Y-m-d H:i:s') ?? ''); ?>">
                                <?php echo e($p->tanggal_bayar?->format('d/m/Y H:i') ?? '-'); ?>

                            </td>
                            <td>
                                <?php switch($p->status):
                                    case ('berhasil'): ?>
                                        <span class="badge badge-success">Berhasil</span>
                                        <?php break; ?>
                                    <?php case ('pending'): ?>
                                        <span class="badge badge-warning">Pending</span>
                                        <?php break; ?>
                                    <?php case ('gagal'): ?>
                                        <span class="badge badge-danger">Gagal</span>
                                        <?php break; ?>
                                    <?php case ('expired'): ?>
                                        <span class="badge badge-secondary">Expired</span>
                                        <?php break; ?>
                                <?php endswitch; ?>
                            </td>
                            <td>
                                <div class="btn-group">
                                    <a href="<?php echo e(route('admin.pembayaran.show', $p)); ?>" class="btn btn-sm btn-info" title="Detail">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <?php if($p->status == 'berhasil'): ?>
                                        <a href="<?php echo e(route('admin.pembayaran.cetak', $p)); ?>" class="btn btn-sm btn-primary" target="_blank" title="Cetak">
                                            <i class="bi bi-printer"></i>
                                        </a>
                                    <?php endif; ?>
                                </div>
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
            order: [[5, 'desc']],
            columnDefs: [
                { orderable: false, targets: -1 }
            ]
        });
    });
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\ORDER\MASTARI\E-SPP\alkahfi-digital\resources\views/admin/pembayaran/index.blade.php ENDPATH**/ ?>