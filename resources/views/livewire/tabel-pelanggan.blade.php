<div>
    <x-mary-header title="Pelanggan" separator progress-indicator>
        <x-slot:middle class="!justify-end">
            <livewire:pelanggan.search-pelanggan name="search-pelanggan"/>
        </x-slot:middle>
        <x-slot:actions>
            <livewire:pelanggan.filter-pelanggan name="filterDraw"/>
            <livewire:pelanggan.addpelanggan name="addModal" />
            <livewire:pelanggan.showpelanggan name="viewModal" />
            <livewire:pelanggan.deletepelanggan name="deleteModal" />
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

         <!-- Kolom Aksi dengan Dropdown -->
        @scope('actions', $row)
            <x-mary-dropdown class="z-0" style="margin: 0; padding: 0;">
                <x-slot:trigger>
                    <x-mary-button icon="m-ellipsis-vertical" class="bg-transparent dark:bg-transparent border-none" />
                </x-slot:trigger>

                <x-mary-menu-item
                    icon="o-eye" 
                    wire:click="showpelanggan({{ $row['id_pelanggan'] }})"
                />
                <x-mary-menu-item 
                    icon="o-pencil-square" 
                    wire:click="editPelanggan({{ $row['id_pelanggan'] }})"
                />
                <livewire:pelanggan.deletepelanggan name="deleteModal"/>
            </x-mary-dropdown>
        @endscope

        <x-slot:empty>
            <x-mary-icon name="o-cube" label="Data Pelanggan Tidak Tersedia." />
        </x-slot:empty>
    </x-mary-table>
</div>
