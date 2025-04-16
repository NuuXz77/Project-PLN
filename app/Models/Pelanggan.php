<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pelanggan extends Model
{
    // Nama tabel
    protected $table = 'pelanggan';

    // Primary key
    protected $primaryKey = 'ID_Pelanggan';

    // Kolom yang dapat diisi (fillable)
    protected $fillable = [
        'No_Kontrol',
        'Nama',
        'Alamat',
        'Telepon',
        'Email',
        'Jenis_Plg',
    ];

    // Relasi ke tabel Pemakaian
    public function pemakaian()
    {
        return $this->hasMany(Pemakaian::class, 'No_Kontrol', 'No_Kontrol');
    }

    public function pembayaran()
    {
        return $this->hasMany(Pembayaran::class, 'No_Kontrol', 'No_Kontrol');
    }

    // Relasi ke tabel Tarif berdasarkan Jenis_Plg
    public function tarif()
    {
        return $this->belongsTo(Tarif::class, 'Jenis_Plg', 'Jenis_Plg');
    }

    // public function tarif()
    // {
    //     return $this->belongsTo(Tarif::class, 'No_Tarif');
    // }

    // Tipe data kolom (opsional)
    protected $casts = [
        'Jenis_Plg' => 'string', // Enum akan di-cast sebagai string
    ];

    // Timestamps (created_at dan updated_at)
    public $timestamps = true; // Default adalah true, tidak perlu ditulis jika tidak diubah
}
