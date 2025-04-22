<div>
    <x-mary-header title="Data Pembayaran" subtitle="Kelola data pembayaran listrik pelanggan." separator progress-indicator>
        <x-slot:middle class="!justify-end">
            <livewire:pelanggan.search-pelanggan name="search-pelanggan" />
        </x-slot:middle>
        <x-slot:actions>
            <livewire:pembayaran.add-pembayaran name="addModal" />
        </x-slot:actions>
    </x-mary-header>
    <x-mary-table class="bg-white dark:bg-base-100" :headers="$headers" :rows="$pembayaran" with-pagination
    per-page="perPage" :per-page-values="[5, 10, 20]">
        @scope('cell_No_Pembayaran', $pembayaran)
        {!! $pembayaran->No_Pembayaran !!}
        @endscope

        @scope('cell_stand_meter', $pembayaran)
        {!! $pembayaran->stand_meter !!}
        @endscope

        @scope('cell_total', $pembayaran)
        {!! $pembayaran->total !!}
        @endscope

        @scope('cell_total_bayar', $pembayaran)
        {!! $pembayaran->total_bayar !!}
        @endscope

        @scope('cell_actions', $pembayaran)
        {{-- <x-mary-dropdown>
            <x-slot:trigger>
                <x-mary-button icon="m-ellipsis-vertical" class="bg-transparent border-none" />
            </x-slot:trigger>
            <x-mary-menu-item icon="o-eye"
                wire:click="$dispatch('showModal', { id: '{{ $pembayaran->ID_Pembayaran }}' })" />
            <x-mary-menu-item icon="o-pencil-square"
                wire:click="$dispatch('showEditModal', { id: '{{ $pembayaran->ID_Pembayaran }}' })" />
            <x-mary-menu-item icon="o-trash"
                wire:click="$dispatch('showDeleteModal', { id: '{{ $pembayaran->ID_Pembayaran }}' })" />
        </x-mary-dropdown> --}}
        @if($pembayaran->StatusPembayaran == "Belum Lunas")
            {{$pembayaran}}
            <x-mary-button
                label="Konfirmasi"
                class="btn-success"
                wire:click="$dispatch('konfirmasiModal', { id: '{{ $pembayaran->No_Kontrol }}' })" />
        @else
            <x-mary-badge :value="$pembayaran->StatusPembayaran" class="badge-success badge-soft" />
        @endif
        @endscope

        <x-slot:empty>
            <x-mary-icon name="o-cube" label="Data Pembayaran Tidak Tersedia." />
        </x-slot:empty>
    </x-mary-table>

    <!-- Komponen Modal -->
    <livewire:pembayaran.show-pembayaran name="viewModal" />
    <livewire:pembayaran.edit-pembayaran name="editModal" />
    <livewire:pembayaran.delete-pembayaran name="deleteModal" />
    <livewire:pembayaran.konfirmasi-pembayaran name="konfirmasiModal" />
</div>
