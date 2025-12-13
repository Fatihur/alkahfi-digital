

<?php $__env->startSection('title', 'Pengaturan Payment Gateway'); ?>

<?php $__env->startSection('content'); ?>
    <div class="page-header">
        <div>
            <h1 class="page-title">Pengaturan Payment Gateway</h1>
            <p class="page-subtitle">Konfigurasi integrasi Duitku payment gateway.</p>
        </div>
    </div>

    <div class="row">
        <div class="col-8">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Konfigurasi Duitku</h3>
                </div>
                <div class="card-body">
                    <form action="<?php echo e(route('admin.pengaturan.payment.update')); ?>" method="POST">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('PUT'); ?>

                        <div class="form-group">
                            <label class="form-check">
                                <input type="hidden" name="payment_gateway_enabled" value="0">
                                <input type="checkbox" name="payment_gateway_enabled" value="1" class="form-check-input" <?php echo e($settings['payment_gateway_enabled'] == '1' ? 'checked' : ''); ?>>
                                <span class="form-check-label">Aktifkan Payment Gateway</span>
                            </label>
                            <small class="text-muted d-block mt-1">Jika dinonaktifkan, wali santri tidak dapat melakukan pembayaran online.</small>
                        </div>

                        <hr>

                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="form-label">Merchant Code <span class="text-danger">*</span></label>
                                    <input type="text" name="duitku_merchant_code" class="form-control" value="<?php echo e($settings['duitku_merchant_code']); ?>" placeholder="Masukkan Merchant Code">
                                    <small class="text-muted">Dapatkan dari dashboard Duitku</small>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="form-label">API Key <span class="text-danger">*</span></label>
                                    <div style="position: relative;">
                                        <input type="password" name="duitku_api_key" id="apiKeyInput" class="form-control" value="<?php echo e($settings['duitku_api_key']); ?>" placeholder="Masukkan API Key">
                                        <button type="button" onclick="toggleApiKey()" style="position: absolute; right: 10px; top: 50%; transform: translateY(-50%); background: none; border: none; cursor: pointer;">
                                            <i class="bi bi-eye" id="toggleIcon"></i>
                                        </button>
                                    </div>
                                    <small class="text-muted">Dapatkan dari dashboard Duitku</small>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Mode</label>
                            <select name="duitku_is_production" class="form-control form-select">
                                <option value="0" <?php echo e($settings['duitku_is_production'] == '0' ? 'selected' : ''); ?>>Sandbox (Testing)</option>
                                <option value="1" <?php echo e($settings['duitku_is_production'] == '1' ? 'selected' : ''); ?>>Production (Live)</option>
                            </select>
                            <small class="text-muted">Gunakan mode Sandbox untuk testing sebelum go-live.</small>
                        </div>

                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="form-label">Callback URL</label>
                                    <input type="text" name="duitku_callback_url" class="form-control" value="<?php echo e($settings['duitku_callback_url'] ?: url('/api/duitku/callback')); ?>" placeholder="<?php echo e(url('/api/duitku/callback')); ?>">
                                    <small class="text-muted">URL untuk menerima notifikasi dari Duitku</small>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="form-label">Return URL</label>
                                    <input type="text" name="duitku_return_url" class="form-control" value="<?php echo e($settings['duitku_return_url'] ?: url('/wali/pembayaran')); ?>" placeholder="<?php echo e(url('/wali/pembayaran')); ?>">
                                    <small class="text-muted">URL redirect setelah pembayaran</small>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Masa Berlaku Pembayaran (menit)</label>
                            <input type="number" name="duitku_expiry_period" class="form-control" value="<?php echo e($settings['duitku_expiry_period']); ?>" min="60" max="10080">
                            <small class="text-muted">Waktu maksimal untuk menyelesaikan pembayaran (60 - 10080 menit / 1 jam - 7 hari)</small>
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-check"></i> Simpan Pengaturan
                            </button>
                            <button type="button" class="btn btn-secondary" onclick="testConnection()">
                                <i class="bi bi-wifi"></i> Test Koneksi
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-4">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Informasi</h3>
                </div>
                <div class="card-body">
                    <div style="background: var(--primary-subtle); padding: 16px; border-radius: 8px; margin-bottom: 16px;">
                        <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 12px;">
                            <div style="width: 40px; height: 40px; background: var(--primary-color); border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                                <i class="bi bi-credit-card" style="color: white; font-size: 1.25rem;"></i>
                            </div>
                            <div>
                                <div style="font-weight: 600;">Duitku</div>
                                <div style="font-size: 0.8rem; color: var(--text-muted);">Payment Gateway</div>
                            </div>
                        </div>
                    </div>

                    <h6>Metode Pembayaran Tersedia:</h6>
                    <ul style="font-size: 0.875rem; color: var(--text-muted); padding-left: 20px;">
                        <li>Virtual Account (BCA, Mandiri, BNI, BRI, Permata)</li>
                        <li>E-Wallet (OVO, DANA, ShopeePay, LinkAja)</li>
                        <li>QRIS</li>
                        <li>Retail (Indomaret, Alfamart)</li>
                    </ul>

                    <hr>

                    <h6>Cara Mendapatkan Kredensial:</h6>
                    <ol style="font-size: 0.875rem; color: var(--text-muted); padding-left: 20px;">
                        <li>Daftar di <a href="https://duitku.com" target="_blank">duitku.com</a></li>
                        <li>Login ke dashboard merchant</li>
                        <li>Buka menu Project > API Keys</li>
                        <li>Salin Merchant Code dan API Key</li>
                    </ol>

                    <hr>

                    <div class="alert alert-warning" style="font-size: 0.875rem;">
                        <i class="bi bi-exclamation-triangle"></i>
                        <strong>Penting:</strong> Pastikan Callback URL dapat diakses dari internet dan sudah didaftarkan di dashboard Duitku.
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Status Koneksi</h3>
                </div>
                <div class="card-body" id="connectionStatus">
                    <div class="text-center text-muted">
                        <i class="bi bi-question-circle" style="font-size: 2rem;"></i>
                        <p class="mb-0 mt-2">Klik "Test Koneksi" untuk memeriksa</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function toggleApiKey() {
            const input = document.getElementById('apiKeyInput');
            const icon = document.getElementById('toggleIcon');
            if (input.type === 'password') {
                input.type = 'text';
                icon.className = 'bi bi-eye-slash';
            } else {
                input.type = 'password';
                icon.className = 'bi bi-eye';
            }
        }

        function testConnection() {
            const statusDiv = document.getElementById('connectionStatus');
            statusDiv.innerHTML = `
                <div class="text-center">
                    <div class="spinner-border text-primary" role="status" style="width: 2rem; height: 2rem;"></div>
                    <p class="mb-0 mt-2">Menguji koneksi...</p>
                </div>
            `;

            fetch('<?php echo e(route("admin.pengaturan.payment.test")); ?>', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    statusDiv.innerHTML = `
                        <div class="text-center">
                            <i class="bi bi-check-circle text-success" style="font-size: 2rem;"></i>
                            <p class="mb-0 mt-2 text-success">${data.message}</p>
                        </div>
                    `;
                } else {
                    statusDiv.innerHTML = `
                        <div class="text-center">
                            <i class="bi bi-x-circle text-danger" style="font-size: 2rem;"></i>
                            <p class="mb-0 mt-2 text-danger">${data.message}</p>
                        </div>
                    `;
                }
            })
            .catch(error => {
                statusDiv.innerHTML = `
                    <div class="text-center">
                        <i class="bi bi-x-circle text-danger" style="font-size: 2rem;"></i>
                        <p class="mb-0 mt-2 text-danger">Gagal menguji koneksi</p>
                    </div>
                `;
            });
        }
    </script>

    <style>
        .spinner-border {
            display: inline-block;
            width: 2rem;
            height: 2rem;
            vertical-align: text-bottom;
            border: 0.25em solid currentColor;
            border-right-color: transparent;
            border-radius: 50%;
            animation: spinner-border .75s linear infinite;
        }
        @keyframes spinner-border {
            to { transform: rotate(360deg); }
        }
    </style>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\ORDER\MASTARI\E-SPP\alkahfi-digital\resources\views/admin/pengaturan/payment.blade.php ENDPATH**/ ?>