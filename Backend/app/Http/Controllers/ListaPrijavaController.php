<?php

namespace App\Http\Controllers;

use App\Models\listaPrijava;
use App\Models\Radionica;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ListaPrijavaController extends Controller
{
    //INDEX
    public function index() {
        $podaci = listaPrijava::get();
        return response()->json($podaci, 200);
    }

    //SHOW
    public function show($id){
        try
        {
            $podaci = listaPrijava::findOrFail($id);
            return response()->json($podaci);
        }
        catch (\Exception $e){
            return response()->json($e->getMessage());

        }

    }

    //Sve prijave jedne radionice
    public function prijave($IdRadionice)
    {
        $podaci = listaPrijava::where('IdRadionice', $IdRadionice)->get();

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

            $podaci = listaPrijava::create([
                'IdKreatora' => $request->IdKreatora,
                'IdRadionice' => $request->IdRadionice
            ]);

            return response()->json($podaci->IdRadionice, 201);
        }
        catch (\Exception $e){
            return response()->json($e->getMessage());

        }
    }

    //DESTROY
    public function destroy($id){
        try
        {
            $podaci = listaPrijava::findOrFail($id);
            $podaci->delete();
            return response()->json(204);
        }
        catch (\Exception $e){
            return response()->json($e->getMessage());

        }

    }

    public function downloadCSVAction($IdRadionice)
{
    try {

        $radionica = Radionica::find($IdRadionice);

        if (!$radionica) {
            return response()->json(['message' => 'Radionica not found'], 404);
        }

        $prijavljeniUseriIds = $radionica->PrijavljeniUseri;
        $prijavljeniUseriIds = explode(',', $prijavljeniUseriIds);
        $users = User::whereIn('id', $prijavljeniUseriIds)->get();
        return $this->downloadCSV($users, $radionica);
    } catch (\Exception $e) {
        dd($e);
        return response()->json(['message' => 'Internal Server Error'], 500);
    }
}

public function downloadCSV($users, $radionica)
{
    $usersData = [
        ['Korisnik ID', 'Ime', 'Email', 'Odgovor'],
    ];
    foreach ($users as $user) {
        $usersData[] = [$user->id, $user->name, $user->email, $user->odgovor];
    }
    $radionicaData = $radionica->NazivRadionice . " - " . $radionica->DatumPocetka . ".csv";
    $filename = $radionicaData;
    $handle = fopen($filename, 'w+');

    foreach ($usersData as $row) {
        fputcsv($handle, $row);
    }

    fclose($handle);

    $headers = [
        'Content-Type' => 'text/csv',
        'Access-Control-Allow-Origin' => 'http://localhost:3000',
        'Access-Control-Allow-Methods' => 'GET, POST, PUT, DELETE, OPTIONS',
        'Access-Control-Allow-Headers' => 'Content-Type, Authorization',
    ];

    return response()->download($filename, $radionicaData, $headers)->deleteFileAfterSend(true);
}



}
