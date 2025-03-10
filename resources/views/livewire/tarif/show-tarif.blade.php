<?php

use Livewire\Volt\Component;
use App\Models\Tarif;

new class extends Component {
    public $viewModal = false; // Modal untuk melihat data
    public $tarif_id; // ID tarif yang akan ditampilkan
    public $No_Tarif;
    public $Jenis_Plg;
    public $Daya;
    public $BiayaBeban;
    public $TarifKWH;

    // Menerima event dari $dispatch
    protected $listeners = ['showModal' => 'openModal'];

    // Method untuk membuka modal dan mengambil data berdasarkan tarif_id
    public function openModal($id)
    {
        // Ambil data tarif berdasarkan ID
        $tarif = Tarif::find($id);

        if ($tarif) {
            // Isi properti dengan data yang ditemukan
            $this->tarif_id = $tarif->ID_Tarif;
            $this->No_Tarif = $tarif->No_Tarif;
            $this->Jenis_Plg = $tarif->Jenis_Plg;
            $this->Daya = $tarif->Daya;
            $this->BiayaBeban = $tarif->BiayaBeban;
            $this->TarifKWH = $tarif->TarifKWH;

            // Buka modal
            $this->viewModal = true;
        } else {
            // Beri feedback jika data tidak ditemukan
            session()->flash('error', 'Tarif tidak ditemukan.');
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
        $this->reset(['tarif_id', 'No_Tarif', 'Jenis_Plg', 'Daya', 'BiayaBeban', 'TarifKWH']);
    }
};
?>

<div>
    <!-- Modal untuk melihat data tarif -->
    <x-mary-modal wire:model="viewModal" class="backdrop-blur" box-class="max-w-4xl" without-trap-focus>
        <x-mary-header title="Detail Tarif" subtitle="Lihat data tarif" separator />
        <div class="space-y-4">
            <div class="grid grid-cols-12 gap-4">
                <div class="col-span-6">
                    <x-mary-input label="No Tarif" wire:model="No_Tarif" readonly />
                </div>
                <div class="col-span-6">
                    <x-mary-input label="Jenis Pelanggan" wire:model="Jenis_Plg" readonly />
                </div>
            </div>
            <div class="grid grid-cols-12 gap-4">
                <div class="col-span-4">
                    <x-mary-input label="Daya" wire:model="Daya" readonly />
                </div>
                <div class="col-span-4">
                    <x-mary-input label="Biaya Beban" wire:model="BiayaBeban" readonly />
                </div>
                <div class="col-span-4">
                    <x-mary-input label="Tarif KWH" wire:model="TarifKWH" readonly />
                </div>
            </div>
        </div>
        <x-slot:actions>
            <x-mary-button label="Tutup" @click="$wire.closeModal()" />
        </x-slot:actions>
    </x-mary-modal>
</div>
