<?php

use Livewire\Volt\Component;

new class extends Component {
    public $filterDraw = false;
    public $users = [
        'user1' => 'User 1',
        'user2' => 'User 2',
        'user3' => 'User 3',
    ];
}; ?>

<div>
    <x-mary-drawer
        right
        wire:model="filterDraw"
        title="Filter"
        separator
        with-close-button
        close-on-escape
        class="w-11/12 lg:w-1/3"
    >
    
        <div>
            <x-mary-input label="Inline label" inline />
            <x-mary-select label="Master user" icon="o-user" :options="$users" wire:model="selectedUser" />
            <x-mary-select label="Master user" icon="o-user" :options="$users" wire:model="selectedUser" />
        </div>
        <x-slot:actions>
            <x-mary-button label="Cancel" @click="$wire.filterDraw = false" />
            <x-mary-button label="Confirm" class="btn-primary" icon="o-check" />
        </x-slot:actions>
    </x-mary-drawer>


    <x-mary-button icon="o-funnel" @click="$wire.filterDraw = true"  />
</div>
