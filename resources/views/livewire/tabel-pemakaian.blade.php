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
        /* Atur lebar kolom */
        table {
            table-layout: fixed;
        }

        th:nth-child(1),
        td:nth-child(1) {
            /* Kolom No */
            width: 4%;
        }

        th:nth-child(2),
        td:nth-child(2) {
            /* Kolom No Pemakaian */
            width: 17%;
        }

        th:nth-child(3),
        td:nth-child(3) {
            /* Kolom No Kontrol */
            width: 7%;
        }

        th:nth-child(4),
        td:nth-child(4) {
            /* Kolom Meter Awal | Meter Akhir */
            width: 11%;
        }

        th:nth-child(5),
        td:nth-child(5) {
            /* Kolom Jumlah Pakai */
            width: 8%;
        }

        th:nth-child(6),
        td:nth-child(6) {
            /* Kolom Biaya (Gabungan) */
            width: 13%; /* Sesuaikan lebar sesuai kebutuhan */
        }

        th:nth-child(7),
        td:nth-child(7) {
            /* Kolom Aksi */
            width: 5%;
        }

        /* Gaya untuk kolom Biaya Gabungan */
        .biaya-gabungan {
            text-align: center;
        }

        .biaya-gabungan .flex {
            justify-content: space-between;
        }

        .biaya-gabungan .mt-1 {
            margin-top: 0.25rem;
        }
    </style>

    <x-mary-table class="bg-white dark:bg-base-100" :headers="$headers" :rows="$pemakaian" with-pagination
        per-page="perPage" :per-page-values="[5, 10, 20]">

        <!-- Kolom Meter Awal | Meter Akhir -->
        @scope('cell_meter_gabungan', $pemakaian)
        {!! $pemakaian->meter_gabungan !!}
        @endscope

        <!-- Kolom Biaya Gabungan -->
        @scope('cell_biaya_gabungan', $pemakaian)
        {!! $pemakaian->biaya_gabungan !!}
        @endscope

        <!-- Kolom Aksi -->
        @scope('cell_actions', $pemakaian)
        <span class="actions-column">
            <x-mary-dropdown>
                <x-slot:trigger>
                    <x-mary-button icon="m-ellipsis-vertical" class="bg-transparent border-none" />
                </x-slot:trigger>
                <x-mary-menu-item icon="o-eye"
                    wire:click="$dispatch('showModal', { id: '{{ $pemakaian->ID_Pemakaian }}' })" />
                <x-mary-menu-item icon="o-pencil-square"
                    wire:click="$dispatch('showEditModal', { id: '{{ $pemakaian->ID_Pemakaian }}' })" />
                <x-mary-menu-item icon="o-trash"
                    wire:click="$dispatch('showDeleteModal', { id: '{{ $pemakaian->ID_Pemakaian }}' })" />
            </x-mary-dropdown>
        </span>
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