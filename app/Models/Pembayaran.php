<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pembayaran extends Model
{
    protected $table = 'pembayaran'; // Nama tabel di database

    protected $primaryKey = 'ID_Pembayaran';

    protected $fillable = [
        'No_Pembayaran',
        'No_Kontrol',
        'Nama',
        'No_Tarif',
        'StandMeter',
        'TotalHarga',
        'Admin',
        'TotalBayar',
    ];

    public function pelanggan()
    {
        return $this->belongsTo(Pelanggan::class, 'No_kontrol', 'No_Kontrol');
    }

    public function tarifID()
    {
        return $this->belongsTo(Tarif::class, 'No_Tarif', 'No_Tarif');
    }

    public function transaksiPembayaran()
    {
        return $this->hasOne(Transaksi::class, 'ID_Pelanggan', 'No_Kontrol');
    }
}
