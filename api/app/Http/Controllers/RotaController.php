<?php

namespace App\Http\Controllers;

use App\Models\Rota;
use Illuminate\Http\Request;

class RotaController extends Controller
{
    public function index()
    {
        $rotas = Rota::all();
        return response()->json($rotas);
    }

    public function show($id)
    {
        $rota = Rota::find($id);
        return response()->json($rota);
    }

    public function store(Request $request)
    {
        $rota = Rota::create($request->all());
        return response()->json($rota, 201);
    }

    public function update(Request $request, $id)
    {
        $rota = Rota::find($id);
        $rota->update($request->all());
        return response()->json($rota);
    }

    public function destroy($id)
    {
        Rota::destroy($id);
        return response()->json(null, 204);
    }
}
