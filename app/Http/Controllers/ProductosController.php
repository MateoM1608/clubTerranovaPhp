<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use App\Models\Categoria;
use App\Models\CateogoriaProducto;
use Illuminate\Http\Request;

class ProductosController extends Controller
{
    public $idCategory;
    public $findProduct;

    public function index(Request $request)
    {
        $productos = Producto::with('categorias')->get();

        return response()->json($productos);
    }


    public function producto(Request $request, $idProducto)
    {
        $producto = Producto::with('Categorias')->where('id', $idProducto)->get();

        return response()->json($producto);
    }


    public function crear(Request $request)
    {
        $categoria = Categoria::where('id', $request->idCategoria)->get();
        $findProduct = Producto::where('nombre', $request->nombre)->get();

        if($findProduct->count() == 0){
            if(isset($request->nombre) && isset($request->precio)){
                $producto = Producto::create([
                    'nombre' => $request->nombre,
                    'precio' => $request->precio,
                    'cantidad' => $request->cantidad
                ]);

                $relation = CateogoriaProducto::create([
                    'CategoriaId' => $categoria->first()->id,
                    'ProductoId' => $producto->id
                ]);

                return response('Producto creado correctamente');
            }
        }else{
            return response('El producto ya existe');
        }
    }

    public function modificar(Request $request, $id){
        $producto = Producto::where('id', $id)->first();
        if(isset($request->sumarCantidad) && isset($request->cantidad)){
            return response('No es posible agregar cantidad y sumarCantidad');
        }else if(isset($request->sumarCantidad)){

            $sumCantidad = $producto->cantidad + $request->sumarCantidad;

            $producto->cantidad = $sumCantidad;

            if(isset($request->nombre)){
                $producto->nombre = $request->nombre;
            }

            if(isset($request->precio)){
                $producto->precio = $request->precio;
            };
            $producto->save();

            return response('producto actualizado correctamente');

        }else{

            if(isset($request->nombre)){
                $producto->nombre = $request->nombre;
            }

            if(isset($request->precio)){
                $producto->precio = $request->precio;
            };

            if(isset($request->cantidad)){
                $producto->cantidad = $request->cantidad;
            };

            $producto->save();
            return response('producto actualizado correctamente');

        }
    }

    public function eliminar(Request $request, $id)
    {
        Producto::find($id)->delete();

        return response('Producto eliminado correctamente');
    }

    public function categoria(Request $request, $idCategory)
    {
        $this->idCategory =$idCategory;
        $productos = Producto::with('categorias')->get();
        $productos->map( function ($producto) {
            if($producto->categorias->first()->id == $this->idCategory){
                $this->findProduct[] = $producto;
            }
        });

        return response()->json($this->findProduct);
    }
}
