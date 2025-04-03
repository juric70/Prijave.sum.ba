<?php

namespace App\Http\Controllers;

use App\Models\Radionica;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RadionicaController extends Controller
{
    //INDEX
    // query params: currentPage, itemsPerPage
    public function index(Request $request)
    {
        try {
            $currentPage = $request->input('currentPage', 1);
            $itemsPerPage = $request->input('itemsPerPage', 10);
            $filter = $request->input('filter', 'open');
            $search = $request->input('search', '');

            if ($filter === 'my' && !auth()->check()) {
                return response()->json(['message' => 'Unauthorized'], 401);
            }

            $podaci = Radionica::query()
                ->when($filter === 'open', function ($query) {
                    return $query->where('DatumPocetka', '>', now());
                })
                ->when($filter === 'closed', function ($query) {
                    return $query->where('DatumPocetka', '<=', now());
                })
                ->when($filter === 'my', function ($query) {
                    return $query->where('IdKreatora', auth()->user()->id);
                })
                ->when($search, function ($query) use ($search) {
                    return $query->where('NazivRadionice', 'like', '%' . $search . '%')
                        ->orWhere('OpisRadionice', 'like', '%' . $search . '%');
                })

                ->orderBy('DatumPocetka', 'asc')
                ->paginate($itemsPerPage, ['*'], 'page', $currentPage);
            return response()->json($podaci);
        } catch (\Exception $e) {
            return response()->json($e->getMessage());
        }
    }

    //SHOW
    public function show($id)
    {
        try {
            $podaci = Radionica::findOrFail($id);
            return response()->json($podaci);
        } catch (\Exception $e) {
            return response()->json($e->getMessage());
        }
    }

    //STORE
    public function store(Request $request)
    {

        try {
            $validator = Validator::make($request->all(), [
                'OpisRadionice' => 'required|string',
                'IdKreatora' => 'required|exists:users,id',
                'NazivRadionice' => 'required|string',
                'DatumPocetka' => 'required',
                'DatumZavrsetka' => 'required',
                'PrijaveDo' => 'required'
            ]);
            if ($validator->fails()) {

                return response()->json($validator->errors(), 422);
            }

            $podaci = Radionica::create([
                'NazivRadionice' => $request->NazivRadionice,
                'OpisRadionice' => $request->OpisRadionice,
                'VoditeljRadionice' => $request->VoditeljRadionice,
                'DatumPocetka' => $request->DatumPocetka,
                'DatumZavrsetka' => $request->DatumZavrsetka,
                'PrijaveDo' => $request->PrijaveDo,
                'IdKreatora' => $request->IdKreatora,
                'UrlSlike' => "Slika",
                'Tagovi' => "Tagovi",
            ]);

            return response()->json($podaci->NazivRadionice, 201);
        } catch (\Exception $e) {
            return response()->json($e->getMessage());
        }
    }

    //DESTROY
    public function destroy($id)
    {
        try {
            $podaci = Radionica::findOrFail($id);
            $podaci->delete();
            return response()->json(204);
        } catch (\Exception $e) {
            return response()->json($e->getMessage());
        }
    }
}
