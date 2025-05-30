<div>
    <x-mary-header title="Users" subtitle="Kelola data pengguna dengan mudah." separator progress-indicator>
        <x-slot:middle class="!justify-end">
            <livewire:users.search-users name="search-users"/>
        </x-slot:middle>
        <x-slot:actions>
            {{-- <livewire:users.filter-users name="filterDraw"/> --}}
            <livewire:users.add-user />
        </x-slot:actions>
    </x-mary-header>

    <x-mary-table class="bg-white dark:bg-base-100 [&_thead]:text-gray-500" 
        :headers="$headers" 
        :rows="$users"
        with-pagination
        per-page="perPage"
        :per-page-values="[3, 5, 10]"
        >
        <!-- Custom Kolom Nomor -->
        @scope('row_number', $row)
            <span>{{ $row['number'] }}</span>
        @endscope
            
        <!-- Kolom Role -->
        @scope('cell_role', $user)
            <x-mary-badge :value="$user['role']" class="capitalize" />
        @endscope

        <!-- Custom Kolom Aksi -->
        @scope('cell_actions', $row)
            <x-mary-dropdown>
                <x-slot:trigger>
                    <x-mary-button icon="m-ellipsis-vertical" class="bg-transparent dark:bg-transparent border-none" />
                </x-slot:trigger>
                <x-mary-menu-item
                    icon="o-pencil-square"
                    wire:click="$dispatch('showEditModal', { id: '{{ $row['id'] }}' })"
                    spiner
                />
                <x-mary-menu-item
                    icon="o-trash"
                    wire:click="$dispatch('showDeleteModal', { id: '{{ $row['id'] }}' })"
                    spiner
                />
            </x-mary-dropdown>
        @endscope

        <!-- Tampilkan pesan jika data kosong -->
        <x-slot:empty>
            <x-mary-icon name="o-user" label="Data User Tidak Tersedia." />
        </x-slot:empty>
    </x-mary-table>

    <!-- Komponen modal untuk melihat, mengedit, dan menghapus data -->
    {{-- <livewire:users.show-user name="viewModal" /> --}}
    <livewire:users.edit-user name="editModal" />
    <livewire:users.delete-user name="deleteModal" />
</div>