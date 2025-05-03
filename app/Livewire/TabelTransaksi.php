<?php

namespace App\Livewire;

use App\Models\Transaksi;
use Livewire\Component;
use Livewire\WithPagination;

class TabelTransaksi extends Component
{
    use WithPagination;

    public $search = '';
    public $perPage = 5;

    protected $listeners = [
        'searchUpdated' => 'updateSearch',
        'refreshTable' => 'refreshTable'
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
            ['key' => 'No_Transaksi', 'label' => 'No Transaksi'],
            ['key' => 'No_Pemakaian', 'label' => 'No Pemakaian'],
            ['key' => 'No_Kontrol', 'label' => 'No Kontrol'],
            ['key' => 'TanggalPembayaran', 'label' => 'Tanggal'],
            ['key' => 'TotalTagihan', 'label' => 'Total Tagihan'],
            ['key' => 'MetodePembayaran', 'label' => 'Metode'],
            ['key' => 'Status', 'label' => 'Status'],
            ['key' => 'actions', 'label' => 'Aksi', 'class' => 'text-center'],
        ];

        $transaksi = Transaksi::query()
            ->when($this->search, function ($query) {
                $query->where('No_Transaksi', 'like', '%' . $this->search . '%')
                    ->orWhere('No_Kontrol', 'like', '%' . $this->search . '%')
                    ->orWhere('No_Pemakaian', 'like', '%' . $this->search . '%');
            })
            ->latest('TanggalPembayaran')
            ->paginate($this->perPage);

        // Add row numbers
        $items = collect($transaksi->items())->transform(function ($item, $index) use ($transaksi) {
            $item->number = ($transaksi->currentPage() - 1) * $transaksi->perPage() + $index + 1;
            return $item;
        });

        $transaksi = new \Illuminate\Pagination\LengthAwarePaginator(
            $items,
            $transaksi->total(),
            $transaksi->perPage(),
            $transaksi->currentPage(),
            ['path' => $transaksi->path()]
        );

        return view('livewire.tabel-transaksi', [
            'headers' => $headers,
            'transaksi' => $transaksi,
        ]);
    }
}
