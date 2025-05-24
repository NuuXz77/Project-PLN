<?php

namespace App\Livewire;

use App\Models\Pemakaian;
use Livewire\Component;
use Livewire\WithPagination;

class TabelPemakaian extends Component
{
    use WithPagination;

    public $search = '';
    public $perPage = 5;

    protected $listeners = [
        'searchUpdated' => 'updateSearch',
        'addSuccess' => 'refreshTable',
        'editSuccess' => 'refreshTable',
        'deleteSuccess' => 'refreshTable',
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

    public function render()
    {
        $headerClass = 'bg-gray-100 text-gray-800 dark:bg-gray-800 dark:text-gray-100';

        $headers = [
            ['key' => 'number', 'label' => 'No', 'class' => 'text-center'],
            ['key' => 'No_Pemakaian', 'label' => 'No Pemakaian'],
            ['key' => 'No_kontrol', 'label' => 'No Kontrol'],
            // ['key' => 'meter_gabungan', 'label' => 'Meter Awalㅤ|ㅤMeter Akhir', 'class' => 'text-center'],
            // ['key' => 'JumlahPakai', 'label' => 'Jumlah Pakai', 'class' => 'text-center'],
            ['key' => 'biaya_gabungan', 'label' => 'Biaya Bebanㅤ|ㅤBiaya Pemakaian', 'class' => 'text-center'], // Kolom baru untuk Biaya Beban, Biaya Pemakaian, dan Status Pembayaran
            ['key' => 'actions', 'label' => 'Aksi', 'class' => 'text-center'],
        ];

        $pemakaian = Pemakaian::query()
            ->with('pelanggan')
            ->when($this->search, function ($query) {
                $query->whereHas('pelanggan', function ($q) {
                    $q->where('Nama', 'like', '%' . $this->search . '%')
                        ->orWhere('No_Kontrol', 'like', '%' . $this->search . '%');
                });
            })
            ->paginate($this->perPage);

        collect($pemakaian->items())->transform(function ($item, $index) use ($pemakaian) {
            // Hitung nomor urut berdasarkan paginasi
            $item->number = ($pemakaian->currentPage() - 1) * $pemakaian->perPage() + $index + 1;

            // Gabungkan Meter Awal dan Meter Akhir
            $item->meter_gabungan = "
            <div class='flex justify-between'>
                <span>" . ($item->MeterAwal ?? 'N/A') . "</span>
                <span>" . ($item->MeterAkhir ?? 'N/A') . "</span>
            </div>
        ";

            // Tentukan kelas badge berdasarkan status pembayaran
            $statusClass = $item->StatusPembayaran == 'Belum Lunas' ? 'badge-error' : 'badge-success';

            // Gabungkan Biaya Beban, Biaya Pemakaian, dan Status Pembayaran
            $item->biaya_gabungan = "
            <div>
                <div class='flex justify-between text-center'>
                    <span>" . ($item->BiayaBebanPemakaian ?? 'N/A') . "</span>
                    <span>" . ($item->BiayaPemakaian ?? 'N/A') . "</span>
                </div>
                <div class='mt-1 text-center'>
                    <span class='badge $statusClass'>" . ($item->StatusPembayaran ?? 'N/A') . "</span>
                </div>
            </div>
        ";

            return $item;
        });

        return view('livewire.tabel-pemakaian', [
            'headers' => $headers,
            'pemakaian' => $pemakaian,
        ]);
    }

    public function showPemakaian($id)
    {
        // Implementasi untuk menampilkan detail pemakaian
    }

    public function editPemakaian($id)
    {
        // Implementasi untuk mengedit data pemakaian
    }

    public function deletePemakaian($id)
    {
        Pemakaian::findOrFail($id)->delete();
        $this->resetPage();
    }
}
