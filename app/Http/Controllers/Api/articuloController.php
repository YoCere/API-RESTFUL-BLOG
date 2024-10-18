<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Articulo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class articuloController extends Controller
{
    public function index(){

        $Articulos = Articulo::all();

        //if($Articulos->isEmpty()){
        //    $data = [
        //        'message'=> 'No se encontraron articulos registrados',
        //        'status'=> 200
        //    ];

        //    return response()->json($data, 404);
        //}

        $data = [
            'articulos' => $Articulos,
            'status'=> 200
        ];

        return response()->json($data, 200);
    }

    public function store(Request $request){
        $validator = Validator::make($request->all(), [
            'titulo'=>'required',
            'contenido'=>'required',
            'categoria_id'=>'required',
            'usuario_id'=>'required'
        ]);

        if($validator->fails()){
            $data = [
                'message'=> 'Error de validacion de los datos',
                'errors'=>$validator->errors(),
                'status'=>400
            ];
            return response()->json($data, 400);
        }
        $Articulo = Articulo::create([
            'titulo'=>$request->titulo,
            'contenido'=>$request->contenido,
            'categoria_id'=>$request->categoria_id,
            'usuario_id'=>$request->usuario_id
        ]);

        if(!$Articulo){
            $data = [
                'message'=> 'Error al crear el articulo',
                'status'=>500
            ];
            return response()->json($data, 500);
        }

        $data = [
            'articulo'=>$Articulo,
            'status'=>201
        ];
        return response()->json($data, 201);
    }
}
