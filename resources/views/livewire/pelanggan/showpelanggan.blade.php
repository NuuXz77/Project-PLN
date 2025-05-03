<?php

use Livewire\Volt\Component;
// use Livewire\Component;
use App\Models\Pelanggan;

new class extends Component {
    public $viewModal = false; // Modal untuk melihat data
    public $customer_id; // ID pelanggan yang akan ditampilkan
    public $No_Kontrol;
    public $Nama;
    public $Alamat;
    public $Telepon;
    public $Email;
    public $Jenis_Plg;

    protected $listeners = ['showModal' => 'openModal'];

    public function openModal($id)
    {
        $pelanggan = Pelanggan::find($id);

        if ($pelanggan) {
            // Isi properti dengan data yang ditemukan
            $this->customer_id = $pelanggan->id;
            $this->No_Kontrol = $pelanggan->No_Kontrol;
            $this->Nama = $pelanggan->Nama;
            $this->Alamat = $pelanggan->Alamat;
            $this->Telepon = $pelanggan->Telepon;
            $this->Email = $pelanggan->Email;
            $this->Jenis_Plg = $pelanggan->Jenis_Plg;

            $this->viewModal = true;
        } else {
            session()->flash('error', 'Pelanggan tidak ditemukan.');
        }
    }

    public function closeModal()
    {
        $this->viewModal = false;
        $this->reset(['customer_id', 'No_Kontrol', 'Nama', 'Alamat', 'Telepon', 'Email', 'Jenis_Plg']);
    }
};
?>

<div>
    <!-- Modal untuk melihat data pelanggan YANG LAMA-->
    <x-mary-modal wire:model="viewModal" class="backdrop-blur" box-class="max-w-4xl" without-trap-focus>
        <x-mary-header title="Detail Pelanggan" subtitle="Lihat data pelanggan" separator />
        <div class="space-y-4">
            <div class="grid grid-cols-12 gap-4">
                <div class="col-span-6">
                    <x-mary-input label="No Kontrol" wire:model="No_Kontrol" readonly class="text-black dark:text-white"/>
                </div>
                <div class="col-span-6">
                    <x-mary-input label="Nama Pelanggan" wire:model="Nama" readonly class="text-black dark:text-white"/>
                </div>
            </div>
            <div class="grid grid-cols-12 gap-4">
                <div class="col-span-4">
                    <x-mary-input label="Jenis Pelanggan" wire:model="Jenis_Plg" readonly class="text-black dark:text-white"/>
                </div>
                <div class="col-span-4">
                    <x-mary-input label="Email" wire:model="Email" readonly class="text-black dark:text-white"/>
                </div>
                <div class="col-span-4">
                    <x-mary-input label="Telepon" wire:model="Telepon" readonly class="text-black dark:text-white"/>
                </div>
            </div>
            <div class="grid grid-cols-12 gap-4">
                <div class="col-span-12 mt-3">
                    <x-mary-textarea
                        wire:model="Alamat"
                        placeholder="Alamat"
                        hint="Max 1000 chars"
                        rows="3"
                        readonly
                        inline class="text-black dark:text-white"/>
                </div>
            </div>
        </div>
        <x-slot:actions>
            <x-mary-button label="Tutup" @click="$wire.closeModal()" />
        </x-slot:actions>
    </x-mary-modal>
</div>