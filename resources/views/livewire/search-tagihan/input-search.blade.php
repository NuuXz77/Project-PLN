<?php

use Livewire\Volt\Component;

new class extends Component {
    //
}; ?>

<div>
    <x-slot:middle>
        <div class="flex gap-2">
            <x-mary-form wire:submit="save2">
                <x-slot:actions>
                    <x-mary-input wire:model="no_kontrol" class="w-96" icon="o-bolt" placeholder="Search..." />
                    <x-mary-button label="Cari" type="submit" class="btn btn-primary" tooltip-left="Klik untuk mencari" spinner="save2"/>
                </x-slot:actions>
            </x-mary-form>
        </div>
    </x-slot:middle>
</div>
