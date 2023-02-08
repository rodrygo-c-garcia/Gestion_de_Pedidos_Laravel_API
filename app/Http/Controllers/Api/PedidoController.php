<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Cliente;
use App\Models\Pedido;
use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PedidoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pedidos = Pedido::with('cliente')->with('user')->paginate(10);
        return response()->json($pedidos, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // nesecitamos cliente_id, user_id
        // [producto_id]

        // validacion los datos requeridos de pedido
        $request->validate([
            'cod_factura' => 'required|unique:pedidos',
            'cliente_id' => 'required',
            'productos' => 'required',
        ]);

        try {
            // obtenemos el id del usuario, es decir el admin del sistema
            $user = Auth::user();
            // buscamos el del cliente
            $cliente = Cliente::findOrFail($request->cliente_id);

            // generamos el pedido
            $pedido = new Pedido();
            $pedido->fecha_pedido = date('Y-m-d H:i:s');
            $pedido->cod_factura = $request->cod_factura;
            $pedido->user_id = $user->id;
            $pedido->cliente_id = $cliente->id;
            $pedido->estado = 0;
            $pedido->save();

            // validamos de que tengamos suficientes productos para procesar el pedido
            if (count($request->productos) > 0) {

                foreach ($request->productos as $ped) {
                    $prod_id = $ped["producto_id"];
                    $prod_cantidad = $ped['cantidad'];

                    $producto = Producto::FindOrFail($prod_id);
                    // validamos nuestro stock
                    if ($producto->stock > $prod_cantidad) {
                        // relacion de muchos a muchos 'pedido_producto'
                        // del mismo pedido que estamos creanto en su producto hacemos incrustacion
                        $pedido->productos()->attach($producto->id, ['cantidad' => $prod_cantidad]);
                    } else {
                        return response()->json(['message' => 'Cantidad inexistente del producto'], 400);
                    }
                }
                // pedido completado
                $pedido->estado = 2;
                $pedido->save();
                return response()->json(['message' => 'Pedido completado'], 200);
            } else {
                return response()->json(['message' => 'Productos son obligatorios!', 'error' => true, 'status' => 400], 400);
            }

            // retornamos al cliente
        } catch (\Exception $e) {
            // En caso de que el cliente no se encuentre
            return response()->json(['message' => 'El cliente o productos son obligatorio!', 'error' => true, 'status' => 422], 422);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        try {
            //$pedido = Pedido::with('cliente')->with('user')->FindOrFail($id);  // el cliente y usuario del pedido (id)
            $pedido = Pedido::FindOrFail($id);
            // obtenemos su cliente
            $pedido->cliente;
            // usuario que atendio
            $pedido->user;
            // los productos que pidio
            $pedido->productos;
            return response()->json($pedido);
        } catch (\Exception $e) {
            return response()->json(['mensaje' => 'El pedido no existe'], 404);
        }
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
