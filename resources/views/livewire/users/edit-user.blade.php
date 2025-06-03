<?php

use Livewire\Volt\Component;
use App\Models\User;
use Mary\Traits\Toast;
use Illuminate\Support\Facades\Hash;

new class extends Component {
    use Toast;

    public $editModal = false;
    public $user_id;
    public $no_user;
    public $name;
    public $email;
    public $password;
    public $password_confirmation;
    public $role = 'loket'; // Default role adalah loket

    protected $listeners = ['showEditModal' => 'openModal'];

    public function refreshTable()
    {
        $this->dispatch('editSuccess');
    }

    public function openModal($id)
    {
        $user = User::find($id);

        if ($user) {
            $this->user_id = $user->id;
            $this->no_user = $user->no_user;
            $this->name = $user->name;
            $this->email = $user->email;
            $this->role = $user->role;
            
            // Password tidak diisi secara default
            $this->password = '';
            $this->password_confirmation = '';

            $this->editModal = true;
        } else {
            $this->toast(
                type: 'error',
                title: 'Error!',
                description: 'User tidak ditemukan.',
                position: 'toast-top toast-end',
                icon: 'o-information-circle',
                css: 'alert-error',
                timeout: 3000
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
            'user_id', 
            'no_user', 
            'name', 
            'email', 
            'password',
            'password_confirmation'
        ]);
        $this->role = 'loket';
    }

    public function save()
    {
        $rules = [
            'no_user' => 'required|string|unique:users,no_user,'.$this->user_id,
            'name' => 'required|string|min:3',
            'email' => 'required|email|unique:users,email,'.$this->user_id,
            'role' => 'required|in:loket' // Hanya boleh loket
        ];

        // Hanya validasi password jika diisi
        if ($this->password) {
            $rules['password'] = 'required|string|min:8|confirmed';
        }

        $this->validate($rules);

        try {
            $user = User::find($this->user_id);

            if ($user) {
                $updateData = [
                    'no_user' => $this->no_user,
                    'name' => $this->name,
                    'email' => $this->email,
                    'role' => $this->role
                ];

                // Update password hanya jika diisi
                if ($this->password) {
                    $updateData['password'] = Hash::make($this->password);
                }

                $user->update($updateData);

                $this->success('Data user berhasil diperbarui', position: 'toast-top toast-end');
                $this->refreshTable();
                $this->closeModal();
            } else {
                $this->error('User tidak ditemukan', position: 'toast-top toast-end');
            }
        } catch (\Exception $e) {
            $this->error('Terjadi kesalahan: '.$e->getMessage(), position: 'toast-top toast-end');
        }
    }
};
?>

<div>
    <x-mary-modal wire:model="editModal" class="backdrop-blur" box-class="max-w-4xl w-100">
        <x-mary-header title="Edit User" subtitle="Edit data user" separator />
        <x-mary-form wire:submit.prevent="save" no-separator>
            <div class="grid grid-cols-12 gap-4">
                <div class="col-span-6">
                    <x-mary-input label="No User" wire:model="no_user" readonly class=""/>
                </div>
                <div class="col-span-6">
                    <x-mary-input 
                        label="Nama Lengkap" 
                        wire:model="name" 
                        class=""
                    />
                </div>
            </div>

            <div class="grid grid-cols-12 gap-4 mt-4">
                <div class="col-span-6">
                    <x-mary-input 
                        label="Email" 
                        wire:model="email" 
                        type="email" 
                        class="" 
                    />
                </div>
                <div class="col-span-6">
                    <x-mary-input 
                        label="Role" 
                        wire:model="role" 
                        readonly
                        class=""
                    />
                </div>
            </div>

            <div class="grid grid-cols-12 gap-4 mt-4">
                <div class="col-span-6">
                    <x-mary-input 
                        label="Password (Kosongkan jika tidak diubah)" 
                        wire:model="password" 
                        type="password" 
                        class="" 
                    />
                </div>
                <div class="col-span-6">
                    <x-mary-input 
                        label="Konfirmasi Password" 
                        wire:model="password_confirmation" 
                        type="password" 
                        class="" 
                    />
                </div>
            </div>

            <x-slot:actions>
                <x-mary-button label="Batal" @click="$wire.closeModal()" />
                <x-mary-button label="Simpan" class="btn-primary" type="submit" spinner="save" />
            </x-slot:actions>
        </x-mary-form>
    </x-mary-modal>
</div>