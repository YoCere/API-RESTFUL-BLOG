<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Comentario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class comentariosController extends Controller
{

     /**
     * @OA\Get(
     *     path="/api/comentarios",
     *     summary="Obtener todos los comentarios",
     *     tags={"Comentarios"},
     *     @OA\Response(
     *         response=200,
     *         description="Lista de comentarios obtenida."
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="No se encontraron comentarios."
     *     )
     * )
     */

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


    /**
     * @OA\Post(
     *     path="/api/comentarios",
     *     summary="Crear un nuevo comentario",
     *     tags={"Comentarios"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"contenido", "articulo_id", "usuario_id"},
     *             @OA\Property(property="contenido", type="string", example="Este es un comentario"),
     *             @OA\Property(property="articulo_id", type="integer", example=1),
     *             @OA\Property(property="usuario_id", type="integer", example=1)
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Comentario creado"
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Error de validación"
     *     )
     * )
     */

    public function store(Request $request) {
        $validator = Validator::make($request->all(), [
            'contenido' => 'required|max:3000',
            'articulo_id' => 'required|exists:articulos,id',
            'usuario_id' => 'required|exists:users,id'
        ], [
            'articulo_id.exists' => 'El artículo seleccionado no es válido.',
            'usuario_id.exists' => 'El usuario seleccionado no es válido.'
        ]);
    
        if ($validator->fails()) {
            return response()->json([
                'message' => 'Error de validación',
                'errors' => $validator->errors(),
                'status' => 400
            ], 400);
        }
    
        // Asignar el ID del usuario autenticado
        $Comentario = Comentario::create([
            'contenido' => $request->contenido,
            'articulo_id' => $request->articulo_id,
            'usuario_id' => $request->usuario_id  // Aquí asignamos el ID del usuario autenticado
        ]);
    
        return response()->json([
            'Comentario' => $Comentario,
            'status' => 201
        ], 201);
    }



    /**
     * @OA\Get(
     *     path="/api/comentarios/{id}",
     *     summary="Mostrar un comentario por ID",
     *     tags={"Comentarios"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID del comentario",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Comentario obtenido"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Comentario no encontrado"
     *     )
     * )
     */


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


    /**
     * @OA\Delete(
     *     path="/api/comentarios/{id}",
     *     summary="Eliminar un comentario por ID",
     *     tags={"Comentarios"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID del comentario",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Comentario eliminado"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Comentario no encontrado"
     *     )
     * )
     */


    public function eliminar($id){
        $ComentarioElim = Comentario::find($id);

        if(!$ComentarioElim){
            $data = [
                'message'=> 'El Comentario no se ha encontrado',
                'status'=> 404
            ]; 
            return response()->json($data, 404);  // Cambiar a 404
        }
        $ComentarioElim->delete();

        $data=[
            'message'=>'El Comentario a sido eliminado',
            'status'=>200
        ];

        return response()->json($data, 200);
    }


    /**
     * @OA\Put(
     *     path="/api/comentarios/{id}",
     *     summary="Actualizar un comentario por ID",
     *     tags={"Comentarios"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID del comentario",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"contenido", "articulo_id", "usuario_id"},
     *             @OA\Property(property="contenido", type="string", example="Este es un comentario actualizado"),
     *             @OA\Property(property="articulo_id", type="integer", example=1),
     *             @OA\Property(property="usuario_id", type="integer", example=1)
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Comentario actualizado"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Comentario no encontrado"
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Error de validación"
     *     )
     * )
     */
    
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
            'articulo_id' => 'required|exists:articulos,id',
            'usuario_id' => 'required|exists:users,id'
        ], [
            'articulo_id.exists' => 'El artículo seleccionado no es válido.',
            'usuario_id.exists' => 'El usuario seleccionado no es válido.'
        ]);
    
        

        if($validator->fails()){
            $data = [
                'message'=>'Error al validar los datos',
                'errors'=>$validator->errors(),
                'status'=>400
            ];
            return response()->json($data, 400);  // Retorna el error si falla la validación
        }

        $ComentarioActu->contenido= $request->contenido;
        $ComentarioActu->articulo_id= $request->articulo_id;
        $ComentarioActu->usuario_id = $request->usuario_id;
        $ComentarioActu->save();

        $data = [
            'message'=> 'Comentario actualizado',
            'Comentario'=> $ComentarioActu,
            'status'=>200
        ];

        return response()->json($data, 200);
    }
}
