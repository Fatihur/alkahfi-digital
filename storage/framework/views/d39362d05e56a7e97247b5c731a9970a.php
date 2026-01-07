<?php $__env->startSection('title', 'Manajemen Pengumuman'); ?>

<?php $__env->startSection('content'); ?>
    <div class="page-header">
        <div>
            <h1 class="page-title">Manajemen Pengumuman</h1>
            <p class="page-subtitle">Kelola pengumuman untuk wali santri.</p>
        </div>
        <a href="<?php echo e(route('admin.pengumuman.create')); ?>" class="btn btn-primary">
            <i class="bi bi-plus"></i> Tambah Pengumuman
        </a>
    </div>

    <div class="card">
        <div class="card-body">
            <table class="table" id="dataTable" style="width:100%">
                <thead>
                    <tr>
                        <th>Judul</th>
                        <th>Prioritas</th>
                        <th>Status</th>
                        <th>Tanggal</th>
                        <th width="100">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $pengumuman; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td><?php echo e($p->judul); ?></td>
                            <td>
                                <span class="badge badge-<?php echo e($p->prioritas == 'tinggi' ? 'danger' : ($p->prioritas == 'normal' ? 'info' : 'secondary')); ?>">
                                    <?php echo e(ucfirst($p->prioritas)); ?>

                                </span>
                            </td>
                            <td>
                                <span class="badge badge-<?php echo e($p->is_published ? 'success' : 'warning'); ?>">
                                    <?php echo e($p->is_published ? 'Published' : 'Draft'); ?>

                                </span>
                            </td>
                            <td data-order="<?php echo e($p->created_at->format('Y-m-d')); ?>">
                                <?php echo e($p->created_at->format('d/m/Y')); ?>

                            </td>
                            <td>
                                <div class="btn-group">
                                    <a href="<?php echo e(route('admin.pengumuman.show', $p)); ?>" class="btn btn-sm btn-info" title="Detail">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <a href="<?php echo e(route('admin.pengumuman.edit', $p)); ?>" class="btn btn-sm btn-secondary" title="Edit">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form action="<?php echo e(route('admin.pengumuman.destroy', $p)); ?>" method="POST" style="display:inline" onsubmit="return confirm('Yakin?')">
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
            order: [[3, 'desc']],
            columnDefs: [
                { orderable: false, targets: -1 }
            ]
        });
    });
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\ORDER\MASTARI\E-SPP\alkahfi-digital\resources\views/admin/pengumuman/index.blade.php ENDPATH**/ ?>