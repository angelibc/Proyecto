<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Persona;
use App\Models\DatoFamilia;
use Illuminate\Support\Facades\DB;

class DatosFamiliaresController
{
    public function crearDatoFamiliar(Request $request){
        $datos = $request->validate([
            //Datos de la persona
            'nombre'            => 'required|string|max:100',
            'apellido'          => 'required|string|max:100',
            'sexo'              => 'required|in:H,M,O', // Hombre, Mujer, Otro
            'fecha_nacimiento'  => 'required|date|before:today',
            'CURP'              => 'required|string|size:18|unique:personas,CURP',
            'RFC'               => 'nullable|string|min:12|max:13|unique:personas,RFC',
            'telefono_personal' => 'nullable|string|max:15',
            'celular'           => 'required|string|max:15',

            //Datos del familiar
            'distribuidor_id'   => 'required',
            'parentesco'        => 'required|string'
        ]);

        return DB::transaction(function () use ($datos) {
            
            // 3. Creamos primero la Persona
            $persona = Persona::create([
                'nombre'           => $datos['nombre'],
                'apellido'         => $datos['apellido'],
                'sexo'             => $datos['sexo'],
                'fecha_nacimiento' => $datos['fecha_nacimiento'],
                'CURP'             => $datos['CURP'],
                'RFC'              => $datos['RFC'],
                'telefono_personal' => $datos['telefono_personal'],
                'celular'          => $datos['celular'],
            ]);

            $familiar = DatoFamilia::create([
                'distribuidor_id'   => $datos['distribuidor_id'],
                'parentesco'        => $datos['parentesco'],
                'persona_id'        => $persona->id 
            ]);

            return response()->json([
                'mensaje' => 'Familiar creados exitosamente!',
                'user_id' => $familiar->id,
                'persona' => $persona
            ], 201);
        });
    }
}
