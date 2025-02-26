<div>
        <x-mary-header title="Pelanggan" subtitle="Dashboard / Pelanggan" separator progress-indicator>
            <x-slot:middle class="!justify-end">
                <x-mary-input icon="o-bolt" placeholder="Search..." />
            </x-slot:middle>
            <x-slot:actions>
                <x-mary-button icon="o-funnel" />
                <livewire:pelanggan.addpelanggan name="addModal">
            </x-slot:actions>
        </x-mary-header>
        
        <x-mary-table :headers="$headers" :rows="$pelanggan">
            {{-- @scope('header_No_Kontrol', $header)
            <h2 class="text-xl font-bold text-primary">
                {{$header['label']}}
            </h2>
            @endscope --}}
        </x-mary-table>
</div>