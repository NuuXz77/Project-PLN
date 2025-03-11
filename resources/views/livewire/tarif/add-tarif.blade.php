<?php

use Livewire\Volt\Component;
use App\Models\Tarif;
use Mary\Traits\Toast;

new class extends Component {
    use Toast;

    public $addModal = false;
    public $No_Tarif;
    public $Jenis_Plg;
    public $Daya;
    public $BiayaBeban;
    public $TarifKWH;

    // Properti untuk menyimpan opsi Jenis_Plg
    public $jenisPlgOptions = [
        'Rumah Tangga' => 'RTG',
        'Bisnis' => 'BSN',
        'Industri' => 'IND',
    ];

    // Method untuk membuka modal
    public function openModal()
    {
        $this->addModal = true;
    }

    // Method untuk generate No_Tarif
    public function generateNoTarif()
    {
        if (empty($this->Jenis_Plg)) {
            session()->flash('error', 'Jenis Pelanggan harus dipilih terlebih dahulu.');
            return;
        }

        // Ambil singkatan Jenis_Plg dari opsi yang tersedia
        $singkatan = $this->jenisPlgOptions[$this->Jenis_Plg] ?? 'UNK';

        // Format: TRF/[Singkatan Jenis_Plg]-Tahun
        $tahun = date('Y'); // Tahun saat ini
        $this->No_Tarif = "TRF/{$singkatan}-{$tahun}";
    }

    // Method untuk menyimpan data
    public function save()
    {
        $this->validate([
            'No_Tarif' => 'required|string|unique:tarif,No_Tarif',
            'Jenis_Plg' => 'required|string',
            'Daya' => 'required|numeric',
            'BiayaBeban' => 'required|numeric',
            'TarifKWH' => 'required|numeric',
        ]);

        Tarif::create([
            'No_Tarif' => $this->No_Tarif,
            'Jenis_Plg' => $this->Jenis_Plg,
            'Daya' => $this->Daya,
            'BiayaBeban' => $this->BiayaBeban,
            'TarifKWH' => $this->TarifKWH,
        ]);

        // Toast
        $this->toast(
            type: 'success',
            title: 'Data Tarif Berhasil Ditambahkan!',
            description: null,
            position: 'bottom-end',
            icon: 'o-information-circle',
            css: 'alert-info',
            timeout: 3000,
            redirectTo: null
        );

        $this->resetForm();
        $this->dispatch('addSuccess');
        $this->addModal = false;
    }

    // Method untuk mereset form
    public function resetForm()
    {
        $this->reset(['No_Tarif', 'Jenis_Plg', 'Daya', 'BiayaBeban', 'TarifKWH']);
    }

    // Method untuk refresh tabel
    public function refreshTable()
    {
        $this->dispatch('addSuccess');
    }
};
?>

<div>
    <x-mary-modal wire:model="addModal" class="backdrop-blur" box-class="max-w-4xl w-100">
        <x-mary-header title="Tambah Tarif" subtitle="Isikan data yang benar!" separator />
        <x-mary-form wire:submit.prevent="save" no-separator>
            <div class="grid grid-cols-12 gap-4">
                <!-- No Tarif otomatis -->
                <div class="col-span-6">
                    <x-mary-input label="No Tarif" wire:model="No_Tarif" readonly class="text-cyan-50"/>
                </div>
                <div class="col-span-6">
                    <x-mary-select
                        label="Jenis Pelanggan"
                        wire:model="Jenis_Plg"
                        :options="[
                            ['id' => 'Rumah Tangga', 'name' => 'Rumah Tangga'],
                            ['id' => 'Bisnis', 'name' => 'Bisnis'],
                            ['id' => 'Industri', 'name' => 'Industri'],
                        ]"
                        option-value="id"
                        option-label="name"
                        placeholder="Pilih Jenis Pelanggan"
                        class="text-cyan-50"
                        wire:change="generateNoTarif"
                    />
                </div>
            </div>

            <div class="grid grid-cols-12 gap-4">
                <div class="col-span-4">
                    <x-mary-input label="Daya" wire:model="Daya" type="number" class="text-cyan-50" />
                </div>
                <div class="col-span-4">
                    <x-mary-input label="Biaya Beban" wire:model="BiayaBeban" type="number" class="text-cyan-50" />
                </div>
                <div class="col-span-4">
                    <x-mary-input label="Tarif KWH" wire:model="TarifKWH" type="number" class="text-cyan-50" />
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
