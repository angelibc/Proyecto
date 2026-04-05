<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DatoVehiculo extends Model
{
    protected $table = 'datos_vehiculos';
    
    protected $fillable = [
        'distribuidor_id',
        'marca',
        'modelo',
        'color',
        'numero_placas'
    ];

    public function distribuidora(): BelongsTo{
        return $this->belongsTo(Distribuidora::class,'distribuidor_id');
    }
}
