<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Validation\Exception;
use App\Models\Persona;

class PersonasController
{
   public function crearPersona(Request $request)
    {
        try {
            $data = $request->validate([
                'nombre'            => 'required|string|max:100',
                'apellido'          => 'required|string|max:100',
                'sexo'              => 'required|in:H,M,O',
                'fecha_nacimiento'  => 'required|date|before:today',
                'CURP'              => 'required|string|size:18|unique:personas,CURP',
                'RFC'               => 'required|string|size:13|unique:personas,RFC',
                'telefono_personal'  => 'required|string|max:15|unique:personas,telefono_personal',
                'celular'           => 'required|string|max:15|unique:personas,celular',
            ]);

            $persona = Persona::create($data);

            return response()->json([
                'status' => 'success',
                'mensaje' => 'Persona creada exitosamente!',
                'data' => $persona,
            ], 201);

        } catch (ValidationException $e) {
            return response()->json([
                'status' => 'error',
                'mensaje' => 'Error de validación',
                'errores' => $e->errors(),
            ], 422);

        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'mensaje' => 'No se pudo crear la persona',
                'error_detalle' => $e->getMessage(), // Ojo: en producción es mejor no mostrar el mensaje real
            ], 500);
        }
    }
}
