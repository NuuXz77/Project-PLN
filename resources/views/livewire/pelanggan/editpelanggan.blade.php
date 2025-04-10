<?php

use Livewire\Volt\Component;
use App\Models\Pelanggan;
use Mary\Traits\Toast;

new class extends Component {
    use Toast;

    public $editModal = false; // Modal untuk mengedit data
    public $customer_id; // ID pelanggan yang akan diedit
    public $No_Kontrol;
    public $Nama;
    public $Alamat;
    public $Telepon;
    public $Email;
    public $Jenis_Plg;

    // Menerima event dari $dispatch
    protected $listeners = ['showEditModal' => 'openModal'];

    public function refreshTable()
    {
        $this->dispatch('editSuccess');
    }
    // Method untuk membuka modal dan mengambil data berdasarkan customer_id
    public function openModal($id)
    {
        // Ambil data pelanggan berdasarkan ID
        $pelanggan = Pelanggan::find($id);

        if ($pelanggan) {
            // Isi properti dengan data yang ditemukan
            $this->customer_id = $pelanggan->ID_Pelanggan;
            $this->No_Kontrol = $pelanggan->No_Kontrol;
            $this->Nama = $pelanggan->Nama;
            $this->Alamat = $pelanggan->Alamat;
            $this->Telepon = $pelanggan->Telepon;
            $this->Email = $pelanggan->Email;
            $this->Jenis_Plg = $pelanggan->Jenis_Plg;

            // Buka modal
            $this->editModal = true;
        } else {
            // Beri feedback jika data tidak ditemukan
            $this->toast(
                type: 'error',
                title: 'Error!',
                description: 'Pelanggan tidak ditemukan.',
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
        $this->reset(['customer_id', 'No_Kontrol', 'Nama', 'Alamat', 'Telepon', 'Email', 'Jenis_Plg']);
    }

    // Method untuk menyimpan perubahan data pelanggan
    public function save()
    {
        // Validasi data
        $this->validate([
            'No_Kontrol' => 'required',
            'Nama' => 'required|string|max:255',
            'Alamat' => 'required|string|max:1000',
            'Telepon' => 'required|numeric|min:10',
            'Email' => 'required|email',
            'Jenis_Plg' => 'required|in:1,2,3',
        ]);

        try {
            // Cari pelanggan berdasarkan ID
            $pelanggan = Pelanggan::find($this->customer_id);

            if ($pelanggan) {
                // Update data pelanggan
                $pelanggan->update([
                    'No_Kontrol' => $this->No_Kontrol,
                    'Nama' => $this->Nama,
                    'Alamat' => $this->Alamat,
                    'Telepon' => $this->Telepon,
                    'Email' => $this->Email,
                    'Jenis_Plg' => $this->Jenis_Plg,
                ]);

                // Toast sukses
                $this->toast(
                    type: 'success',
                    title: 'It is done!',
                    description: 'Data Berhasil Diperbarui!',
                    position: 'toast-top toast-end',
                    icon: 'o-information-circle',
                    css: 'alert-info',
                    timeout: 3000,
                    redirectTo: null
                );

                $this->refreshTable();
                $this->closeModal();
            } else {
                // Toast error jika pelanggan tidak ditemukan
                $this->toast(
                    type: 'error',
                    title: 'Error!',
                    description: 'Pelanggan tidak ditemukan.',
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
}; ?>

<div>
    <!-- Modal untuk mengedit data pelanggan -->
    <x-mary-modal wire:model="editModal" class="backdrop-blur" box-class="max-w-4xl w-100">
        <x-mary-header title="Edit Pelanggan" subtitle="Edit data pelanggan" separator />
        <x-mary-form wire:submit.prevent="save" no-separator>
            <div class="grid grid-cols-12 gap-4">
                <!-- No Kontrol otomatis -->
                <div class="col-span-6">
                    <x-mary-input label="No Kontrol" wire:model="No_Kontrol" readonly
                        class="dark:text-black text-gray-900" />
                </div>
                <div class="col-span-6">
                    <x-mary-input label="Nama Pelanggan" wire:model="Nama"
                        class="dark:text-black text-gray-900" />
                </div>
            </div>

            <div class="grid grid-cols-12 gap-4">
                <div class="col-span-4">
                    <x-mary-select
                        label="Jenis Pelanggan"
                        wire:model="Jenis_Plg"
                        :options="[ 
                            ['id' => '1', 'name' => 'Rumah Tangga'], 
                            ['id' => '2', 'name' => 'Bisnis'], 
                            ['id' => '3', 'name' => 'Industri']
                        ]"
                        option-value="id"
                        option-label="name"
                        placeholder="Pilih Jenis Pelanggan"
                        class="dark:text-black text-gray-900" />
                </div>
                <div class="col-span-4">
                    <x-mary-input label="Email" wire:model="Email"
                        class="dark:text-black text-gray-900" />
                </div>
                <div class="col-span-4">
                    <x-mary-input label="Telepon" wire:model="Telepon"
                        class="dark:text-black text-gray-900" />
                </div>
            </div>

            <div class="grid grid-cols-12 gap-4">
                <div class="col-span-12 mt-3">
                    <x-mary-textarea
                        wire:model="Alamat"
                        placeholder="User Address ..."
                        hint="Max 1000 chars"
                        rows="3"
                        inline
                        class="dark:text-black text-gray-900" />
                </div>
            </div>

            <x-slot:actions>
                <x-mary-button label="Cancel" @click="$wire.closeModal()" />
                <x-mary-button label="Save" class="btn-primary" type="submit" spinner="save" />
            </x-slot:actions>
        </x-mary-form>
    </x-mary-modal>
</div>