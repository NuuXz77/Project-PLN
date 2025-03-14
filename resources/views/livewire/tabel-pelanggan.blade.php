<div>
    <x-mary-header title="Pelanggan" separator progress-indicator>
        <x-slot:middle class="!justify-end">
            <livewire:pelanggan.search-pelanggan name="search-pelanggan"/>
        </x-slot:middle>
        <x-slot:actions>
            <livewire:pelanggan.filter-pelanggan name="filterDraw"/>
            <livewire:pelanggan.addpelanggan name="addModal" />

        </x-slot:actions>
    </x-mary-header>

    <x-mary-table class="bg-white dark:bg-base-100" 
        :headers="$headers" 
        :rows="$pelanggan"
        with-pagination
        per-page="perPage"
        :per-page-values="[3, 5, 10]"
        >
        <!-- Custom Kolom Nomor -->
        @scope('row_number', $row)
            <span>{{ $row['number'] }}</span>
        @endscope

         @scope('actions', $row)
            <x-mary-dropdown>
                <x-slot:trigger>
                    <x-mary-button icon="m-ellipsis-vertical" class="bg-transparent dark:bg-transparent border-none" />
                </x-slot:trigger>

                <x-mary-menu-item
                    icon="o-eye"
                    wire:click="$dispatch('showModal', { id: '{{ $row['ID_Pelanggan'] }}' })"
                />
                <x-mary-menu-item
                    icon="o-pencil-square"
                    wire:click="$dispatch('showEditModal', { id: '{{ $row['ID_Pelanggan'] }}' })"
                />
                <x-mary-menu-item
                    icon="o-trash"
                    wire:click="$dispatch('showDeleteModal', { id: '{{ $row['ID_Pelanggan'] }}',no: '{{ $row['No_Kontrol'] }}' })"
                />
            </x-mary-dropdown>
        @endscope

        <!-- Letakkan komponen di luar -->
        
        
        <x-slot:empty>
            <x-mary-icon name="o-cube" label="Data Pelanggan Tidak Tersedia." />
        </x-slot:empty>
    </x-mary-table>
    <livewire:pelanggan.showpelanggan name="viewModal" />
    <livewire:pelanggan.editpelanggan name="editModal" />
    <livewire:pelanggan.deletepelanggan name="deleteModal" />
</div>
