<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Validator;
use Laravel\Telescope\Watchers\EventWatcher;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * @OA\Post(
     *     path="/api/user/login",
     *     summary="Login the user",
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="email",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="password",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="device_name",
     *                     type="string"
     *                 ),
     *                 example={"email": "john@doe.com", "password": "Password", "device_name": "DeviceX"}
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Token Issued"
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Unprocessable Entity"
     *     )
     * )
     */


    protected function apiLogin(Request $request)
    {
        $inputs = $request->json()->all();

        $validated = Validator::make($inputs,
            [
                'email' => 'required|email',
                'password' => 'required',
                'device_name' => 'required',
            ])->validate();

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        $result = [
            'token' => $user->createToken($request->device_name)->plainTextToken,
            'name' => $user->name
        ];

        if (!$user->hasVerifiedEmail()) {
                $result['errors'] = [
                    'email' => ['Email verification error']
            ];
        }

        return response()->json($result);

    }


    /**
     * @OA\Post(
     *     path="/api/user/logout",
     *     summary="Logout the user",
     *     description="Use with bearer token",
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="device_name",
     *                     type="string"
     *                 ),
     *                 example={"device_name": "DeviceX"}
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Token Revoked"
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Unprocessable Entity"
     *     )
     * )
     */

    protected function apiLogout(Request $request)
    {

        $inputs = $request->json()->all();

        $validated = Validator::make($inputs,
            [
                'device_name' => 'required',
            ])->validate();

        $user = $request->user();

        $user->tokens()->where('name', $request->device_name)->delete();

        return response()->json([
            "message" => "Success"], 200);
    }


    /**
     * @OA\Get(
     *     path="/api/user",
     *     summary="Get current user basic info",
     *     description="Use with bearer token",
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="User details returned"
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Unprocessable Entity"
     *     )
     * )
     */

    protected function apiGetCurrentUser(Request $request) {
        $user = $request->user();

        $user->companyRoles = $user->companyRoles();

        return $user;
    }
}
