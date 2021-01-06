<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function me(Request $request){

        return response()->json([
            'name'  => $request->user->name,
            'email' => $request->user->email,
            'role'  => $request->user->role
        ]);
    }
}
