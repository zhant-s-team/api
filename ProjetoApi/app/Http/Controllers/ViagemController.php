<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ViagemController extends Controller
{
    public function index()
    {
        return Viagem::all();
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'origem' => 'required|string|max:255',
            'destino' => 'required|string|max:255',
            'data' => 'required|date',
            'veiculo_id' => 'required|exists:veiculos,id',
            'motorista_id' => 'required|exists:motoristas,id',
        ]);

        $viagem = Viagem::create($validatedData);
        return response()->json($viagem, 201);
    }

    public function show(string $id)
    {
        return Viagem::findOrFail($id);
    }

    public function update(Request $request, string $id)
    {
        $viagem = Viagem::findOrFail($id);
        $validatedData = $request->validate([
            'origem' => 'sometimes|required|string|max:255',
            'destino' => 'sometimes|required|string|max:255',
            'data' => 'sometimes|required|date',
            'veiculo_id' => 'sometimes|required|exists:veiculos,id',
            'motorista_id' => 'sometimes|required|exists:motoristas,id',
        ]);

        $viagem->update($validatedData);
        return response()->json($viagem, 200);
    }

    public function destroy(string $id)
    {
        Viagem::destroy($id);
        return response()->json(null, 204);
    }
}
