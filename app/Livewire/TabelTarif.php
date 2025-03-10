<?php

namespace App\Livewire;

use App\Models\Tarif;
use Livewire\Component;
use Livewire\WithPagination;

class TabelTarif extends Component
{
    use WithPagination;

    public $search = ''; // Properti untuk menyimpan nilai pencarian
    public $perPage = 5; // Jumlah item per halaman

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
        // Header tabel
        $headers = [
            ['key' => 'number', 'label' => 'No'], // Tambah nomor urut dinamis
            ['key' => 'No_Tarif', 'label' => 'No Tarif'],
            ['key' => 'Jenis_Plg', 'label' => 'Jenis Pelanggan'],
            ['key' => 'Daya', 'label' => 'Daya'],
            ['key' => 'BiayaBeban', 'label' => 'Biaya Beban'],
            ['key' => 'TarifKWH', 'label' => 'Tarif KWH'],
        ];

        // Ambil data tarif dengan pencarian dan pagination
        $tarif = Tarif::query()
            ->when($this->search, function ($query) {
                $query->where('No_Tarif', 'like', '%' . $this->search . '%')
                    ->orWhere('Jenis_Plg', 'like', '%' . $this->search . '%');
            })
            ->paginate($this->perPage);

        // Tambahkan nomor urut dinamis
        collect($tarif->items())->transform(function ($item, $index) use ($tarif) {
            $item->number = ($tarif->currentPage() - 1) * $tarif->perPage() + $index + 1;
            return $item;
        });

        return view('livewire.tabel-tarif', [
            'headers' => $headers,
            'tarif' => $tarif,
        ]);
    }
}
