<?php $__env->startSection('title', 'Galeri - ' . ($profil->nama_sekolah ?? 'Sekolah')); ?>

<?php $__env->startSection('content'); ?>
    <!-- Header Start -->
    <div class="container-fluid bg-primary py-5 mb-5 page-header">
        <div class="container py-5">
            <div class="row justify-content-center">
                <div class="col-lg-10 text-center">
                    <h1 class="display-3 text-white animated slideInDown">Galeri Foto</h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb justify-content-center">
                            <li class="breadcrumb-item"><a class="text-white" href="<?php echo e(route('landing.index')); ?>">Beranda</a></li>
                            <li class="breadcrumb-item text-white active" aria-current="page">Galeri</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <!-- Header End -->

    <!-- Galeri Start -->
    <div class="container-xxl py-5">
        <div class="container">
            <?php if($galeri->count() > 0): ?>
            <div class="row g-4">
                <?php $__currentLoopData = $galeri; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="col-lg-3 col-md-4 col-sm-6 wow fadeInUp" data-wow-delay="0.1s">
                    <div class="position-relative overflow-hidden rounded" style="cursor: pointer;" data-bs-toggle="modal" data-bs-target="#galeriModal<?php echo e($item->id); ?>">
                        <img class="img-fluid w-100" src="<?php echo e(Storage::url($item->gambar)); ?>" alt="<?php echo e($item->judul); ?>" style="height: 200px; object-fit: cover;">
                        <div class="position-absolute top-0 start-0 w-100 h-100 d-flex flex-column justify-content-end p-3" style="background: linear-gradient(to top, rgba(0,0,0,0.7), transparent);">
                            <h6 class="text-white mb-1"><?php echo e(Str::limit($item->judul, 25)); ?></h6>
                            <small class="text-white-50"><?php echo e($item->kategori); ?></small>
                        </div>
                    </div>
                </div>
                <!-- Modal -->
                <div class="modal fade" id="galeriModal<?php echo e($item->id); ?>" tabindex="-1">
                    <div class="modal-dialog modal-lg modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title"><?php echo e($item->judul); ?></h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body text-center">
                                <img src="<?php echo e(Storage::url($item->gambar)); ?>" alt="<?php echo e($item->judul); ?>" class="img-fluid rounded">
                                <?php if($item->deskripsi): ?>
                                    <p class="mt-3 text-muted"><?php echo e($item->deskripsi); ?></p>
                                <?php endif; ?>
                                <span class="badge bg-primary"><?php echo e($item->kategori); ?></span>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
            <div class="d-flex justify-content-center mt-5">
                <?php echo e($galeri->links()); ?>

            </div>
            <?php else: ?>
            <div class="text-center py-5 wow fadeInUp" data-wow-delay="0.1s">
                <i class="fa fa-images fa-5x text-muted mb-4"></i>
                <h4 class="text-muted">Belum ada galeri yang dipublikasikan.</h4>
            </div>
            <?php endif; ?>
        </div>
    </div>
    <!-- Galeri End -->
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.landing', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\ORDER\MASTARI\E-SPP\alkahfi-digital\resources\views/landing/galeri.blade.php ENDPATH**/ ?>