<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Categoria extends Model
{
    protected $table = 'categorias';

    protected $fillable = [
        'categoria',
        'porcentaje_comision'
    ];

    public function distribuidora(): HasMany{
        return $this->hasMany(Distribuidora::class,'categoria_id');
    }
}
