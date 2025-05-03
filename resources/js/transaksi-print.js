document.addEventListener('livewire:initialized', () => {
    Livewire.on('open-print-window', (data) => {
        // Buat konten HTML untuk dicetak
        const printContent = `
            <!DOCTYPE html>
            <html>
            <head>
                <title>Cetak Bukti Transaksi</title>
                <style>
                    body { font-family: Arial, sans-serif; margin: 20px; }
                    .header { text-align: center; margin-bottom: 20px; }
                    .title { font-size: 18px; font-weight: bold; }
                    .subtitle { font-size: 14px; margin-bottom: 10px; }
                    .divider { border-top: 1px dashed #000; margin: 15px 0; }
                    .section { margin-bottom: 15px; }
                    .section-title { font-weight: bold; margin-bottom: 5px; }
                    .row { display: flex; margin-bottom: 5px; }
                    .col { flex: 1; }
                    .text-right { text-align: right; }
                    .table { width: 100%; border-collapse: collapse; margin-top: 10px; }
                    .table th, .table td { border: 1px solid #ddd; padding: 8px; }
                    .table th { background-color: #f2f2f2; }
                    .footer { margin-top: 30px; text-align: right; }
                    @media print {
                        .no-print { display: none; }
                        body { margin: 0; padding: 10px; }
                    }
                </style>
            </head>
            <body>
                <div class="header">
                    <div class="title">BUKTI PEMBAYARAN LISTRIK</div>
                    <div class="subtitle">${data.transaksi.No_Transaksi}</div>
                </div>
                
                <div class="divider"></div>
                
                <div class="section">
                    <div class="section-title">INFORMASI TRANSAKSI</div>
                    <div class="row">
                        <div class="col">No. Transaksi</div>
                        <div class="col">: ${data.transaksi.No_Transaksi}</div>
                    </div>
                    <div class="row">
                        <div class="col">Tanggal</div>
                        <div class="col">: ${new Date(data.transaksi.TanggalPembayaran).toLocaleString()}</div>
                    </div>
                    <div class="row">
                        <div class="col">Total Tagihan</div>
                        <div class="col">: Rp ${new Intl.NumberFormat('id-ID').format(data.transaksi.TotalTagihan)}</div>
                    </div>
                    <div class="row">
                        <div class="col">Metode Pembayaran</div>
                        <div class="col">: ${data.transaksi.MetodePembayaran}</div>
                    </div>
                    <div class="row">
                        <div class="col">Status</div>
                        <div class="col">: ${data.transaksi.Status}</div>
                    </div>
                </div>
                
                <div class="divider"></div>
                
                <div class="section">
                    <div class="section-title">INFORMASI PELANGGAN</div>
                    <div class="row">
                        <div class="col">No. Kontrol</div>
                        <div class="col">: ${data.pelanggan.No_Kontrol}</div>
                    </div>
                    <div class="row">
                        <div class="col">Nama</div>
                        <div class="col">: ${data.pelanggan.Nama}</div>
                    </div>
                    <div class="row">
                        <div class="col">Alamat</div>
                        <div class="col">: ${data.pelanggan.Alamat}</div>
                    </div>
                    <div class="row">
                        <div class="col">Jenis Pelanggan</div>
                        <div class="col">: ${data.pelanggan.Jenis_Plg}</div>
                    </div>
                </div>
                
                ${data.pemakaian ? `
                <div class="divider"></div>
                
                <div class="section">
                    <div class="section-title">INFORMASI PEMAKAIAN</div>
                    <div class="row">
                        <div class="col">No. Pemakaian</div>
                        <div class="col">: ${data.pemakaian.No_Pemakaian}</div>
                    </div>
                    <div class="row">
                        <div class="col">Periode</div>
                        <div class="col">: ${new Date(data.pemakaian.TanggalCatat).toLocaleDateString()}</div>
                    </div>
                    <div class="row">
                        <div class="col">Meter Awal</div>
                        <div class="col">: ${data.pemakaian.MeterAwal} kWh</div>
                    </div>
                    <div class="row">
                        <div class="col">Meter Akhir</div>
                        <div class="col">: ${data.pemakaian.MeterAkhir} kWh</div>
                    </div>
                    <div class="row">
                        <div class="col">Pemakaian</div>
                        <div class="col">: ${data.pemakaian.JumlahPakai} kWh</div>
                    </div>
                </div>
                ` : ''}
                
                ${data.pembayaran ? `
                <div class="divider"></div>
                
                <div class="section">
                    <div class="section-title">RINCIAN PEMBAYARAN</div>
                    <table class="table">
                        <tr>
                            <th>Deskripsi</th>
                            <th class="text-right">Jumlah</th>
                        </tr>
                        <tr>
                            <td>Biaya Pemakaian</td>
                            <td class="text-right">Rp ${new Intl.NumberFormat('id-ID').format(data.pembayaran.TotalHarga)}</td>
                        </tr>
                        <tr>
                            <td>Biaya Admin</td>
                            <td class="text-right">Rp ${new Intl.NumberFormat('id-ID').format(data.pembayaran.Admin)}</td>
                        </tr>
                        <tr>
                            <td><strong>Total Bayar</strong></td>
                            <td class="text-right"><strong>Rp ${new Intl.NumberFormat('id-ID').format(data.pembayaran.TotalBayar)}</strong></td>
                        </tr>
                    </table>
                </div>
                ` : ''}
                
                <div class="divider"></div>
                
                <div class="footer">
                    <div>Terima kasih telah melakukan pembayaran</div>
                    <div style="margin-top: 50px;">(__________________)</div>
                    <div>Tanda Tangan</div>
                </div>
            </body>
            </html>
        `;

        // Buka window baru untuk cetak
        const printWindow = window.open('', '_blank');
        printWindow.document.open();
        printWindow.document.write(printContent);
        printWindow.document.close();
        
        // Tunggu konten dimuat sebelum mencetak
        printWindow.onload = function() {
            setTimeout(() => {
                printWindow.print();
                printWindow.close();
            }, 200);
        };
    });
});