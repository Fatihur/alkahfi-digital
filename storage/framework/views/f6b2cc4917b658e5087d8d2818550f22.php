<?php $__env->startSection('title', 'Manajemen Tagihan'); ?>

<?php $__env->startSection('content'); ?>
    <div class="page-header">
        <div>
            <h1 class="page-title">Manajemen Tagihan</h1>
            <p class="page-subtitle">Kelola tagihan SPP santri.</p>
        </div>
        <div>
            <a href="<?php echo e(route('bendahara.tagihan.create')); ?>" class="btn btn-primary">
                <i class="bi bi-plus"></i> Buat Tagihan
            </a>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <table class="table" id="dataTable" style="width:100%">
                <thead>
                    <tr>
                        <th>Santri</th>
                        <th>Tagihan</th>
                        <th>Total</th>
                        <th>Jatuh Tempo</th>
                        <th>Status</th>
                        <th width="80">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $tagihan; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $t): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td>
                                <strong><?php echo e($t->santri->nama_lengkap); ?></strong>
                                <br><small class="text-muted"><?php echo e($t->santri->nis); ?></small>
                            </td>
                            <td>
                                <?php echo e($t->nama_tagihan); ?>

                                <br><small class="text-muted"><?php echo e($t->periode ?? '-'); ?></small>
                            </td>
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
                                    <?php case ('pending'): ?>
                                        <span class="badge badge-info">Pending</span>
                                        <?php break; ?>
                                    <?php case ('jatuh_tempo'): ?>
                                        <span class="badge badge-danger">Jatuh Tempo</span>
                                        <?php break; ?>
                                <?php endswitch; ?>
                            </td>
                            <td>
                                <div class="btn-group">
                                    <a href="<?php echo e(route('bendahara.tagihan.show', $t)); ?>" class="btn btn-sm btn-info" title="Detail">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <?php if($t->status !== 'lunas'): ?>
                                        <a href="<?php echo e(route('bendahara.tagihan.edit', $t)); ?>" class="btn btn-sm btn-secondary" title="Edit">
                                            <i class="bi bi-pencil"></i>
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
            order: [[3, 'desc']],
            columnDefs: [
                { orderable: false, targets: -1 }
            ]
        });
    });
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.bendahara', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\ORDER\MASTARI\E-SPP\alkahfi-digital\resources\views/bendahara/tagihan/index.blade.php ENDPATH**/ ?>