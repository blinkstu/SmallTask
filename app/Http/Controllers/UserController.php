<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('jwt_auth');
    }

    public function show(Request $request)
    {
        return response()->json([
            'name'  => $request->user->name,
            'email' => $request->user->email,
            'role'  => $request->user->role,
            'id'    => $request->user->id
        ]);
    }
}
