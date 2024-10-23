<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class RegisteredUserController extends Controller
{
    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): Response
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'lastname' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required'],
            'datumRodjenja' => 'required',
        ]);

        $user = User::create([
            'name' => $request->name,
            'lastname' => $request->lastname,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'datumRodjenja' => $request->datumRodjenja,
            'vrstaKorisnika' => 3,
        ]);

        event(new Registered($user));

        Auth::login($user);

        return response()->noContent();
    }
    // INDEX
    public function index() {
        $podaci = User::get();
        return response()->json($podaci, 200);
    }

    // PRIKAZI JEDNOG
    public function show($id) {
        try
        {
            $podaci = User::findOrFail($id);
            return response()->json($podaci);
        }
        catch (\Exception $e){
            return response()->json($e->getMessage());

        }
    }

    // UPDATE VRSTAKORISNIKA
    public function promjeni(Request $request, $id){
        try{
            $request->validate([
                'vrstaKorisnika' => 'required'
            ]);
            $korisnik = User::findOrFail($id);
            $korisnik->update([

                'vrstaKorisnika' => $request->vrstaKorisnika

            ]);
            return response()->json($korisnik, 200);
        }
        catch (\Exception $e){
            return response()->json($e->getMessage());

        }
    }
}
