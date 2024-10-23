<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PitanjaRadionice;
use Illuminate\Support\Facades\Validator;

class PitanjaRadioniceController extends Controller
{
    //INDEX
    public function index() {
        $podaci = PitanjaRadionice::get();
        return response()->json($podaci, 200);
    }

    //SHOW
    public function show($id){
        try
        {
            $podaci = PitanjaRadionice::findOrFail($id);
            return response()->json($podaci);
        }
        catch (\Exception $e){
            return response()->json($e->getMessage());

        }

    }

    //Sva pitanja jedne radionica
    public function pitanja($radionice)
    {
        $podaci = PitanjaRadionice::where('radionice', $radionice)->get();
        
        return response()->json($podaci);
    }

    //STORE
    public function store(Request $request){

        try{
           $validator = Validator::make( $request->all(),[
                'VrstaPodatka' => 'required',
                'radionice' => 'required|exists:radionica,id',
                'NazivPitanja' => 'required|unique:pitanjaRadionice,NazivPitanja,NULL,id,radionice,' . $request->input('radionice')
            ]);
            if($validator->fails()) {

                return response()->json($validator->errors(),422);
            }

            $podaci = PitanjaRadionice::create([
                'NazivPitanja' => $request->NazivPitanja,
                'VrstaPodatka' => $request->VrstaPodatka,
                'radionice' => $request->radionice,
                'OpcijePitanja' => $request->OpcijePitanja,
            ]);

            return response()->json($podaci->NazivPitanja, 201);
        }
        catch (\Exception $e){
            return response()->json($e->getMessage());

        }
    }

    //DESTROY
    public function destroy($id){
        try
        {
            $podaci = Pitanjaradionice::findOrFail($id);
            $podaci->delete();
            return response()->json(204);
        }
        catch (\Exception $e){
            return response()->json($e->getMessage());

        }

    }

    
}