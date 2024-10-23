<?php

namespace App\Http\Controllers;

use App\Models\Radionica;
use Illuminate\Http\Request;

class DataController extends Controller
{
    public function export()
{
    $data = Radionica::all(); 
    return response()->json($data);
}
}