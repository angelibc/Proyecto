<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Relacion;

class RelacionesController
{
    public function crearRelacion(Request $request){
        $relacion = $requets->validate([
            'distribuidor_id'   => 'required',
            'folio_referencia'  => 'required',
            'fecha_limite_pago' => 'required',
            'total_a_pagar'     => 'required',
        ]);

        Relacion::create($relacion);

        return response()->json([
            'mensaje'  => 'Relacion creada exitosamente!',
            'relacion' => $relacion
        ],200);
    }
}
