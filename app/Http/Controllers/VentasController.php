<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use App\Models\Venta;
use Illuminate\Http\Request;
use Carbon\Carbon;

class VentasController extends Controller
{
    private $totalVendido;
    private $totalProdVen;

    public function crear(Request $request, $idProducto)
    {
        try{
            $producto = Producto::where('id', $idProducto)->first();

            $data = new Carbon();
            $data ->subHours(5);
            $data->toDateTimeString();

            $cantidadRestante = $producto->cantidad - $request->cantidadAVender;

            if($cantidadRestante >= 0)
            {
                $producto->cantidad = $cantidadRestante;
                $producto->save();

                $precioTotal = $producto->precio * $request->cantidadAVender;
                $venta = Venta::create([
                    'producto' => $producto->nombre,
                    'precio_unitario' => $producto->precio,
                    'cantidad' => $request->cantidadAVender,
                    'precio_total' => $precioTotal,
                    'fecha' => $data,
                    'usuario' => $request->usuario,
                ]);
                return response('Venta creada correctamente');
            }else{
                $response = [
                    "error" => "No existe en inventario la cantidad que desea vender"
                ];
                return response()->json($response);
            }

        }catch(\Illuminate\Database\QueryExcepcion $e){
            return response()->json($e->getMessage());
        }
    }

    public function eliminar(Request $request, $ventaId)
    {
        try{
            Venta::where('id', $ventaId)->delete();

            return response('Venta eliminada correctamente');

        }catch(\Illuminate\Database\QueryExcepcion $e){
            return response()->json($e->getMessage());
        }
    }

    public function informes(Request $request)
    {

        $informe = Venta::whereBetween('fecha', [Carbon::parse($request->fechaInicio)->toDateTimeString(), Carbon::parse($request->fechaFinal)->toDateTimeString()])->get();

        $informe->map(function ($venta) {
            $this->totalVendido += $venta->precio_total;
            $this->totalProdVen +=$venta->cantidad;
        });

        $response = [[
            'informe' =>$informe,
            'total' => [
                'total_productos' => $this->totalProdVen,
                'total_venta' => $this->totalVendido
            ]
        ], $informe->count()];

        return response()->json($response);
    }
}
