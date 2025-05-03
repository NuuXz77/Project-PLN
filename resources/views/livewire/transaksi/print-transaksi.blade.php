<?php

use Livewire\Volt\Component;
use App\Models\Transaksi;
use App\Models\Pelanggan;
use App\Models\Pemakaian;
use App\Models\Pembayaran;
use Mary\Traits\Toast;

new class extends Component {
    use Toast;

    public $printModal = false;
    public $transaksiId;
    public $transaksiData;
    public $pelangganData;
    public $pemakaianData;
    public $pembayaranData;

    protected $listeners = ['printModal' => 'openModal'];

    // Method untuk membuka modal print dengan data transaksi
    public function openModal($id)
    {
        $this->transaksiId = $id;
        $this->printModal = true;
        $this->loadData();
    }

    // Method untuk memuat data terkait transaksi
    protected function loadData()
    {
        // Ambil data transaksi
        $this->transaksiData = Transaksi::find($this->transaksiId);

        if (!$this->transaksiData) {
            $this->toast(type: 'error', title: 'Error', description: 'Transaksi tidak ditemukan', position: 'bottom-end', icon: 'o-exclamation-triangle', timeout: 3000);
            return;
        }

        // Ambil data pelanggan
        $this->pelangganData = Pelanggan::where('No_Kontrol', $this->transaksiData->No_Kontrol)->first();

        // Ambil data pemakaian jika ada
        if ($this->transaksiData->No_Pemakaian) {
            $this->pemakaianData = Pemakaian::where('No_Pemakaian', $this->transaksiData->No_Pemakaian)->first();
        }

        // Ambil data pembayaran
        $this->pembayaranData = Pembayaran::where('No_Kontrol', $this->transaksiData->No_Kontrol)
            ->where('No_Pembayaran', $this->transaksiData->No_Transaksi)
            ->first();
    }

    // Method untuk print data
    public function printData()
    {
        // Redirect ke route khusus untuk print
        return redirect()->route('print', ['id' => $this->transaksiId]);
    }
};
?>

