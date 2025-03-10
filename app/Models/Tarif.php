<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tarif extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'tarif';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'ID_Tarif';

    /**
     * Indicates if the model's ID is auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = true;

    /**
     * The data type of the auto-incrementing ID.
     *
     * @var string
     */
    protected $keyType = 'int';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'No_Tarif',
        'Jenis_Plg',
        'Daya',
        'BiayaBeban',
        'TarifKWH',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'Jenis_Plg' => 'string',
        'Daya' => 'integer',
        'BiayaBeban' => 'decimal:2',
        'TarifKWH' => 'decimal:2',
    ];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = true;
}
