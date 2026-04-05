<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Producto;

class ProductosController
{
    public function crearProducto(Request $request){
        $producto = $request->validate([
            'monto'             => 'required',
            'porcentaje_comision'          => 'required',
            'seguro'            => 'required',
            'quincenas'         => 'required',
            'interes_quincenal' => 'required',
        ]);

        Producto::create($producto);

        return response()->json([
            'mensaje'=>'Producto creado exitosamente!',
            'producto'=>$producto,
        ],200);
    }
}
