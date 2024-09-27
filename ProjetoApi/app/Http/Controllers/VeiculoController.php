<?php

namespace App\Http\Controllers;

use App\Models\Veiculos;
use Illuminate\Http\Request;

class VeiculoController extends Controller
{
    public function index()
    {
        return Veiculos::all();
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'tipo' => 'required|string|max:50',
            'capacidade' => 'required|integer|min:0',
            'status' => 'required|string|max:20',
            'placa' => 'required|string|max:10|unique:veiculos',
        ]);

        $veiculos = Veiculos::create($validatedData);
        return response()->json($veiculos, 201);
    }

    public function show(int $id)
    {
        return Veiculos::findOrFail($id);
    }

    public function update(Request $request, int $id)
    {
        $veiculos = Veiculos::findOrFail($id);

        $validatedData = $request->validate([
            'tipo' => 'sometimes|required|string|max:50',
            'capacidade' => 'sometimes|required|integer|min:0',
            'status' => 'sometimes|required|string|max:20',
            'placa' => 'sometimes|required|string|max:10|unique:veiculos,placa,' . $id,
        ]);

        $veiculos->update($validatedData);
        return response()->json($veiculos, 200);
    }

    public function destroy(int $id)
    {
        Veiculos::destroy($id);
        return response()->json(null, 204);
    }
}
