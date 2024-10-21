<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Comentario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class comentariosController extends Controller
{
    public function index(){

        $Comentarios = Comentario::all();

        //if($Comentarios->isEmpty()){
        //    $data = [
        //        'message'=> 'No se encontraron Comentarios registrados',
        //        'status'=> 200
        //    ];

        //    return response()->json($data, 404);
        //}

        $data = [
            'Comentarios' => $Comentarios,
            'status'=> 200
        ];

        return response()->json($data, 200);
    }

    public function store(Request $request){
        $validator = Validator::make($request->all(), [
            'contenido' => 'required|max:3000',
            'descripcion' => 'required|max:255',
            'articulo_id' => 'required|exists:articulos,id',
            'usuario_id' => 'required|exists:usuarios,id'
        ], [
            'articulo_id.exists' => 'El artículo seleccionado no es válido.',
            'usuario_id.exists' => 'El usuario seleccionado no es válido.'
        ]);
    
        if($validator->fails()){
            $data = [
                'message'=> 'Error de validacion de los datos',
                'errors'=>$validator->errors(),
                'status'=>400
            ];
            return response()->json($data, 400);
        }
    
        $Comentario = Comentario::create([
            'contenido' => $request->contenido,
            'descripcion' => $request->descripcion,
            'articulo_id' => $request->articulo_id,
            'usuario_id' => auth()->id()  // Asignar el ID del usuario autenticado
        ]);
    
        if(!$Comentario){
            $data = [
                'message'=> 'Error al crear la Comentario',
                'status'=>500
            ];
            return response()->json($data, 500);
        }
    
        $data = [
            'Comentario' => $Comentario,
            'status'=>201
        ];
        return response()->json($data, 201);
    }

    public function mostrar($id){
        $Comentario = Comentario::find($id);
        if(!$Comentario){
            $data = [
                'message' => 'Comentario no encontrado',
                'status' => 404
            ];
            return response()->json($data, 404);
        }
        $data = [
            'Comentario'=> $Comentario,
            'status'=> 200
        ];
        
        return response()->json($data, 200); 
    }

    public function eliminar($id){
        $ComentarioElim = Comentario::find($id);

        if(!$ComentarioElim){
            $data = [
                'message'=> 'El Comentario no se a encontrado',
                'status'=> 404
            ]; 
            return response()->json($data, 200);
        }
        $ComentarioElim->delete();

        $data=[
            'message'=>'El Comentario a sido eliminado',
            'status'=>200
        ];

        return response()->json($data, 200);
    }

    public function actualizar(Request $request, $id){
        $ComentarioActu = Comentario::find($id);
        if(!$ComentarioActu){
            $data=[
            'message'=>'Comentario no encontrado',
            'status'=>404
            ];
            return response()->json($data, 404);
        }

        $validator = Validator::make($request->all(), [
            'contenido' => 'required|max:3000',
            'descripcion' => 'required|max:255',
            'articulo_id' => 'required|exists:articulos,id',
            'usuario_id' => 'required|exists:usuarios,id'
        ], [
            'articulo_id.exists' => 'El artículo seleccionado no es válido.',
            'usuario_id.exists' => 'El usuario seleccionado no es válido.'
        ]);

        if(!$validator->fails()){
            $data = [
                'message'=>'Error al validar los datos',
                'errors'=>$validator->errors(),
                'status'=>400
            ];
        }

        $ComentarioActu->contenido= $request->contenido;
        $ComentarioActu->descripcion= $request->descripcion;
        $ComentarioActu->articulo_id= $request->articulo_id;
        $ComentarioActu->usuario_id= $request->usuario_id;
        
        $ComentarioActu->save();

        $data = [
            'message'=> 'Comentario actualizado',
            'Comentario'=> $ComentarioActu,
            'status'=>200
        ];

        return response()->json($data, 200);
    }
}
