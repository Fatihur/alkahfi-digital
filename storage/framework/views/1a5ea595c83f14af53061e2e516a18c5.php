<?php $__env->startSection('title', 'Manajemen Santri'); ?>

<?php $__env->startSection('content'); ?>
    <div class="page-header">
        <div>
            <h1 class="page-title">Manajemen Santri</h1>
            <p class="page-subtitle">Kelola data santri.</p>
        </div>
        <div>
            <a href="<?php echo e(route('admin.santri.create')); ?>" class="btn btn-primary">
                <i class="bi bi-plus"></i> Tambah Santri
            </a>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <table class="table" id="dataTable" style="width:100%">
                <thead>
                    <tr>
                        <th>NIS</th>
                        <th>Nama Lengkap</th>
                        <th>Kelas</th>
                        <th>Jurusan</th>
                        <th>Status</th>
                        <th width="120">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $santri; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td><?php echo e($s->nis); ?></td>
                            <td><?php echo e($s->nama_lengkap); ?></td>
                            <td><?php echo e($s->kelas->nama_kelas); ?></td>
                            <td><?php echo e($s->jurusan->nama_jurusan ?? '-'); ?></td>
                            <td>
                                <?php switch($s->status):
                                    case ('aktif'): ?>
                                        <span class="badge badge-success">Aktif</span>
                                        <?php break; ?>
                                    <?php case ('nonaktif'): ?>
                                        <span class="badge badge-warning">Nonaktif</span>
                                        <?php break; ?>
                                    <?php case ('lulus'): ?>
                                        <span class="badge badge-info">Lulus</span>
                                        <?php break; ?>
                                    <?php case ('pindah'): ?>
                                        <span class="badge badge-secondary">Pindah</span>
                                        <?php break; ?>
                                <?php endswitch; ?>
                            </td>
                            <td>
                                <div class="btn-group">
                                    <a href="<?php echo e(route('admin.santri.show', $s)); ?>" class="btn btn-sm btn-info" title="Detail">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <a href="<?php echo e(route('admin.santri.edit', $s)); ?>" class="btn btn-sm btn-secondary" title="Edit">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form action="<?php echo e(route('admin.santri.destroy', $s)); ?>" method="POST" style="display:inline" onsubmit="return confirm('Yakin ingin menghapus santri ini?')">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('DELETE'); ?>
                                        <button type="submit" class="btn btn-sm btn-danger" title="Hapus">
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
            order: [[1, 'asc']],
            columnDefs: [
                { orderable: false, targets: -1 }
            ]
        });
    });
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\ORDER\MASTARI\E-SPP\alkahfi-digital\resources\views/admin/santri/index.blade.php ENDPATH**/ ?>