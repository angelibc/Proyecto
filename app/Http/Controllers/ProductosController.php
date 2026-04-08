<?php

namespace App\Http\Controllers;

use Illuminate\Validation\ValidationException;
use Illuminate\Validation\Exception;
use Illuminate\Http\Request;
use App\Models\Producto;

class ProductosController
{
    public function listaProductos(){
        $productos = Producto::all();

        return response()->json([
            'mensaje' => 'Lista de productos',
            'productos' => $productos
        ],200);
    }


    public function crearProducto(Request $request)
    {
        try {
            // La regla 'required' por sí sola ya impide valores NULL o vacíos
            $data = $request->validate([
                'monto'               => 'required|unique:productos,monto|numeric|min:0.01',
                'porcentaje_comision' => 'required|unique:productos,porcentaje_comision|numeric|between:0,100',
                'seguro'              => 'required|unique:productos,seguro|numeric|min:0',
                'quincenas'           => 'required|unique:productos,quincenas|integer|min:1|max:96',
                'interes_quincenal'   => 'required|unique:productos,interes_quincenal|numeric|min:0',
            ]);

            $producto = Producto::create($data);

            return response()->json([
                'status' => 'success',
                'mensaje' => 'Producto creado exitosamente!',
                'data' => $producto,
            ], 201);

        } catch (ValidationException $e) {
            return response()->json([
                'status' => 'error',
                'mensaje' => 'Error de validación: faltan datos o son incorrectos',
                'errores' => $e->errors(),
            ], 422);

        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'mensaje' => 'No se pudo crear el producto',
                // Recuerda que config('app.debug') ayuda a ocultar esto en producción
                'error_detalle' => config('app.debug') ? $e->getMessage() : 'Error interno del servidor',
            ], 500);
        }
    }

    public function editarProducto(Request $request, $id){
        $producto = Producto::findOrFail($id);

        $validated = $request->validate([
            'monto'                => 'sometimes|numeric|min:0',
            'porcentaje_comision'  => 'sometimes|numeric|min:0|max:100',
            'seguro'               => 'sometimes|numeric|min:0',
            'quincenas'            => 'sometimes|integer|min:1',
            'interes_quincenal'    => 'sometimes|numeric|min:0',
            'activo'               => 'sometimes|boolean',
        ]);

        $producto->update($validated);

        return response()->json([
            'mensaje'  => 'Producto actualizado correctamente',
            'producto' => $producto
        ], 200);
        }
    }
