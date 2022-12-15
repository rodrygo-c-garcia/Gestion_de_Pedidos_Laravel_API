<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class SanctumAuthController extends Controller
{
    // registrar usuario
    public function login(Request $request)
    {
        $request->validate([
            "email" => "required|email",
            "password" => "required",
        ]);

        // verificar correo
        $user = User::where("email", "=", $request->email)->first();

        if (isset($user->id)) {
            // verificar el password
            if (Hash::check($request->password, $user->password)) {
                //generar el token
                $token = $user->createToken("auth_token")->plainTextToken;
                return response()->json([
                    "mensaje" => "Usuario Logueado",
                    "access_token" => $token
                ]);
            } else {
                return response()->json(["mensaje" => "Contraseña Incorrecta", "error" => true], 200);
            }
        } else {
            return response()->json(["mensaje" => "Usuario no existe", "error" => true], 200);
        }
    }

    public function registro(Request $request)
    {
        // 1 -> validar
        $request->validate([
            "name" => "required",
            "email" => "required|email|unique:users",
            "password" => "required|confirmed",
        ]);
        // 2 -> guardar
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->save();

        return response()->json(["mensaje" => "Usuario Registrado"], 201);
    }

    public function perfil()
    {
    }

    public function logout()
    {
    }
}
