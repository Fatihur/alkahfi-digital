<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Bukti Pembayaran - {{ $pembayaran->nomor_transaksi }}</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Arial', sans-serif; font-size: 12px; line-height: 1.5; padding: 20px; }
        .container { max-width: 400px; margin: 0 auto; border: 2px solid #333; padding: 20px; }
        .header { text-align: center; margin-bottom: 20px; padding-bottom: 15px; border-bottom: 2px dashed #333; }
        .header h1 { font-size: 18px; margin-bottom: 5px; }
        .header p { color: #666; font-size: 11px; }
        .info-row { display: flex; justify-content: space-between; margin-bottom: 8px; }
        .info-row .label { color: #666; }
        .info-row .value { font-weight: bold; text-align: right; }
        .divider { border-top: 1px dashed #333; margin: 15px 0; }
        .total-row { font-size: 16px; font-weight: bold; background: #f5f5f5; padding: 10px; margin: 15px -20px; }
        .footer { text-align: center; margin-top: 20px; padding-top: 15px; border-top: 2px dashed #333; font-size: 10px; color: #666; }
        .badge { display: inline-block; padding: 3px 8px; border-radius: 4px; font-size: 10px; background: #28a745; color: white; }
        @media print { body { padding: 0; } .container { border: none; } }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>BUKTI PEMBAYARAN SPP</h1>
            <p>ALKAHFI DIGITAL - Sistem Pembayaran SPP Santri</p>
        </div>

        <div class="info-row">
            <span class="label">No. Transaksi</span>
            <span class="value">{{ $pembayaran->nomor_transaksi }}</span>
        </div>
        <div class="info-row">
            <span class="label">Tanggal</span>
            <span class="value">{{ $pembayaran->tanggal_bayar->format('d/m/Y H:i') }}</span>
        </div>

        <div class="divider"></div>

        <div class="info-row">
            <span class="label">NIS</span>
            <span class="value">{{ $pembayaran->santri->nis }}</span>
        </div>
        <div class="info-row">
            <span class="label">Nama Santri</span>
            <span class="value">{{ $pembayaran->santri->nama_lengkap }}</span>
        </div>
        <div class="info-row">
            <span class="label">Kelas</span>
            <span class="value">{{ $pembayaran->santri->kelas->nama_kelas ?? '-' }}</span>
        </div>

        <div class="divider"></div>

        <div class="info-row">
            <span class="label">Pembayaran Untuk</span>
            <span class="value">{{ $pembayaran->tagihan->nama_tagihan }}</span>
        </div>
        <div class="info-row">
            <span class="label">Periode</span>
            <span class="value">{{ $pembayaran->tagihan->periode ?? '-' }}</span>
        </div>
        <div class="info-row">
            <span class="label">Metode</span>
            <span class="value">{{ ucfirst($pembayaran->metode_pembayaran) }}</span>
        </div>

        <div class="total-row">
            <div class="info-row" style="margin: 0;">
                <span>TOTAL BAYAR</span>
                <span>Rp {{ number_format($pembayaran->jumlah_bayar, 0, ',', '.') }}</span>
            </div>
        </div>

        <div style="text-align: center; margin: 10px 0;">
            <span class="badge">LUNAS</span>
        </div>

        <div class="footer">
            <p>Bukti pembayaran ini sah dan dikeluarkan secara elektronik.</p>
            <p>Dicetak pada: {{ now()->format('d/m/Y H:i') }}</p>
        </div>
    </div>

    <script>window.onload = function() { window.print(); }</script>
</body>
</html>
