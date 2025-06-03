<?php

namespace App\Livewire;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class TabelUsers extends Component
{
    use WithPagination;

    public $search = '';
    public $perPage = 5;

    protected $listeners = [
        'searchUpdated' => 'updateSearch',
        'addSuccess' => 'refreshTable',
        'editSuccess' => 'refreshTable',
        'deleteSuccess' => 'refreshTable',
    ];

    public function refreshTable()
    {
        $this->resetPage();
    }

    public function updateSearch($value)
    {
        $this->search = $value;
        $this->resetPage();
    }

    public function render()
    {
        $headers = [
            ['key' => 'number', 'label' => 'No', 'class' => 'text-center'],
            ['key' => 'no_user', 'label' => 'No User'],
            ['key' => 'name', 'label' => 'Nama'],
            ['key' => 'email', 'label' => 'Email'],
            ['key' => 'role', 'label' => 'Role'],
            ['key' => 'actions', 'label' => 'Aksi', 'class' => 'text-center'],
        ];

        // Filter hanya menampilkan user dengan role 'loket'
        $users = User::query()
            ->where('role', 'loket') // Hanya tampilkan role loket
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('no_user', 'like', '%' . $this->search . '%')
                        ->orWhere('name', 'like', '%' . $this->search . '%')
                        ->orWhere('email', 'like', '%' . $this->search . '%');
                });
            })
            ->paginate($this->perPage);

        // Tambahkan nomor urut dinamis
        collect($users->items())->transform(function ($item, $index) use ($users) {
            $item->number = ($users->currentPage() - 1) * $users->perPage() + $index + 1;
            return $item;
        });

        return view('livewire.tabel-users', [
            'headers' => $headers,
            'users' => $users,
        ]);
    }
}
