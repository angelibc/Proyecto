<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Vale;

class ValesController
{
    public function crearPrevale(Request $request){
        $vale = $request->validate([
            'folio'             => 'required',
            'cliente_id'        => 'required',
            'distribuidor_id'   => 'required',
            'producto_id'       => 'required',
            'estado'            => 'required',
            'fecha_emision'     => 'required'
        ]);

        Vale::create($vale);

        return response()->json([
            'mensaje' => 'Vale creado exitosamente!',
            'vale' => $vale
        ],200);
    }
}
