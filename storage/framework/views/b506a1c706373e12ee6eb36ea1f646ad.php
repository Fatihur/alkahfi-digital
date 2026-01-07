

<?php $__env->startSection('title', 'Detail Pengumuman'); ?>

<?php $__env->startSection('content'); ?>
    <div class="page-header">
        <div>
            <h1 class="page-title">Detail Pengumuman</h1>
        </div>
        <div class="d-flex gap-2">
            <a href="<?php echo e(route('admin.pengumuman.edit', $pengumuman)); ?>" class="btn btn-secondary">
                <i class="bi bi-pencil"></i> Edit
            </a>
            <a href="<?php echo e(route('admin.pengumuman.index')); ?>" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left"></i> Kembali
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-8">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div>
                            <h2 class="mb-2"><?php echo e($pengumuman->judul); ?></h2>
                            <div class="d-flex gap-2 mb-3">
                                <span class="badge badge-<?php echo e($pengumuman->prioritas == 'tinggi' ? 'danger' : ($pengumuman->prioritas == 'normal' ? 'info' : 'secondary')); ?>">
                                    <?php echo e(ucfirst($pengumuman->prioritas)); ?>

                                </span>
                                <span class="badge badge-<?php echo e($pengumuman->is_published ? 'success' : 'warning'); ?>">
                                    <?php echo e($pengumuman->is_published ? 'Published' : 'Draft'); ?>

                                </span>
                            </div>
                        </div>
                    </div>

                    <?php if($pengumuman->gambar): ?>
                        <div class="mb-4">
                            <img src="<?php echo e(asset('storage/' . $pengumuman->gambar)); ?>" 
                                 alt="<?php echo e($pengumuman->judul); ?>" 
                                 class="img-fluid rounded" 
                                 style="max-height: 400px; width: 100%; object-fit: cover;">
                        </div>
                    <?php endif; ?>

                    <div class="content">
                        <?php echo nl2br(e($pengumuman->isi)); ?>

                    </div>
                </div>
            </div>
        </div>

        <div class="col-4">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Informasi Pengumuman</h3>
                </div>
                <div class="card-body">
                    <table class="table table-borderless">
                        <tr>
                            <td><strong>Prioritas</strong></td>
                            <td>
                                <span class="badge badge-<?php echo e($pengumuman->prioritas == 'tinggi' ? 'danger' : ($pengumuman->prioritas == 'normal' ? 'info' : 'secondary')); ?>">
                                    <?php echo e(ucfirst($pengumuman->prioritas)); ?>

                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td><strong>Status</strong></td>
                            <td>
                                <span class="badge badge-<?php echo e($pengumuman->is_published ? 'success' : 'warning'); ?>">
                                    <?php echo e($pengumuman->is_published ? 'Published' : 'Draft'); ?>

                                </span>
                            </td>
                        </tr>
                        <?php if($pengumuman->tanggal_mulai): ?>
                            <tr>
                                <td><strong>Tanggal Mulai</strong></td>
                                <td><?php echo e($pengumuman->tanggal_mulai->format('d/m/Y')); ?></td>
                            </tr>
                        <?php endif; ?>
                        <?php if($pengumuman->tanggal_selesai): ?>
                            <tr>
                                <td><strong>Tanggal Selesai</strong></td>
                                <td><?php echo e($pengumuman->tanggal_selesai->format('d/m/Y')); ?></td>
                            </tr>
                        <?php endif; ?>
                        <tr>
                            <td><strong>Dibuat Oleh</strong></td>
                            <td><?php echo e($pengumuman->createdBy->name ?? '-'); ?></td>
                        </tr>
                        <tr>
                            <td><strong>Tanggal Dibuat</strong></td>
                            <td><?php echo e($pengumuman->created_at->format('d/m/Y H:i')); ?></td>
                        </tr>
                        <tr>
                            <td><strong>Terakhir Update</strong></td>
                            <td><?php echo e($pengumuman->updated_at->format('d/m/Y H:i')); ?></td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\ORDER\MASTARI\E-SPP\alkahfi-digital\resources\views/admin/pengumuman/show.blade.php ENDPATH**/ ?>