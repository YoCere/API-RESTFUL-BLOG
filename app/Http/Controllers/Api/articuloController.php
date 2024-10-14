<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Articulo;

use Illuminate\Http\Request;

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
}
