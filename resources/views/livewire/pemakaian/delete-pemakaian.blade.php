<?php

namespace App\Livewire;

use Livewire\Volt\Component;
use App\Models\Pemakaian;
use Mary\Traits\Toast;

new class extends Component {
    use Toast;

    public $deleteModal = false; // Modal untuk menghapus data
    public $pemakaian_id; // ID pemakaian yang akan dihapus
    public $No_Pemakaian; // No Pemakaian untuk ditampilkan di modal

    // Menerima event dari $dispatch
    protected $listeners = ['showDeleteModal' => 'openModal'];

    // Method untuk membuka modal dan mengambil data berdasarkan pemakaian_id
    public function openModal($id)
    {
        // Ambil data pemakaian berdasarkan ID
        $pemakaian = Pemakaian::find($id);

        if ($pemakaian) {
            // Isi properti dengan data yang ditemukan
            $this->pemakaian_id = $pemakaian->ID_Pemakaian;
            $this->No_Pemakaian = $pemakaian->No_Pemakaian;

            // Buka modal
            $this->deleteModal = true;
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

    // Method untuk menghapus data pemakaian
    public function deletePemakaian()
    {
        try {
            // Cari pemakaian berdasarkan ID
            $pemakaian = Pemakaian::find($this->pemakaian_id);

            if ($pemakaian) {
                // Hapus data pemakaian
                $pemakaian->delete();
                
                // Toast sukses
                $this->toast(
                    type: 'success',
                    title: 'It is done!',
                    description: 'Data Pemakaian Berhasil Dihapus!',
                    position: 'toast-top toast-end',
                    icon: 'o-information-circle',
                    css: 'alert-info',
                    timeout: 3000,
                    redirectTo: null
                );

                $this->dispatch('deleteSuccess');
                $this->deleteModal = false; // Tutup modal
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

    // Method untuk menutup modal
    public function closeModal()
    {
        $this->deleteModal = false;
        $this->resetForm();
    }

    // Method untuk reset form
    public function resetForm()
    {
        $this->reset(['pemakaian_id', 'No_Pemakaian']);
    }
};
?>

<div>
    <!-- Modal untuk menghapus data pemakaian -->
    <x-mary-modal wire:model="deleteModal" class="backdrop-blur">
        <div class="mb-5">
            Apakah Anda yakin ingin menghapus pemakaian dengan No: {{ $No_Pemakaian }}?
        </div>

        <!-- Tombol Hapus -->
        <x-mary-button label="Hapus" class="btn-error" wire:click="deletePemakaian" />
        <!-- Tombol Batal -->
        <x-mary-button label="Batal" @click="$wire.closeModal()" />
    </x-mary-modal>
</div>
