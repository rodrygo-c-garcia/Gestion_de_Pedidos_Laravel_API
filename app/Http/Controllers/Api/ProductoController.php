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
            'precio' => "required",
            'categoria_id' => "required"
        ]);

        $name_img = '';
        if ($file = $request->file('imagen')) {
            $name_img = time() . "-" . $file->getClientOriginalName();
            $file->move('imagenes');
        }
        // creamos nuevo Producto
        $producto = new Producto();
        $producto->nombre = $request->nombre;
        $producto->precio = $request->precio;
        $producto->stock = $request->stock;
        $producto->descripcion = $request->descripcion;
        $producto->estado = $request->estado;
        $producto->categoria_i = $request->categoria_i;
        $producto->imagen = '/imagenes' . $name_img;
        $producto->save();

        return response()->json(["mensaje" => "Producto Registrado", "data" => $producto], 201);
    }


    public function show($id)
    {
        $producto = Producto::find($id);
        return response()->json($producto, 200);
    }

    public function update(Request $request, $id)
    {
        // validar antes de guardar
        $request->validate([
            // que verifique todo excepto el dato seleccionado
            "nombre" => "required|max:20|min:3|unique:productos,nombre,$id",
            'precio' => "required",
            'categoria_id' => "required"
        ]);

        $producto = Producto::find($id);


        // actualizamos los datos del Producto
        $producto = new Producto();
        $producto->nombre = $request->nombre;
        $producto->precio = $request->precio;
        $producto->stock = $request->stock;
        $producto->descripcion = $request->descripcion;
        $producto->estado = $request->estado;
        $producto->categoria_i = $request->categoria_i;
        $name_img = '';
        if ($file = $request->file('imagen')) {
            $name_img = time() . "-" . $file->getClientOriginalName();
            $file->move('imagenes');
            $producto->imagen = '/imagenes' . $name_img;
        }
        $producto->save();

        return response()->json(["mensaje" => "Producto Modificado"], 201);
    }
}
