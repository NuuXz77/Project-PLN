<?php

namespace App\Livewire;

use Livewire\Volt\Component;
use App\Models\Pemakaian;
use App\Models\Pelanggan;
use App\Models\Tarif;
use Mary\Traits\Toast;

new class extends Component {
    use Toast;

    public $editModal = false;
    public $pemakaian_id;
    public $No_Pemakaian;
    public $No_Kontrol;
    public $TanggalCatat;
    public $MeterAwal;
    public $MeterAkhir;
    public $JumlahPakai;
    public $BiayaBebanPemakaian;
    public $BiayaPemakaian;
    public $StatusPembayaran;
    public $pelangganList = [];
    public $tarif;
    public $jenisPelanggan;

    protected $listeners = ['showEditModal' => 'openModal'];

    public function mount()
    {
        $this->pelangganList = Pelanggan::all(['No_Kontrol', 'Nama', 'Jenis_Plg', 'created_at'])->toArray();
        $this->tarif = Tarif::all()->keyBy('Jenis_Plg')->toArray();
    }

    public function openModal($id)
    {
        $pemakaian = Pemakaian::find($id);

        if ($pemakaian) {
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

            $pelanggan = Pelanggan::where('No_Kontrol', $this->No_Kontrol)->first();
            if ($pelanggan) {
                $this->jenisPelanggan = $pelanggan->Jenis_Plg;
            }

            $this->editModal = true;
        } else {
            $this->toast(
                type: 'error',
                title: 'Error!',
                description: 'Pemakaian tidak ditemukan.',
                position: 'toast-top toast-end',
                icon: 'o-information-circle',
                css: 'alert-error',
                timeout: 3000,
                redirectTo: null
            );
        }
    }

    public function closeModal()
    {
        $this->editModal = false;
        $this->resetForm();
    }

    public function resetForm()
    {
        $this->reset([
            'pemakaian_id', 'No_Pemakaian', 'No_Kontrol', 'TanggalCatat', 
            'MeterAwal', 'MeterAkhir', 'JumlahPakai', 
            'BiayaBebanPemakaian', 'BiayaPemakaian', 'StatusPembayaran'
        ]);
    }

    public function updatedMeterAwal()
    {
        $this->calculateJumlahPakai();
    }

    public function updatedMeterAkhir()
    {
        $this->calculateJumlahPakai();
    }

    public function calculateJumlahPakai()
    {
        if (is_numeric($this->MeterAwal) && is_numeric($this->MeterAkhir) && $this->MeterAkhir >= $this->MeterAwal) {
            $this->JumlahPakai = $this->MeterAkhir - $this->MeterAwal;
            $this->calculateBiayaPemakaian();
        }
    }

    public function calculateBiayaPemakaian()
    {
        if ($this->JumlahPakai && isset($this->tarif[$this->jenisPelanggan])) {
            $tarif = $this->tarif[$this->jenisPelanggan];
            $this->BiayaPemakaian = $this->JumlahPakai * $tarif['TarifKWH'];
            $this->BiayaBebanPemakaian = $tarif['BiayaBeban'];
        }
    }

    public function save()
    {
        $this->validate([
            'No_Pemakaian' => 'required|string',
            'No_Kontrol' => 'required|string',
            'TanggalCatat' => 'required|date',
            'MeterAwal' => 'required|numeric',
            'MeterAkhir' => 'required|numeric|gte:MeterAwal',
            'JumlahPakai' => 'required|numeric',
            'BiayaBebanPemakaian' => 'required|numeric',
            'BiayaPemakaian' => 'required|numeric',
            'StatusPembayaran' => 'required|in:Lunas,Belum Lunas',
        ]);

        try {
            $pemakaian = Pemakaian::find($this->pemakaian_id);

            if ($pemakaian) {
                $pemakaian->update([
                    'No_Pemakaian' => $this->No_Pemakaian,
                    'No_kontrol' => $this->No_Kontrol,
                    'TanggalCatat' => $this->TanggalCatat,
                    'MeterAwal' => $this->MeterAwal,
                    'MeterAkhir' => $this->MeterAkhir,
                    'JumlahPakai' => $this->JumlahPakai,
                    'BiayaBebanPemakaian' => $this->BiayaBebanPemakaian,
                    'BiayaPemakaian' => $this->BiayaPemakaian,
                    'StatusPembayaran' => $this->StatusPembayaran,
                ]);

                $this->toast(
                    type: 'success',
                    title: 'It is done!',
                    description: 'Data Pemakaian Berhasil Diperbarui!',
                    position: 'toast-top toast-end',
                    icon: 'o-information-circle',
                    css: 'alert-info',
                    timeout: 3000,
                    redirectTo: null
                );

                $this->dispatch('editSuccess');
                $this->closeModal();
            } else {
                $this->toast(
                    type: 'error',
                    title: 'Error!',
                    description: 'Pemakaian tidak ditemukan.',
                    position: 'toast-top toast-end',
                    icon: 'o-information-circle',
                    css: 'alert-error',
                    timeout: 3000,
                    redirectTo: null
                );
            }
        } catch (\Exception $e) {
            $this->toast(
                type: 'error',
                title: 'Error!',
                description: 'Terjadi kesalahan: ' . $e->getMessage(),
                position: 'toast-top toast-end',
                icon: 'o-information-circle',
                css: 'alert-error',
                timeout: 3000,
                redirectTo: null
            );
        }
    }
};
?>

<div>
    <!-- Modal untuk mengedit data pemakaian -->
    <x-mary-modal wire:model="editModal" class="backdrop-blur" box-class="max-w-4xl w-100">
        <x-mary-header title="Edit Pemakaian" subtitle="Edit data pemakaian" separator />
        <x-mary-form wire:submit.prevent="save" no-separator>
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
                    <x-mary-input label="Tanggal Catat" wire:model="TanggalCatat" type="date" />
                </div>
                <div class="col-span-6">
                    <x-mary-select 
                        label="Status Pembayaran"
                        wire:model="StatusPembayaran"
                        :options="[
                            ['id' => 'Lunas', 'name' => 'Lunas'],
                            ['id' => 'Belum Lunas', 'name' => 'Belum Lunas']
                        ]"
                        option-value="id"
                        option-label="name"
                        placeholder="Pilih Status"
                    />
                </div>
            </div>
            <div class="grid grid-cols-12 gap-4">
                <div class="col-span-4">
                    <x-mary-input label="Meter Awal" wire:model.live="MeterAwal" type="number" class="text-black dark:text-white"/>
                </div>
                <div class="col-span-4">
                    <x-mary-input label="Meter Akhir" wire:model.live="MeterAkhir" type="number" class="text-black dark:text-white"/>
                </div>
                <div class="col-span-4">
                    <x-mary-input label="Jumlah Pakai" wire:model="JumlahPakai" type="number" readonly class="text-black dark:text-white"/>
                </div>
            </div>
            <div class="grid grid-cols-12 gap-4">
                <div class="col-span-6">
                    <x-mary-input label="Biaya Beban" wire:model="BiayaBebanPemakaian" type="number" readonly class="text-black dark:text-white"/>
                </div>
                <div class="col-span-6">
                    <x-mary-input label="Biaya Pemakaian" wire:model="BiayaPemakaian" type="number" readonly class="text-black dark:text-white"/>
                </div>
            </div>
            <x-slot:actions>
                <x-mary-button label="Cancel" @click="$wire.closeModal()" />
                <x-mary-button label="Save" class="btn-primary" type="submit" spinner="save" />
            </x-slot:actions>
        </x-mary-form>
    </x-mary-modal>
</div>