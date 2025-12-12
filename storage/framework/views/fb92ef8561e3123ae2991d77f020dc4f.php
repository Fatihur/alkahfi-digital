<?php $__env->startSection('title', 'Tambah Jurusan'); ?>

<?php $__env->startSection('content'); ?>
    <div class="page-header">
        <div>
            <h1 class="page-title">Tambah Jurusan</h1>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <form action="<?php echo e(route('admin.jurusan.store')); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <label class="form-label">Nama Jurusan <span class="text-danger">*</span></label>
                            <input type="text" name="nama_jurusan" class="form-control" value="<?php echo e(old('nama_jurusan')); ?>" required>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label class="form-label">Kode Jurusan</label>
                            <input type="text" name="kode_jurusan" class="form-control" value="<?php echo e(old('kode_jurusan')); ?>" placeholder="Contoh: IPA, IPS, TKJ">
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="form-label">Keterangan</label>
                    <textarea name="keterangan" class="form-control" rows="3"><?php echo e(old('keterangan')); ?></textarea>
                </div>
                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary"><i class="bi bi-check"></i> Simpan</button>
                    <a href="<?php echo e(route('admin.jurusan.index')); ?>" class="btn btn-secondary">Batal</a>
                </div>
            </form>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\ORDER\MASTARI\E-SPP\alkahfi-digital\resources\views/admin/jurusan/create.blade.php ENDPATH**/ ?>