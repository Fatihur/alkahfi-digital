<?php $__env->startSection('title', 'Tagihan SPP'); ?>

<?php $__env->startSection('content'); ?>
    <div class="page-header">
        <div>
            <h1 class="page-title">Tagihan SPP</h1>
            <p class="page-subtitle">Daftar tagihan SPP anak Anda.</p>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <table class="table" id="dataTable" style="width:100%">
                <thead>
                    <tr>
                        <th>Santri</th>
                        <th>Tagihan</th>
                        <th>Periode</th>
                        <th>Total</th>
                        <th>Jatuh Tempo</th>
                        <th>Status</th>
                        <th width="80">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $tagihan; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $t): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td><?php echo e($t->santri->nama_lengkap); ?></td>
                            <td><?php echo e($t->nama_tagihan); ?></td>
                            <td><?php echo e($t->periode ?? '-'); ?></td>
                            <td>Rp <?php echo e(number_format($t->total_bayar, 0, ',', '.')); ?></td>
                            <td data-order="<?php echo e($t->tanggal_jatuh_tempo->format('Y-m-d')); ?>">
                                <?php echo e($t->tanggal_jatuh_tempo->format('d/m/Y')); ?>

                            </td>
                            <td>
                                <?php switch($t->status):
                                    case ('lunas'): ?>
                                        <span class="badge badge-success">Lunas</span>
                                        <?php break; ?>
                                    <?php case ('belum_bayar'): ?>
                                        <span class="badge badge-warning">Belum Bayar</span>
                                        <?php break; ?>
                                    <?php case ('jatuh_tempo'): ?>
                                        <span class="badge badge-danger">Jatuh Tempo</span>
                                        <?php break; ?>
                                <?php endswitch; ?>
                            </td>
                            <td>
                                <?php if($t->status != 'lunas'): ?>
                                    <a href="<?php echo e(route('wali.pembayaran.bayar', $t)); ?>" class="btn btn-sm btn-primary">
                                        <i class="bi bi-credit-card"></i> Bayar
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
            order: [[4, 'asc']],
            columnDefs: [
                { orderable: false, targets: -1 }
            ]
        });
    });
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.wali', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\ORDER\MASTARI\E-SPP\alkahfi-digital\resources\views/wali/tagihan/index.blade.php ENDPATH**/ ?>