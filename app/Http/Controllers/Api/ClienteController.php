<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Cliente;
use Illuminate\Http\Request;

class ClienteController extends Controller
{

    public function index(Request $request)
    {
        //
        if ($request->search != '') {
            $lista_clientes = Cliente::where('ci_nit', 'like', '%' . $request->search . '%')->get();
        } else $lista_clientes = Cliente::all();

        return response()->json($lista_clientes, 200);
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
        $cliente = Cliente::find($id);
        if ($cliente) return response()->json($cliente, 200);
        return response()->json(["mensaje" => "No se encontro la cliente"], 404);
    }


    public function update(Request $request, $id)
    {
        //
    }


    public function destroy($id)
    {
        //
    }

    // public function search($atributo)
    // {
    //     return ['mensaje' => 'Exito'];
    // }
}
