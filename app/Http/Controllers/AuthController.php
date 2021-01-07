<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth as JWTAuth;

class AuthController extends Controller
{
    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login()
    {
        if (!$token = auth('api')->attempt(request(['email', 'password']))) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return response()->json(['token' => $token]);
    }

    /**
     * Register
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Request $request)
    {
        $validation = Validator::make(request()->all(), [
            'name' => 'required',
            'email' => [
                'required',
                'email',
                function ($attribute, $value, $fail) {
                    if (User::whereEmail($value)->count() > 0) {
                        $fail($attribute . ' is already used.');
                    }
                },
            ],
            'password' => 'required'
        ]);

        $errors = $validation->errors()->all();

        if (count($errors) > 0) {
            return response()->json([
                'msg' => $errors[0]
            ], 400);
        }

        $name = $request->input('name');
        $email = $request->input('email');
        $password = $request->input('password');

        User::create([
            'name'  => $name,
            'email' => $email,
            'password' => $password,
            'role'  => 'client'
        ]);

        return response()->json([
            'msg' => 'Created successfully'
        ]);
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }
}
