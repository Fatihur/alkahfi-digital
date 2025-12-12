<?php $__env->startSection('title', 'Laporan Tunggakan'); ?>

<?php $__env->startSection('content'); ?>
    <div class="page-header">
        <div>
            <h1 class="page-title">Laporan Tunggakan</h1>
            <p class="page-subtitle">Total Tunggakan: <strong class="text-danger">Rp <?php echo e(number_format($totalTunggakan, 0, ',', '.')); ?></strong></p>
        </div>
        <a href="<?php echo e(route('bendahara.laporan.tunggakan', array_merge(request()->query(), ['export' => 'pdf']))); ?>" class="btn btn-danger">
            <i class="bi bi-file-earmark-pdf"></i> Export PDF
        </a>
    </div>

    <div class="card">
        <div class="card-header">
            <form action="" method="GET" class="d-flex gap-2">
                <select name="bulan" class="form-control form-select" style="width:130px;">
                    <option value="">Semua Bulan</option>
                    <?php $__currentLoopData = ['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $bulan): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($i+1); ?>" <?php echo e(request('bulan') == $i+1 ? 'selected' : ''); ?>><?php echo e($bulan); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
                <select name="tahun" class="form-control form-select" style="width:100px;">
                    <?php for($y = date('Y'); $y >= 2020; $y--): ?>
                        <option value="<?php echo e($y); ?>" <?php echo e(request('tahun', date('Y')) == $y ? 'selected' : ''); ?>><?php echo e($y); ?></option>
                    <?php endfor; ?>
                </select>
                <button type="submit" class="btn btn-secondary">Filter</button>
            </form>
        </div>
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Santri</th>
                        <th>Kelas</th>
                        <th>Tagihan</th>
                        <th>Total</th>
                        <th>Jatuh Tempo</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $tagihan; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $t): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td><?php echo e($i + 1); ?></td>
                            <td><?php echo e($t->santri->nama_lengkap); ?><br><small class="text-muted"><?php echo e($t->santri->nis); ?></small></td>
                            <td><?php echo e($t->santri->kelas->nama_kelas ?? '-'); ?></td>
                            <td><?php echo e($t->nama_tagihan); ?></td>
                            <td>Rp <?php echo e(number_format($t->total_bayar, 0, ',', '.')); ?></td>
                            <td><?php echo e($t->tanggal_jatuh_tempo->format('d/m/Y')); ?></td>
                            <td>
                                <?php if($t->status === 'jatuh_tempo'): ?>
                                    <span class="badge badge-danger">Jatuh Tempo</span>
                                <?php else: ?>
                                    <span class="badge badge-warning">Belum Bayar</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr><td colspan="7" class="text-center text-muted">Tidak ada tunggakan</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.bendahara', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\ORDER\MASTARI\E-SPP\alkahfi-digital\resources\views/bendahara/laporan/tunggakan.blade.php ENDPATH**/ ?>