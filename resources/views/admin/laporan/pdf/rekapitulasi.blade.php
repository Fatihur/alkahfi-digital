<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Rekapitulasi Bulanan</title>
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
            width: 100px;
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
            padding: 10px 8px;
            text-align: left;
        }
        table.data th {
            background-color: #0ea5e9;
            color: white;
            font-weight: bold;
            text-transform: uppercase;
            font-size: 10px;
        }
        table.data tbody tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        table.data tfoot td {
            background-color: #f0f9ff;
            font-weight: bold;
        }
        .text-right {
            text-align: right;
        }
        .text-center {
            text-align: center;
        }
        .text-success {
            color: #10b981;
        }
        .text-danger {
            color: #dc2626;
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
        <h2>Rekapitulasi Tagihan & Pembayaran Bulanan</h2>
        <p>Dicetak pada: {{ date('d/m/Y H:i') }}</p>
    </div>

    <div class="info">
        <table>
            <tr>
                <td class="label">Tahun</td>
                <td>: {{ $tahun }}</td>
            </tr>
        </table>
    </div>

    <table class="data">
        <thead>
            <tr>
                <th width="30" class="text-center">No</th>
                <th>Bulan</th>
                <th class="text-right">Total Tagihan</th>
                <th class="text-right">Total Pembayaran</th>
                <th class="text-right">Selisih</th>
            </tr>
        </thead>
        <tbody>
            @php
                $grandTotalTagihan = 0;
                $grandTotalPembayaran = 0;
                $grandSelisih = 0;
            @endphp
            @foreach($rekapBulanan as $index => $rekap)
                @php
                    $grandTotalTagihan += $rekap['total_tagihan'];
                    $grandTotalPembayaran += $rekap['total_pembayaran'];
                    $grandSelisih += $rekap['selisih'];
                @endphp
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td>{{ $rekap['nama_bulan'] }}</td>
                    <td class="text-right">Rp {{ number_format($rekap['total_tagihan'], 0, ',', '.') }}</td>
                    <td class="text-right">Rp {{ number_format($rekap['total_pembayaran'], 0, ',', '.') }}</td>
                    <td class="text-right {{ $rekap['selisih'] > 0 ? 'text-danger' : 'text-success' }}">
                        Rp {{ number_format($rekap['selisih'], 0, ',', '.') }}
                    </td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td colspan="2" class="text-right">TOTAL TAHUNAN</td>
                <td class="text-right">Rp {{ number_format($grandTotalTagihan, 0, ',', '.') }}</td>
                <td class="text-right">Rp {{ number_format($grandTotalPembayaran, 0, ',', '.') }}</td>
                <td class="text-right {{ $grandSelisih > 0 ? 'text-danger' : 'text-success' }}">
                    Rp {{ number_format($grandSelisih, 0, ',', '.') }}
                </td>
            </tr>
        </tfoot>
    </table>

    <p style="font-size: 10px; color: #666; margin-top: 10px;">
        <strong>Keterangan:</strong> Selisih positif menunjukkan tagihan yang belum terbayar, selisih negatif menunjukkan kelebihan pembayaran.
    </p>

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
