<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Bukti Pembayaran - <?php echo e($pembayaran->nomor_transaksi); ?></title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Segoe UI', sans-serif; font-size: 14px; padding: 20px; }
        .container { max-width: 400px; margin: 0 auto; border: 1px solid #ddd; padding: 20px; }
        .header { text-align: center; border-bottom: 2px dashed #ddd; padding-bottom: 15px; margin-bottom: 15px; }
        .header h1 { font-size: 18px; margin-bottom: 5px; }
        .header p { font-size: 12px; color: #666; }
        .info { margin-bottom: 15px; }
        .info-row { display: flex; justify-content: space-between; padding: 5px 0; border-bottom: 1px dotted #eee; }
        .info-row:last-child { border-bottom: none; }
        .label { color: #666; }
        .value { font-weight: 500; text-align: right; }
        .total { background: #f5f5f5; padding: 15px; text-align: center; margin: 15px 0; border-radius: 5px; }
        .total .amount { font-size: 24px; font-weight: bold; color: #16a34a; }
        .status { text-align: center; padding: 10px; background: #dcfce7; color: #16a34a; border-radius: 5px; font-weight: bold; }
        .footer { text-align: center; margin-top: 20px; font-size: 12px; color: #666; }
        @media print { body { padding: 0; } .container { border: none; } }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1><?php echo e(config('app.name')); ?></h1>
            <p>Bukti Pembayaran SPP</p>
        </div>

        <div class="info">
            <div class="info-row"><span class="label">No. Transaksi</span><span class="value"><?php echo e($pembayaran->nomor_transaksi); ?></span></div>
            <div class="info-row"><span class="label">Tanggal</span><span class="value"><?php echo e($pembayaran->tanggal_bayar?->format('d/m/Y H:i')); ?></span></div>
        </div>

        <div class="info">
            <div class="info-row"><span class="label">NIS</span><span class="value"><?php echo e($pembayaran->santri->nis); ?></span></div>
            <div class="info-row"><span class="label">Nama Santri</span><span class="value"><?php echo e($pembayaran->santri->nama_lengkap); ?></span></div>
            <div class="info-row"><span class="label">Kelas</span><span class="value"><?php echo e($pembayaran->santri->kelas->nama_kelas ?? '-'); ?></span></div>
        </div>

        <div class="info">
            <div class="info-row"><span class="label">Tagihan</span><span class="value"><?php echo e($pembayaran->tagihan->nama_tagihan); ?></span></div>
            <div class="info-row"><span class="label">Periode</span><span class="value"><?php echo e($pembayaran->tagihan->periode ?? '-'); ?></span></div>
            <div class="info-row"><span class="label">Metode</span><span class="value"><?php echo e(ucfirst($pembayaran->metode_pembayaran)); ?></span></div>
        </div>

        <div class="total">
            <div style="font-size:12px;color:#666;">Total Pembayaran</div>
            <div class="amount">Rp <?php echo e(number_format($pembayaran->jumlah_bayar, 0, ',', '.')); ?></div>
        </div>

        <div class="status">LUNAS</div>

        <div class="footer">
            <p>Terima kasih atas pembayaran Anda</p>
            <p><?php echo e(now()->format('d/m/Y H:i')); ?></p>
        </div>
    </div>
    <script>window.onload = function() { window.print(); }</script>
</body>
</html>
<?php /**PATH D:\ORDER\MASTARI\E-SPP\alkahfi-digital\resources\views/bendahara/pembayaran/cetak.blade.php ENDPATH**/ ?>