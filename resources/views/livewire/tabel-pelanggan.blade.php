<div>
    <x-mary-header title="Pelanggan" subtitle="Dashboard / Pelanggan" separator progress-indicator>
        <x-slot:middle class="!justify-end">
            <x-mary-input icon="o-bolt" placeholder="Search..." />
        </x-slot:middle>
        <x-slot:actions>
            <x-mary-button icon="o-funnel" />
            <livewire:pelanggan.addpelanggan name="addModal" />
        </x-slot:actions>
    </x-mary-header>

    <div>
        <x-mary-header title="Pelanggan" subtitle="Dashboard / Pelanggan" separator progress-indicator>
            <x-slot:middle class="!justify-end">
                <x-mary-input icon="o-bolt" placeholder="Search..." />
            </x-slot:middle>
            <x-slot:actions>
                <x-mary-button icon="o-funnel" />
                <livewire:pelanggan.addpelanggan name="addModal" />
            </x-slot:actions>
        </x-mary-header>

        <x-mary-table
            :headers="$headers"
            :rows="$pelanggan"
            with-pagination
            per-page="perPage"
            :per-page-values="[5, 50, 100]">
            <!-- Custom Kolom Nomor -->
            @scope('row_number', $row)
            <span>{{ $row['number'] }}</span>
            @endscope

            <!-- Kolom Informasi yang Digabungkan -->
            @scope('informasi', $row)
            <div>
                <strong>Jenis Pelanggan:</strong> {{ $row['jenis_pelanggan'] }}<br>
                <strong>No HP:</strong> {{ $row['no_hp'] }}<br>
                <strong>Email:</strong> {{ $row['email'] }}
            </div>
            @endscope

            <!-- Kolom Aksi dengan Dropdown -->
            @scope('actions', $row)
            <x-mary-dropdown class="z-0" style="margin: 0; padding: 0;">
                <x-slot:trigger>
                    <x-mary-button icon="m-ellipsis-vertical" class="bg-transparent dark:bg-transparent border-none" />
                </x-slot:trigger>

                <x-mary-menu-item
                    icon="o-eye"
                    wire:click="showPelanggan({{ $row['id_pelanggan'] }})" />
                <x-mary-menu-item
                    icon="o-pencil-square"
                    wire:click="editPelanggan({{ $row['id_pelanggan'] }})" />
                <x-mary-menu-item
                    icon="o-trash"
                    wire:click="deletePelanggan({{ $row['id_pelanggan'] }})" />
            </x-mary-dropdown>
            @endscope

            <x-slot:empty>
                <x-mary-icon name="o-cube" label="Data Pelanggan Tidak Tersedia." />
            </x-slot:empty>
        </x-mary-table>
    </div>
</div>