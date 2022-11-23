<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Models\Categoria;
use App\Models\Producto;

class CategoriasController extends Controller
{
    private $find_productos;
    private $id;

    public function index(Request $request)
    {   
        $categoria = Categoria::get();
        return response()->json($categoria);
    }

    public function crear(Request $request)
    {
        $categoria = Categoria::where('nombre',$request->nombre)->get();
        
        if($categoria->count() == 0){
            Categoria::create([
                'nombre' => $request->nombre
            ]);
        };

        return response('Categoria creada correctamente');   
    }

    public function modificar(Request $request, $id)
    {
        if($request->nombre){
            $categoria = Categoria::find($id);
            $categoria->nombre = $request->nombre;
            $categoria->save();

            return response('categoria actualizada correctamente');
        }else{
            return response('Ingresa el nuevo nombre de la categoría');
        }
    }

    public function eliminar(Request $request, $id)
    {
        $this->id = $id;
        $productos = Producto::with('categorias')->get();

        $productos->map(function ($producto) {
            $producto = $producto->toArray();
            if($producto['categorias'][0]['id'] == $this->id){
                $this->find_productos[] = $producto;
                $this->find_productos = collect($this->find_productos);
            };
        });

        $this->find_productos->map(function ($find_producto) {
            $res = Producto::where('id',$find_producto['id'])->delete();
        });
        $resCategoria = Categoria::where('id', $this->id)->delete();

        return response('Categoria eliminada correctamente');
    }
}
