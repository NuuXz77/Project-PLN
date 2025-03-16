<?php

use Livewire\Volt\Component;
use App\Models\Pelanggan;
use App\Models\Pemakaian;
use App\Models\Tarif;
use Mary\Traits\Toast;

new class extends Component {
    use Toast;
    public $addModal = false;
    public $No_Pemakaian;
    public $No_Kontrol;
    public $TanggalCatat;
    public $MeterAwal;
    public $MeterAkhir;
    public $JumlahPakai;
    public $BiayaBebanPemakaian = 0;
    public $BiayaPemakaian = 0;
    public $StatusPembayaran;
    public $pelangganList = [];
    public $tarif;
    public $jenisPelanggan;

    public function refreshTable()
    {
        $this->dispatch('addSuccess');
    }

    public function mount()
    {
        $this->pelangganList = Pelanggan::all(['No_Kontrol', 'Nama', 'Jenis_Plg', 'created_at'])->toArray();
        $this->tarif = Tarif::all()->keyBy('Jenis_Plg')->toArray();
    }

    public function updatedNoKontrol($value)
    {
        $this->generateNoPemakaian();

        $pelanggan = Pelanggan::where('No_Kontrol', $value)->first();

        if ($pelanggan) {
            $this->jenisPelanggan = $pelanggan->Jenis_Plg;
            $this->calculateBiayaPemakaian();
        }
    }

    public function updatedMeterAwal()
    {
        $this->calculateJumlahPakai();
    }

    public function updatedMeterAkhir()
    {
        $this->calculateJumlahPakai();
    }

    public function calculateJumlahPakai()
    {
        if (is_numeric($this->MeterAwal) && is_numeric($this->MeterAkhir) && $this->MeterAkhir >= $this->MeterAwal) {
            $this->JumlahPakai = $this->MeterAkhir - $this->MeterAwal;
            $this->calculateBiayaPemakaian();
        }
    }

    public function calculateBiayaPemakaian()
    {
        if ($this->JumlahPakai && isset($this->tarif[$this->jenisPelanggan])) {
            $tarif = $this->tarif[$this->jenisPelanggan];
            $this->BiayaPemakaian = $this->JumlahPakai * $tarif['TarifKWH'];
            $this->BiayaBebanPemakaian = $tarif['BiayaBeban'];
        }
    }

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
        $this->validate([
            'No_Pemakaian' => 'required|unique:pemakaian,No_Pemakaian',
            'No_Kontrol' => 'required|exists:pelanggan,No_Kontrol',
            'TanggalCatat' => 'required|date',
            'MeterAwal' => 'required|numeric',
            'MeterAkhir' => 'required|numeric|gte:MeterAwal',
            'JumlahPakai' => 'required|numeric',
            'BiayaBebanPemakaian' => 'required|numeric',
            'BiayaPemakaian' => 'required|numeric',
            'StatusPembayaran' => 'required|in:Lunas,Belum Lunas',
        ]);

        Pemakaian::create([
            'No_Pemakaian' => $this->No_Pemakaian,
            'No_kontrol' => $this->No_Kontrol,
            'TanggalCatat' => $this->TanggalCatat,
            'MeterAwal' => $this->MeterAwal,
            'MeterAkhir' => $this->MeterAkhir,
            'JumlahPakai' => $this->JumlahPakai,
            'BiayaBebanPemakaian' => $this->BiayaBebanPemakaian,
            'BiayaPemakaian' => $this->BiayaPemakaian,
            'StatusPembayaran' => $this->StatusPembayaran,
        ]);
        // Toast sukses
        $this->toast(
            type: 'success',
            title: 'It is done!',
            description: 'Data Pemakaian Berhasil Di Tambahkan!',
            position: 'toast-top toast-end',
            icon: 'o-information-circle',
            css: 'alert-info',
            timeout: 3000,
            redirectTo: null
        );

        $this->resetForm();
        $this->refreshTable();
        $this->addModal = false;
        session()->flash('message', 'Data pemakaian berhasil ditambahkan!');
    }

    public function resetForm()
    {
        $this->reset(['No_Pemakaian', 'No_Kontrol', 'TanggalCatat', 'MeterAwal', 'MeterAkhir', 'JumlahPakai', 'BiayaBebanPemakaian', 'BiayaPemakaian', 'StatusPembayaran']);
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
                    <x-mary-input label="Meter Awal" type="number" wire:model.live="MeterAwal" />
                </div>

                <div class="col-span-6">
                    <x-mary-input label="Meter Akhir" type="number" wire:model.live="MeterAkhir" />
                </div>

                <div class="col-span-6">
                    <x-mary-input label="Jumlah Pakai" type="number" wire:model="JumlahPakai" readonly />
                </div>

                <div class="col-span-6">
                    <x-mary-input label="Biaya Beban Pemakai" type="number" wire:model="BiayaBebanPemakaian" readonly />
                </div>

                <div class="col-span-6">
                    <x-mary-input label="Biaya Pemakaian" type="number" wire:model="BiayaPemakaian" readonly />
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