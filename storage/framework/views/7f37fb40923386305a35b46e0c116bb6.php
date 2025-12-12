

<?php $__env->startSection('title', 'Detail Wali Santri'); ?>

<?php $__env->startSection('content'); ?>
    <div class="page-header">
        <div>
            <h1 class="page-title">Detail Wali Santri</h1>
            <p class="page-subtitle">Informasi lengkap wali santri.</p>
        </div>
        <div class="d-flex gap-2">
            <a href="<?php echo e(route('admin.wali-santri.edit', $wali_santri)); ?>" class="btn btn-secondary">
                <i class="bi bi-pencil"></i> Edit
            </a>
            <a href="<?php echo e(route('admin.wali-santri.index')); ?>" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left"></i> Kembali
            </a>
        </div>
    </div>

    <?php if(session('generated_password')): ?>
        <div class="alert alert-warning">
            <i class="bi bi-key"></i> <strong>Password Akun:</strong> Simpan password ini, tidak akan ditampilkan lagi: <code><?php echo e(session('generated_password')); ?></code>
        </div>
    <?php endif; ?>

    <?php if(session('new_password')): ?>
        <div class="alert alert-warning">
            <i class="bi bi-key"></i> <strong>Password Baru:</strong> Password berhasil direset: <code><?php echo e(session('new_password')); ?></code>
        </div>
    <?php endif; ?>

    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Informasi Akun</h5>
                </div>
                <div class="card-body">
                    <table class="table table-borderless mb-0">
                        <tr>
                            <td class="text-muted" width="40%">Nama</td>
                            <td><?php echo e($wali_santri->name); ?></td>
                        </tr>
                        <tr>
                            <td class="text-muted">Email</td>
                            <td><?php echo e($wali_santri->email); ?></td>
                        </tr>
                        <tr>
                            <td class="text-muted">No. HP</td>
                            <td><?php echo e($wali_santri->no_hp ?? '-'); ?></td>
                        </tr>
                        <tr>
                            <td class="text-muted">Status</td>
                            <td>
                                <?php if($wali_santri->is_active): ?>
                                    <span class="badge badge-success">Aktif</span>
                                <?php else: ?>
                                    <span class="badge badge-danger">Nonaktif</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-muted">Terdaftar</td>
                            <td><?php echo e($wali_santri->created_at->format('d M Y H:i')); ?></td>
                        </tr>
                    </table>
                </div>
                <div class="card-footer">
                    <form action="<?php echo e(route('admin.wali-santri.reset-password', $wali_santri)); ?>" method="POST" onsubmit="return confirm('Reset password wali ini?')">
                        <?php echo csrf_field(); ?>
                        <button type="submit" class="btn btn-warning btn-sm w-100">
                            <i class="bi bi-key"></i> Reset Password
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Daftar Santri</h5>
                </div>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>NIS</th>
                                <th>Nama Santri</th>
                                <th>Kelas</th>
                                <th>Hubungan</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__empty_1 = true; $__currentLoopData = $wali_santri->waliSantri; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ws): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <tr>
                                    <td><?php echo e($ws->santri->nis ?? '-'); ?></td>
                                    <td>
                                        <a href="<?php echo e(route('admin.santri.show', $ws->santri)); ?>">
                                            <?php echo e($ws->santri->nama_lengkap ?? 'N/A'); ?>

                                        </a>
                                    </td>
                                    <td><?php echo e($ws->santri->kelas->nama ?? '-'); ?></td>
                                    <td><span class="badge badge-info"><?php echo e(ucfirst($ws->hubungan)); ?></span></td>
                                    <td>
                                        <?php if($ws->santri->status == 'aktif'): ?>
                                            <span class="badge badge-success">Aktif</span>
                                        <?php else: ?>
                                            <span class="badge badge-secondary"><?php echo e(ucfirst($ws->santri->status)); ?></span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <tr>
                                    <td colspan="5" class="text-center text-muted">Belum ada santri yang terhubung</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\ORDER\MASTARI\E-SPP\alkahfi-digital\resources\views/admin/wali-santri/show.blade.php ENDPATH**/ ?>