<?php

namespace App\Livewire;

use App\Models\Pelanggan;
use Livewire\Component;
use Livewire\WithPagination;

class TabelPelanggan extends Component
{
    use WithPagination;

    public $pelangganId = null;
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
        // Header tabel
        $headers = [
            ['key' => 'number', 'label' => 'No'],
            ['key' => 'No_Kontrol', 'label' => 'No Kontrol'],
            ['key' => 'Nama', 'label' => 'Nama Pelanggan'],
            ['key' => 'Alamat', 'label' => 'Alamat'],
            ['key' => 'informasi_gabungan', 'label' => 'Informasi', 'class' => 'text-left'],
            ['key' => 'actions', 'label' => 'Aksi', 'class' => 'text-center'],
            // ['key' => 'Tarif', 'label' => 'Tabel Tarif']
        ];

        // Ambil data pelanggan dengan pencarian dan pagination
        $pelanggan = Pelanggan::query()
            ->when($this->search, function ($query) {
                $query->where('Nama', 'like', '%' . $this->search . '%')
                    ->orWhere('No_Kontrol', 'like', '%' . $this->search . '%');
            })
            ->paginate($this->perPage);

        // Tambahkan nomor urut dan informasi gabungan
        $pelangganData = collect($pelanggan->items())->map(function ($item, $index) use ($pelanggan) {
            $item->number = ($pelanggan->currentPage() - 1) * $pelanggan->perPage() + $index + 1;

            // Format informasi gabungan dengan Tailwind
            $item->informasi_gabungan = "
                <div class='flex flex-col gap-1 text-sm'>
                    <div class='flex justify-between text-gray-500 font-semibold'>
                        <span>{$item->Jenis_Plg}</span>
                        <span>{$item->Telepon}</span>
                    </div>
                    <div class='text-black text-left justify-between'>{$item->Email}</div>
                </div>
            ";

            return $item;
        });


        // Ganti koleksi data di objek pagination
        $pelanggan = new \Illuminate\Pagination\LengthAwarePaginator(
            $pelangganData,
            $pelanggan->total(),
            $pelanggan->perPage(),
            $pelanggan->currentPage(),
            ['path' => \Illuminate\Pagination\Paginator::resolveCurrentPath()]
        );

        return view('livewire.tabel-pelanggan', [
            'headers' => $headers,
            'pelanggan' => $pelanggan,
        ]);
    }
}
