<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Cliente;
use Illuminate\Http\Request;

class ClienteController extends Controller
{

    public function index()
    {
        //
    }


    public function store(Request $request)
    {
        //validamos
        $request->validate([
            'nombreCompleto' => 'required',
        ]);

        // creamos nuevo Cliente
        $cliente = new Cliente();
        $cliente->nombreCompleto = $request->nombreCompleto;
        $cliente->ci_nit = $request->ci_nit;
        $cliente->telefono = $request->telefono;
        $cliente->correo = $request->correo;
        $cliente->save();

        return response()->json(['mensaje' => 'Cliente registrado', 'cliente' => $cliente]);
    }


    public function show($id)
    {
        //
    }


    public function update(Request $request, $id)
    {
        //
    }


    public function destroy($id)
    {
        //
    }
}
