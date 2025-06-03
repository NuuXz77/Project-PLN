<?php

use Livewire\Volt\Component;
use App\Models\Pelanggan;
use Livewire\WithPagination;
use Mary\Traits\Toast;

new class extends Component {
    use Toast;
    // use WithPagination;

    public function refreshTable()
    {
        $this->dispatch('deleteSuccess');
    }

    public bool $deleteModal = false;
    public $pelangganId = null;
    public $pelangganNo = null;

    // Menerima event dari $dispatch
    protected $listeners = ['showDeleteModal' => 'openModal'];

    // Membuka modal dan menyimpan ID pelanggan
    public function openModal($no,$id): void
    {
        // dump($no,$id);
        $this->pelangganNo = $no;
        $this->pelangganId = $id;
        $this->deleteModal = true;
    }

    // Fungsi hapus pelanggan
    public function deletePelanggan()
    {
        try {
            $pelanggan = Pelanggan::find($this->pelangganId);
            $pelanggan->delete();

            if ($pelanggan) {
                // dd($pelanggan);
                // Toast
                $this->toast(
                    type: 'success',
                    title: 'Success',
                    description: 'Data Berhasil Di Hapus!',
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
                    description: 'Pelanggan tidak ditemukan.',
                    position: 'toast-top toast-end',
                    icon: 'o-information-circle',
                    css: 'alert-error',
                    timeout: 3000,
                    redirectTo: null
                );
            }
        } catch (\Exception $e) {
            dd($e);
            $this->toast(
                type: 'error',
                title: 'Error!',
                description: 'Terjadi kesalahan saat menghapus pelanggan.',
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
            Apakah anda yakin ingin menghapus pelanggan dengan No Kontrol : {{ $pelangganNo }}?
        </div>

        <!-- Tombol Hapus -->
        <x-mary-button label="Hapus" class="btn-error" wire:click="deletePelanggan" />
        <!-- Tombol Batal -->
        <x-mary-button label="Batal" @click="$wire.deleteModal = false" />
    </x-mary-modal>
</div>