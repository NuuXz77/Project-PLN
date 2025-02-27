<?php

namespace App\Livewire;

use App\Models\Pelanggan;
use Livewire\Component;

class TabelPelanggan extends Component
{
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
            ['key' => 'actions', 'label' => 'Aksi'],
        ];

        // Ambil data pelanggan dengan pagination
        $pelanggan = Pelanggan::paginate(5);

        // Tambahkan nomor urut dinamis
        $pelanggan->getCollection()->transform(function ($item, $index) use ($pelanggan) {
            $item->number = ($pelanggan->currentPage() - 1) * $pelanggan->perPage() + $index + 1;
            return $item;
        });

        return view('livewire.tabel-pelanggan', [
            'headers' => $headers,
            'pelanggan' => $pelanggan,
        ]);
    }
}
