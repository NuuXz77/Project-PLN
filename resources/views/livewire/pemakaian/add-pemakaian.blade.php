<?php

use Livewire\Volt\Component;
use App\Models\Pelanggan;
use App\Models\Pemakaian;

new class extends Component {
    public $addModal = false;
    public $No_Pemakaian;
    public $No_Kontrol;
    public $TanggalCatat;
    public $MeterAwal;
    public $MeterAkhir;
    public $JumlahPakai;
    public $BiayaBebanPemakai;
    public $BiayaPemakaian;
    public $StatusPembayaran;
    public $pelangganList = [];


    public function refreshTable()
    {
        $this->dispatch('addSuccess');
    }

    public function mount()
    {
        $this->pelangganList = Pelanggan::all(['No_Kontrol', 'Nama', 'created_at'])->toArray();
    }

    protected $rules = [
        'No_Pemakaian' =>'required|unique:pemakaian,No_Pemakaian',
        'No_Kontrol' => 'required|exists:pelanggan,No_Kontrol',
        'TanggalCatat' => 'required|date',
        'MeterAwal' => 'required|numeric',
        'MeterAkhir' => 'required|numeric|gte:MeterAwal',
        'JumlahPakai' => 'required|numeric',
        'BiayaBebanPemakai' => 'required|numeric',
        'BiayaPemakaian' => 'required|numeric',
        'StatusPembayaran' => 'required|in:Lunas,Belum Lunas',
    ];

    public function generateNoPemakaian()
    {
        $pelanggan = Pelanggan::where('No_Kontrol', $this->No_Kontrol)->first();

        if ($pelanggan) {
            $namaPelanggan = strtoupper(str_replace(' ', '', $pelanggan->Nama));
            $tanggalPembuatan = $pelanggan->created_at->format('dmY');
            $tahunIni = now()->format('Y');

            $this->No_Pemakaian = "PMK/{$namaPelanggan}-{$tanggalPembuatan}/{$tahunIni}";
        }
    }

    public function save()
    {
        // dd($this->No_Pemakaian);
        $this->validate();

        $this->generateNoPemakaian();

        Pemakaian::create([
            'No_Pemakaian' => $this->No_Pemakaian,
            'No_kontrol' => $this->No_Kontrol,
            'TanggalCatat' => $this->TanggalCatat,
            'MeterAwal' => $this->MeterAwal,
            'MeterAkhir' => $this->MeterAkhir,
            'JumlahPakai' => $this->JumlahPakai,
            'BiayaBebanPemakaian' => $this->BiayaBebanPemakai,
            'BiayaPemakaian' => $this->BiayaPemakaian,
            'StatusPembayaran' => $this->StatusPembayaran,
        ]);

        $this->resetForm();
        $this->refreshTable();
        $this->addModal = false;
        session()->flash('message', 'Data pemakaian berhasil ditambahkan!');
    }

    public function resetForm()
    {
        $this->reset(['No_Pemakaian', 'No_Kontrol', 'TanggalCatat', 'MeterAwal', 'MeterAkhir', 'JumlahPakai', 'BiayaBebanPemakai', 'BiayaPemakaian', 'StatusPembayaran']);
    }
};
?>

<div>
    <x-mary-modal wire:model="addModal" class="backdrop-blur" box-class="max-w-4xl w-full">
        <x-mary-header title="Tambah Pemakaian" subtitle="Isi data pemakaian pelanggan!" separator />

        <x-mary-form wire:submit="save" no-separator>
            <div class="grid grid-cols-12 gap-4">

                <div class="col-span-12">
                    <x-mary-input label="No Pemakaian" wire:model="No_Pemakaian" readonly />
                </div>

                <div class="col-span-6">
                    <x-mary-select 
                        label="Nomor Kontrol"
                        wire:model="No_Kontrol"
                        :options="$pelangganList"
                        option-value="No_Kontrol"
                        option-label="Nama"
                        placeholder="Pilih Pelanggan"
                        wire:change="generateNoPemakaian"
                    />
                </div>

                <div class="col-span-6">
                    <x-mary-input label="Tanggal Catat" type="date" wire:model="TanggalCatat" />
                </div>

                <div class="col-span-6">
                    <x-mary-input label="Meter Awal" type="number" min=0 wire:model="MeterAwal" />
                </div>

                <div class="col-span-6">
                    <x-mary-input label="Meter Akhir" type="number" min=0 wire:model="MeterAkhir" />
                </div>

                <div class="col-span-6">
                    <x-mary-input label="Jumlah Pakai" type="number" min=0 wire:model="JumlahPakai" />
                </div>

                <div class="col-span-6">
                    <x-mary-input label="Biaya Beban Pemakai" type="number" min=0 wire:model="BiayaBebanPemakai" />
                </div>

                <div class="col-span-6">
                    <x-mary-input label="Biaya Pemakaian" type="number" min=0 wire:model="BiayaPemakaian" />
                </div>

                <div class="col-span-6">
                    <x-mary-select 
                        label="Status Pembayaran"
                        wire:model="StatusPembayaran"
                        :options="[
                            ['id' => 'Lunas', 'name' => 'Lunas'],
                            ['id' => 'Belum Lunas', 'name' => 'Belum Lunas']
                        ]"
                        option-value="id"
                        option-label="name"
                        placeholder="Pilih Status"
                    />
                </div>

            </div>

            <x-slot:actions>
                <x-mary-button label="Batal" @click="$wire.addModal = false" />
                <x-mary-button label="Simpan" class="btn-primary" type="submit" spinner="save" />
            </x-slot:actions>
        </x-mary-form>
    </x-mary-modal>

    <x-mary-button icon="o-plus" class="btn-primary" @click="$wire.addModal = true" />
</div>
