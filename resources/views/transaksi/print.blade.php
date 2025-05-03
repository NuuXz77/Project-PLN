<!DOCTYPE html>
<html>
<head>
    <title>Cetak Bukti Transaksi</title>
    <style>
        @page {
            size: 80mm 200mm; /* Ukuran struk kecil */
            margin: 5mm;
        }
        body {
            font-family: 'Courier New', monospace;
            font-size: 12px;
            margin: 0;
            padding: 5px;
            width: 70mm;
        }
        .logo {
            text-align: center;
            margin-bottom: 5px;
        }
        .logo img {
            max-width: 50mm;
            max-height: 20mm;
        }
        .header {
            text-align: center;
            margin-bottom: 5px;
        }
        .title {
            font-weight: bold;
            font-size: 14px;
            margin-bottom: 3px;
        }
        .subtitle {
            font-size: 10px;
            margin-bottom: 5px;
        }
        .divider {
            border-top: 1px dashed #000;
            margin: 5px 0;
        }
        .section {
            margin-bottom: 5px;
        }
        .section-title {
            font-weight: bold;
            text-align: center;
            margin-bottom: 3px;
            font-size: 11px;
            background-color: #f0f0f0;
            padding: 2px;
        }
        .row {
            display: flex;
            margin-bottom: 2px;
        }
        .col {
            flex: 1;
        }
        .col-30 {
            width: 30%;
        }
        .col-70 {
            width: 70%;
        }
        .text-right {
            text-align: right;
        }
        .text-center {
            text-align: center;
        }
        .table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 3px;
            font-size: 10px;
        }
        .table th, .table td {
            padding: 2px 0;
            border-bottom: 1px dashed #ddd;
        }
        .paid-sticker {
            text-align: center;
            margin: 5px 0;
            padding: 3px;
            background-color: #4CAF50;
            color: white;
            font-weight: bold;
            border-radius: 3px;
            transform: rotate(-5deg);
        }
        .footer {
            margin-top: 5px;
            font-size: 9px;
            text-align: center;
            border-top: 1px dashed #000;
            padding-top: 3px;
        }
        .print-info {
            font-size: 8px;
            text-align: center;
            margin-top: 3px;
            color: #777;
        }
        @media print {
            .no-print {
                display: none;
            }
            body {
                width: 70mm;
                margin: 0 auto;
            }
        }
    </style>
