<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController
{
    public function iniciarSesion(Request $request){
        $credenciales = $request->validate([
            'email'     => 'required|email',
            'password'  => 'required',
        ]);

        if(!Auth::attempt($credenciales)){
            return response()->json([
                'mensaje' => 'Credenciales incorrectas'
            ],401);
        }

        $usuario = User::with(['persona','role'])->where('email',$request->email)->first();

        $token  = $usuario->createToken('auth_token')->plainTextToken;

        return response()->json([
            'mensaje' => 'Bienvenido al sistema Prevale',
            'access_token' => $token,
            'token_type' => 'Bearer',
            'usuario' => [
                'id' => $usuario->id,
                'nombre' => $usuario->persona->nombre . ' ' . $usuario->persona->apellido,
                'email' => $usuario->email,
                'rol' => $usuario->role->role, // Ejemplo: 'Gerente'
                'sucursal_id' => $usuario->sucursal_id
            ]
        ], 200);
    }
}
