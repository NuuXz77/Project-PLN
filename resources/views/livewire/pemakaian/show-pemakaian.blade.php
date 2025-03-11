<?php

namespace App\Livewire;

use Livewire\Volt\Component;
use App\Models\Pemakaian;
use App\Models\Pelanggan;

new class extends Component {
    public $viewModal = false; // Modal untuk melihat data
    public $pemakaian_id; // ID pemakaian yang akan ditampilkan
    public $No_Pemakaian;
    public $No_Kontrol;
    public $Nama;
    public $TanggalCatat;
    public $MeterAwal;
    public $MeterAkhir;
    public $JumlahPakai;
    public $BiayaBebanPemakaian;
    public $BiayaPemakaian;
    public $StatusPembayaran;

    // Menerima event dari $dispatch
    protected $listeners = ['showModal' => 'openModal'];

    // Method untuk membuka modal dan mengambil data berdasarkan pemakaian_id
    public function openModal($id)
    {
        // Ambil data pemakaian berdasarkan ID
        $pemakaian = Pemakaian::with('pelanggan')->find($id);

        if ($pemakaian) {
            // Isi properti dengan data yang ditemukan
            $this->pemakaian_id = $pemakaian->ID_Pemakaian;
            $this->No_Pemakaian = $pemakaian->No_Pemakaian;
            $this->No_Kontrol = $pemakaian->No_kontrol;
            $this->TanggalCatat = $pemakaian->TanggalCatat;
            $this->MeterAwal = $pemakaian->MeterAwal;
            $this->MeterAkhir = $pemakaian->MeterAkhir;
            $this->JumlahPakai = $pemakaian->JumlahPakai;
            $this->BiayaBebanPemakaian = $pemakaian->BiayaBebanPemakaian;
            $this->BiayaPemakaian = $pemakaian->BiayaPemakaian;
            $this->StatusPembayaran = $pemakaian->StatusPembayaran;

            // Buka modal
            $this->viewModal = true;
        } else {
            // Beri feedback jika data tidak ditemukan
            session()->flash('error', 'Pemakaian tidak ditemukan.');
        }
    }

    // Method untuk menutup modal
    public function closeModal()
    {
        $this->viewModal = false;
        $this->resetForm();
    }

    // Method untuk reset form
    public function resetForm()
    {
        $this->reset(['pemakaian_id', 'No_Pemakaian', 'No_Kontrol', 'Nama', 'TanggalCatat', 'MeterAwal', 'MeterAkhir', 'JumlahPakai', 'BiayaBebanPemakaian', 'BiayaPemakaian', 'StatusPembayaran']);
    }
};
?>

<div>
    <!-- Modal untuk melihat data pemakaian -->
    <x-mary-modal wire:model="viewModal" class="backdrop-blur" box-class="max-w-4xl" without-trap-focus>
        <x-mary-header title="Detail Pemakaian" subtitle="Lihat data pemakaian" separator />
        <div class="space-y-4">
            <div class="grid grid-cols-12 gap-4">
                <div class="col-span-6">
                    <x-mary-input label="No Pemakaian" wire:model="No_Pemakaian" readonly />
                </div>
                <div class="col-span-6">
                    <x-mary-input label="No Kontrol" wire:model="No_Kontrol" readonly />
                </div>
            </div>
            <div class="grid grid-cols-12 gap-4">
                <div class="col-span-6">
                    <x-mary-input label="Nama Pelanggan" wire:model="Nama" readonly />
                </div>
                <div class="col-span-6">
                    <x-mary-input label="Tanggal Catat" wire:model="TanggalCatat" readonly />
                </div>
            </div>
            <div class="grid grid-cols-12 gap-4">
                <div class="col-span-4">
                    <x-mary-input label="Meter Awal" wire:model="MeterAwal" readonly />
                </div>
                <div class="col-span-4">
                    <x-mary-input label="Meter Akhir" wire:model="MeterAkhir" readonly />
                </div>
                <div class="col-span-4">
                    <x-mary-input label="Jumlah Pakai" wire:model="JumlahPakai" readonly />
                </div>
            </div>
            <div class="grid grid-cols-12 gap-4">
                <div class="col-span-6">
                    <x-mary-input label="Biaya Beban" wire:model="BiayaBebanPemakaian" readonly />
                </div>
                <div class="col-span-6">
                    <x-mary-input label="Biaya Pemakaian" wire:model="BiayaPemakaian" readonly />
                </div>
            </div>
            <div class="grid grid-cols-12 gap-4">
                <div class="col-span-12">
                    <x-mary-input label="Status Pembayaran" wire:model="StatusPembayaran" readonly />
                </div>
            </div>
        </div>
        <x-slot:actions>
            <x-mary-button label="Tutup" @click="$wire.closeModal()" />
        </x-slot:actions>
    </x-mary-modal>
</div>