</head>
<body>
    <!-- Logo Perusahaan -->
    <div class="logo">
        <!-- Ganti dengan path logo Anda -->
        <img src="data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSIxMDAiIGhlaWdodD0iNDAiIHZpZXdCb3g9IjAgMCAxMDAgNDAiPjxyZWN0IHdpZHRoPSIxMDAiIGhlaWdodD0iNDAiIGZpbGw9IiMzMTk2RjMiLz48dGV4dCB4PSI1MCIgeT0iMjUiIGZvbnQtZmFtaWx5PSJBcmlhbCIgZm9udC1zaXplPSIxMCIgZmlsbD0id2hpdGUiIHRleHQtYW5jaG9yPSJtaWRkbGUiPkxJU1RSSUsgTUFOQUpFPC90ZXh0Pjwvc3ZnPg==" alt="Logo Perusahaan">
    </div>

    <!-- Header Struk -->
    <div class="header">
        <div class="title">BUKTI PEMBAYARAN LISTRIK</div>
        <div class="subtitle">No. {{ $transaksi->No_Transaksi }}</div>
    </div>
    
    <div class="divider"></div>
    
    <!-- Info Transaksi -->
    <div class="section">
        <div class="section-title">TRANSAKSI</div>
        <div class="row">
            <div class="col-30">Tgl Bayar</div>
            <div class="col-70">: {{ \Carbon\Carbon::parse($transaksi->TanggalPembayaran)->format('d/m/Y H:i') }}</div>
        </div>
        <div class="row">
            <div class="col-30">Metode</div>
            <div class="col-70">: {{ $transaksi->MetodePembayaran }}</div>
        </div>
        <div class="row">
            <div class="col-30">Total</div>
            <div class="col-70">: Rp {{ number_format($transaksi->TotalTagihan, 0, ',', '.') }}</div>
        </div>
    </div>
    
    <div class="divider"></div>
    
    <!-- Info Pelanggan -->
    <div class="section">
        <div class="section-title">PELANGGAN</div>
        <div class="row">
            <div class="col-30">ID Pelanggan</div>
            <div class="col-70">: {{ $pelanggan->No_Kontrol }}</div>
        </div>
        <div class="row">
            <div class="col-30">Nama</div>
            <div class="col-70">: {{ $pelanggan->Nama }}</div>
        </div>
        <div class="row">
            <div class="col-30">Alamat</div>
            <div class="col-70">: {{ substr($pelanggan->Alamat, 0, 30) }}{{ strlen($pelanggan->Alamat) > 30 ? '...' : '' }}</div>
        </div>
    </div>
    
    @if($pemakaian)
    <div class="divider"></div>
    
    <!-- Info Pemakaian -->
    <div class="section">
        <div class="section-title">PEMAKAIAN</div>
        <div class="row">
            <div class="col-30">Periode</div>
            <div class="col-70">: {{ \Carbon\Carbon::parse($pemakaian->TanggalCatat)->format('M Y') }}</div>
        </div>
        <div class="row">
            <div class="col-30">Meter</div>
            <div class="col-70">: {{ $pemakaian->MeterAwal }} - {{ $pemakaian->MeterAkhir }} kWh</div>
        </div>
        <div class="row">
            <div class="col-30">Pakai</div>
            <div class="col-70">: {{ $pemakaian->JumlahPakai }} kWh</div>
        </div>
    </div>
    @endif
    
    @if($pembayaran)
    <div class="divider"></div>
    
    <!-- Rincian Pembayaran -->
    <div class="section">
        <div class="section-title">RINCIAN</div>
        <table class="table">
            <tr>
                <td>Tagihan Listrik</td>
                <td class="text-right">Rp {{ number_format($pembayaran->TotalHarga, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td>Biaya Admin</td>
                <td class="text-right">Rp {{ number_format($pembayaran->Admin, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td><strong>TOTAL</strong></td>
                <td class="text-right"><strong>Rp {{ number_format($pembayaran->TotalBayar, 0, ',', '.') }}</strong></td>
            </tr>
        </table>
    </div>
    @endif
    
    <!-- Stiker Lunas -->
    <div class="paid-sticker">
        PEMBAYARAN LUNAS
    </div>
    
    <!-- Footer -->
    <div class="footer">
        <div>Terima kasih telah membayar tepat waktu</div>
        <div>PLN Manaje</div>
        <div>Jl. Listrik No. 123, Kota Anda</div>
        <div>Telp: (021) 12345678</div>
    </div>
    
    <!-- Info Cetak -->
    <div class="print-info">
        Dicetak: {{ \Carbon\Carbon::now()->format('d/m/Y H:i:s') }}
    </div>

    <!-- Tombol untuk pratinjau (tidak tercetak) -->
    <div class="no-print" style="text-align: center; margin-top: 10px;">
        <button onclick="window.print()" style="padding: 5px 10px; background: #4CAF50; color: white; border: none; border-radius: 3px; cursor: pointer; font-size: 10px;">
            Cetak
        </button>
        <a href="/transaksi" style="padding: 5px 10px; background: #f44336; color: white; border: none; border-radius: 3px; cursor: pointer; margin-left: 5px; font-size: 10px; text-decoration:none;">
            Tutup
        </a>
    </div>

    <script>
        // Auto print dan close setelah cetak
        window.onload = function() {
            window.print();
            setTimeout(function() {
                window.close();
            }, 1000);
        }
    </script>
</body>
</html>