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
 *     required={"titulo", "contenido", "categoria_id", "usuario_id"},
 *     @OA\Property(property="id", type="integer", description="ID del artículo"),
 *     @OA\Property(property="titulo", type="string", description="Título del artículo"),
 *     @OA\Property(property="contenido", type="string", description="Contenido del artículo"),
 *     @OA\Property(property="categoria_id", type="integer", description="ID de la categoría asociada"),
 *     @OA\Property(property="usuario_id", type="integer", description="ID del usuario creador"),
 *     @OA\Property(property="created_at", type="string", format="date-time", description="Fecha de creación"),
 *     @OA\Property(property="updated_at", type="string", format="date-time", description="Fecha de última actualización")
 * )
 */

class articuloController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/articulos",
     *     summary="Get all articles",
     *     description="Fetch all articles from the database.",
     *     tags={"Articles"},
     *     @OA\Response(
     *         response=200,
     *         description="List of articles",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Articulo")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="No articles found"
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
     *     description="Store a new article in the database.",
     *     tags={"Articles"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"titulo", "contenido", "categoria_id", "usuario_id"},
     *             @OA\Property(property="titulo", type="string", example="New Article Title"),
     *             @OA\Property(property="contenido", type="string", example="Article content goes here..."),
     *             @OA\Property(property="categoria_id", type="integer", example=1),
     *             @OA\Property(property="usuario_id", type="integer", example=1)
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Article created successfully",
     *         @OA\JsonContent(ref="#/components/schemas/Articulo")
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Validation error",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Error de validacion de los datos"),
     *             @OA\Property(property="errors", type="object")
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
     *     summary="Get a specific article",
     *     description="Fetch details of a specific article by its ID.",
     *     tags={"Articles"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Article details",
     *         @OA\JsonContent(ref="#/components/schemas/Articulo")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Article not found",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Articulo no encontrado")
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
     *     summary="Delete an article",
     *     description="Delete a specific article by its ID.",
     *     tags={"Articles"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Article deleted successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="El articulo a sido eliminado")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Article not found",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="El articulo no se a encontrado")
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

    /**
     * @OA\Put(
     *     path="/api/articulos/{id}",
     *     summary="Update an existing article",
     *     description="Update the details of an existing article by its ID.",
     *     tags={"Articles"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"titulo", "contenido", "categoria_id", "usuario_id"},
     *             @OA\Property(property="titulo", type="string", example="Updated Article Title"),
     *             @OA\Property(property="contenido", type="string", example="Updated content goes here..."),
     *             @OA\Property(property="categoria_id", type="integer", example=2),
     *             @OA\Property(property="usuario_id", type="integer", example=1)
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Article updated successfully",
     *         @OA\JsonContent(ref="#/components/schemas/Articulo")
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Validation error",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Error al validar los datos"),
     *             @OA\Property(property="errors", type="object")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Article not found",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Articulo no encontrado")
     *         )
     *     )
     * )
     */

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
