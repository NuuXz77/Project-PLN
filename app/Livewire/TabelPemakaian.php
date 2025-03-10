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

    // Daftarkan event listener untuk menerima nilai pencarian
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
        $headers = [
            ['key' => 'number', 'label' => 'No'],
            ['key' => 'No_Pemakaian', 'label' => 'No Pemakaian'],
            ['key' => 'No_kontrol', 'label' => 'No Kontrol'],
            ['key' => 'TanggalCatat', 'label' => 'Tanggal Catat'],
            ['key' => 'MeterAwal', 'label' => 'Meter Awal'],
            ['key' => 'MeterAkhir', 'label' => 'Meter Akhir'],
            ['key' => 'JumlahPakai', 'label' => 'Jumlah Pakai'],
            ['key' => 'BiayaBebanPemakaian', 'label' => 'Biaya Beban'],
            ['key' => 'BiayaPemakaian', 'label' => 'Biaya Pemakaian'],
            ['key' => 'StatusPembayaran', 'label' => 'Status Pembayaran'],
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
            $item->number = ($pemakaian->currentPage() - 1) * $pemakaian->perPage() + $index + 1;
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
