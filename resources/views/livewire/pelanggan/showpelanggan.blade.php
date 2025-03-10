<?php

use Livewire\Volt\Component;
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

    // Menerima event dari $dispatch
    protected $listeners = ['showModal' => 'openModal'];

    // Method untuk membuka modal dan mengambil data berdasarkan customer_id
    public function openModal($id)
    {
        // Ambil data pelanggan berdasarkan ID
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

            // Buka modal
            $this->viewModal = true;
        } else {
            // Beri feedback jika data tidak ditemukan
            session()->flash('error', 'Pelanggan tidak ditemukan.');
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
        $this->reset(['customer_id', 'No_Kontrol', 'Nama', 'Alamat', 'Telepon', 'Email', 'Jenis_Plg']);
    }
}; ?>

<div>
    <!-- Modal untuk melihat data pelanggan -->
    <x-mary-modal wire:model="viewModal" class="backdrop-blur" box-class="max-w-4xl" without-trap-focus>
        <x-mary-header title="Detail Pelanggan" subtitle="Lihat data pelanggan" separator />
        <div class="space-y-4">
            <div class="grid grid-cols-12 gap-4">
                <div class="col-span-6">
                    <x-mary-input label="No Kontrol" wire:model="No_Kontrol" readonly />
                </div>
                <div class="col-span-6">
                    <x-mary-input label="Nama Pelanggan" wire:model="Nama" readonly />
                </div>
            </div>
            <div class="grid grid-cols-12 gap-4">
                <div class="col-span-4">
                    <x-mary-input label="Jenis Pelanggan" wire:model="Jenis_Plg" readonly />
                </div>
                <div class="col-span-4">
                    <x-mary-input label="Email" wire:model="Email" readonly />
                </div>
                <div class="col-span-4">
                    <x-mary-input label="Telepon" wire:model="Telepon" readonly />
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
                        inline />
                </div>
            </div>
        </div>
        <x-slot:actions>
            <x-mary-button label="Tutup" @click="$wire.closeModal()" />
        </x-slot:actions>
    </x-mary-modal>

    {{-- <!-- Tombol untuk membuka modal (contoh) -->
    <x-mary-button 
        icon="o-eye" 
        class="btn-primary" 
        @click="$wire.viewModal = true"
    /> --}}
</div>