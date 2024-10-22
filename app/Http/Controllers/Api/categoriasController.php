<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Categoria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

/**
 * @OA\Info(
 *     title="Api Rest", 
 *     version="1.0",
 *     description="Descripcion"
 * )
 *
 * @OA\Server(url="http://localhost/API-RESTFUL-BLOG/public/")
 * 
 * @OA\Schema(
 *     schema="Categoria",
 *     type="object",
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="nombre", type="string", example="Categoria 1"),
 *     @OA\Property(property="descripcion", type="string", example="Descripción de la categoría 1"),
 *     @OA\Property(property="created_at", type="string", format="date-time", example="2024-01-01T12:00:00Z"),
 *     @OA\Property(property="updated_at", type="string", format="date-time", example="2024-01-01T12:00:00Z")
 * )
 */

class categoriasController extends Controller
{

        /**
         * @OA\Get(
         *     path="/api/categorias",
         *     summary="Get all categories",
         *     tags={"Categories"},
         *     @OA\Response(
         *         response=200,
         *         description="Successful operation",
         *         @OA\JsonContent(
         *             type="object",
         *             @OA\Property(property="Categorias", type="array", @OA\Items(ref="#/components/schemas/Categoria")),
         *             @OA\Property(property="status", type="integer", example=200)
         *         )
         *     ),
         *     @OA\Response(
         *         response=404,
         *         description="No categories found",
         *         @OA\JsonContent(
         *             type="object",
         *             @OA\Property(property="message", type="string", example="No se encontraron Categorias registrados"),
         *             @OA\Property(property="status", type="integer", example=404)
         *         )
         *     )
         * )
         */

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

 /**
     * @OA\Post(
     *     path="/api/categorias",
     *     summary="Create a new category",
     *     tags={"Categories"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"nombre", "descripcion"},
     *             @OA\Property(property="nombre", type="string", example="Categoria 1"),
     *             @OA\Property(property="descripcion", type="string", example="Descripción de la categoría 1")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Category created successfully",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="categoria", ref="#/components/schemas/Categoria"),
     *             @OA\Property(property="status", type="integer", example=201)
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Validation error",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="Error de validacion de los datos"),
     *             @OA\Property(property="errors", type="object"),
     *             @OA\Property(property="status", type="integer", example=400)
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Internal server error",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="Error al crear la categoria"),
     *             @OA\Property(property="status", type="integer", example=500)
     *         )
     *     )
     * )
     */

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

 /**
     * @OA\Get(
     *     path="/api/categorias/{id}",
     *     summary="Get a category by ID",
     *     tags={"Categories"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Category found",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="Categoria", ref="#/components/schemas/Categoria"),
     *             @OA\Property(property="status", type="integer", example=200)
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Category not found",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="Categoria no encontrado"),
     *             @OA\Property(property="status", type="integer", example=404)
     *         )
     *     )
     * )
     */

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
        return response()->json($data, 200);
    }

  /**
     * @OA\Delete(
     *     path="/api/categorias/{id}",
     *     summary="Delete a category by ID",
     *     tags={"Categories"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Category deleted successfully",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="El Categoria a sido eliminado"),
     *             @OA\Property(property="status", type="integer", example=200)
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Category not found",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="El Categoria no se a encontrado"),
     *             @OA\Property(property="status", type="integer", example=404)
     *         )
     *     )
     * )
     */

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

  /**
     * @OA\Put(
     *     path="/api/categorias/{id}",
     *     summary="Update a category by ID",
     *     tags={"Categories"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"nombre", "descripcion"},
     *             @OA\Property(property="nombre", type="string", example="Categoria 1"),
     *             @OA\Property(property="descripcion", type="string", example="Descripción de la categoría 1")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Category updated successfully",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="Categoria actualizado"),
     *             @OA\Property(property="Categoria", ref="#/components/schemas/Categoria"),
     *             @OA\Property(property="status", type="integer", example=200)
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Category not found",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="Categoria no encontrado"),
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
