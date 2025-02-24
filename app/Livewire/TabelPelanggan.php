<?php

namespace App\Livewire;

use App\Models\Pelanggan;
use Livewire\Component;

class TabelPelanggan extends Component
{
    public function render()
    {
        $headers = [
            ['key' => 'ID_Pelanggan', 'label' => 'No'], // Primary key
            ['key' => 'No_Kontrol', 'label' => 'No Kontrol'], // Primary key
            ['key' => 'Nama', 'label' => 'Nama Pelanggan'], // Kolom Nama
            ['key' => 'Alamat', 'label' => 'Alamat'], // Kolom Alamat
            ['key' => 'Telepon', 'label' => 'Telepon'], // Kolom Telepon
            ['key' => 'Email', 'label' => 'Email'], // Kolom Email
            ['key' => 'Jenis_Plg', 'label' => 'Jenis Pelanggan'], // Kolom Jenis_Plg (enum)
            ['key' => 'actions', 'label' => 'Aksi'], // Kolom aksi
        ];

        return view(
            'livewire.tabel-pelanggan',
            [
                'headers' => $headers,
                'pelanggan' => Pelanggan::paginate(2),
            ]
        );
    }
}
