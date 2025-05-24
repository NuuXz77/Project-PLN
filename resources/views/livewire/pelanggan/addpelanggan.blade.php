<?php

use Livewire\Volt\Component;
use Livewire\WithPagination;
use App\Models\Pelanggan;
use App\Models\Tarif;
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

    public $jenisPlgOptions = [];

    public function mount()
    {
        $this->jenisPlgOptions = Tarif::all()->toArray();
        $this->generateKodeKontrol(); // Generate kode otomatis saat modal dibuka
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
        'Jenis_Plg' => 'required',
    ];

    public function updatedTelepon()
    {
        $this->generateKodeKontrol();
    }

    public function generateKodeKontrol()
    {
        $now = now(); // Menggunakan waktu sistem saat ini (real-time)
        $year = $now->format('Y'); // Tahun 4 digit
        $time = $now->format('Gis'); // Format 24 jam tanpa leading zero (jam 17:05:30 -> 170530)

        // Jika ada nomor telepon, gunakan 6 digit terakhir
        $nomor = !empty($this->Telepon) ? substr($this->Telepon, -6) : rand(100000, 999999);

        $this->No_Kontrol = 'PLN' . $nomor . $year . $time;

        // Cek jika nomor sudah ada, tambahkan random number
        while (Pelanggan::where('No_Kontrol', $this->No_Kontrol)->exists()) {
            $this->No_Kontrol = 'PLN' . $nomor . $year . $time . rand(10, 99);
        }
    }

    public function save()
    {
        $this->validate();

        Pelanggan::create([
            'No_Kontrol' => $this->No_Kontrol,
            'Nama' => $this->Nama,
            'Alamat' => $this->Alamat,
            'Telepon' => $this->Telepon,
            'Email' => $this->Email,
            'Jenis_Plg' => $this->Jenis_Plg,
        ]);

        $this->toast(type: 'success', title: 'Success', description: null, position: 'bottom-end', icon: 'o-information-circle', css: 'alert-info', timeout: 3000, redirectTo: null);

        $this->success('Data Berhasil Di Tambahkan !');
        $this->resetForm();
        $this->refreshTable();
        $this->addModal = false;
    }

    public function resetForm()
    {
        $this->reset(['No_Kontrol', 'Nama', 'Alamat', 'Telepon', 'Email', 'Jenis_Plg']);
        $this->generateKodeKontrol(); // Generate baru saat form direset
    }

    public function openModal()
    {
        $this->addModal = true;
        $this->generateKodeKontrol(); // Generate baru saat modal dibuka
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
                    <x-mary-input label="No Kontrol" wire:model="No_Kontrol" readonly class=""
                        x-on:click="$wire.generateKodeKontrol()" />
                </div>
                <div class="col-span-6">
                    <x-mary-input label="Nama Pelanggan" wire:model="Nama" class="" />
                </div>
            </div>

            <div class="grid grid-cols-12 gap-4">
                <div class="col-span-4">
                    <x-mary-select label="Jenis Pelanggan" wire:model="Jenis_Plg" :options="$this->jenisPlgOptions"
                        option-value="Jenis_Plg" option-label="Jenis_Plg" placeholder="Pilih Jenis Pelanggan"
                        class="" />
                </div>
                <div class="col-span-4">
                    <x-mary-input label="Email" wire:model="Email" class="" />
                </div>
                <div class="col-span-4">
                    <x-mary-input label="Telepon" wire:model="Telepon" class=""
                        x-on:input.debounce.500ms="$wire.generateKodeKontrol()" />
                </div>
            </div>

            <div class="grid grid-cols-12 gap-4">
                <div class="col-span-12 mt-3">
                    <x-mary-textarea wire:model="Alamat" placeholder="Your Address ..." hint="Max 1000 chars"
                        rows="3" inline class="" />
                </div>
            </div>

            <x-slot:actions>
                <x-mary-button label="Cancel" @click="$wire.addModal = false" />
                <x-mary-button label="Save" class="btn-primary" type="submit" spinner="save" />
            </x-slot:actions>
        </x-mary-form>
    </x-mary-modal>

    <x-mary-button icon="o-plus" class="btn-primary" @click="$wire.openModal()" />
</div>
