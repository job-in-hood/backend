<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

/**
 * @OA\Info(
 * description="",
 * version="",
 * title="jobinhood.co.uk API",
 * )
 */

/**
 * @OA\SecurityScheme(
 * securityScheme="bearerAuth",
 * type="http",
 * scheme="bearer",
 * bearerFormat="sanctum"
 * ),
 */
class RegisterController extends Controller
{
    /**
     * @OA\Post(
     *     path="/api/user/register",
     *     summary="Adds a new user",
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="email",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="name",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="password",
     *                     type="string"
     *                 ),
     *                 example={"email": "john@doe.com", "name": "John Doe", "password": "Password"}
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Created"
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Unprocessable Entity"
     *     )
     * )
     */

    public function register(Request $request)
    {
        $inputs = $request->json()->all();

        $validated = Validator::make($inputs,
            [
                'name' => ['required'],
                'password' => ['required', 'min:8'],
                'email' => ['required', 'email', 'unique:users']
            ])->validate();


        // Hash the password
        $validated["password"] = Hash::make($validated["password"]);

        // Trigger event
        event(new Registered($user = User::create($validated)));

        return $user;
    }
}