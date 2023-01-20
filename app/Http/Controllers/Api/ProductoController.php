<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Producto;

class ProductoController extends Controller
{

    public function index()
    {
        // cuantos datos por pagina enviamos
        $productos = Producto::paginate(10);
        return response()->json($productos, 200);
    }


    public function store(Request $request)
    {
        // validar antes de guardar
        $request->validate([
            "nombre" => "required|unique:producto|max:20|min:3",
        ]);

        // creamos nuevo producto
        $cat = new Producto();
        $cat->nombre = $request->nombre;
        $cat->detalle = $request->detalle;
        $cat->save();

        return response()->json(["mensaje" => "Categoria Registrado", "data" => $cat], 201);
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
