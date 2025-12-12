

<?php $__env->startSection('title', 'Kelola Wali Santri'); ?>

<?php $__env->startSection('content'); ?>
    <div class="page-header">
        <div>
            <h1 class="page-title">Kelola Wali Santri</h1>
            <p class="page-subtitle">Kelola data wali santri dan akun login mereka.</p>
        </div>
        <div class="d-flex gap-2">
            
            <a href="<?php echo e(route('admin.wali-santri.create')); ?>" class="btn btn-primary">
                <i class="bi bi-plus"></i> Tambah Wali Santri
            </a>
        </div>
    </div>

    <?php if(session('generated_accounts')): ?>
        <div class="alert alert-success">
            <h5><i class="bi bi-check-circle"></i> Akun Berhasil Dibuat</h5>
            <p>Simpan informasi login berikut (Password menggunakan NIS santri):</p>
            <div class="table-responsive">
                <table class="table table-sm table-bordered bg-white">
                    <thead>
                        <tr>
                            <th>Santri</th>
                            <th>NIS</th>
                            <th>Email</th>
                            <th>Password</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = session('generated_accounts'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $account): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td><?php echo e($account['santri']); ?></td>
                                <td><code><?php echo e($account['nis'] ?? $account['password']); ?></code></td>
                                <td><code><?php echo e($account['email']); ?></code></td>
                                <td><code><?php echo e($account['password']); ?></code></td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>
        </div>
    <?php endif; ?>

    <div class="card">
        <div class="card-body">
            <table class="table" id="dataTable" style="width:100%">
                <thead>
                    <tr>
                        <th>Nama Wali</th>
                        <th>Email</th>
                        <th>No. HP</th>
                        <th>Santri</th>
                        <th>Status</th>
                        <th width="150">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $waliSantri; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $wali): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td><?php echo e($wali->name); ?></td>
                            <td><?php echo e($wali->email); ?></td>
                            <td><?php echo e($wali->no_hp ?? '-'); ?></td>
                            <td>
                                <?php $__empty_1 = true; $__currentLoopData = $wali->waliSantri; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ws): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <span class="badge badge-info"><?php echo e($ws->santri->nama_lengkap ?? 'N/A'); ?></span>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <span class="text-muted">-</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php if($wali->is_active): ?>
                                    <span class="badge badge-success">Aktif</span>
                                <?php else: ?>
                                    <span class="badge badge-danger">Nonaktif</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <div class="btn-group">
                                    <a href="<?php echo e(route('admin.wali-santri.show', $wali)); ?>" class="btn btn-sm btn-info" title="Detail">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <a href="<?php echo e(route('admin.wali-santri.edit', $wali)); ?>" class="btn btn-sm btn-secondary" title="Edit">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form action="<?php echo e(route('admin.wali-santri.reset-password', $wali)); ?>" method="POST" style="display:inline" onsubmit="return confirm('Reset password wali ini?')">
                                        <?php echo csrf_field(); ?>
                                        <button type="submit" class="btn btn-sm btn-warning" title="Reset Password">
                                            <i class="bi bi-key"></i>
                                        </button>
                                    </form>
                                    <form action="<?php echo e(route('admin.wali-santri.destroy', $wali)); ?>" method="POST" style="display:inline" onsubmit="return confirm('Yakin ingin menghapus wali santri ini?')">
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
            order: [[0, 'asc']],
            columnDefs: [
                { orderable: false, targets: -1 }
            ]
        });
    });
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\ORDER\MASTARI\E-SPP\alkahfi-digital\resources\views/admin/wali-santri/index.blade.php ENDPATH**/ ?>