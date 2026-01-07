<?php $__env->startSection('title', 'Beranda - ' . ($profil->nama_sekolah ?? 'Sekolah')); ?>

<?php $__env->startSection('content'); ?>
    <!-- Carousel Start -->
    <div class="container-fluid p-0 mb-5">
        <div class="owl-carousel header-carousel position-relative">
            <?php if($sliders->count() > 0): ?>
                <?php $__currentLoopData = $sliders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $slider): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="owl-carousel-item position-relative">
                    <img class="img-fluid" src="<?php echo e(Storage::url($slider->gambar)); ?>" alt="<?php echo e($slider->judul); ?>" style="width: 100%; height: 600px; object-fit: cover;">
                    <div class="position-absolute top-0 start-0 w-100 h-100 d-flex align-items-center" style="background: rgba(24, 29, 56, .7);">
                        <div class="container">
                            <div class="row justify-content-start">
                                <div class="col-sm-10 col-lg-8">
                                    <?php if($slider->judul): ?>
                                        <h5 class="text-primary text-uppercase mb-3 animated slideInDown"><?php echo e($profil->nama_sekolah ?? 'Sekolah'); ?></h5>
                                        <h1 class="display-3 text-white animated slideInDown"><?php echo e($slider->judul); ?></h1>
                                    <?php endif; ?>
                                    <?php if($slider->deskripsi): ?>
                                        <p class="fs-5 text-white mb-4 pb-2"><?php echo e($slider->deskripsi); ?></p>
                                    <?php endif; ?>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php else: ?>
                <div class="owl-carousel-item position-relative">
                    <img class="img-fluid" src="<?php echo e(asset('landing/img/carousel-1.jpg')); ?>" alt="" style="width: 100%; height: 600px; object-fit: cover;">
                    <div class="position-absolute top-0 start-0 w-100 h-100 d-flex align-items-center" style="background: rgba(24, 29, 56, .7);">
                        <div class="container">
                            <div class="row justify-content-start">
                                <div class="col-sm-10 col-lg-8">
                                    <h5 class="text-primary text-uppercase mb-3 animated slideInDown">Selamat Datang</h5>
                                    <h1 class="display-3 text-white animated slideInDown"><?php echo e($profil->nama_sekolah ?? 'Sekolah Kami'); ?></h1>
                                    <p class="fs-5 text-white mb-4 pb-2"><?php echo e(Str::limit($profil->visi ?? 'Mewujudkan generasi yang berilmu, berakhlak, dan berprestasi', 150)); ?></p>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
    <!-- Carousel End -->

    <!-- Service Start -->
    <div class="container-xxl py-5">
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-3 col-sm-6 wow fadeInUp" data-wow-delay="0.1s">
                    <div class="service-item text-center pt-3">
                        <div class="p-4">
                            <i class="fa fa-3x fa-graduation-cap text-primary mb-4"></i>
                            <h5 class="mb-3">Tenaga Pengajar</h5>
                            <p>Pengajar profesional dan berpengalaman di bidangnya</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6 wow fadeInUp" data-wow-delay="0.3s">
                    <div class="service-item text-center pt-3">
                        <div class="p-4">
                            <i class="fa fa-3x fa-globe text-primary mb-4"></i>
                            <h5 class="mb-3">Fasilitas Lengkap</h5>
                            <p>Fasilitas pembelajaran modern dan lengkap</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6 wow fadeInUp" data-wow-delay="0.5s">
                    <div class="service-item text-center pt-3">
                        <div class="p-4">
                            <i class="fa fa-3x fa-home text-primary mb-4"></i>
                            <h5 class="mb-3">Lingkungan Kondusif</h5>
                            <p>Lingkungan belajar yang nyaman dan kondusif</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6 wow fadeInUp" data-wow-delay="0.7s">
                    <div class="service-item text-center pt-3">
                        <div class="p-4">
                            <i class="fa fa-3x fa-book-open text-primary mb-4"></i>
                            <h5 class="mb-3">Kurikulum Terbaik</h5>
                            <p>Kurikulum yang terintegrasi dan berkualitas</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Service End -->

    <!-- About Start -->
    <div class="container-xxl py-5">
        <div class="container">
            <div class="row g-5">
                <div class="col-lg-6 wow fadeInUp" data-wow-delay="0.1s" style="min-height: 400px;">
                    <div class="position-relative h-100">
                        <?php if($profil->foto_gedung ?? false): ?>
                            <img class="img-fluid position-absolute w-100 h-100" src="<?php echo e(Storage::url($profil->foto_gedung)); ?>" alt="Gedung Sekolah" style="object-fit: cover;">
                        <?php else: ?>
                            <img class="img-fluid position-absolute w-100 h-100" src="<?php echo e(asset('landing/img/depan.jpg')); ?>" alt="" style="object-fit: cover;">
                        <?php endif; ?>
                    </div>
                </div>
                <div class="col-lg-6 wow fadeInUp" data-wow-delay="0.3s">
                    <h6 class="section-title bg-white text-start text-primary pe-3">Tentang Kami</h6>
                    <h1 class="mb-4">Selamat Datang di <?php echo e($profil->nama_sekolah ?? 'Sekolah Kami'); ?></h1>
                    <p class="mb-4"><?php echo e(Str::limit($profil->sejarah ?? 'Sekolah kami berkomitmen untuk memberikan pendidikan terbaik bagi generasi penerus bangsa.', 200)); ?></p>
                    <?php if($profil->visi ?? false): ?>
                        <p class="mb-4"><strong>Visi:</strong> <?php echo e($profil->visi); ?></p>
                    <?php endif; ?>
                    <?php if($profil->misi ?? false): ?>
                        <div class="row gy-2 gx-4 mb-4">
                            <?php
                                $misiList = explode("\n", $profil->misi);
                            ?>
                            <?php $__currentLoopData = array_slice($misiList, 0, 6); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $misi): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php if(trim($misi)): ?>
                                    <div class="col-sm-6">
                                        <p class="mb-0"><i class="fa fa-arrow-right text-primary me-2"></i><?php echo e(Str::limit(trim($misi), 40)); ?></p>
                                    </div>
                                <?php endif; ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    <?php endif; ?>
                    <a class="btn btn-primary py-3 px-5 mt-2" href="<?php echo e(route('landing.profil')); ?>">Selengkapnya</a>
                </div>
            </div>
        </div>
    </div>
    <!-- About End -->

    <?php if($profil->kepala_sekolah ?? false): ?>
    <!-- Kepala Sekolah Start -->
    <div class="container-xxl py-5">
        <div class="container">
            <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
                <h6 class="section-title bg-white text-center text-primary px-3">Sambutan</h6>
                <h1 class="mb-5">Kepala Sekolah</h1>
            </div>
            <div class="row g-4 justify-content-center">
                <div class="col-lg-8 wow fadeInUp" data-wow-delay="0.1s">
                    <div class="testimonial-item text-center">
                        <?php if($profil->foto_kepala_sekolah ?? false): ?>
                            <img class="border rounded-circle p-2 mx-auto mb-3" src="<?php echo e(Storage::url($profil->foto_kepala_sekolah)); ?>" style="width: 120px; height: 120px; object-fit: cover;">
                        <?php else: ?>
                            <div class="border rounded-circle p-2 mx-auto mb-3 bg-light d-flex align-items-center justify-content-center" style="width: 120px; height: 120px;">
                                <i class="fa fa-user fa-3x text-primary"></i>
                            </div>
                        <?php endif; ?>
                        <h5 class="mb-0"><?php echo e($profil->kepala_sekolah); ?></h5>
                        <p>Kepala Sekolah</p>
                        <div class="testimonial-text bg-light text-center p-4">
                            <p class="mb-0">"<?php echo e(Str::limit($profil->kata_sambutan ?? 'Selamat datang di website resmi sekolah kami.', 300)); ?>"</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Kepala Sekolah End -->
    <?php endif; ?>

    <!-- Berita Start -->
    <div class="container-xxl py-5">
        <div class="container">
            <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
                <h6 class="section-title bg-white text-center text-primary px-3">Informasi</h6>
                <h1 class="mb-5">Berita Terbaru</h1>
            </div>
            <?php if($beritaTerbaru->count() > 0): ?>
            <div class="row g-4 justify-content-center">
                <?php $__currentLoopData = $beritaTerbaru; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $berita): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.<?php echo e($loop->iteration); ?>s">
                    <div class="course-item bg-light">
                        <div class="position-relative overflow-hidden">
                            <?php if($berita->gambar): ?>
                                <img class="img-fluid" src="<?php echo e(Storage::url($berita->gambar)); ?>" alt="<?php echo e($berita->judul); ?>" style="height: 200px; width: 100%; object-fit: cover;">
                            <?php else: ?>
                                <img class="img-fluid" src="<?php echo e(asset('landing/img/course-1.jpg')); ?>" alt="" style="height: 200px; width: 100%; object-fit: cover;">
                            <?php endif; ?>
                            <div class="w-100 d-flex justify-content-center position-absolute bottom-0 start-0 mb-4">
                                <a href="<?php echo e(route('landing.berita.detail', $berita->slug)); ?>" class="flex-shrink-0 btn btn-sm btn-primary px-3" style="border-radius: 30px;">Baca Selengkapnya</a>
                            </div>
                        </div>
                        <div class="text-center p-4 pb-0">
                            <span class="badge bg-primary mb-2"><?php echo e($berita->kategori); ?></span>
                            <h5 class="mb-4"><?php echo e(Str::limit($berita->judul, 50)); ?></h5>
                        </div>
                        <div class="d-flex border-top">
                            <small class="flex-fill text-center border-end py-2"><i class="fa fa-calendar text-primary me-2"></i><?php echo e($berita->tanggal_publikasi?->format('d M Y')); ?></small>
                            <small class="flex-fill text-center py-2"><i class="fa fa-eye text-primary me-2"></i><?php echo e($berita->views); ?> views</small>
                        </div>
                    </div>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
            <div class="text-center mt-4">
                <a href="<?php echo e(route('landing.berita')); ?>" class="btn btn-primary py-3 px-5">Lihat Semua Berita</a>
            </div>
            <?php else: ?>
            <div class="text-center py-5">
                <i class="fa fa-newspaper fa-4x text-muted mb-3"></i>
                <p class="text-muted">Belum ada berita yang dipublikasikan.</p>
            </div>
            <?php endif; ?>
        </div>
    </div>
    <!-- Berita End -->

    <!-- Galeri Start -->
    <div class="container-xxl py-5 category">
        <div class="container">
            <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
                <h6 class="section-title bg-white text-center text-primary px-3">Dokumentasi</h6>
                <h1 class="mb-5">Galeri Foto</h1>
            </div>
            <?php if($galeriTerbaru->count() > 0): ?>
            <div class="row g-3">
                <?php $__currentLoopData = $galeriTerbaru->take(5); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $galeri): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php if($index == 0): ?>
                    <div class="col-lg-7 col-md-6">
                        <div class="row g-3">
                            <div class="col-lg-12 col-md-12 wow zoomIn" data-wow-delay="0.1s">
                                <a class="position-relative d-block overflow-hidden" href="<?php echo e(Storage::url($galeri->gambar)); ?>" data-bs-toggle="modal" data-bs-target="#galeriModal<?php echo e($galeri->id); ?>">
                                    <img class="img-fluid" src="<?php echo e(Storage::url($galeri->gambar)); ?>" alt="<?php echo e($galeri->judul); ?>" style="height: 217px; width: 100%; object-fit: cover;">
                                    <div class="bg-white text-center position-absolute bottom-0 end-0 py-2 px-3" style="margin: 1px;">
                                        <h5 class="m-0"><?php echo e(Str::limit($galeri->judul, 20)); ?></h5>
                                        <small class="text-primary"><?php echo e($galeri->kategori); ?></small>
                                    </div>
                                </a>
                            </div>
                            <?php if($galeriTerbaru->count() > 1): ?>
                            <div class="col-lg-6 col-md-12 wow zoomIn" data-wow-delay="0.3s">
                                <?php $g = $galeriTerbaru[1] ?? null; ?>
                                <?php if($g): ?>
                                <a class="position-relative d-block overflow-hidden" href="<?php echo e(Storage::url($g->gambar)); ?>" data-bs-toggle="modal" data-bs-target="#galeriModal<?php echo e($g->id); ?>">
                                    <img class="img-fluid" src="<?php echo e(Storage::url($g->gambar)); ?>" alt="<?php echo e($g->judul); ?>" style="height: 200px; width: 100%; object-fit: cover;">
                                    <div class="bg-white text-center position-absolute bottom-0 end-0 py-2 px-3" style="margin: 1px;">
                                        <h5 class="m-0"><?php echo e(Str::limit($g->judul, 15)); ?></h5>
                                        <small class="text-primary"><?php echo e($g->kategori); ?></small>
                                    </div>
                                </a>
                                <?php endif; ?>
                            </div>
                            <?php endif; ?>
                            <?php if($galeriTerbaru->count() > 2): ?>
                            <div class="col-lg-6 col-md-12 wow zoomIn" data-wow-delay="0.5s">
                                <?php $g = $galeriTerbaru[2] ?? null; ?>
                                <?php if($g): ?>
                                <a class="position-relative d-block overflow-hidden" href="<?php echo e(Storage::url($g->gambar)); ?>" data-bs-toggle="modal" data-bs-target="#galeriModal<?php echo e($g->id); ?>">
                                    <img class="img-fluid" src="<?php echo e(Storage::url($g->gambar)); ?>" alt="<?php echo e($g->judul); ?>" style="height: 200px; width: 100%; object-fit: cover;">
                                    <div class="bg-white text-center position-absolute bottom-0 end-0 py-2 px-3" style="margin: 1px;">
                                        <h5 class="m-0"><?php echo e(Str::limit($g->judul, 15)); ?></h5>
                                        <small class="text-primary"><?php echo e($g->kategori); ?></small>
                                    </div>
                                </a>
                                <?php endif; ?>
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>
                    <?php if($galeriTerbaru->count() > 3): ?>
                    <div class="col-lg-5 col-md-6 wow zoomIn" data-wow-delay="0.7s" style="min-height: 350px;">
                        <?php $g = $galeriTerbaru[3] ?? null; ?>
                        <?php if($g): ?>
                        <a class="position-relative d-block h-100 overflow-hidden" href="<?php echo e(Storage::url($g->gambar)); ?>" data-bs-toggle="modal" data-bs-target="#galeriModal<?php echo e($g->id); ?>">
                            <img class="img-fluid position-absolute w-100 h-100" src="<?php echo e(Storage::url($g->gambar)); ?>" alt="<?php echo e($g->judul); ?>" style="object-fit: cover;">
                            <div class="bg-white text-center position-absolute bottom-0 end-0 py-2 px-3" style="margin: 1px;">
                                <h5 class="m-0"><?php echo e(Str::limit($g->judul, 20)); ?></h5>
                                <small class="text-primary"><?php echo e($g->kategori); ?></small>
                            </div>
                        </a>
                        <?php endif; ?>
                    </div>
                    <?php endif; ?>
                    <?php endif; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
            <div class="text-center mt-4">
                <a href="<?php echo e(route('landing.galeri')); ?>" class="btn btn-primary py-3 px-5">Lihat Semua Galeri</a>
            </div>
            <?php else: ?>
            <div class="text-center py-5">
                <i class="fa fa-images fa-4x text-muted mb-3"></i>
                <p class="text-muted">Belum ada galeri yang dipublikasikan.</p>
            </div>
            <?php endif; ?>
        </div>
    </div>
    <!-- Galeri End -->

    <!-- Modal Galeri -->
    <?php $__currentLoopData = $galeriTerbaru; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $galeri): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <div class="modal fade" id="galeriModal<?php echo e($galeri->id); ?>" tabindex="-1">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><?php echo e($galeri->judul); ?></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body text-center">
                    <img src="<?php echo e(Storage::url($galeri->gambar)); ?>" alt="<?php echo e($galeri->judul); ?>" class="img-fluid rounded">
                    <?php if($galeri->deskripsi): ?>
                        <p class="mt-3 text-muted"><?php echo e($galeri->deskripsi); ?></p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.landing', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\ORDER\MASTARI\E-SPP\alkahfi-digital\resources\views/landing/index.blade.php ENDPATH**/ ?>