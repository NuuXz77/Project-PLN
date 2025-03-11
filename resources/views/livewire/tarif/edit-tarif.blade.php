<?php

use Livewire\Volt\Component;
use App\Models\Tarif;
use Mary\Traits\Toast;

new class extends Component {
    use Toast;

    public $editModal = false; // Modal untuk mengedit data
    public $tarif_id; // ID tarif yang akan diedit
    public $No_Tarif;
    public $Jenis_Plg;
    public $Daya;
    public $BiayaBeban;
    public $TarifKWH;

    // Menerima event dari $dispatch
    protected $listeners = ['showEditModal' => 'openModal'];

    public function refreshTable()
    {
        $this->dispatch('editSuccess');
    }

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
            $this->editModal = true;
        } else {
            // Beri feedback jika data tidak ditemukan
            $this->toast(
                type: 'error',
                title: 'Error!',
                description: 'Tarif tidak ditemukan.',
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
        $this->reset(['tarif_id', 'No_Tarif', 'Jenis_Plg', 'Daya', 'BiayaBeban', 'TarifKWH']);
    }

    // Method untuk menyimpan perubahan data tarif
    public function save()
    {
        // Validasi data
        $this->validate([
            'No_Tarif' => 'required|string|unique:tarif,No_Tarif,' . $this->tarif_id . ',ID_Tarif',
            'Jenis_Plg' => 'required|string',
            'Daya' => 'required|numeric',
            'BiayaBeban' => 'required|numeric',
            'TarifKWH' => 'required|numeric',
        ]);

        try {
            // Cari tarif berdasarkan ID
            $tarif = Tarif::find($this->tarif_id);

            if ($tarif) {
                // Update data tarif
                $tarif->update([
                    'No_Tarif' => $this->No_Tarif,
                    'Jenis_Plg' => $this->Jenis_Plg,
                    'Daya' => $this->Daya,
                    'BiayaBeban' => $this->BiayaBeban,
                    'TarifKWH' => $this->TarifKWH,
                ]);

                // Toast sukses
                $this->toast(
                    type: 'success',
                    title: 'It is done!',
                    description: 'Data Tarif Berhasil Diperbarui!',
                    position: 'toast-top toast-end',
                    icon: 'o-information-circle',
                    css: 'alert-info',
                    timeout: 3000,
                    redirectTo: null
                );

                $this->refreshTable();
                $this->closeModal();
            } else {
                // Toast error jika tarif tidak ditemukan
                $this->toast(
                    type: 'error',
                    title: 'Error!',
                    description: 'Tarif tidak ditemukan.',
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
    <!-- Modal untuk mengedit data tarif -->
    <x-mary-modal wire:model="editModal" class="backdrop-blur" box-class="max-w-4xl w-100">
        <x-mary-header title="Edit Tarif" subtitle="Edit data tarif" separator />
        <x-mary-form wire:submit.prevent="save" no-separator>
            <div class="grid grid-cols-12 gap-4">
                <!-- No Tarif -->
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
                <x-mary-button label="Cancel" @click="$wire.closeModal()" />
                <x-mary-button label="Save" class="btn-primary" type="submit" spinner="save" />
            </x-slot:actions>
        </x-mary-form>
    </x-mary-modal>
</div>
