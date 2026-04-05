<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Afilial extends Model
{
    protected $table = 'afiliales';

    protected $fillable = [
        'distribuidor_id',
        'nombre',
        'antiguedad',
        'linea_credito'
    ];

    public function distribuidora(): BelongsTo{
        return $this->belongsTo(Distribuidora::class,'distribuidor_id');
    }
}
