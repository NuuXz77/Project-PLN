<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Pelanggan;
use App\Models\Pemakaian;
use Illuminate\Support\Facades\DB;

class PelangganTeratas extends Component
{
    public $limit = 5; // Jumlah pelanggan teratas yang ditampilkan

    public function render()
    {
        $pelangganTeratas = Pelanggan::select([
            'pelanggan.No_Kontrol',
            'pelanggan.Nama',
            DB::raw('SUM(pemakaian.JumlahPakai) as total_pemakaian')
        ])
            ->join('pemakaian', 'pelanggan.No_Kontrol', '=', 'pemakaian.No_kontrol')
            ->groupBy('pelanggan.No_Kontrol', 'pelanggan.Nama')
            ->orderByDesc('total_pemakaian')
            ->limit($this->limit)
            ->get();

        return view('livewire.pelanggan-teratas', [
            'pelangganTeratas' => $pelangganTeratas
        ]);
    }
}
