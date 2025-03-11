<?php

use Livewire\Volt\Component;

new class extends Component {
    public $search = '';

    public function updatedSearch($value)
    {
        $this->dispatch('searchUpdated', $value);
    }
}; ?>

<div>
    <x-mary-input 
        wire:model.live="search"
        icon="o-bolt"
        placeholder="Search..." 
    />
</div>