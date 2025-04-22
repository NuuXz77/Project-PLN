<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    use HasFactory;

    protected $table = 'transaksi_pembayaran'; // Sesuai nama tabel
    protected $primaryKey = 'ID_Pembayaran'; // Sesuai migrasi

    // Jika kamu tidak pakai auto-increment id (bisa dihapus jika pakai auto-increment)
    // public $incrementing = true;

    // Tipe data primary key
    protected $keyType = 'int';

    // Kolom yang bisa diisi
    protected $fillable = [
        'No_Transaksi',
        'No_Kontrol',
        'No_Pemakaian',
        'TanggalPembayaran',
        'TotalTagihan',
        'MetodePembayaran',
        'Status',
    ];
}
