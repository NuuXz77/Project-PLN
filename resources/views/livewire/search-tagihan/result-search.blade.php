<?php

use Livewire\Volt\Component;
use App\Models\Pembayaran;

new class extends Component {
    public $type;
    public $result;

    public function mount($type, $result = null)
    {
        $this->type = $type;
        $this->result = $result;
    }
}; ?>

<livewire:search-tagihan.result-search
    :type="'kontrol'"
    :result="$resultKontrol"
    wire:key="kontrol-result-{{ $resultKontrol ? $resultKontrol->id : 'empty' }}" />

<div>
    @if($result)
    <div class="border border-gray-200 rounded-lg p-4 mb-4">
        <div class="flex justify-between items-center mb-2">
            <span class="text-gray-600">Hasil pencarian :</span>
            <span class="text-gray-600">{{ date('d-m-Y') }}</span>
        </div>

        <div class="space-y-2">
            @if($type === 'kontrol')
            <div class="flex">
                <span class="w-1/3 font-semibold">No Kontrol</span>
                <span>: {{ $result->No_Kontrol }}</span>
            </div>
            <div class="flex">
                <span class="w-1/3 font-semibold">Nama</span>
                <span>: {{ $result->Nama ?? '-' }}</span>
            </div>
            <div class="flex">
                <span class="w-1/3 font-semibold">Tagihan</span>
                <span>: Rp {{ isset($result->TotalBayar) ? number_format($result->TotalBayar, 0, ',', '.') : '0' }}</span>
            </div>
            <div class="flex">
                <span class="w-1/3 font-semibold">Status Pembayaran</span>
                <span>:
                    <span class="{{ ($result->StatusPembayaran ?? '') === 'Lunas' ? 'text-green-500' : 'text-red-500' }}">
                        {{ $result->StatusPembayaran ?? 'Belum lunas' }}
                    </span>
                </span>
            </div>
            @else
            <div class="flex">
                <span class="w-1/3 font-semibold">No Pemakaian</span>
                <span>: {{ $result->No_Pemakaian ?? $result->No_Pemakaian ?? '-' }}</span>
            </div>
            <div class="flex">
                <span class="w-1/3 font-semibold">No Kontrol</span>
                <span>: {{ $result->No_Kontrol }}</span>
            </div>
            <div class="flex">
                <span class="w-1/3 font-semibold">Total Tagihan</span>
                <span>: Rp {{ isset($result->TotalBayar) ? number_format($result->TotalBayar, 0, ',', '.') : '0' }}</span>
            </div>
            <div class="flex">
                <span class="w-1/3 font-semibold">Metode Pembayaran</span>
                <span>: {{ $result->MetodePembayaran ?? '-' }}</span>
            </div>
            @endif
        </div>
    </div>
    @endif
</div>