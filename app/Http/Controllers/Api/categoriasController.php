<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Categoria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class categoriasController extends Controller
{
    public function index(){

        $Categorias = Categoria::all();

        //if($Categorias->isEmpty()){
        //    $data = [
        //        'message'=> 'No se encontraron articulos registrados',
        //        'status'=> 200
        //    ];

        //    return response()->json($data, 404);
        //}

        $data = [
            'articulos' => $Categorias,
            'status'=> 200
        ];

        return response()->json($data, 200);
    }

    public function store(Request $request){
        $validator = Validator::make($request->all(), [
            'nombre' => 'required|max:255',
            'descripcion' => 'required|max:1000'
        ]);
    
        if($validator->fails()){
            $data = [
                'message'=> 'Error de validacion de los datos',
                'errors'=>$validator->errors(),
                'status'=>400
            ];
            return response()->json($data, 400);
        }
    
        $Categoria = Categoria::create([
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion
        ]);
    
        if(!$Categoria){
            $data = [
                'message'=> 'Error al crear la categoria',
                'status'=>500
            ];
            return response()->json($data, 500);
        }
    
        $data = [
            'categoria' => $Categoria,
            'status'=>201
        ];
        return response()->json($data, 201);
    }
}
