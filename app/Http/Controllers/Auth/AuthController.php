<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator; // Importar el validador
use Illuminate\Support\Facades\Hash;      // Importar la clase Hash
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;
use App\Http\Request\Auth\LoginRequest;
use PHPOpenSourceSaver\JWTAuth\Exceptions\JWTException;

class AuthController extends Controller
{
   public function register(Request $request)
   {
       // Crear las reglas de validación
       $validator = Validator::make($request->all(), [
           'name' => 'required|string|max:255',
           'email' => 'required|email|max:255|unique:users',
           'password' => 'required|string|min:6|confirmed',
           'rol' => 'required|in:admin,editor,usuario',
       ]);

       $user = User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($request->password),
        'rol' => $request->rol,
]);

$token= JWTAuth:: fromUser($user);

return response()->json([
    'user'=>$user,
    'token'=>$token
],201);

       // Comprobar si la validación falla
       if ($validator->fails()) {
           return response()->json(['errors' => $validator->errors()], 422); // Devuelve errores en formato JSON
       }
       return response()->json(['message' => 'Usuario registrado con éxito'], 201);
   }

 

   public function login(LoginRequest $request){
   $credencials = $request->only('email','password');

   try {
    if (!$token = JWTAuth::attempt($credencials)) {
        return response()->json([
            'error' => 'invalid credentials'
        ], 400);
            }
        } catch (JWTException $e) {
            return response()->json([
                'error' => 'no create token'
            ], 500);
        }
   return response()->json(compact('token'));
}
}