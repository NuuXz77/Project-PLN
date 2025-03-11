<?php

use Livewire\Volt\Component;
use App\Models\Pelanggan;

new class extends Component {
    public $addModal = false;
    public $No_Kontrol;
    public $Nama;
    public $Alamat;
    public $Telepon;
    public $Email;
    public $Jenis_Plg;


    // Rules untuk validasi
    protected $rules = [
        'No_Kontrol' => 'required|unique:pelanggan,No_Kontrol', // Sesuaikan dengan nama tabel dan kolom
        'Nama' => 'required|string|max:255',
        'Alamat' => 'required|string|max:255',
        'Telepon' => 'required|string|max:15',
        'Email' => 'required|email|unique:pelanggan,Email', // Pastikan email unik
        'Jenis_Plg' => 'required|in:1,2,3', // Sesuaikan dengan enum yang digunakan
    ];

    // Pesan error kustom
    protected $messages = [
        'No_Kontrol.required' => 'No Kontrol wajib diisi.',
        'No_Kontrol.unique' => 'No Kontrol sudah digunakan.',
        'Nama.required' => 'Nama Pelanggan wajib diisi.',
        'Alamat.required' => 'Alamat wajib diisi.',
        'Telepon.required' => 'Telepon wajib diisi.',
        'Email.required' => 'Email wajib diisi.',
        'Email.unique' => 'Email sudah digunakan.',
        'Jenis_Plg.required' => 'Jenis Pelanggan wajib dipilih.',
        'Jenis_Plg.in' => 'Jenis Pelanggan tidak valid.',
    ];

    // Method untuk menyimpan data
    public function save()
    {
        // Validasi data
        $this->validate();

        // Simpan data ke database
        Pelanggan::create([
            'No_Kontrol' => $this->No_Kontrol,
            'Nama' => $this->Nama,
            'Alamat' => $this->Alamat,
            'Telepon' => $this->Telepon,
            'Email' => $this->Email,
            'Jenis_Plg' => $this->Jenis_Plg,
        ]);

        // Reset form
        $this->resetForm();

        // Tutup modal
        $this->addModal = false;

        // Beri feedback ke user
        session()->flash('message', 'Pelanggan berhasil ditambahkan!');
    }

    // Method untuk reset form
    public function resetForm()
    {
        $this->reset(['No_Kontrol', 'Nama', 'Alamat', 'Telepon', 'Email', 'Jenis_Plg']);
    }
}; ?>


<div>
    <x-mary-modal wire:model="addModal" class="backdrop-blur w-1/2">
        <x-mary-header title="Tambah Pelanggan" subtitle="Isikan data yang benar!" separator />
        <x-mary-form wire:submit="save" no-separator>
            <div class="grid grid-cols-12 gap-4">
                <div class="col-span-6">
                    <x-mary-input label="No Kontrol" wire:model="No_Kontrol" />
                </div>
                <div class="col-span-6">
                    <x-mary-input label="Nama Pelanggan" wire:model="Nama" />
                </div>
            </div>
            <div class="grid grid-cols-12 gap-4">
                <div class="col-span-4">
                    <div class="col-span-6">
                        <x-mary-select
                            label="Jenis Pelanggan"
                            wire:model="Jenis_Plg"
                            :options="[
                    ['id' => '1', 'name' => 'Bisnis'],
                    ['id' => '2', 'name' => 'Rumah Tangga'],
                    ['id' => '3', 'name' => 'Industri'],
                ]"
                            option-value="id"
                            option-label="name"
                            placeholder="Pilih Jenis Pelanggan" />
                    </div>
                </div>
                <div class="col-span-4">
                    <x-mary-input label="Email" wire:model="Email" />
                </div>
                <div class="col-span-4">
                    <x-mary-input label="Telepon" wire:model="Telepon" />
                </div>
            </div>
            <div class="grid grid-cols-12 gap-4">
                <div class="col-span-12 mt-3">
                    <x-mary-textarea
                        wire:model="Alamat"
                        placeholder="Your Address ..."
                        hint="Max 1000 chars"
                        rows="3"
                        inline />
                </div>
            </div>
            <x-slot:actions>
                <x-mary-button label="Cancel" @click="$wire.addModal = false" />
                <x-mary-button label="Save" class="btn-primary" type="submit" spinner="save" />
            </x-slot:actions>
        </x-mary-form>
    </x-mary-modal>

    <!-- Tombol untuk membuka modal -->
    <x-mary-button icon="o-plus" class="btn-primary" @click="$wire.addModal = true" />
</div>
