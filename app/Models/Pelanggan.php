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

    // Tipe data kolom (opsional)
    protected $casts = [
        'Jenis_Plg' => 'string', // Enum akan di-cast sebagai string
    ];

    // Timestamps (created_at dan updated_at)
    public $timestamps = true; // Default adalah true, tidak perlu ditulis jika tidak diubah
}
