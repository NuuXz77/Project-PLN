<?php

namespace App\Livewire;

use App\Models\Pembayaran;
use Livewire\Component;
use Livewire\WithPagination;

class BeWelcome extends Component
{
    use WithPagination;

    public string $search = '';
    public $selectedPayment = null;

    // Tambahkan properti untuk menampung pembayaran dan pemakaian
    public $pembayaran;
    public $semuaPemakaian;

    public function render()
    {
        $pembayarans = collect(); // Default empty collection

        // Cek jika search memiliki minimal 5 karakter
        if (strlen($this->search) >= 5) {
            $pembayarans = Pembayaran::with(['pemakaian' => function ($query) {
                $query->select('ID_Pemakaian', 'StatusPembayaran', 'ID_Pembayaran');
            }])
                ->where('No_Kontrol', 'like', "%{$this->search}%")
                ->select('ID_Pembayaran', 'No_Kontrol', 'Nama', 'TotalBayar')
                ->paginate(10);
        }

        return view('livewire.be-welcome', [
            'pembayarans' => $pembayarans
        ]);
    }

    public function showDetail($id)
    {
        $this->selectedPayment = Pembayaran::with(['pemakaian'])
            ->find($id);
    }
    
    // Fungsi untuk mengambil pembayaran dan pemakaian
    public function detail($id)
    {
        // Mencari pembayaran berdasarkan ID
        $this->pembayaran = Pembayaran::find($id);

        // Mengambil semua pemakaian terkait pembayaran ini
        if ($this->pembayaran) {
            $this->semuaPemakaian = $this->pembayaran->pemakaian;
        }
    }
}
