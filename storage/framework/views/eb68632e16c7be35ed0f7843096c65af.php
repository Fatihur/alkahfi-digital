<?php $__env->startSection('title', 'Tambah Pengumuman'); ?>

<?php $__env->startSection('content'); ?>
    <div class="page-header"><div><h1 class="page-title">Tambah Pengumuman</h1></div></div>

    <div class="card">
        <div class="card-body">
            <form action="<?php echo e(route('admin.pengumuman.store')); ?>" method="POST" enctype="multipart/form-data">
                <?php echo csrf_field(); ?>
                <div class="form-group">
                    <label class="form-label">Judul <span class="text-danger">*</span></label>
                    <input type="text" name="judul" class="form-control" value="<?php echo e(old('judul')); ?>" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Isi <span class="text-danger">*</span></label>
                    <textarea name="isi" class="form-control" rows="6" required><?php echo e(old('isi')); ?></textarea>
                </div>
                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <label class="form-label">Prioritas</label>
                            <select name="prioritas" class="form-control form-select">
                                <option value="rendah">Rendah</option>
                                <option value="normal" selected>Normal</option>
                                <option value="tinggi">Tinggi</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label class="form-label">Gambar</label>
                            <input type="file" name="gambar" class="form-control" accept="image/*">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <label class="form-label">Tanggal Mulai</label>
                            <input type="date" name="tanggal_mulai" class="form-control" value="<?php echo e(old('tanggal_mulai')); ?>">
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label class="form-label">Tanggal Selesai</label>
                            <input type="date" name="tanggal_selesai" class="form-control" value="<?php echo e(old('tanggal_selesai')); ?>">
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="form-check form-switch">
                        <input type="checkbox" name="is_published" class="form-check-input" value="1">
                        <span>Publish Sekarang</span>
                    </label>
                </div>
                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary"><i class="bi bi-check"></i> Simpan</button>
                    <a href="<?php echo e(route('admin.pengumuman.index')); ?>" class="btn btn-secondary">Batal</a>
                </div>
            </form>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\ORDER\MASTARI\E-SPP\alkahfi-digital\resources\views/admin/pengumuman/create.blade.php ENDPATH**/ ?>