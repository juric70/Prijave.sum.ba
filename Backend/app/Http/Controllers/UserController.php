<?php

namespace App\Http\Controllers;

use App\Models\User;

class UserController extends Controller
{
    //INDEX
    public function index() {
        $podaci = User::get();
        return response()->json($podaci, 200);
    }

    //SHOW
    public function show($id){
        try
        {
            $podaci = User::findOrFail($id);
            return response()->json($podaci);
        }
        catch (\Exception $e){
            return response()->json($e->getMessage());
        }
    }
}