<div>
    <x-mary-header title="Data Pemakaian" separator progress-indicator>
        <x-slot:middle class="!justify-end">
            <livewire:pelanggan.search-pelanggan name="search-pelanggan" />
        </x-slot:middle>

        <x-slot:actions>
            <livewire:pemakaian.add-pemakaian name="addModal" />
        </x-slot:actions>
    </x-mary-header>

    <x-mary-table class="bg-white dark:bg-base-100" 
        :headers="$headers" 
        :rows="$pemakaian"
        with-pagination
        per-page="perPage"
        :per-page-values="[5, 10, 20]"
        >
        {{-- <!-- Custom Kolom Nomor -->
        @scope('row_number', $pemakaian)
            <span>{{ $pemakaian['number'] }}</span>
        @endscope

        <!-- Kolom No Kontrol -->
        @scope('No_Kontrol', $pemakaian)
            <span>{{ $pemakaian->pelanggan->No_Kontrol }}</span>
        @endscope

        <!-- Kolom Nama Pelanggan -->
        @scope('Nama', $pemakaian)
            <span>{{ $pemakaian->pelanggan->Nama }}</span>
        @endscope

        <!-- Kolom Tanggal Catat -->
        @scope('TanggalCatat', $pemakaian)
            <span>{{ $pemakaian->TanggalCatat }}</span>
        @endscope

        <!-- Kolom Meter Awal -->
        @scope('MeterAwal', $pemakaian)
            <span>{{ $pemakaian->MeterAwal }}</span>
        @endscope

        <!-- Kolom Meter Akhir -->
        @scope('MeterAkhir', $pemakaian)
            <span>{{ $pemakaian->MeterAkhir }}</span>
        @endscope

        <!-- Kolom Jumlah Pakai -->
        @scope('JumlahPakai', $pemakaian)
            <span>{{ $pemakaian->JumlahPakai }}</span>
        @endscope

        <!-- Kolom Biaya Beban -->
        @scope('BiayaBebanPemakai', $pemakaian)
            <span>{{ number_format($pemakaian->BiayaBebanPemakai) }}</span>
        @endscope

        <!-- Kolom Biaya Pemakaian -->
        @scope('BiayaPemakaian', $pemakaian)
            <span>{{ number_format($pemakaian->BiayaPemakaian) }}</span>
        @endscope --}}

        <!-- Kolom Status Pembayaran -->
        @scope('cell_StatusPembayaran', $pemakaian)
            @if($pemakaian->StatusPembayaran == 'Belum Lunas')
                <x-mary-badge :value="$pemakaian->StatusPembayaran" class="badge-error" />
            @else
                <x-mary-badge :value="$pemakaian->StatusPembayaran" class="badge-success" />
            @endif
        @endscope

        <!-- Kolom Aksi -->
        @scope('actions', $pemakaian)
            <x-mary-dropdown>
                <x-slot:trigger>
                    <x-mary-button icon="m-ellipsis-vertical" class="bg-transparent border-none" />
                </x-slot:trigger>

                <x-mary-menu-item
                    icon="o-eye"
                    wire:click="$dispatch('showModal', { id: '{{ $pemakaian->ID_Pemakaian }}' })"
                />
                <x-mary-menu-item
                    icon="o-pencil-square"
                    wire:click="$dispatch('showEditModal', { id: '{{ $pemakaian->ID_Pemakaian }}' })"
                />
                <x-mary-menu-item
                    icon="o-trash"
                    wire:click="$dispatch('showDeleteModal', { id: '{{ $pemakaian->ID_Pemakaian }}' })"
                />
            </x-mary-dropdown>
        @endscope

        <x-slot:empty>
            <x-mary-icon name="o-cube" label="Data Pemakaian Tidak Tersedia." />
        </x-slot:empty>
    </x-mary-table>

    <!-- Komponen modal untuk melihat, mengedit, dan menghapus data -->
    <livewire:pemakaian.show-pemakaian name="viewModal" />
    <livewire:pemakaian.edit-pemakaian name="editModal" />
    <livewire:pemakaian.delete-pemakaian name="deleteModal" />
</div>