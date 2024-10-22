<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;


     
class UserController extends Controller
{
    /**
 * @OA\Get(
 *     path="/api/user",
 *     summary="Get authenticated user",
 *     description="Fetch the details of the authenticated user.",
 *     tags={"User"},
 *     security={{"bearerAuth":{}}}, 
 *     @OA\Response(
 *         response=200,
 *         description="Authenticated user data",
 *         @OA\JsonContent(
 *             @OA\Property(property="id", type="integer", example=1),
 *             @OA\Property(property="name", type="string", example="John Doe"),
 *             @OA\Property(property="email", type="string", example="johndoe@example.com")
 *         )
 *     ),
 *     @OA\Response(
 *         response=401,
 *         description="Unauthorized",
 *         @OA\JsonContent(
 *             @OA\Property(property="message", type="string", example="Unauthorized")
 *         )
 *     )
 * )
 */

    public function index()
    {
        $user= User::all();
        return response()->json($user);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        //
    }
}
