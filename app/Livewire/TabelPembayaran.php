<?php

namespace App\Livewire;

use App\Models\Pemakaian;
use App\Models\Pembayaran;
use Livewire\Component;
use Livewire\WithPagination;

class TabelPembayaran extends Component
{
    use WithPagination;

    public $search = '';
    public $perPage = 5;

    protected $listeners = [
        'searchUpdated' => 'updateSearch',
        'refreshTable' => 'refreshTable',
    ];

    public function refreshTable()
    {
        $this->resetPage();
    }

    public function updateSearch($value)
    {
        $this->search = $value;
        $this->resetPage();
    }

    public function generateNoPembayaran($noKontrol, $noPemakaian)
    {
        // Hitung jumlah pembayaran dengan No_Pemakaian yang sama
        $countPemakaian = Pemakaian::where('No_Pemakaian', $noPemakaian)->count() + 1;

        // Format nomor urut dengan leading zeros (3 digit)
        $nomorUrut = str_pad($countPemakaian, 3, '0', STR_PAD_LEFT);

        // Format tanggal sekarang (DDMMYYYY)
        $tanggalSekarang = now()->format('dmY');

        // Gabungkan semua bagian
        return "PMB/{$noKontrol}/{$noPemakaian}-{$nomorUrut}-{$tanggalSekarang}";
    }

    public function render()
    {
        $headers = [
            ['key' => 'number', 'label' => 'No'],
            ['key' => 'No_Pembayaran', 'label' => 'No Pembayaran'],
            ['key' => 'No_Pemakaian', 'label' => 'No Pemakaian'],
            ['key' => 'No_Kontrol', 'label' => 'No Kontrol'],
            ['key' => 'Nama', 'label' => 'Nama Pelanggan'],
            ['key' => 'stand_meter', 'label' => 'Stand Meter'],
            ['key' => 'total', 'label' => 'Harga & Admin'],
            ['key' => 'total_bayar', 'label' => 'Total Bayar'],
            ['key' => 'actions', 'label' => 'Aksi', 'class' => 'text-center'],
        ];

        $adminBiaya = 2500;

        $pemakaian = Pemakaian::with(['pelanggan.tarif'])
            ->when($this->search, function ($query) {
                $query->where('No_Pemakaian', 'like', '%' . $this->search . '%')
                    ->orWhere('No_Kontrol', 'like', '%' . $this->search . '%')
                    ->orWhereHas('pelanggan', function ($q) {
                        $q->where('Nama', 'like', '%' . $this->search . '%');
                    });
            })
            ->paginate($this->perPage);

        $pembayaranData = collect($pemakaian->items())->map(function ($item, $index) use ($pemakaian, $adminBiaya) {
            $item->number = ($pemakaian->currentPage() - 1) * $pemakaian->perPage() + $index + 1;

            $NoPembayaran = Pembayaran::all();
            // Data dasar
            $standAwal = $item->MeterAwal ?? 0;
            $standAkhir = $item->MeterAkhir ?? 0;
            $jumlahPakai = max(0, $standAkhir - $standAwal); // Pastikan tidak negatif

            // Data tarif dari relasi
            $tarif = $item->pelanggan->tarif ?? null;
            $biayaBeban = $tarif->BiayaBeban ?? 0;
            $tarifPerKwh = $tarif->TarifKWH ?? 0;

            // Perhitungan yang benar:
            $biayaPemakaian = $jumlahPakai * $tarifPerKwh;
            $totalHarga = $biayaBeban + $biayaPemakaian;
            $totalBayar = $totalHarga + $adminBiaya;

            // Format output
            $item->No_Pemakaian = $item->No_Pemakaian;
            $item->No_Kontrol = $item->pelanggan->No_Kontrol ?? '-';
            $item->Nama = $item->pelanggan->Nama ?? '-';

            $item->stand_meter = "<span class='text-sm'>Awal: <b>{$standAwal}</b> | Akhir: <b>{$standAkhir}</b></span>";

            $item->total = "
        <div class='text-sm'>
            <div>Beban: <b>Rp " . number_format($biayaBeban, 0, ',', '.') . "</b></div>
            <div>Pemakaian: <b>Rp " . number_format($biayaPemakaian, 0, ',', '.') . "</b></div>
            <div>Admin: <b>Rp " . number_format($adminBiaya, 0, ',', '.') . "</b></div>
        </div>
    ";

            $item->total_bayar = "<span class='font-semibold'>Rp " . number_format($totalBayar, 0, ',', '.') . "</span>";

            // Simpan nilai untuk keperluan lain
            // Tambahkan data pembayaran ke item
            $item->ID_Pembayaran;

            $item->No_Pembayaran;
            // dd($item->NoPembayaran->No_Pembayaran);
            $item->BiayaBeban = $biayaBeban;
            $item->BiayaPemakaian = $biayaPemakaian;
            $item->Admin = $adminBiaya;
            $item->TotalBayar = $totalBayar;

            // Cek apakah pembayaran sudah ada berdasarkan No_Pemakaian
            $pembayaran = Pembayaran::where('No_Kontrol', $item->No_Kontrol)->first();

            if ($pembayaran) {
                // Jika pembayaran sudah ada, ambil No_Pembayaran dari pembayaran yang ada
                $item->No_Pembayaran = $pembayaran->No_Pembayaran;
            } else {
                // Kalau belum ada, buat pembayaran baru
                $noPembayaranBaru = $this->generateNoPembayaran(
                    $item->pelanggan->No_Kontrol ?? 'NOKONTROL',
                    $item->No_Pemakaian
                );

                // Simpan pembayaran baru ke database
                Pembayaran::create([
                    'No_Pembayaran' => $noPembayaranBaru,
                    'No_Pemakaian' => $item->No_Pemakaian,
                    'No_Kontrol' => $item->pelanggan->No_Kontrol ?? '-',
                    'Nama' => $item->pelanggan->Nama ?? '-',
                    'No_Tarif' => $item->pelanggan->tarif->No_Tarif ?? null,
                    'StandMeter' => $standAwal . '/' . $standAkhir,
                    'TotalHarga' => $totalHarga,
                    'Admin' => $adminBiaya,
                    'TotalBayar' => $totalBayar,
                ]);

                // Setelah pembayaran baru dibuat, set No_Pembayaran pada item
                $item->No_Pembayaran = $noPembayaranBaru;
            }


            return $item;
        });


        $pembayaran = new \Illuminate\Pagination\LengthAwarePaginator(
            $pembayaranData,
            $pemakaian->total(),
            $pemakaian->perPage(),
            $pemakaian->currentPage(),
            ['path' => \Illuminate\Pagination\Paginator::resolveCurrentPath()]
        );

        return view('livewire.tabel-pembayaran', [
            'headers' => $headers,
            'pembayaran' => $pembayaran,
        ]);
    }
}
