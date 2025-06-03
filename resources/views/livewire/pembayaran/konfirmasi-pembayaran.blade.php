<?php

use Livewire\Volt\Component;
use App\Models\Pembayaran;
use App\Models\Transaksi;
use App\Models\Pemakaian;
use Mary\Traits\Toast;
use Carbon\Carbon;

new class extends Component {
    use Toast;

    public $konfirmasiModal = false;
    public $pembayaran_id;
    public $No_Kontrol;
    public $No_Pemakaian;
    public $TotalTagihan = 0;
    public $MetodePembayaran = 'Tunai'; // Diubah dari MetodePembayaran ke MetodePembayaran (konsisten dengan nama field)
    public $UangBayar;
    public $UangKembali = 0;
    public $paymentError = false;

    protected $listeners = ['konfirmasiModal' => 'openModal'];

    public function rules()
    {
        return [
            'UangBayar' => [
                'required',
                'numeric',
                'min:' . $this->TotalTagihan,
                function ($attribute, $value, $fail) {
                    if ($value < $this->TotalTagihan) {
                        $fail('Jumlah pembayaran kurang dari total tagihan.');
                    }
                },
            ],
            'MetodePembayaran' => 'required|string',
            'No_Kontrol' => 'required|string',
            'TotalTagihan' => 'required|numeric|min:0',
        ];
    }

    public function updatedUangBayar($value)
    {
        $this->calculateChange();
    }

    public function updatedMetodePembayaran()
    {
        // Reset payment calculations when payment method changes
        $this->reset(['UangBayar', 'UangKembali', 'paymentError']);
    }

    private function calculateChange()
    {
        if (empty($this->UangBayar)) {
            $this->UangKembali = 0;
            $this->paymentError = false;
            return;
        }

        // Bersihkan input dari format "Rp" dan titik pemisah
        $clean = preg_replace('/[^0-9]/', '', $this->UangBayar);
        $this->UangBayar = (int) $clean;

        $this->UangKembali = $this->UangBayar - $this->TotalTagihan;
        $this->paymentError = $this->UangKembali < 0;
    }

    public function openModal($id)
    {
        $this->resetValidation();
        $this->reset(['UangBayar', 'UangKembali', 'paymentError']);

        $getDataPemakaian = Pemakaian::where('No_Kontrol', 'LIKE', '%' . $id . '%')->first();
        $pembayaran = Pembayaran::where('No_Kontrol', 'LIKE', '%' . $id . '%')->first();

        if ($pembayaran) {
            $this->pembayaran_id = $pembayaran->ID_Pembayaran;
            $this->No_Kontrol = $pembayaran->No_Kontrol;
            $this->No_Pemakaian = $getDataPemakaian->No_Pemakaian ?? '-';
            $this->TotalTagihan = $pembayaran->TotalBayar;
            $this->MetodePembayaran = 'Tunai'; // Reset metode pembayaran setiap kali modal dibuka
            $this->konfirmasiModal = true;
        } else {
            // dd($id);sd
            $this->toast(
                type: 'error',
                title: 'Error!',
                description: 'Data pembayaran tidak ditemukan.',
                timeout: 3000
            );
        } 
    }

    public function save()
    {
        $this->validate();

        try {
            $tanggalPembayaran = Carbon::now()->format('Ymd');

            $count = Transaksi::where('No_Pemakaian', $this->No_Pemakaian)->where('No_Kontrol', $this->No_Kontrol)->whereDate('TanggalPembayaran', Carbon::today())->count();

            $urutan = str_pad($count + 1, 3, '0', STR_PAD_LEFT);
            $noTransaksi = "TRX-{$urutan}-{$this->No_Kontrol}-{$tanggalPembayaran}";

            // Update status pemakaian
            $pemakaian = Pemakaian::where('No_Kontrol', $this->No_Kontrol)->first();
            if ($pemakaian) {
                $pemakaian->update([
                    'StatusPembayaran' => 'Lunas',
                ]);
            } else {
                throw new \Exception("Data pemakaian dengan No_Kontrol {$this->No_Kontrol} tidak ditemukan.");
            }

            Transaksi::create([
                'No_Transaksi' => $noTransaksi,
                'No_Kontrol' => $this->No_Kontrol,
                'No_Pemakaian' => $this->No_Pemakaian,
                'TanggalPembayaran' => now(),
                'TotalTagihan' => $this->TotalTagihan,
                'MetodePembayaran' => $this->MetodePembayaran,
                'Status' => 'Lunas',
            ]);

            $this->toast(type: 'success', title: 'Pembayaran Berhasil', description: 'Transaksi telah dicatat sebagai Lunas', position: 'toast-top toast-end', timeout: 3000);

            $this->konfirmasiModal = false;
            $this->dispatch('refreshTable');
        } catch (\Exception $e) {
            dd($e->getMessage());
            $this->toast(type: 'error', title: 'Terjadi Kesalahan', description: 'Gagal menyimpan transaksi: ', position: 'toast-top toast-end', timeout: 5000);
        }
    }
};
?>

<div>
    <x-mary-modal wire:model="konfirmasiModal" class="backdrop-blur" box-class="max-w-2xl w-full" persistent>
        <x-mary-header title="Konfirmasi Pembayaran" subtitle="Lengkapi detail pembayaran" separator />

        <x-mary-form wire:submit.prevent="save">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                <!-- Info Tagihan -->
                <div class="space-y-4">
                    <x-mary-input label="No. Kontrol" wire:model="No_Kontrol" readonly
                        class="" />
                    <x-mary-input label="No. Pemakaian" wire:model="No_Pemakaian" readonly
                        class="" />
                    <x-mary-input label="Total Tagihan (Rp)" wire:model="TotalTagihan" readonly prefix="Rp"
                        thousands-separator="." decimal-separator=","
                        class="text-lg font-semibold " />
                </div>

                <!-- Detail Pembayaran -->
                <div class="space-y-4">
                    <x-mary-input label="Metode Pembayaran" wire:model="MetodePembayaran" value="Tunai"
                        icon="o-credit-card" class="" />

                    <x-mary-input label="Uang Bayar" wire:model.live="UangBayar" type="text" prefix="Rp"
                        thousands-separator="." decimal-separator=","
                        class="{{ $paymentError ? 'border-red-500 focus:border-red-500 focus:ring-red-500' : '' }}"
                        hint="{{ $paymentError ? 'Jumlah pembayaran kurang dari total tagihan' : '' }}"
                        error="{{ $paymentError }}" />

                    <x-mary-input label="Uang Kembali" wire:model="UangKembali" readonly prefix="Rp"
                        thousands-separator="." decimal-separator=","
                        class="{{ $paymentError ? 'text-red-600 font-bold' : 'text-green-600 font-bold' }} bg-gray-50" />
                </div>
            </div>

            <x-slot:actions>
                <x-mary-button label="Batal" @click="$wire.konfirmasiModal = false" class="btn-ghost"
                    icon="o-x-mark" />
                <x-mary-button label="Simpan Transaksi" type="submit" spinner="save" class="btn-primary"
                    icon="o-check-badge" :disabled="$paymentError" />
            </x-slot:actions>
        </x-mary-form>
    </x-mary-modal>
</div>
