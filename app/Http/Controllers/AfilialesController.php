<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Afilial;

class AfilialesController
{
    public function crearAfilial(Request $request){
        $datos = $request->validate([
            //Datos del vehiculo
            'distribuidor_id'   => 'required',
            'nombre'            => 'required',
            'antiguedad'        => 'required',
            'linea_credito'     => 'required',
        ]);

        return DB::transaction(function () use ($datos) {
            $afilial = Afilial::create([
                'distribuidor_id'   => $datos['distribuidor_id'],
                'nombre'            => $datos['nombre'],
                'antiguedad'        => $datos['antiguedad'],
                'linea_credito'     => $datos['linea_credito'],
            ]);
            
            return response()->json([
                'mensaje' => 'Vehiculo creado exitosamente!',
                'afilial' => $afilial
            ], 201);
        });
    }
}
