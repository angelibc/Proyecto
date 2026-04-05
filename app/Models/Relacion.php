<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Relacion extends Model
{
    protected $table = 'relaciones';

    protected $fillable = [
        'distribuidor_id',
        'folio_referencia',
        'fecha_limite_pago',
        'total_a_pagar',
    ];

    public function distribuidora(): BelongsTo{
        return $this->belongsTo(Distribuidora::class,'distribuidor_id');
    }
}
