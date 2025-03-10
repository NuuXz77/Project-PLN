<?php

use Livewire\Volt\Component;
use App\Models\Tarif;
use Mary\Traits\Toast;

new class extends Component {
    use Toast;

    public function refreshTable()
    {
        $this->dispatch('deleteSuccess');
    }

    public bool $deleteModal = false;
    public $tarifId = null;
    public $tarifNo = null;

    // Menerima event dari $dispatch
    protected $listeners = ['showDeleteModal' => 'openModal'];

    // Membuka modal dan menyimpan ID tarif
    public function openModal($no, $id): void
    {
        $this->tarifNo = $no;
        $this->tarifId = $id;
        $this->deleteModal = true;
    }

    // Fungsi hapus tarif
    public function deleteTarif()
    {
        try {
            $tarif = Tarif::find($this->tarifId);

            if ($tarif) {
                $tarif->delete();

                // Toast
                $this->toast(
                    type: 'success',
                    title: 'It is done!',
                    description: 'Data Tarif Berhasil Dihapus!',
                    position: 'toast-top toast-end',
                    icon: 'o-information-circle',
                    css: 'alert-info',
                    timeout: 3000,
                    redirectTo: null
                );
            } else {
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
            $this->toast(
                type: 'error',
                title: 'Error!',
                description: 'Terjadi kesalahan saat menghapus tarif.',
                position: 'toast-top toast-end',
                icon: 'o-information-circle',
                css: 'alert-error',
                timeout: 3000,
                redirectTo: null
            );
        }

        $this->refreshTable();
        $this->deleteModal = false; // Tutup modal
    }
};
?>

<div>
    <!-- Modal Delete -->
    <x-mary-modal wire:model="deleteModal" class="backdrop-blur">
        <div class="mb-5">
            Apakah Anda yakin ingin menghapus tarif dengan No: {{ $tarifNo }}?
        </div>

        <!-- Tombol Hapus -->
        <x-mary-button label="Hapus" class="btn-error" wire:click="deleteTarif" />
        <!-- Tombol Batal -->
        <x-mary-button label="Batal" @click="$wire.deleteModal = false" />
    </x-mary-modal>
</div>
