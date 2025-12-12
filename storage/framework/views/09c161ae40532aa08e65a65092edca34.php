<?php $__env->startSection('title', 'Manajemen Kegiatan'); ?>

<?php $__env->startSection('content'); ?>
    <div class="page-header">
        <div>
            <h1 class="page-title">Manajemen Kegiatan</h1>
            <p class="page-subtitle">Kelola kegiatan sekolah.</p>
        </div>
        <a href="<?php echo e(route('admin.kegiatan.create')); ?>" class="btn btn-primary">
            <i class="bi bi-plus"></i> Tambah Kegiatan
        </a>
    </div>

    <div class="card">
        <div class="card-body">
            <table class="table" id="dataTable" style="width:100%">
                <thead>
                    <tr>
                        <th>Nama Kegiatan</th>
                        <th>Tanggal</th>
                        <th>Lokasi</th>
                        <th>Status</th>
                        <th>Published</th>
                        <th width="100">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $kegiatan; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td><?php echo e($k->nama_kegiatan); ?></td>
                            <td data-order="<?php echo e($k->tanggal_pelaksanaan->format('Y-m-d')); ?>">
                                <?php echo e($k->tanggal_pelaksanaan->format('d/m/Y')); ?>

                            </td>
                            <td><?php echo e($k->lokasi ?? '-'); ?></td>
                            <td>
                                <span class="badge badge-info"><?php echo e(ucfirst(str_replace('_', ' ', $k->status))); ?></span>
                            </td>
                            <td>
                                <span class="badge badge-<?php echo e($k->is_published ? 'success' : 'warning'); ?>">
                                    <?php echo e($k->is_published ? 'Ya' : 'Tidak'); ?>

                                </span>
                            </td>
                            <td>
                                <div class="btn-group">
                                    <a href="<?php echo e(route('admin.kegiatan.edit', $k)); ?>" class="btn btn-sm btn-secondary" title="Edit">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form action="<?php echo e(route('admin.kegiatan.destroy', $k)); ?>" method="POST" style="display:inline" onsubmit="return confirm('Yakin?')">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('DELETE'); ?>
                                        <button class="btn btn-sm btn-danger" title="Hapus">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
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
            order: [[1, 'desc']],
            columnDefs: [
                { orderable: false, targets: -1 }
            ]
        });
    });
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\ORDER\MASTARI\E-SPP\alkahfi-digital\resources\views/admin/kegiatan/index.blade.php ENDPATH**/ ?>