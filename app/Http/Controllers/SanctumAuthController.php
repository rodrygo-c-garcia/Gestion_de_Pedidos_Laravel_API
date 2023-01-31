<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class SanctumAuthController extends Controller
{
    public function login(Request $request)
    {
        // validar los datos
        $request->validate([
            "email" => "required|email",
            "password" => "required",
        ]);

        // verificamos y obtenemos al usuario por su correo
        //$user = User::where("email", "=", $request->email)->first();
        $user = User::where("email", $request->email)->first();

        // preguntamos si existe el id del usuario y verificar el password con la clase Hash y su metodo check (verificacion)
        if (isset($user->id) && Hash::check($request->password, $user->password)) {
            //generar el token
            $token = $user->createToken("auth_token")->plainTextToken;
            return response()->json([
                "mensaje" => "Usuari o Logueado",
                "access_token" => $token,
                "error" => false
            ]);
        } else {
            return response()->json(["mensaje" => "Credenciales invalidas", "error" => true], 200);
        }
    }

    // registrar usuario
    public function registro(Request $request)
    {
        // 1 -> validar
        // reglas de validacion
        $request->validate([
            "name" => "required",
            "email" => "required|email|unique:users",
            "password" => "required|confirmed", // confirmacion de la contraseña
        ]);
        // 2 -> guardar
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        // encriptar la contraseña con la clase Hash
        $user->password = Hash::make($request->password);
        $user->save();

        return response()->json(["mensaje" => "Usuario Registrado"], 201);
    }

    public function perfil()
    {
        return response()->json([
            "mensaje" => "Perfil",
            "data" => Auth::user()
        ]);
    }

    public function logout()
    {
        // del usuario actual su usuario
        return Auth::user()->tokens()->delete();
    }


    // Refrescar Token
    public function refresh(Request $request)
    {
        $request->user()->tokens()->delete();

        return response()->json([
            'access_token' => $request->user()->createToken('api')->plainTextToken,
        ]);
    }
}
