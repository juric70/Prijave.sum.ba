<?php

namespace App\Http\Controllers;

use App\Models\User;

class UserController extends Controller
{
    //INDEX
    public function index()
    {
        $podaci = User::get();
        return response()->json($podaci, 200);
    }

    public function getMe()
    {
        $korisnik = auth()->user();
        try {
            $podaci = User::findOrFail($korisnik->id);
            return response()->json($podaci, 200);
        } catch (\Exception $e) {
            return response()->json($e->getMessage());
        }
    }

    //SHOW
    public function show($id)
    {
        try {
            $podaci = User::findOrFail($id);
            return response()->json($podaci);
        } catch (\Exception $e) {
            return response()->json($e->getMessage());
        }
    }
}
