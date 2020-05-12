<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    public function register(Request $request)
    {
        $inputs = $request->json()->all();

        $validated = Validator::make($inputs,
            [
                'name' => ['required'],
                'password' => ['required', 'min:8', 'confirmed'],
                'email' => ['required', 'email', 'unique:users']
            ])->validate();


        // Hash the password
        $validated["password"] = Hash::make($validated["password"]);

        $user = User::create(
            $validated
        );

        return $user;
    }
}