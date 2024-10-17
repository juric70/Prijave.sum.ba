<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function dodajRolu(Request $request)
    {
        // Validacija ulaza
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
            'role_name' => 'required|exists:roles,name',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        // Dodeljivanje rola
        $user = User::find($request->user_id);
        $user->assignRole($request->role_name);

        return response()->json(['message' => 'Rola dodeljena korisniku!'], 200);
    }

    public function provjeriRolu(Request $request)
{
    // Validacija ulaza
    $validator = Validator::make($request->all(), [
        'user_id' => 'required|exists:users,id',
    ]);

    if ($validator->fails()) {
        return response()->json($validator->errors(), 400);
    }

    // Dohvaćanje korisnika
    $user = User::find($request->user_id);
    $roles = $user->getRoleNames();

    return response()->json(['roles' => $roles], 200);
}

public function obrisiRolu(Request $request)
{
    // Validacija ulaza
    $validator = Validator::make($request->all(), [
        'user_id' => 'required|exists:users,id',
        'role_name' => 'required|exists:roles,name',
    ]);

    if ($validator->fails()) {
        return response()->json($validator->errors(), 400);
    }

    // Brisanje rola
    $user = User::find($request->user_id);
    $user->removeRole($request->role_name);

    return response()->json(['message' => 'Rola obrisana korisniku!'], 200);
}




}


