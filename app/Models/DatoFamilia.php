<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DatoFamilia extends Model
{
    protected $table = 'datos_familiares';

    protected $fillable = [
        'distribuidor_id',
        'paretesco',
        'persona_id',
    ];

    public function distribuidora(): BelongsTo{
        return $this->belongsTo(Distribuidora::class,'distribuidor_id');
    }

    public function persona(): BelongsTo{
        return $this->belongsTo(Persona::class,'persona_id');
    }
}
