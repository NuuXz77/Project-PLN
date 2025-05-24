<div>
    <x-mary-header title="Transaksi" subtitle="Transaksi hasil dari pembayaran ada disini." separator progress-indicator>
        <x-slot:middle class="!justify-end">
            <livewire:pelanggan.search-pelanggan name="search-pelanggan" />
        </x-slot:middle>
        <x-slot:actions>
            <livewire:pelanggan.filter-pelanggan name="filterDraw" />
        </x-slot:actions>
    </x-mary-header>

    <x-mary-table class="bg-white dark:bg-base-100 [&_thead]:text-gray-500" :headers="$headers" :rows="$transaksi" with-pagination per-page="perPage"
        :per-page-values="[5, 10, 20]">
        <!-- Custom Kolom Nomor -->
        @scope('row_number', $row)
            <span>{{ $row['number'] }}</span>
        @endscope

        <!-- Kolom Tanggal -->
        @scope('cell_TanggalPembayaran', $transaksi)
            <span>{{ \Carbon\Carbon::parse($transaksi['TanggalPembayaran'])->format('d/m/Y H:i') }}</span>
        @endscope

        <!-- Kolom Total Tagihan -->
        @scope('cell_TotalTagihan', $transaksi)
            <span>Rp {{ number_format($transaksi['TotalTagihan'], 0, ',', '.') }}</span>
        @endscope

        <!-- Kolom Status -->
        @scope('cell_Status', $transaksi)
            @if ($transaksi['Status'] === 'Lunas')
                <x-mary-badge value="Lunas" class="badge-success badge-soft" />
            @elseif($transaksi['Status'] === 'Menunggu Konfirmasi')
                <x-mary-badge value="Menunggu Konfirmasi" class="badge-warning badge-soft" />
            @else
                <x-mary-badge value="Gagal" class="badge-error badge-soft" />
            @endif
        @endscope

        <!-- Custom Kolom Aksi -->
        @scope('cell_actions', $transaksi)
            <span class="actions-column">
                <x-mary-dropdown>
                    <x-slot:trigger>
                        <x-mary-button icon="m-ellipsis-vertical" class="bg-transparent dark:bg-transparent border-none" />
                    </x-slot:trigger>
                    <x-mary-menu-item icon="o-eye" label="Lihat"
                        wire:click="$dispatch('openShowModal', { id: '{{ $transaksi['ID_Transaksi'] }}' })" />
                    <x-mary-menu-item icon="o-printer" label="Cetak"
                        wire:click="$dispatch('printModal', { id: '{{ $transaksi['ID_Transaksi'] }}' })" />
                </x-mary-dropdown>
            </span>
        @endscope


        <!-- Tampilkan pesan jika data kosong -->
        <x-slot:empty>
            <x-mary-icon name="o-cube" label="Data Transaksi Tidak Tersedia." />
        </x-slot:empty>
    </x-mary-table>

    <!-- Komponen modal -->
    <livewire:transaksi.show-transaksi />
    <livewire:transaksi.print-transaksi />
</div>
