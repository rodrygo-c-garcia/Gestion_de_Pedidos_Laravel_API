<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Categoria;
use Illuminate\Http\Request;

class CategoriaController extends Controller
{

    public function index()
    {
        //listar toda la informacion
        $lista_categorias = Categoria::all();
        return response()->json($lista_categorias, 200);
    }

    // Guardar
    public function store(Request $request)
    {
        // validar antes de guardar
        $request->validate([
            "nombre" => "required|unique:categorias|max:50|min:3",
        ]);

        // guardar
        $cat = new Categoria();
        $cat->nombre = $request->nombre;
        $cat->detalle = $request->detalle;
        $cat->save();

        return response()->json(["mensaje" => "Categoria Registrado", "data" => $cat], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // $categoria = Categoria::findorFail($id);
        $categoria = Categoria::find($id);
        if ($categoria) return response()->json($categoria, 200);
        return response()->json(["mensaje" => "No se encontro la categoria"], 404);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            // Verficamos que se pueda guardar los camios en el id especicado
            "nombre" => "required|max:50|min:3|unique:categorias,nombre,$id",
        ]);

        $categoria = Categoria::where("id", $id)->first();
        if ($categoria) {
            $categoria->nombre = $request->nombre;
            $categoria->detalle = $request->detalle;
            $categoria->save();

            return response()->json(["mensaje" => "Categoria Modificada", "data" => $categoria], 201);
        }
        return response()->json(["mensaje" => "No se encontro la categoria"], 404);
    }


    public function destroy($id)
    {
        // Clase dia 4 hora 1: Minuto 12
    }
}
