<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Comentario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

/**

 * @OA\Schema(
 *     schema="Comentario",
 *     type="object",
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="contenido", type="string", example="Contenido del comentario"),
 *     @OA\Property(property="articulo_id", type="integer", example=1),
 *     @OA\Property(property="usuario_id", type="integer", example=1),
 *     @OA\Property(property="created_at", type="string", format="date-time", example="2024-01-01T12:00:00Z"),
 *     @OA\Property(property="updated_at", type="string", format="date-time", example="2024-01-01T12:00:00Z")
 * )
 */
class comentariosController extends Controller
{

  /**
     * @OA\Get(
     *     path="/api/comentarios",
     *     summary="Get all comments",
     *     tags={"Comentarios"},
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="Comentarios", type="array", @OA\Items(ref="#/components/schemas/Comentario")),
     *             @OA\Property(property="status", type="integer", example=200)
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="No comments found",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="No se encontraron comentarios registrados"),
     *             @OA\Property(property="status", type="integer", example=404)
     *         )
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
     *     summary="Create a new comment",
     *     tags={"Comentarios"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"contenido", "articulo_id", "usuario_id"},
     *             @OA\Property(property="contenido", type="string", example="Contenido del comentario"),
     *             @OA\Property(property="articulo_id", type="integer", example=1),
     *             @OA\Property(property="usuario_id", type="integer", example=1)
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Comment created successfully",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="Comentario", ref="#/components/schemas/Comentario"),
     *             @OA\Property(property="status", type="integer", example=201)
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Validation error",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="Error de validación"),
     *             @OA\Property(property="errors", type="object"),
     *             @OA\Property(property="status", type="integer", example=400)
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Internal server error",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="Error al crear el comentario"),
     *             @OA\Property(property="status", type="integer", example=500)
     *         )
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
     *     summary="Get a comment by ID",
     *     tags={"Comentarios"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Comment found",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="Comentario", ref="#/components/schemas/Comentario"),
     *             @OA\Property(property="status", type="integer", example=200)
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Comment not found",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="Comentario no encontrado"),
     *             @OA\Property(property="status", type="integer", example=404)
     *         )
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
     *     summary="Delete a comment by ID",
     *     tags={"Comentarios"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Comment deleted successfully",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="El comentario ha sido eliminado"),
     *             @OA\Property(property="status", type="integer", example=200)
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Comment not found",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="El comentario no se ha encontrado"),
     *             @OA\Property(property="status", type="integer", example=404)
     *         )
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
     *     summary="Update a comment by ID",
     *     tags={"Comentarios"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"contenido", "articulo_id", "usuario_id"},
     *             @OA\Property(property="contenido", type="string", example="Contenido actualizado del comentario"),
     *             @OA\Property(property="articulo_id", type="integer", example=1),
     *             @OA\Property(property="usuario_id", type="integer", example=1)
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Comment updated successfully",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="Comentario actualizado"),
     *             @OA\Property(property="Comentario", ref="#/components/schemas/Comentario"),
     *             @OA\Property(property="status", type="integer", example=200)
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Comment not found",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="Comentario no encontrado"),
     *             @OA\Property(property="status", type="integer", example=404)
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Validation error",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="Error al validar los datos"),
     *             @OA\Property(property="errors", type="object"),
     *             @OA\Property(property="status", type="integer", example=400)
     *         )
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
