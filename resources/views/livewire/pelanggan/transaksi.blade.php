<?php

use Livewire\Volt\Component;
use App\Models\Pelanggan;

new class extends Component {
    public array $myChart = [
        'type' => 'doughnut',
        'data' => [
            'labels' => [],
            'datasets' => [
                [
                    'label' => '# of Customers',
                    'data' => [],
                ]
            ]
        ]
    ];

    public function mount()
    {
        // Ambil data dari tabel Pelanggan
        $pelangganData = Pelanggan::selectRaw('jenis_Plg, count(*) as total')
            ->groupBy('jenis_Plg')
            ->get();

        // Isi labels dan data untuk chart
        $labels = [];
        $data = [];
        foreach ($pelangganData as $pelanggan) {
            $labels[] = $pelanggan->jenis_Plg;
            $data[] = $pelanggan->total;
        }

        $this->myChart['data']['labels'] = $labels;
        $this->myChart['data']['datasets'][0]['data'] = $data;
    }
}; ?>

<div>
    <x-mary-header title="Jenis Pelanggan" subtitle="Data Jenis Pelanggan" size="text-xl" separator />

    <x-mary-chart class="w-80 items-center justify-center mb-5 mx-auto" wire:model="myChart" />
</div>