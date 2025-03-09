<?php

use Livewire\Volt\Component;

new class extends Component {
    public bool $deleteModal = false;
}; ?>

<div>
    <x-mary-modal wire:model="deleteModal" class="backdrop-blur">
        <div class="mb-5">Press `ESC`, click outside or click `CANCEL` to close.</div>
        <x-mary-button label="Cancel" @click="$wire.deleteModal = false" />
    </x-mary-modal>

    <x-mary-menu-item icon="o-trash"  @click="$wire.deleteModal = true" />
</div>
