

<?php $__env->startSection('title', 'Tambah Wali Santri'); ?>

<?php $__env->startSection('content'); ?>
    <div class="page-header">
        <div>
            <h1 class="page-title">Tambah Wali Santri</h1>
            <p class="page-subtitle">Buat akun wali santri baru.</p>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <form action="<?php echo e(route('admin.wali-santri.store')); ?>" method="POST">
                <?php echo csrf_field(); ?>

                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <label class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" value="<?php echo e(old('name')); ?>" required>
                            <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="text-danger" style="font-size: 0.875rem; margin-top: 4px;"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label class="form-label">Email <span class="text-danger">*</span></label>
                            <input type="email" name="email" class="form-control <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" value="<?php echo e(old('email')); ?>" required>
                            <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="text-danger" style="font-size: 0.875rem; margin-top: 4px;"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <label class="form-label">No. HP</label>
                            <input type="text" name="no_hp" class="form-control <?php $__errorArgs = ['no_hp'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" value="<?php echo e(old('no_hp')); ?>">
                            <?php $__errorArgs = ['no_hp'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="text-danger" style="font-size: 0.875rem; margin-top: 4px;"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label class="form-check form-switch">
                                <input type="checkbox" name="generate_password" class="form-check-input" value="1" id="generate_password" <?php echo e(old('generate_password', true) ? 'checked' : ''); ?> onchange="togglePasswordField()">
                                <span>Generate password otomatis</span>
                            </label>
                        </div>
                    </div>
                </div>

                <div class="row" id="password_fields" style="<?php echo e(old('generate_password', true) ? 'display: none;' : ''); ?>">
                    <div class="col-6">
                        <div class="form-group">
                            <label class="form-label">Password</label>
                            <input type="password" name="password" class="form-control <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" minlength="8">
                            <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="text-danger" style="font-size: 0.875rem; margin-top: 4px;"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label class="form-label">Konfirmasi Password</label>
                            <input type="password" name="password_confirmation" class="form-control">
                        </div>
                    </div>
                </div>

                <hr class="my-4">

                <h5 class="mb-3">Hubungkan dengan Santri</h5>

                <?php if($santriTanpaWali->count() > 0): ?>
                    <div class="alert alert-info mb-3">
                        <i class="bi bi-info-circle"></i> Ada <?php echo e($santriTanpaWali->count()); ?> santri yang belum memiliki wali.
                    </div>
                <?php endif; ?>

                <div id="santri-container">
                    <div class="santri-item">
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="form-label">Pilih Santri <span class="text-danger">*</span></label>
                                    <select class="form-control form-select <?php $__errorArgs = ['santri_ids.0'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="santri_ids[]" required>
                                        <option value="">-- Pilih Santri --</option>
                                        <?php $__currentLoopData = $semuaSantri; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $santri): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($santri->id); ?>" <?php echo e(old('santri_ids.0') == $santri->id ? 'selected' : ''); ?>>
                                                <?php echo e($santri->nama_lengkap); ?> (<?php echo e($santri->nis); ?>)
                                            </option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                    <?php $__errorArgs = ['santri_ids.0'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <div class="text-danger" style="font-size: 0.875rem; margin-top: 4px;"><?php echo e($message); ?></div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label class="form-label">Hubungan <span class="text-danger">*</span></label>
                                    <select class="form-control form-select" name="hubungan[]" required>
                                        <option value="ayah" <?php echo e(old('hubungan.0') == 'ayah' ? 'selected' : ''); ?>>Ayah</option>
                                        <option value="ibu" <?php echo e(old('hubungan.0') == 'ibu' ? 'selected' : ''); ?>>Ibu</option>
                                        <option value="wali" <?php echo e(old('hubungan.0', 'wali') == 'wali' ? 'selected' : ''); ?>>Wali</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-2 d-flex align-items-end">
                                <div class="form-group">
                                    <button type="button" class="btn btn-danger btn-sm remove-santri" style="display: none;">
                                        <i class="bi bi-trash"></i> Hapus
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mb-4">
                    <button type="button" class="btn btn-outline-primary btn-sm" id="add-santri">
                        <i class="bi bi-plus"></i> Tambah Santri Lain
                    </button>
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-check"></i> Simpan
                    </button>
                    <a href="<?php echo e(route('admin.wali-santri.index')); ?>" class="btn btn-secondary">Batal</a>
                </div>
            </form>
        </div>
    </div>

    <?php $__env->startPush('scripts'); ?>
    <script>
        function togglePasswordField() {
            const checkbox = document.getElementById('generate_password');
            const passwordFields = document.getElementById('password_fields');
            passwordFields.style.display = checkbox.checked ? 'none' : '';
        }

        document.getElementById('add-santri').addEventListener('click', function() {
            const container = document.getElementById('santri-container');
            const items = container.querySelectorAll('.santri-item');
            const index = items.length;

            const newItem = items[0].cloneNode(true);
            newItem.querySelectorAll('select')[0].name = `santri_ids[${index}]`;
            newItem.querySelectorAll('select')[0].value = '';
            newItem.querySelectorAll('select')[1].name = `hubungan[${index}]`;
            newItem.querySelectorAll('select')[1].value = 'wali';
            newItem.querySelector('.remove-santri').style.display = '';

            container.appendChild(newItem);
            updateRemoveButtons();
        });

        document.addEventListener('click', function(e) {
            if (e.target.closest('.remove-santri')) {
                e.target.closest('.santri-item').remove();
                updateRemoveButtons();
            }
        });

        function updateRemoveButtons() {
            const items = document.querySelectorAll('.santri-item');
            items.forEach((item, index) => {
                const removeBtn = item.querySelector('.remove-santri');
                removeBtn.style.display = items.length > 1 ? '' : 'none';
            });
        }
    </script>
    <?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\ORDER\MASTARI\E-SPP\alkahfi-digital\resources\views/admin/wali-santri/create.blade.php ENDPATH**/ ?>