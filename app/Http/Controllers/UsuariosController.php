<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Usuario;

class UsuariosController extends Controller
{
    public function registrar(Request $request)
    {

        try{
            if(isset($request->password) && isset($request->username)){
                $passwordEncrypt = Hash::make($request->password,['rounds' => 12]);

                Usuario::create([
                    'username' => $request->username,
                    'password' => $passwordEncrypt
                ]);
                return response('Usuario creado correcamente');
            }else if(!isset($request->password) && !isset($request->username)){
                $response = [
                    'usuario' => 'El usuario es necesario',
                    'contraseña' => 'la contraseña es necesaria para crear un usuario'
                ];
                return response($response);
            }else if(!isset($request->password)){
                $response = [
                    'contraseña' => 'la contraseña es necesaria para crear un usuario'
                ];
                return response($response);
            }else{
                $response = [
                    'usuario' => 'El usuario es necesario',
                ];
                return response($response);
            }
        }catch(\Illuminate\Database\QueryExcepcion $e){
            return response()->json($e->getMessage());
        }
    }

    public function autenticar(Request $request){

        $usuario = Usuario::where('username', $request->username)->first();

        if($usuario){

            if(Hash::check($request->password, $usuario->password)){
                $response = [
                    'user' => [
                        'id' => $usuario->id,
                        'username' => $usuario->username
                    ]
                ];
                return response()->json($response);
            }else{
                return response('Error en usuario y/o contraseña');
            }

        }else{
            return response('Error en usuario y/o contraseña');
        }

    }

    public function index(Request $request){
        $usuarios = Usuario::get([
            'id',
            'username'
        ]);

        return response()->json($usuarios);
    }

    public function eliminar(Request $request, $id)
    {
        if($id == 1){
            return response('El Administrador no puede ser eliminado');
        }else{
            Usuario::find($id)->delete();

            return response('Usuario eliminado corectamente');
        }
    }
}
