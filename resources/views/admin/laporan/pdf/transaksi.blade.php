<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Transaksi</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 11px;
            line-height: 1.4;
            color: #333;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 2px solid #333;
            padding-bottom: 15px;
        }
        .header h1 {
            font-size: 18px;
            margin-bottom: 5px;
            text-transform: uppercase;
        }
        .header h2 {
            font-size: 14px;
            font-weight: normal;
            margin-bottom: 5px;
        }
        .header p {
            font-size: 10px;
            color: #666;
        }
        .info {
            margin-bottom: 15px;
        }
        .info table {
            width: 100%;
        }
        .info td {
            padding: 3px 0;
        }
        .info .label {
            width: 120px;
            font-weight: bold;
        }
        table.data {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }
        table.data th,
        table.data td {
            border: 1px solid #ddd;
            padding: 8px 6px;
            text-align: left;
        }
        table.data th {
            background-color: #4f46e5;
            color: white;
            font-weight: bold;
            text-transform: uppercase;
            font-size: 10px;
        }
        table.data tbody tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        table.data tfoot td {
            background-color: #f0f0f0;
            font-weight: bold;
        }
        .text-right {
            text-align: right;
        }
        .text-center {
            text-align: center;
        }
        .footer {
            margin-top: 30px;
            text-align: right;
        }
        .footer .signature {
            display: inline-block;
            text-align: center;
            margin-top: 10px;
        }
        .footer .signature .line {
            border-bottom: 1px solid #333;
            width: 150px;
            margin: 50px auto 5px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Pondok Pesantren Al-Kahfi</h1>
        <h2>Laporan Transaksi Pembayaran</h2>
        <p>Dicetak pada: {{ date('d/m/Y H:i') }}</p>
    </div>

    <div class="info">
        <table>
            <tr>
                <td class="label">Periode</td>
                <td>: {{ $tanggalDari }} s/d {{ $tanggalSampai }}</td>
            </tr>
            <tr>
                <td class="label">Jumlah Transaksi</td>
                <td>: {{ $pembayaran->count() }} transaksi</td>
            </tr>
        </table>
    </div>

    <table class="data">
        <thead>
            <tr>
                <th width="30" class="text-center">No</th>
                <th width="100">No. Transaksi</th>
                <th>Nama Santri</th>
                <th width="70">NIS</th>
                <th>Tagihan</th>
                <th width="100" class="text-right">Jumlah</th>
                <th width="60">Metode</th>
                <th width="90">Tanggal</th>
            </tr>
        </thead>
        <tbody>
            @forelse($pembayaran as $index => $p)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td>{{ $p->nomor_transaksi }}</td>
                    <td>{{ $p->santri->nama_lengkap }}</td>
                    <td>{{ $p->santri->nis }}</td>
                    <td>{{ $p->tagihan->nama_tagihan }}</td>
                    <td class="text-right">Rp {{ number_format($p->jumlah_bayar, 0, ',', '.') }}</td>
                    <td>{{ ucfirst($p->metode_pembayaran) }}</td>
                    <td>{{ $p->tanggal_bayar->format('d/m/Y H:i') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" class="text-center">Tidak ada data transaksi</td>
                </tr>
            @endforelse
        </tbody>
        <tfoot>
            <tr>
                <td colspan="5" class="text-right">TOTAL PEMBAYARAN</td>
                <td class="text-right">Rp {{ number_format($totalPembayaran, 0, ',', '.') }}</td>
                <td colspan="2"></td>
            </tr>
        </tfoot>
    </table>

    <div class="footer">
        <div class="signature">
            <p>Mengetahui,</p>
            <p>Bendahara</p>
            <div class="line"></div>
            <p>(_______________________)</p>
        </div>
    </div>
</body>
</html>
