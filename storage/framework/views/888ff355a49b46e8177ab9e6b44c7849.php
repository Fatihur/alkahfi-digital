

<?php $__env->startSection('title', 'Generate Akun Wali Santri'); ?>

<?php $__env->startSection('content'); ?>
    <div class="page-header">
        <div>
            <h1 class="page-title">Generate Akun Otomatis</h1>
            <p class="page-subtitle">Buat akun wali santri secara otomatis untuk santri yang belum memiliki wali.</p>
        </div>
    </div>

    <?php if($santriTanpaWali->count() == 0): ?>
        <div class="alert alert-info">
            <i class="bi bi-info-circle"></i> Semua santri aktif sudah memiliki akun wali. Tidak ada santri yang perlu dibuatkan akun.
        </div>
        <a href="<?php echo e(route('admin.wali-santri.index')); ?>" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
    <?php else: ?>
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span>Pilih santri yang akan dibuatkan akun wali</span>
                <span class="badge badge-info"><?php echo e($santriTanpaWali->count()); ?> santri tanpa wali</span>
            </div>
            <div class="card-body">
                <form action="<?php echo e(route('admin.wali-santri.generate.store')); ?>" method="POST" id="generateForm">
                    <?php echo csrf_field(); ?>

                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label class="form-label">Hubungan Default <span class="text-danger">*</span></label>
                                <select class="form-control form-select <?php $__errorArgs = ['hubungan_default'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="hubungan_default" required>
                                    <option value="ayah">Ayah</option>
                                    <option value="ibu">Ibu</option>
                                    <option value="wali" selected>Wali</option>
                                </select>
                                <?php $__errorArgs = ['hubungan_default'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="text-danger" style="font-size: 0.875rem; margin-top: 4px;"><?php echo e($message); ?></div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                <small class="text-muted">Hubungan default yang akan digunakan untuk semua akun yang dibuat</small>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label class="form-check">
                                    <input type="checkbox" class="form-check-input" id="selectAll">
                                    <span>Pilih Semua Santri</span>
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th width="50">
                                        <input type="checkbox" class="form-check-input" id="checkAll">
                                    </th>
                                    <th>NIS</th>
                                    <th>Nama Santri</th>
                                    <th>Kelas</th>
                                    <th>Email yang akan dibuat</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $santriTanpaWali; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $santri): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td>
                                            <input type="checkbox" class="form-check-input santri-checkbox" name="santri_ids[]" value="<?php echo e($santri->id); ?>">
                                        </td>
                                        <td><?php echo e($santri->nis); ?></td>
                                        <td><?php echo e($santri->nama_lengkap); ?></td>
                                        <td><?php echo e($santri->kelas->nama ?? '-'); ?></td>
                                        <td>
                                            <code><?php echo e(Str::slug($santri->nama_lengkap, '.')); ?>@wali.pesantren.id</code>
                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>

                    <div class="alert alert-warning">
                        <i class="bi bi-exclamation-triangle"></i>
                        <strong>Perhatian:</strong> Password akan di-generate secara otomatis dan ditampilkan setelah proses selesai.
                        Pastikan untuk menyimpan informasi login tersebut.
                    </div>

                    <div class="d-flex justify-content-between align-items-center">
                        <span id="selectedCount" class="text-muted">0 santri dipilih</span>
                        <div class="d-flex gap-2">
                            <a href="<?php echo e(route('admin.wali-santri.index')); ?>" class="btn btn-secondary">Batal</a>
                            <button type="submit" class="btn btn-success" id="submitBtn" disabled>
                                <i class="bi bi-magic"></i> Generate Akun (<span id="btnCount">0</span>)
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    <?php endif; ?>

    <?php $__env->startPush('scripts'); ?>
    <script>
        const checkboxes = document.querySelectorAll('.santri-checkbox');
        const selectAll = document.getElementById('selectAll');
        const checkAll = document.getElementById('checkAll');
        const selectedCount = document.getElementById('selectedCount');
        const submitBtn = document.getElementById('submitBtn');
        const btnCount = document.getElementById('btnCount');

        function updateCount() {
            const checked = document.querySelectorAll('.santri-checkbox:checked').length;
            selectedCount.textContent = checked + ' santri dipilih';
            btnCount.textContent = checked;
            submitBtn.disabled = checked === 0;
        }

        if (selectAll) {
            selectAll.addEventListener('change', function() {
                checkboxes.forEach(cb => cb.checked = this.checked);
                if (checkAll) checkAll.checked = this.checked;
                updateCount();
            });
        }

        if (checkAll) {
            checkAll.addEventListener('change', function() {
                checkboxes.forEach(cb => cb.checked = this.checked);
                if (selectAll) selectAll.checked = this.checked;
                updateCount();
            });
        }

        checkboxes.forEach(cb => {
            cb.addEventListener('change', function() {
                const allChecked = document.querySelectorAll('.santri-checkbox:checked').length === checkboxes.length;
                if (selectAll) selectAll.checked = allChecked;
                if (checkAll) checkAll.checked = allChecked;
                updateCount();
            });
        });

        document.getElementById('generateForm')?.addEventListener('submit', function(e) {
            const checked = document.querySelectorAll('.santri-checkbox:checked').length;
            if (checked === 0) {
                e.preventDefault();
                alert('Pilih minimal satu santri');
                return false;
            }
            return confirm('Generate ' + checked + ' akun wali santri?');
        });
    </script>
    <?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\ORDER\MASTARI\E-SPP\alkahfi-digital\resources\views/admin/wali-santri/generate.blade.php ENDPATH**/ ?>