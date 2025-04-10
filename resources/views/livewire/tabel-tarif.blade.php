<div>
    <x-mary-header title="Tarif" subtitle="Kelola data tarif listrik pelanggan dengan mudah." separator progress-indicator>
        <x-slot:middle class="!justify-end">
            <livewire:pelanggan.search-pelanggan name="search-pelanggan"/>
        </x-slot:middle>
        <x-slot:actions>
            <livewire:pelanggan.filter-pelanggan name="filterDraw"/>
            <livewire:tarif.add-tarif name="addModal" />
        </x-slot:actions>
    </x-mary-header>

    <x-mary-table class="bg-white dark:bg-base-100" 
        :headers="$headers" 
        :rows="$tarif"
        with-pagination
        per-page="perPage"
        :per-page-values="[3, 5, 10]"
        >
        <!-- Custom Kolom Nomor -->
        @scope('row_number', $row)
            <span>{{ $row['number'] }}</span>
        @endscope

        <!-- Custom Kolom Aksi -->
        @scope('cell_actions', $row)
            <x-mary-dropdown>
                <x-slot:trigger>
                    <x-mary-button icon="m-ellipsis-vertical" class="bg-transparent dark:bg-transparent border-none" />
                </x-slot:trigger>

                <x-mary-menu-item
                    icon="o-eye"
                    wire:click="$dispatch('showModal', { id: '{{ $row['ID_Tarif'] }}' })"
                    spiner
                />
                <x-mary-menu-item
                    icon="o-pencil-square"
                    wire:click="$dispatch('showEditModal', { id: '{{ $row['ID_Tarif'] }}' })"
                    spiner
                />
                <x-mary-menu-item
                    icon="o-trash"
                    wire:click="$dispatch('showDeleteModal', { id: '{{ $row['ID_Tarif'] }}', no: '{{ $row['No_Tarif'] }}' })"
                    spiner
                />
            </x-mary-dropdown>
        @endscope

        <!-- Tampilkan pesan jika data kosong -->
        <x-slot:empty>
            <x-mary-icon name="o-cube" label="Data Tarif Tidak Tersedia." />
        </x-slot:empty>
    </x-mary-table>

    <!-- Komponen modal untuk melihat, mengedit, dan menghapus data -->
    <livewire:tarif.show-tarif name="viewModal" />
    <livewire:tarif.edit-tarif name="editModal" />
    <livewire:tarif.delete-tarif name="deleteModal" />
</div>