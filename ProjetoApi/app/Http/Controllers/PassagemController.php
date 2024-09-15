<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PassagemController extends Controller
{

    public function index()
    {
        return Passagem::all();
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'origem' => 'required|string|max:255',
            'destino' => 'required|string|max:255',
            'preco' => 'required|numeric',
            'data_viagem' => 'required|date',
        ]);

        $passagem = Passagem::create($validatedData);
        return response()->json($passagem, 201);
    }

    public function show(string $id)
    {
        return Passagem::findOrFail($id);
    }

    public function update(Request $request, string $id)
    {
        $passagem = Passagem::findOrFail($id);
        $validatedData = $request->validate([
            'origem' => 'sometimes|required|string|max:255',
            'destino' => 'sometimes|required|string|max:255',
            'preco' => 'sometimes|required|numeric',
            'data_viagem' => 'sometimes|required|date',
        ]);
        $passagem->update($validatedData);
        return response()->json($passagem, 200);
    }

    public function destroy(string $id)
    {
        Passagem::destroy($id);
        return response()->json(null, 204);
    }
}
