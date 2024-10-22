<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Articulo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Validator;

/**
 * @OA\Schema(
 *     schema="Articulo",
 *     type="object",
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="titulo", type="string", example="Título del artículo"),
 *     @OA\Property(property="contenido", type="string", example="Contenido del artículo"),
 *     @OA\Property(property="categoria_id", type="integer", example=1),
 *     @OA\Property(property="usuario_id", type="integer", example=1),
 *     @OA\Property(property="created_at", type="string", format="date-time", example="2024-01-01T12:00:00Z"),
 *     @OA\Property(property="updated_at", type="string", format="date-time", example="2024-01-01T12:00:00Z")
 * )
 */

class articuloController extends Controller
{

    /**
     * @OA\Get(
     *     path="/api/articulos",
     *     summary="Get all articles",
     *     tags={"Articulos"},
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="articulos", type="array", @OA\Items(ref="#/components/schemas/Articulo")),
     *             @OA\Property(property="status", type="integer", example=200)
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="No articles found",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="No se encontraron artículos registrados"),
     *             @OA\Property(property="status", type="integer", example=404)
     *         )
     *     )
     * )
     */
    
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

       /**
     * @OA\Post(
     *     path="/api/articulos",
     *     summary="Create a new article",
     *     tags={"Articulos"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"titulo", "contenido", "categoria_id", "usuario_id"},
     *             @OA\Property(property="titulo", type="string", example="Título del artículo"),
     *             @OA\Property(property="contenido", type="string", example="Contenido del artículo"),
     *             @OA\Property(property="categoria_id", type="integer", example=1),
     *             @OA\Property(property="usuario_id", type="integer", example=1)
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Article created successfully",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="articulo", ref="#/components/schemas/Articulo"),
     *             @OA\Property(property="status", type="integer", example=201)
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Validation error",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="Error de validación de los datos"),
     *             @OA\Property(property="errors", type="object"),
     *             @OA\Property(property="status", type="integer", example=400)
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Internal server error",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="Error al crear el artículo"),
     *             @OA\Property(property="status", type="integer", example=500)
     *         )
     *     )
     * )
     */
   
    public function store(Request $request){
        $validator = Validator::make($request->all(), [
            'titulo'=>'required|max:255',
            'contenido'=>'required|max:5000',
            'categoria_id'=>'required|exists:categorias,id',
            'usuario_id'=>'required|exists:users,id'
        ], [
            'categoria_id.exists' => 'El artículo seleccionado no es válido.',
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

    /**
     * @OA\Get(
     *     path="/api/articulos/{id}",
     *     summary="Get an article by ID",
     *     tags={"Articulos"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Article found",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="articulo", ref="#/components/schemas/Articulo"),
     *             @OA\Property(property="status", type="integer", example=200)
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Article not found",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="Artículo no encontrado"),
     *             @OA\Property(property="status", type="integer", example=404)
     *         )
     *     )
     * )
     */

    public function mostrar($id){
        $Articulo= Articulo::find($id);
        if(!$Articulo){
            $data = [
                'message' => 'Articulo no encontrado',
                'status' => 404
            ];
            return response()->json($data, 404);
        }
        $data = [
            'Articulo'=> $Articulo,
            'status'=> 200
        ];
        return response()->json($data, 200);
    }

     /**
     * @OA\Delete(
     *     path="/api/articulos/{id}",
     *     summary="Delete an article by ID",
     *     tags={"Articulos"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Article deleted successfully",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="El artículo ha sido eliminado"),
     *             @OA\Property(property="status", type="integer", example=200)
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Article not found",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="El artículo no se ha encontrado"),
     *             @OA\Property(property="status", type="integer", example=404)
     *         )
     *     )
     * )
     */

    public function eliminar($id){
        $ArticuloElim = Articulo::find($id);

        if(!$ArticuloElim){
            $data = [
                'message'=> 'El articulo no se a encontrado',
                'status'=> 404
            ]; 
            return response()->json($data, 200);
        }
        $ArticuloElim->delete();

        $data=[
            'message'=>'El articulo a sido eliminado',
            'status'=>200
        ];

        return response()->json($data, 200);
    }

    

    public function actualizar(Request $request, $id){
        $ArticuloActu = Articulo::find($id);
        if(!$ArticuloActu){
            $data=[
            'message'=>'Articulo no encontrado',
            'status'=>404
            ];
            return response()->json($data, 404);
        }

        $validator = Validator::make($request->all(), [
            'titulo'=>'required|max:255',
            'contenido'=>'required|max:5000',
            'categoria_id'=>'required|exists:categorias,id',
            'usuario_id'=>'required|exists:users,id'
        ], [
            'categoria_id.exists' => 'El artículo seleccionado no es válido.',
            'usuario_id.exists' => 'El usuario seleccionado no es válido.'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Error al validar los datos',
                'errors' => $validator->errors(),
                'status' => 400
            ], 400);
        }

        $ArticuloActu->titulo= $request->titulo;
        $ArticuloActu->contenido= $request->contenido;
        $ArticuloActu->categoria_id= $request->categoria_id;
        $ArticuloActu->usuario_id= $request->usuario_id;
        
        $ArticuloActu->save();

        $data = [
            'message'=> 'Articulo actualizado',
            'Articulo'=> $ArticuloActu,
            'status'=>200
        ];

        return response()->json($data, 200);
    }
}
