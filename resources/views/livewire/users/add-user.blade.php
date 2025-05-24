<?php

use Livewire\Volt\Component;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Mary\Traits\Toast;

new class extends Component {
    use Toast;

    public $addModal = false;
    public $no_user;
    public $name;
    public $email;
    public $password;
    public $password_confirmation;
    public $role = 'loket'; // Default role adalah loket

    // Method untuk membuka modal
    public function openModal()
    {
        $this->addModal = true;
    }

    // Method untuk generate no_user
    public function generateNoUser()
    {
        if (empty($this->name)) {
            session()->flash('error', 'Nama harus diisi terlebih dahulu.');
            return;
        }

        $tahun = date('Y'); // Current year
        $inisial = substr(strtoupper(preg_replace('/[^A-Za-z]/', '', $this->name)), 0, 3); // Get first 3 letters

        // Find the latest user number with this pattern
        $latestUser = User::where('no_user', 'like', "USR/{$inisial}-{$tahun}/%")
            ->orderBy('no_user', 'desc')
            ->first();

        // Determine the next sequence number
        $sequence = 1;
        if ($latestUser) {
            // Extract the number part
            $parts = explode('/', $latestUser->no_user);
            $numberPart = end($parts);
            $sequence = (int) $numberPart + 1;
        }

        // Format with leading zeros
        $this->no_user = sprintf('USR/%s-%s/%03d', $inisial, $tahun, $sequence);
    }

    // Method untuk menyimpan data
    public function save()
    {
        $this->validate([
            'no_user' => 'required|string|unique:users,no_user',
            'name' => 'required|string|min:3',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|in:loket', // Hanya boleh loket, admin tidak bisa dibuat
        ]);
        // dd($this->no_user);
        User::create([
            'no_user' => $this->no_user,
            'name' => $this->name,
            'email' => $this->email,
            'password' => Hash::make($this->password),
            'role' => $this->role,
        ]);

        // Toast
        $this->success('User berhasil ditambahkan', position: 'toast-bottom');

        $this->resetForm();
        $this->dispatch('addSuccess');
        $this->addModal = false;
    }

    // Method untuk mereset form
    public function resetForm()
    {
        $this->reset(['no_user', 'name', 'email', 'password', 'password_confirmation']);
        $this->role = 'loket'; // Reset ke default
    }
};
?>

<div>
    <x-mary-modal wire:model="addModal" class="backdrop-blur" box-class="max-w-4xl w-100">
        <x-mary-header title="Tambah User" subtitle="Isikan data yang benar!" separator />
        <x-mary-form wire:submit.prevent="save" no-separator>
            <div class="grid grid-cols-12 gap-4">
                <!-- No User otomatis -->
                <div class="col-span-6">
                    <x-mary-input label="No User" wire:model="no_user" readonly class="" />
                </div>
                <div class="col-span-6">
                    <x-mary-input label="Nama Lengkap" wire:model="name" class=""
                        wire:change="generateNoUser" />
                </div>
            </div>

            <div class="grid grid-cols-12 gap-4 mt-4">
                <div class="col-span-6">
                    <x-mary-input label="Email" wire:model="email" type="email" class="" />
                </div>
                <div class="col-span-6">
                    <x-mary-input label="Role" wire:model="role" readonly class="" />
                </div>
            </div>

            <div class="grid grid-cols-12 gap-4 mt-4">
                <div class="col-span-6">
                    <x-mary-input label="Password" wire:model="password" type="password"
                        class="" />
                </div>
                <div class="col-span-6">
                    <x-mary-input label="Konfirmasi Password" wire:model="password_confirmation" type="password"
                        class="" />
                </div>
            </div>

            <x-slot:actions>
                <x-mary-button label="Batal" @click="$wire.addModal = false" />
                <x-mary-button label="Simpan" class="btn-primary" type="submit" spinner="save" />
            </x-slot:actions>
        </x-mary-form>
    </x-mary-modal>

    <!-- Tombol untuk membuka modal -->
    <x-mary-button icon="o-plus" class="btn-primary" @click="$wire.openModal()" />
</div>
