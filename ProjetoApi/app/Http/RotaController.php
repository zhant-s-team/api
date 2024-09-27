<?php

namespace App\Http\Controllers;

use App\Models\Rotas;
use Illuminate\Http\Request;

class RotaController extends Controller
{
    public function index()
    {
        return Rotas::all();
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'origem' => 'required|string|max:100',
            'destino' => 'required|string|max:100',
            'data_hora' => 'required|date',
            'paradas' => 'required|json',
        ]);

        $rotas = Rotas::create($validatedData);
        return response()->json($rotas, 201);
    }

    public function show(int $id)
    {
        return Rotas::findOrFail($id);
    }

    public function update(Request $request, int $id)
    {
        $rotas = Rotas::findOrFail($id);

        $validatedData = $request->validate([
            'origem' => 'sometimes|required|string|max:100',
            'destino' => 'sometimes|required|string|max:100',
            'data_hora' => 'sometimes|required|date',
            'paradas' => 'sometimes|required|json',
        ]);

        $rotas->update($validatedData);
        return response()->json($rotas, 200);
    }

    public function destroy(int $id)
    {
        Rotas::destroy($id);
        return response()->json(null, 204);
    }
}
