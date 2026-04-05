<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DatoVehiculo;
use Illuminate\Support\Facades\DB;

class DatosVehiculosController
{
    public function crearVehiculo(Request $request){
        $datos = $request->validate([
            //Datos del vehiculo
            'distribuidor_id'   => 'required',
            'marca'             => 'required',
            'modelo'            => 'required',
            'color'             => 'required',
            'numero_placas'     => 'required',            
        ]);

        return DB::transaction(function () use ($datos) {
            $vehiculo = DatoVehiculo::create([
                'distribuidor_id'   => $datos['distribuidor_id'],
                'marca'             => $datos['marca'],
                'modelo'            => $datos['modelo'],
                'color'             => $datos['color'],
                'numero_placas'     => $datos['numero_placas'],  
            ]);
            
            return response()->json([
                'mensaje' => 'Vehiculo creado exitosamente!',
                'vehiculo' => $vehiculo
            ], 201);
        });
    }
}
