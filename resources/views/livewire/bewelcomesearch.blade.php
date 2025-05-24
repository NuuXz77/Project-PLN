<?php

use Livewire\Volt\Component;
use App\Models\Pembayaran;

new class extends Component {
    public $searchQuery = '';
    public $searchType = 'kontrol'; // 'kontrol' atau 'transaksi'
    public $results = null;

    public function search()
    {
        if (strlen($this->searchQuery) > 3) {
            if ($this->searchType === 'kontrol') {
                $this->results = Pembayaran::where('No_Kontrol', $this->searchQuery)
                    ->first();
            } else {
                $this->results = Pembayaran::where('No_Transaksi', $this->searchQuery)
                    ->first();
            }
        }
    }

    
}; ?>

<div>
    <div class="relative mb-4">
        <x-mary-input
            wire:model.live="searchQuery"
            wire:keydown.debounce.500ms="search"
            placeholder="{{ $searchType === 'kontrol' ? 'Masukkan No Kontrol...' : 'Masukkan No Transaksi...' }}"
            class="w-full pl-10" />
        <div class="absolute left-3 top-3 text-gray-400">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
            </svg>
        </div>
    </div>

    @if($results)
    <!-- Tampilkan hasil pencarian -->
    @endif
</div>