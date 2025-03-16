<?php

use Livewire\Volt\Component;
use Livewire\WithPagination;
use App\Models\Pelanggan;
use App\Models\Tarif; // Tambahkan ini untuk mengakses model Tarif
use Mary\Traits\Toast;

new class extends Component {
    use Toast;

    public $addModal = false;
    public $No_Kontrol;
    public $Nama;
    public $Alamat;
    public $Telepon;
    public $Email;
    public $Jenis_Plg;

    // Tambahkan properti untuk menyimpan opsi Jenis_Plg dari tabel Tarif
    public $jenisPlgOptions = [
        ['No_Tarif' => 1, 'Jenis_Plg' => 'Rumah Tangga'],
        ['No_Tarif' => 2, 'Jenis_Plg' => 'Bisnis'],
        ['No_Tarif' => 3, 'Jenis_Plg' => 'Industri'],
    ];

    // Method untuk mengambil data Jenis_Plg dari tabel Tarif
    public function mount()
    {
        $this->jenisPlgOptions = Tarif::all('No_Tarif', 'Jenis_Plg')->toArray();
        // dump($this->jenisPlgOptions);
    }

    public function refreshTable()
    {
        $this->dispatch('addSuccess');
    }

    protected $rules = [
        'Nama' => 'required|string|max:255',
        'Alamat' => 'required|string|max:1000',
        'Telepon' => 'required|numeric|min:10',
        'Email' => 'required|email',
        'Jenis_Plg' => 'required', // Validasi Jenis_Plg
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

        // Toast
        $this->toast(
            type: 'success',
            title: 'Success',
            description: null,
            position: 'bottom-end',
            icon: 'o-information-circle',
            css: 'alert-info',
            timeout: 3000,
            redirectTo: null
        );

        $this->success('Data Berhasil Di Tambahkan !');
        $this->resetForm();
        $this->refreshTable();
        $this->addModal = false;

        session()->flash('message', 'Pelanggan berhasil ditambahkan!');
    }

    public function resetForm()
    {
        $this->reset(['No_Kontrol', 'Nama', 'Alamat', 'Telepon', 'Email', 'Jenis_Plg']);
    }

    public function openModal()
    {
        $this->addModal = true;
    }
};
?>

<div>
    <x-mary-modal wire:model="addModal" class="backdrop-blur" box-class="max-w-4xl w-100">
        <x-mary-header title="Tambah Pelanggan" subtitle="Isikan data yang benar!" separator />
        <x-mary-form wire:submit.prevent="save" no-separator>
            <div class="grid grid-cols-12 gap-4">
                <!-- No Kontrol otomatis -->
                <div class="col-span-6">
                    <x-mary-input label="No Kontrol" wire:model="No_Kontrol" readonly class="text-black" />
                </div>
                <div class="col-span-6">
                    <x-mary-input label="Nama Pelanggan" wire:model="Nama" class="text-black" />
                </div>
            </div>

            <div class="grid grid-cols-12 gap-4">
                <div class="col-span-4">
                    <x-mary-select
                        label="Jenis Pelanggan"
                        wire:model="Jenis_Plg"
                        :options="$this->jenisPlgOptions"
                        option-value="No_Tarif"
                        option-label="Jenis_Plg"
                        placeholder="Pilih Jenis Pelanggan"
                        class="text-black" />
                </div>
                <div class="col-span-4">
                    <x-mary-input label="Email" wire:model="Email" class="text-black" />
                </div>
                <div class="col-span-4">
                    <x-mary-input label="Telepon" wire:model="Telepon" class="text-black" />
                </div>
            </div>

            <div class="grid grid-cols-12 gap-4">
                <div class="col-span-12 mt-3">
                    <x-mary-textarea
                        wire:model="Alamat"
                        placeholder="Your Address ..."
                        hint="Max 1000 chars"
                        rows="3"
                        inline class="text-black" />
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