<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pemakaian extends Model
{
    protected $table = 'pemakaian'; // Nama tabel di database

    protected $primaryKey = 'ID_Pemakaian';

    protected $fillable = [
        'No_Pemakaian',
        'No_kontrol',
        'TanggalCatat',
        'MeterAwal',
        'MeterAkhir',
        'JumlahPakai',
        'BiayaBebanPemakaian',
        'BiayaPemakaian',
        'StatusPembayaran',
    ];

    // Relasi ke tabel Pelanggan
    public function pelanggan()
    {
        return $this->belongsTo(Pelanggan::class, 'No_kontrol', 'No_Kontrol');
    }

    public function pembayaran()
    {
        return $this->belongsTo(Pembayaran::class, 'ID_Pembayaran');
    }
}
