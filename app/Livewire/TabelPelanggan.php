<?php

namespace App\Livewire;

use App\Models\Pelanggan;
use Livewire\Component;
use Livewire\WithPagination;

class TabelPelanggan extends Component
{
    use WithPagination;
    public $pelangganId = null; // ID pelanggan yang sedang diedit

    public $search = ''; // Properti untuk menyimpan nilai pencarian
    public $perPage = 5; // Jumlah item per halaman
    // Daftarkan event listener untuk menerima nilai pencarian
    protected $listeners = [
        'searchUpdated' => 'updateSearch',
        'addSuccess' => 'refreshTable',
        'editSuccess' => 'refreshTable',
        'deleteSuccess' => 'refreshTable',
    ];

    public function refreshTable(){
        $this->resetPage();
    }

    public function DeleteModal(){
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
            ['key' => 'number', 'label' => 'No'], // Tambah nomor urut dinamis
            ['key' => 'No_Kontrol', 'label' => 'No Kontrol'],
            ['key' => 'Nama', 'label' => 'Nama Pelanggan'],
            ['key' => 'Alamat', 'label' => 'Alamat'],
            ['key' => 'Telepon', 'label' => 'Telepon'],
            ['key' => 'Email', 'label' => 'Email'],
            ['key' => 'Jenis_Plg', 'label' => 'Jenis Pelanggan'],
            // ['key' => 'Daya', 'label' => 'Daya'],
            ['key' => 'Tarif', 'label' => 'Tabel Tarif'],
        ];
        // Ambil data pelanggan dengan pencarian dan pagination
        $pelanggan = Pelanggan::query()
            ->when($this->search, function ($query) {
                $query->where('Nama', 'like', '%' . $this->search . '%')
                    ->orWhere('No_Kontrol', 'like', '%' . $this->search . '%');
            })
            ->paginate($this->perPage);

        // Tambahkan nomor urut dinamis
        collect($pelanggan->items())->transform(function ($item, $index) use ($pelanggan) {
            $item->number = ($pelanggan->currentPage() - 1) * $pelanggan->perPage() + $index + 1;
            return $item;
        });

        return view('livewire.tabel-pelanggan', [
            'headers' => $headers,
            'pelanggan' => $pelanggan,
        ]);
    }
}
