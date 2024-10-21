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
        //        'message'=> 'No se encontraron Categorias registrados',
        //        'status'=> 200
        //    ];

        //    return response()->json($data, 404);
        //}

        $data = [
            'Categorias' => $Categorias,
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

    public function mostrar($id){
        $Categoria= Categoria::find($id);
        if(!$Categoria){
            $data = [
                'message' => 'Categoria no encontrado',
                'status' => 404
            ];
            return response()->json($data, 404);
        }
        $data = [
            'Categoria'=> $Categoria,
            'status'=> 200
        ];
    }

    public function eliminar($id){
        $CategoriaElim = Categoria::find($id);

        if(!$CategoriaElim){
            $data = [
                'message'=> 'El Categoria no se a encontrado',
                'status'=> 404
            ]; 
            return response()->json($data, 200);
        }
        $CategoriaElim->delete();

        $data=[
            'message'=>'El Categoria a sido eliminado',
            'status'=>200
        ];

        return response()->json($data, 200);
    }

    public function actualizar(Request $request, $id){
        $CategoriaActu = Categoria::find($id);
        if(!$CategoriaActu){
            $data=[
            'message'=>'Categoria no encontrado',
            'status'=>404
            ];
            return response()->json($data, 404);
        }

        $validator = Validator::make($request->all(), [
            'nombre'=>'required|max:255',
            'descripcion'=>'required|max:5000'
        ]);

        if(!$validator->fails()){
            $data = [
                'message'=>'Error al validar los datos',
                'errors'=>$validator->errors(),
                'status'=>400
            ];
        }

        $CategoriaActu->nombre= $request->nombre;
        $CategoriaActu->descripcion= $request->descripcion;
        
        $CategoriaActu->save();

        $data = [
            'message'=> 'Categoria actualizado',
            'Categoria'=> $CategoriaActu,
            'status'=>200
        ];

        return response()->json($data, 200);
    }
}
