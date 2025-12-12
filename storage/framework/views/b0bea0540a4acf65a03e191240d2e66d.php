<?php $__env->startSection('title', 'Tambah Slider'); ?>

<?php $__env->startSection('content'); ?>
    <div class="page-header">
        <div>
            <h1 class="page-title">Tambah Slider</h1>
            <p class="page-subtitle">Tambah slider/banner baru untuk landing page.</p>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <form action="<?php echo e(route('admin.landing.slider.store')); ?>" method="POST" enctype="multipart/form-data">
                <?php echo csrf_field(); ?>
                <div class="form-group">
                    <label class="form-label">Judul</label>
                    <input type="text" name="judul" class="form-control" value="<?php echo e(old('judul')); ?>">
                </div>

                <div class="form-group">
                    <label class="form-label">Deskripsi</label>
                    <textarea name="deskripsi" class="form-control" rows="2"><?php echo e(old('deskripsi')); ?></textarea>
                </div>

                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <label class="form-label">Gambar <span class="text-danger">*</span></label>
                            <input type="file" name="gambar" class="form-control" accept="image/*" required>
                            <?php $__errorArgs = ['gambar'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="text-danger" style="font-size: 0.875rem; margin-top: 4px;"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            <small class="text-muted">Ukuran: 1920x500 px. Max 2MB</small>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label class="form-label">Urutan</label>
                            <input type="number" name="urutan" class="form-control" value="<?php echo e(old('urutan', 0)); ?>" min="0">
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-check form-switch">
                        <input type="checkbox" name="is_active" class="form-check-input" value="1" <?php echo e(old('is_active', true) ? 'checked' : ''); ?>>
                        <span>Aktif</span>
                    </label>
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary"><i class="bi bi-check"></i> Simpan</button>
                    <a href="<?php echo e(route('admin.landing.slider.index')); ?>" class="btn btn-secondary">Batal</a>
                </div>
            </form>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\ORDER\MASTARI\E-SPP\alkahfi-digital\resources\views/admin/landing/slider/create.blade.php ENDPATH**/ ?>