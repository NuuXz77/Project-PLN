<?php
use Livewire\Volt\Component;
use App\Models\Pembayaran;
use App\Models\Transaksi;
use Illuminate\Support\Str;
use Mary\Traits\Toast;
use Carbon\Carbon;

new class extends Component {
    use Toast;

    public $konfirmasiModal = false;

    public $pembayaran_id;
    public $No_Kontrol;
    public $No_Pemakaian;
    public $TotalTagihan;
    public $MetodePembayaran = 'Tunai';
    public $UangBayar;
    public $UangKembali = 0;

    protected $listeners = ['konfirmasiModal' => 'openModal'];

    public function updatedUangBayar()
    {
        if ($this->UangBayar && $this->TotalTagihan) {
            $this->UangKembali = $this->UangBayar - $this->TotalTagihan;
        }
    }

    public function openModal($id)
    {
        $pembayaran = Pembayaran::where('Nama', 'LIKE', '%'.$id.'%')->first();
        // dd($id);

        if ($pembayaran) {
            $this->pembayaran_id = $pembayaran->ID_Pembayaran;
            $this->No_Kontrol = $pembayaran->No_Kontrol;
            $this->No_Pemakaian = $pembayaran->No_Pemakaian;
            $this->TotalTagihan = $pembayaran->TotalTagihan;
            
            $this->konfirmasiModal = true;
        } else {
            // dd($id);
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
        $this->validate([
            'UangBayar' => 'required|numeric|min:' . $this->TotalTagihan,
            'MetodePembayaran' => 'required',
        ]);

        Transaksi::create([
            'No_Transaksi' => 'TRX-' . strtoupper(Str::random(8)),
            'No_Kontrol' => $this->No_Kontrol,
            'No_Pemakaian' => $this->No_Pemakaian,
            'TanggalPembayaran' => Carbon::now(),
            'TotalTagihan' => $this->TotalTagihan,
            'MetodePembayaran' => $this->MetodePembayaran,
            'Status' => 'Lunas',
        ]);

        $this->toast(
            type: 'success',
            title: 'Pembayaran Berhasil',
            description: 'Transaksi telah dicatat sebagai Lunas',
            timeout: 3000,
        );

        $this->reset(['UangBayar', 'UangKembali', 'pembayaran_id']);
        $this->konfirmasiModal = false;

        $this->dispatch('refreshTable');
    }
};

 ?>

<div>
    <x-mary-modal wire:model="konfirmasiModal" class="backdrop-blur" box-class="max-w-2xl w-full">
        <x-mary-header title="Konfirmasi Pembayaran" subtitle="Masukkan detail pembayaran" separator />

        <x-mary-form wire:submit.prevent="save" no-separator>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <x-mary-input label="Total Tagihan (Rp)" wire:model="TotalTagihan" readonly class="text-black" />
                </div>

                <div>
                    <x-mary-select
                        label="Metode Pembayaran"
                        wire:model="MetodePembayaran"
                        :options="[
                            'Transfer' => 'Transfer',
                            'Virtual Account' => 'Virtual Account',
                            'QRIS' => 'QRIS',
                            'Tunai' => 'Tunai'
                        ]"
                        placeholder="Pilih Metode"
                        class="text-black"
                    />
                </div>

                <div>
                    <x-mary-input
                        label="Uang Bayar"
                        wire:model="UangBayar"
                        type="number"
                        min="0"
                        class="text-black"
                    />
                </div>

                <div>
                    <x-mary-input
                        label="Uang Kembali"
                        wire:model="UangKembali"
                        readonly
                        class="text-black bg-gray-100"
                    />
                </div>
            </div>

            <x-slot:actions>
                <x-mary-button label="Batal" @click="$wire.konfirmasiModal = false" />
                <x-mary-button label="Simpan" class="btn-primary" type="submit" spinner="save" />
            </x-slot:actions>
        </x-mary-form>
    </x-mary-modal>
</div>

