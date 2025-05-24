<?php

use Livewire\Volt\Component;

new class extends Component {
    public $search = '';

    public function updatedSearch($value)
    {
        $this->dispatch('searchUpdated', value: $value);
    }

    // Optional: Clear search and reset table
    public function clearSearch()
    {
        $this->search = '';
        $this->dispatch('searchUpdated', value: '');
    }
}; ?>

<div class="relative">
    <x-mary-input 
        wire:model.live="search"
        icon="o-magnifying-glass"
        placeholder="Cari user..." 
        class="!min-w-[250px]"
        right-icon="o-x-mark"
        right-icon-click="clearSearch"
        right-icon-wire-click="clearSearch"
        {{-- hint="Cari berdasarkan No User, Nama, atau Email" --}}
    />
</div>