<div>
    <x-mary-header title="Pelanggan" subtitle="Kelola data pelanggan PLN dengan mudah dan cepat." separator progress-indicator>
        <x-slot:middle class="!justify-end">
            <livewire:pelanggan.search-pelanggan name="search-pelanggan" />
        </x-slot:middle>
        <x-slot:actions>
            <livewire:pelanggan.filter-pelanggan name="filterDraw" />
            <livewire:pelanggan.addpelanggan name="addModal" />
        </x-slot:actions>
    </x-mary-header>


    <style>
        th:nth-child(2),
        td:nth-child(2) {
            /* No Kontrol */
            width: 15%;
        }

        th:nth-child(3),
        td:nth-child(3) {
            /* Nama Pelanggan */
            width: 25%;
        }

        th:nth-child(4),
        td:nth-child(4) {
            /* Alamat */
            width: 25%;
        }

        th:nth-child(5),
        td:nth-child(5) {
            /* Informasi */
            width: 24%;
        }

        th:nth-child(6),
        td:nth-child(6) {
            /* Aksi */
            width: 10%;
        }

        /* th,
        td {
            border: 1px solid red;
        } HANYA UNTUK MELIHAT WARNA KOLOM, AGAR TIDAK ADA KOLOM GHAIB*/

        .informasi-gabungan {
            white-space: nowrap;
            /* Mencegah pemisahan baris */
        }

        .actions-column {
            display: flex;
            justify-content: center;
            align-items: center;
        }
    </style>

    <x-mary-table
        class="bg-white dark:bg-base-100 mb-5"
        :headers="$headers"
        :rows="$pelanggan"
        with-pagination
        per-page="perPage"
        :per-page-values="[3, 5, 10]"
        pagination-class="text-black dark:text-white">

        @scope('row_number', $row)
        <span>{{ $row->number }}</span>
        @endscope

        @scope('cell_alamat', $row)
        <span>{{ $row->alamat }}</span>
        @endscope

        @scope('cell_informasi_gabungan', $row)
        <span class="informasi-gabungan">{!! $row->informasi_gabungan !!}</span>
        @endscope

        @scope('cell_actions', $row)
        <span class="actions-column">
            <x-mary-dropdown>
                <x-slot:trigger>
                    <x-mary-button icon="m-ellipsis-vertical" class="bg-transparent dark:bg-transparent border-none" />
                </x-slot:trigger>
                <x-mary-menu-item
                    icon="o-eye"
                    wire:click="$dispatch('showModal', { id: '{{ $row->ID_Pelanggan }}' })" />
                <x-mary-menu-item
                    icon="o-pencil-square"
                    wire:click="$dispatch('showEditModal', { id: '{{ $row->ID_Pelanggan }}' })" />
                <x-mary-menu-item
                    icon="o-trash"
                    wire:click="$dispatch('showDeleteModal', { id: '{{ $row->ID_Pelanggan }}', no: '{{ $row->No_Kontrol }}' })" />
            </x-mary-dropdown>
        </span>
        @endscope

        <x-slot:empty>
            <x-mary-icon name="o-cube" label="Data Pelanggan Tidak Tersedia." />
        </x-slot:empty>
    </x-mary-table>

    <livewire:pelanggan.showpelanggan name="viewModal" />
    <livewire:pelanggan.editpelanggan name="editModal" />
    <livewire:pelanggan.deletepelanggan name="deleteModal" />
</div>