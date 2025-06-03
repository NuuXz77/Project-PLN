<?php

use Livewire\Volt\Component;
use App\Models\Pelanggan;
use App\Models\Pemakaian;
use App\Models\Transaksi;
use App\Models\Pembayaran;

new class extends Component {
    public $pelangganCount;
    public $pemakaianCount;
    public $pembayaranCount;
    public $transaksiCount;

    public function mount() //menambahkan ini untuk menjumlahkan semua data yang ada
    {
        $this->pelangganCount = Pelanggan::count();
        $this->pemakaianCount = Pemakaian::count();
        $this->pembayaranCount = Pembayaran::count();
        $this->transaksiCount = Transaksi::count();
    }
}; ?>

<div>
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-4">
        <x-mary-stat
            title="Pelanggan"
            value="{{ number_format($pelangganCount) }}"
            icon="o-users"
            tooltip="Total Pelanggan" />

        <x-mary-stat
            title="Pemakaian"
            description="Total Data"
            value="{{ number_format($pemakaianCount) }}"
            icon="o-bolt"
            tooltip-bottom="Total Pemakaian" />

        <x-mary-stat
            title="Pembayaran"
            description="Total Data"
            value="{{ number_format($pembayaranCount) }}"
            icon="o-credit-card"
            tooltip-left="Total Pembayaran" />

        <x-mary-stat
            title="Transaksi"
            description="Total Data"
            value="{{ number_format($transaksiCount) }}"
            icon="o-receipt-percent"
            tooltip-right="Total Transaksi" />
    </div>
</div>