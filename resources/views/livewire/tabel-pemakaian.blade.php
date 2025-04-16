<div>
    <x-mary-header title="Data Pemakaian" subtitle="Kelola data pemakaian listrik pelanggan dengan mudah." separator progress-indicator>
        <x-slot:middle class="!justify-end">
            <livewire:pelanggan.search-pelanggan name="search-pelanggan" />
        </x-slot:middle>
        <x-slot:actions>
            <livewire:pemakaian.add-pemakaian name="addModal" />
        </x-slot:actions>
    </x-mary-header>

    <style>
        /* Responsive table */
        .responsive-table {
            width: 100%;
            overflow-x: auto;
        }
        
        /* Fixed layout for better column control */
        .pemakaian-table {
            table-layout: fixed;
            min-width: 900px; /* Minimum width before scrolling */
        }
        
        /* Column widths */
        .pemakaian-table th:nth-child(1),
        .pemakaian-table td:nth-child(1) { width: 5%; } /* No */
        .pemakaian-table th:nth-child(2),
        .pemakaian-table td:nth-child(2) { width: 15%; } /* No Pemakaian */
        .pemakaian-table th:nth-child(3),
        .pemakaian-table td:nth-child(3) { width: 10%; } /* No Kontrol */
        .pemakaian-table th:nth-child(4),
        .pemakaian-table td:nth-child(4) { width: 12%; } /* Meter */
        .pemakaian-table th:nth-child(5),
        .pemakaian-table td:nth-child(5) { width: 15%; } /* Jumlah Pakai */
        .pemakaian-table th:nth-child(6),
        .pemakaian-table td:nth-child(6) { width: 20%; } /* Biaya */
        .pemakaian-table th:nth-child(7),
        .pemakaian-table td:nth-child(7) { width: 10%; } /* Status */
        .pemakaian-table th:nth-child(8),
        .pemakaian-table td:nth-child(8) { width: 15%; } /* Aksi */
        
        /* Cell styling */
        .pemakaian-table td {
            padding: 0.5rem;
            vertical-align: top;
        }
        
        .pemakaian-table .cell-content {
            font-size: 0.875rem;
            line-height: 1.25rem;
        }
        
        /* For mobile view */
        @media (max-width: 768px) {
            .pemakaian-table th:nth-child(3),
            .pemakaian-table td:nth-child(3) { display: none; } /* Hide No Kontrol on mobile */
        }
    </style>

    <div class="responsive-table">
        <x-mary-table class="pemakaian-table bg-white dark:bg-base-100" :headers="$headers" :rows="$pemakaian" 
                      with-pagination per-page="perPage" :per-page-values="[5, 10, 20]">

            <!-- Kolom Meter -->
            @scope('cell_meter_gabungan', $pemakaian)
            <div class="cell-content">
                {!! $pemakaian->meter_gabungan !!}
            </div>
            @endscope

            <!-- Kolom Jumlah Pakai -->
            @scope('cell_JumlahPakai', $pemakaian)
            <div class="cell-content font-medium">
                {{ $pemakaian->JumlahPakai }} kWh
            </div>
            @endscope

            <!-- Kolom Biaya -->
            @scope('cell_biaya_gabungan', $pemakaian)
            <div class="cell-content">
                {!! $pemakaian->biaya_gabungan !!}
                <div class="mt-1 font-bold">Total: Rp {{ number_format($pemakaian->TotalBayar, 0, ',', '.') }}</div>
            </div>
            @endscope

            <!-- Kolom Status Pembayaran -->
            @scope('cell_StatusPembayaran', $pemakaian)
            <div class="cell-content">
                @if($pemakaian->StatusPembayaran == 'Belum Lunas')
                    <x-mary-badge :value="$pemakaian->StatusPembayaran" class="badge-error" />
                @else
                    <x-mary-badge :value="$pemakaian->StatusPembayaran" class="badge-success" />
                @endif
            </div>
            @endscope

            <!-- Kolom Aksi -->
            @scope('cell_actions', $pemakaian)
            <div class="cell-content">
                <x-mary-dropdown>
                    <x-slot:trigger>
                        <x-mary-button icon="m-ellipsis-vertical" class="btn-sm bg-transparent border-none" />
                    </x-slot:trigger>
                    <x-mary-menu-item icon="o-eye" 
                        wire:click="$dispatch('showModal', { id: '{{ $pemakaian->ID_Pemakaian }}' })" />
                    <x-mary-menu-item icon="o-pencil-square" 
                        wire:click="$dispatch('showEditModal', { id: '{{ $pemakaian->ID_Pemakaian }}' })" />
                    <x-mary-menu-item icon="o-trash" 
                        wire:click="$dispatch('showDeleteModal', { id: '{{ $pemakaian->ID_Pemakaian }}' })" />
                </x-mary-dropdown>
            </div>
            @endscope

            <x-slot:empty>
                <x-mary-icon name="o-cube" label="Data Pemakaian Tidak Tersedia." />
            </x-slot:empty>
        </x-mary-table>
    </div>

    <!-- Komponen modal -->
    <livewire:pemakaian.show-pemakaian name="viewModal" />
    <livewire:pemakaian.edit-pemakaian name="editModal" />
    <livewire:pemakaian.delete-pemakaian name="deleteModal" />
</div>