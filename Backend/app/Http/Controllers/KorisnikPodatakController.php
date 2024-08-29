<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\korisnikPodatak;
use Illuminate\Support\Facades\Validator;

class KorisnikPodatakController extends Controller
{
    //INDEX
    public function index() {
        $podaci = korisnikPodatak::get();
        return response()->json($podaci, 200);
    }

    //SHOW
    public function show($id){
        try
        {
            $podaci = korisnikPodatak::findOrFail($id);
            return response()->json($podaci);
        }
        catch (\Exception $e){
            return response()->json($e->getMessage());

        }

    }

    //Svi podaci jedne prijave
    public function podaci($IdPrijave)
    {
        $podaci = korisnikPodatak::where('IdPrijave', $IdPrijave)->get();
        
        return response()->json($podaci);
    }

    //STORE
    public function store(Request $request){

        try{
           $validator = Validator::make( $request->all(),[
                'IdPrijave' => 'required|exists:listaprijava,id',
                'Odgovor' => 'required|string',
            ]);
            if($validator->fails()) {

                return response()->json($validator->errors(),422);
            }

            $podaci = korisnikPodatak::create([
                'IdPrijave' => $request->IdPrijave,
                'Odgovor' => $request->Odgovor
            ]);

            return response()->json($podaci->IdPrijave, 201);
        }
        catch (\Exception $e){
            return response()->json($e->getMessage());

        }
    }

    //DESTROY
    public function destroy($id){
        try
        {
            $podaci = korisnikPodatak::findOrFail($id);
            $podaci->delete();
            return response()->json(204);
        }
        catch (\Exception $e){
            return response()->json($e->getMessage());

        }

    }

    
}
