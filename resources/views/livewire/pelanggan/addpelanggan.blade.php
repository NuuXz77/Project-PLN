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

    
    protected $rules = [
        'Nama' => 'required|string|max:255',
        'Alamat' => 'required|string|max:1000',
        'Telepon' => 'required|numeric|min:10',
        'Email' => 'required|email',
        'Jenis_Plg' => 'required|in:1,2,3',
    ];

    public function updatedTelepon()
    {
      
        $this->generateKodeKontrol();
    }

    
    public function generateKodeKontrol()
    {
        if (empty($this->Telepon)) {
            session()->flash('error', 'Nomor Telepon harus diisi terlebih dahulu.');
            return;
        }

      
        $noTeleponLast6 = substr($this->Telepon, -6);

       
        do {
            $this->No_Kontrol = 'PLN-' . strtoupper($noTeleponLast6);  // Format: PLN-123456
        } while (Pelanggan::where('No_Kontrol', $this->No_Kontrol)->exists());
    }

 
    public function save()
    {
        
        $this->validate();

        if (empty($this->No_Kontrol)) {
            session()->flash('error', 'Kode Kontrol tidak dapat kosong.');
            return;
        }

     
        Pelanggan::create([
            'No_Kontrol' => $this->No_Kontrol,
            'Nama' => $this->Nama,
            'Alamat' => $this->Alamat,
            'Telepon' => $this->Telepon,
            'Email' => $this->Email,
            'Jenis_Plg' => $this->Jenis_Plg,
        ]);

       
        $this->resetForm();
        $this->addModal = false;
        session()->flash('message', 'Pelanggan berhasil ditambahkan!');
    }

    
    public function resetForm()
    {
        $this->reset(['No_Kontrol', 'Nama', 'Alamat', 'Telepon', 'Email', 'Jenis_Plg']);
    }

 ///sss
    public function openModal()
    {
        $this->addModal = true;
    }
};
?>

<div>
    <!-- Modal untuk menambahkan pelanggan -->
    <x-mary-modal wire:model="addModal" class="backdrop-blur">
        <x-mary-header title="Tambah Pelanggan" subtitle="Isikan data yang benar!" separator />
        <x-mary-form wire:submit.prevent="save" no-separator>
            <div class="grid grid-cols-12 gap-4">
                <!-- No Kontrol otomatis -->
                <div class="col-span-6">
                    <x-mary-input label="No Kontrol" wire:model="No_Kontrol" readonly class="text-cyan-50"/>
                </div>
                <div class="col-span-6">
                    <x-mary-input label="Nama Pelanggan" wire:model="Nama" class="text-cyan-50" />
                    @error('Nama') <span class="text-red-500">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="grid grid-cols-12 gap-4">
                <div class="col-span-4">
                    <x-mary-select
                        label="Jenis Pelanggan"
                        wire:model="Jenis_Plg"
                        :options="[ ['id' => '1', 'name' => 'Bisnis'], ['id' => '2', 'name' => 'Rumah Tangga'], ['id' => '3', 'name' => 'Industri'], ]"
                        option-value="id"
                        option-label="name"
                        placeholder="Pilih Jenis Pelanggan"
                        class="text-cyan-50"
                    />
                    @error('Jenis_Plg') <span class="text-red-500">{{ $message }}</span> @enderror
                </div>
                <div class="col-span-4">
                    <x-mary-input label="Email" wire:model="Email" class="text-cyan-50" />
                    @error('Email') <span class="text-red-500">{{ $message }}</span> @enderror
                </div>
                <div class="col-span-4">
                    <x-mary-input label="Telepon" wire:model="Telepon" class="text-cyan-50" />
                    @error('Telepon') <span class="text-red-500">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="grid grid-cols-12 gap-4">
                <div class="col-span-12 mt-3">
                    <x-mary-textarea
                        wire:model="Alamat"
                        placeholder="Your Address ..."
                        hint="Max 1000 chars"
                        rows="3"
                        inline class="text-cyan-50"
                    />
                    @error('Alamat') <span class="text-red-500">{{ $message }}</span> @enderror
                </div>
            </div>

            <x-slot:actions>
                <x-mary-button label="Cancel" @click="$wire.addModal = false" />
                <x-mary-button label="Save" class="btn-primary" type="submit" spinner="save" />
            </x-slot:actions>
        </x-mary-form>
    </x-mary-modal>

    <!-- Tombol untuk membuka modal -->
    <x-mary-button icon="o-plus" class="btn-primary" @click="$wire.openModal()" />
</div>
