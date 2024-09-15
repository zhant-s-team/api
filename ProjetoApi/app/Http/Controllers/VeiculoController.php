<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class VeiculoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Veiculo::all();
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'modelo' => 'required|string|max:255',
            'placa' => 'required|string|max:10|unique:veiculos',
            'ano' => 'required|integer|min:1900|max:' . (date('Y')),
        ]);
        $veiculo = Veiculo::create($validatedData);
        return response()->json($veiculo, 201);
    }

    public function show(string $id)
    {
        return Veiculo::findOrFail($id);
    }

    public function update(Request $request, string $id)
    {
        $veiculo = Veiculo::findOrFail($id);
        $validatedData = $request->validate([
            'modelo' => 'sometimes|required|string|max:255',
            'placa' => 'sometimes|required|string|max:10|unique:veiculos,placa,' . $id,
            'ano' => 'sometimes|required|integer|min:1900|max:' . (date('Y')),
        ]);

        $veiculo->update($validatedData);
        return response()->json($veiculo, 200);
    }

    public function destroy(string $id)
    {
        Veiculo::destroy($id);
        return response()->json(null, 204);
    }
}
