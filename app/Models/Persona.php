<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Persona extends Model
{
    protected $table = 'personas';

    protected $fillable = [
        'nombre',
        'apellido',
        'sexo',
        'fecha_nacimiento',
        'CURP',
        'RFC',
        'telefono_personal',
        'celular',
    ];

    protected $casts = [
        'fecha_nacimiento' => 'date',
    ];

    protected function curp(): Attribute
    {
        return Attribute::make(
            set: fn (string $value) => strtoupper($value),
        );
    }

    protected function rfc(): Attribute
    {
        return Attribute::make(
            set: fn (string $value) => strtoupper($value),
        );
    }
    
    public function usuario(): HasOne{
        return $this->hasOne(User::class,'persona_id');
    }

    public function cliente(): HasOne{
        return $this->hasOne(Cliente::class,'persona_id');
    }

    public function dato_familia(): HasOne{
        return $this->hasOne(DatoFamilia::class,'persona_id');
    }
}
