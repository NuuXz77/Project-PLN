<?php

use Livewire\Volt\Component;
use App\Models\User;
use Mary\Traits\Toast;

new class extends Component {
    use Toast;

    public function refreshTable()
    {
        $this->dispatch('deleteSuccess');
    }

    public bool $deleteModal = false;
    public $userId = null;
    public $userNo = null;
    public $userName = null;

    // Listen for the delete event
    protected $listeners = ['showDeleteModal' => 'openModal'];

    // Open modal and store user data
    public function openModal($id): void
    {
        $user = User::find($id);
        if ($user) {
            $this->userId = $id ?? null;
            $this->userName = $user->name ?? null;
            $this->deleteModal = true;
        }
    }

    // Delete user function
    public function deleteUser()
    {
        try {
            // Prevent deleting admin accounts
            $user = User::where('id', $this->userId)->where('role', '!=', 'admin')->first();

            if ($user) {
                $user->delete();

                $this->success('User berhasil dihapus', position: 'toast-top toast-end', timeout: 3000);
            } else {
                $this->error('User tidak ditemukan atau tidak boleh dihapus (admin)', position: 'toast-top toast-end', timeout: 3000);
            }
        } catch (\Exception $e) {
            $this->error('Terjadi kesalahan saat menghapus user: ' . $e->getMessage(), position: 'toast-top toast-end', timeout: 3000);
        }

        $this->refreshTable();
        $this->deleteModal = false;
    }
};
?>

<div>
    <!-- Delete Confirmation Modal -->
    <x-mary-modal wire:model="deleteModal" class="backdrop-blur">
        <div class="mb-5">
            <p class="font-bold text-lg">Konfirmasi Penghapusan</p>
            <p>Apakah Anda yakin ingin menghapus user berikut?</p>
            <div class="mt-2 p-4 bg-base-200 rounded-lg">
                <p><span class="font-semibold">No User:</span> {{ $userNo }}</p>
                <p><span class="font-semibold">Nama:</span> {{ $userName }}</p>
            </div>
            <p class="mt-3 text-warning">Perhatian: Aksi ini tidak dapat dibatalkan!</p>
        </div>

        <div class="flex gap-3 justify-end">
            <!-- Cancel Button -->
            <x-mary-button label="Batal" @click="$wire.deleteModal = false" />
            <!-- Delete Button -->
            <x-mary-button label="Hapus" class="btn-error" wire:click="deleteUser" spinner="deleteUser" />
        </div>
    </x-mary-modal>
</div>
