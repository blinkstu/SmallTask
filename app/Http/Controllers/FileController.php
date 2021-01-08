<?php

namespace App\Http\Controllers;

use App\Files;
use Illuminate\Http\Request;

class FileController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['jwt_auth']);
    }

    public function store(Request $request)
    {
        //store file into document folder
        $file = $request->file('file')->store('public/files');

        $file = str_replace('public', 'storage', $file);

        $id = Files::create([
            'user_id' => $request->user->id,
            'name' => $request->file('file')->getClientOriginalName(),
            'path' => $file
        ])->id;

        return response()->json([
            "msg" => "File successfully uploaded",
            "id" => $id
        ]);
    }
}
