<?php

use Livewire\Volt\Component;

new class extends Component {
    //
}; ?>

<div>
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <x-mary-stat title="Pelanggan" value="10" icon="o-users" tooltip="Total Pelanggan" />
        
        <x-mary-stat
            title="Pemakaian"
            description="Keseluruhan"
            value="Bos"
            icon="o-users"
            tooltip-bottom="Keseluruhan Pemakaian" />
        
        <x-mary-stat
            title="Lost"
            description="This month"
            value="34"
            icon="o-arrow-trending-down"
            tooltip-left="Ops!" />
        
        <x-mary-stat
            title="Sales"
            description="This month"
            value="22.124"
            icon="o-arrow-trending-down"
            class="text-orange-500"
            color="text-pink-500"
            tooltip-right="Gosh!" />
    </div>
</div>