<div>
    <x-mary-modal 
        wire:model="printModal" 
        class="backdrop-blur"
        box-class="max-w-5xl w-full p-0"
        persistent
    >
        <!-- Modal Header -->
        <div class="bg-primary text-primary-content p-6 rounded-t-lg">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-2xl font-bold">Cetak Bukti Transaksi</h2>
                    <p class="text-primary-content/80">Detail lengkap transaksi untuk dicetak</p>
                </div>
                <div class="bg-white/10 p-2 rounded-full">
                    <x-mary-icon name="o-printer" class="w-8 h-8" />
                </div>
            </div>
        </div>

        <!-- Modal Content -->
        <div class="p-6 space-y-6">
            @if ($transaksiData && $pelangganData)
                <!-- Transaction Overview -->
                <div class="flex flex-col md:flex-row gap-4">
                    <!-- Transaction Info Card -->
                    <div class="flex-1 bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-100 dark:border-gray-700 p-5">
                        <div class="flex items-center gap-3 mb-4">
                            <div class="bg-primary/10 p-2 rounded-lg">
                                <x-mary-icon name="o-document-text" class="text-primary w-6 h-6" />
                            </div>
                            <h3 class="font-bold text-lg">Informasi Transaksi</h3>
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <p class="text-sm text-gray-500 dark:text-gray-400">No. Transaksi</p>
                                <p class="font-medium">{{ $transaksiData->No_Transaksi }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500 dark:text-gray-400">Tanggal</p>
                                <p class="font-medium">
                                    {{ \Carbon\Carbon::parse($transaksiData->TanggalPembayaran)->format('d M Y H:i') }}
                                </p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500 dark:text-gray-400">Total Tagihan</p>
                                <p class="font-medium text-primary">
                                    Rp {{ number_format($transaksiData->TotalTagihan, 0, ',', '.') }}
                                </p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500 dark:text-gray-400">Status</p>
                                <x-mary-badge 
                                    :value="$transaksiData->Status" 
                                    @class([
                                        'badge-success' => $transaksiData->Status === 'Lunas',
                                        'badge-warning' => $transaksiData->Status === 'Menunggu Konfirmasi',
                                        'badge-error' => $transaksiData->Status === 'Gagal',
                                    ])
                                    class="badge-sm"
                                />
                            </div>
                            <div class="col-span-2">
                                <p class="text-sm text-gray-500 dark:text-gray-400">Metode Pembayaran</p>
                                <p class="font-medium">
                                    {{ $transaksiData->MetodePembayaran }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Customer Info Card -->
                    <div class="flex-1 bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-100 dark:border-gray-700 p-5">
                        <div class="flex items-center gap-3 mb-4">
                            <div class="bg-primary/10 p-2 rounded-lg">
                                <x-mary-icon name="o-user" class="text-primary w-6 h-6" />
                            </div>
                            <h3 class="font-bold text-lg">Informasi Pelanggan</h3>
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <p class="text-sm text-gray-500 dark:text-gray-400">No. Kontrol</p>
                                <p class="font-medium">{{ $pelangganData->No_Kontrol }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500 dark:text-gray-400">Nama</p>
                                <p class="font-medium">{{ $pelangganData->Nama }}</p>
                            </div>
                            <div class="col-span-2">
                                <p class="text-sm text-gray-500 dark:text-gray-400">Alamat</p>
                                <p class="font-medium">{{ $pelangganData->Alamat }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500 dark:text-gray-400">Jenis Pelanggan</p>
                                <p class="font-medium">{{ $pelangganData->Jenis_Plg }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Additional Information -->
                <div class="flex flex-col md:flex-row gap-4">
                    <!-- Usage Info (if available) -->
                    @if ($pemakaianData)
                        <div class="flex-1 bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-100 dark:border-gray-700 p-5">
                            <div class="flex items-center gap-3 mb-4">
                                <div class="bg-primary/10 p-2 rounded-lg">
                                    <x-mary-icon name="o-bolt" class="text-primary w-6 h-6" />
                                </div>
                                <h3 class="font-bold text-lg">Informasi Pemakaian</h3>
                            </div>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">No. Pemakaian</p>
                                    <p class="font-medium">{{ $pemakaianData->No_Pemakaian }}</p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">Periode</p>
                                    <p class="font-medium">
                                        {{ \Carbon\Carbon::parse($pemakaianData->TanggalCatat)->format('d M Y') }}
                                    </p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">Meter Awal</p>
                                    <p class="font-medium">{{ $pemakaianData->MeterAwal }} kWh</p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">Meter Akhir</p>
                                    <p class="font-medium">{{ $pemakaianData->MeterAkhir }} kWh</p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">Pemakaian</p>
                                    <p class="font-medium text-primary">
                                        {{ $pemakaianData->JumlahPakai }} kWh
                                    </p>
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- Payment Info (if available) -->
                    @if ($pembayaranData)
                        <div class="flex-1 bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-100 dark:border-gray-700 p-5">
                            <div class="flex items-center gap-3 mb-4">
                                <div class="bg-primary/10 p-2 rounded-lg">
                                    <x-mary-icon name="o-credit-card" class="text-primary w-6 h-6" />
                                </div>
                                <h3 class="font-bold text-lg">Detail Pembayaran</h3>
                            </div>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">No. Pembayaran</p>
                                    <p class="font-medium">{{ $pembayaranData->No_Pembayaran }}</p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">Stand Meter</p>
                                    <p class="font-medium">{{ $pembayaranData->StandMeter }}</p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">Biaya Admin</p>
                                    <p class="font-medium">
                                        Rp {{ number_format($pembayaranData->Admin, 0, ',', '.') }}
                                    </p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">Total Bayar</p>
                                    <p class="font-medium text-primary">
                                        Rp {{ number_format($pembayaranData->TotalBayar, 0, ',', '.') }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            @else
                <!-- Loading State -->
                <div class="flex flex-col items-center justify-center py-12">
                    {{-- <x-mary-spinner class="w-12 h-12 text-primary" /> --}}
                    <p class="mt-4 text-gray-500 dark:text-gray-400">Memuat data transaksi...</p>
                </div>
            @endif
        </div>

        <!-- Modal Footer -->
        <div class="bg-gray-50 dark:bg-gray-800 px-6 py-4 rounded-b-lg flex justify-end gap-3">
            <x-mary-button 
                label="Batal" 
                @click="$wire.printModal = false" 
                class="btn-ghost" 
            />
            <x-mary-button
                label="Cetak Sekarang" 
                icon-right="o-printer" 
                class="btn-primary" 
                spinner="printData"
                wire:click="printData" 
            />
        </div>
    </x-mary-modal>
</div>