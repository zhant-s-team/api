<?php

namespace App\Http\Controllers;

use App\Models\Viagem;
use Illuminate\Http\Request;

class ViagemController extends Controller
{
    public function index()
    {
        $viagens = Viagem::all();
        return response()->json($viagens);
    }

    public function show($id)
    {
        $viagem = Viagem::find($id);
        return response()->json($viagem);
    }

    public function store(Request $request)
    {
        $viagem = Viagem::create($request->all());
        return response()->json($viagem, 201);
    }

    public function update(Request $request, $id)
    {
        $viagem = Viagem::find($id);
        $viagem->update($request->all());
        return response()->json($viagem);
    }

    public function destroy($id)
    {
        Viagem::destroy($id);
        return response()->json(null, 204);
    }
}
