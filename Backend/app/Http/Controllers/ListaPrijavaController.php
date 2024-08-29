<?php

namespace App\Http\Controllers;

use App\Models\listaPrijava;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ListaPrijavaController extends Controller
{
    //INDEX
    public function index() {
        $podaci = listaprijava::get();
        return response()->json($podaci, 200);
    }

    //SHOW
    public function show($id){
        try
        {
            $podaci = listaprijava::findOrFail($id);
            return response()->json($podaci);
        }
        catch (\Exception $e){
            return response()->json($e->getMessage());

        }

    }

    //Sve prijave jednog korisnika
    public function prijaveKorisnika($IdKreatora)
    {
        $podaci = listaprijava::where('IdKreatora', $IdKreatora)->get();
        
        return response()->json($podaci);
    }

    //Sve prijave jedne radionice
    public function prijave($IdRadionice)
    {
        $podaci = listaprijava::where('IdRadionice', $IdRadionice)->get();
        
        return response()->json($podaci);
    }

    //STORE
    public function store(Request $request){

        try{
           $validator = Validator::make( $request->all(),[
                'IdKreatora' => 'required|exists:users,id',
                'IdRadionice' => 'required|exists:radionica,id',
            ]);
            if($validator->fails()) {

                return response()->json($validator->errors(),422);
            }

            $podaci = listaprijava::create([
                'IdKreatora' => $request->IdKreatora,
                'IdRadionice' => $request->IdRadionice
            ]);

            return response()->json($podaci->id, 201);
        }
        catch (\Exception $e){
            return response()->json($e->getMessage());

        }
    }

    //DESTROY
    public function destroy($id){
        try
        {
            $podaci = listaprijava::findOrFail($id);
            $podaci->delete();
            return response()->json(204);
        }
        catch (\Exception $e){
            return response()->json($e->getMessage());

        }

    }

    
}
