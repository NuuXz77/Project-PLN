<?php

namespace App\Livewire;

use Livewire\Volt\Component;
use App\Models\Pemakaian;
use Mary\Traits\Toast;

new class extends Component {
    use Toast;

    public $editModal = false; // Modal untuk mengedit data
    public $pemakaian_id; // ID pemakaian yang akan diedit
    public $No_Pemakaian;
    public $No_Kontrol;
    public $TanggalCatat;
    public $MeterAwal;
    public $MeterAkhir;
    public $JumlahPakai;
    public $BiayaBebanPemakaian;
    public $BiayaPemakaian;
    public $StatusPembayaran;

    // Menerima event dari $dispatch
    protected $listeners = ['showEditModal' => 'openModal'];

    // Method untuk membuka modal dan mengambil data berdasarkan pemakaian_id
    public function openModal($id)
    {
        // Ambil data pemakaian berdasarkan ID
        $pemakaian = Pemakaian::find($id);

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
            $this->editModal = true;
        } else {
            // Beri feedback jika data tidak ditemukan
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

    // Method untuk menutup modal
    public function closeModal()
    {
        $this->editModal = false;
        $this->resetForm();
    }

    // Method untuk reset form
    public function resetForm()
    {
        $this->reset(['pemakaian_id', 'No_Pemakaian', 'No_Kontrol', 'TanggalCatat', 'MeterAwal', 'MeterAkhir', 'JumlahPakai', 'BiayaBebanPemakaian', 'BiayaPemakaian', 'StatusPembayaran']);
    }

    // Method untuk menyimpan perubahan data pemakaian
    public function save()
    {
        // Validasi data
        $this->validate([
            'No_Pemakaian' => 'required|string',
            'No_Kontrol' => 'required|string',
            'TanggalCatat' => 'required|date',
            'MeterAwal' => 'required|numeric',
            'MeterAkhir' => 'required|numeric',
            'JumlahPakai' => 'required|numeric',
            'BiayaBebanPemakaian' => 'required|numeric',
            'BiayaPemakaian' => 'required|numeric',
            'StatusPembayaran' => 'required|string',
        ]);

        try {
            // Cari pemakaian berdasarkan ID
            $pemakaian = Pemakaian::find($this->pemakaian_id);

            if ($pemakaian) {
                // Update data pemakaian
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

                // Toast sukses
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
                // Toast error jika pemakaian tidak ditemukan
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
            // Toast error jika terjadi exception
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
                    <x-mary-input label="Status Pembayaran" wire:model="StatusPembayaran" />
                </div>
            </div>
            <div class="grid grid-cols-12 gap-4">
                <div class="col-span-4">
                    <x-mary-input label="Meter Awal" wire:model="MeterAwal" type="number" />
                </div>
                <div class="col-span-4">
                    <x-mary-input label="Meter Akhir" wire:model="MeterAkhir" type="number" />
                </div>
                <div class="col-span-4">
                    <x-mary-input label="Jumlah Pakai" wire:model="JumlahPakai" type="number" readonly />
                </div>
            </div>
            <div class="grid grid-cols-12 gap-4">
                <div class="col-span-6">
                    <x-mary-input label="Biaya Beban" wire:model="BiayaBebanPemakaian" type="number" />
                </div>
                <div class="col-span-6">
                    <x-mary-input label="Biaya Pemakaian" wire:model="BiayaPemakaian" type="number" />
                </div>
            </div>
            <x-slot:actions>
                <x-mary-button label="Cancel" @click="$wire.closeModal()" />
                <x-mary-button label="Save" class="btn-primary" type="submit" spinner="save" />
            </x-slot:actions>
        </x-mary-form>
    </x-mary-modal>
</div>
