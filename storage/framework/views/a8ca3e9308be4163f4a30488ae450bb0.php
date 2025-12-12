<?php $__env->startSection('title', 'Kelola Slider'); ?>

<?php $__env->startSection('content'); ?>
    <div class="page-header">
        <div>
            <h1 class="page-title">Kelola Slider</h1>
            <p class="page-subtitle">Kelola slider/banner untuk landing page.</p>
        </div>
        <a href="<?php echo e(route('admin.landing.slider.create')); ?>" class="btn btn-primary">
            <i class="bi bi-plus"></i> Tambah Slider
        </a>
    </div>

    <div class="card">
        <div class="card-body">
            <table class="table" id="dataTable" style="width:100%">
                <thead>
                    <tr>
                        <th width="120">Gambar</th>
                        <th>Judul</th>
                        <th>Deskripsi</th>
                        <th>Urutan</th>
                        <th>Status</th>
                        <th width="100">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $sliders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $slider): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td>
                                <img src="<?php echo e(Storage::url($slider->gambar)); ?>" alt="" style="width: 100px; height: 50px; object-fit: cover; border-radius: 4px;">
                            </td>
                            <td><strong><?php echo e($slider->judul ?? '-'); ?></strong></td>
                            <td><small class="text-muted"><?php echo e(Str::limit($slider->deskripsi, 50) ?? '-'); ?></small></td>
                            <td><?php echo e($slider->urutan); ?></td>
                            <td>
                                <span class="badge badge-<?php echo e($slider->is_active ? 'success' : 'secondary'); ?>">
                                    <?php echo e($slider->is_active ? 'Aktif' : 'Nonaktif'); ?>

                                </span>
                            </td>
                            <td>
                                <div class="btn-group">
                                    <a href="<?php echo e(route('admin.landing.slider.edit', $slider)); ?>" class="btn btn-sm btn-secondary" title="Edit">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form action="<?php echo e(route('admin.landing.slider.destroy', $slider)); ?>" method="POST" style="display:inline" onsubmit="return confirm('Yakin hapus?')">
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
            order: [[3, 'asc']],
            columnDefs: [
                { orderable: false, targets: [0, -1] }
            ]
        });
    });
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\ORDER\MASTARI\E-SPP\alkahfi-digital\resources\views/admin/landing/slider/index.blade.php ENDPATH**/ ?>