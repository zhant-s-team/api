<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RotaController extends Controller
{

    public function index()
    {
        return Rota::all();
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'origem' => 'required|string|max:255',
            'destino' => 'required|string|max:255',
            'distancia' => 'required|numeric',
        ]);

        $rota = Rota::create($validatedData);
        return response()->json($rota, 201);
    }

    public function show(string $id)
    {
        return Rota::findOrFail($id);
    }

    public function update(Request $request, string $id)
    {
        $rota = Rota::findOrFail($id);
        $validatedData = $request->validate([
            'origem' => 'sometimes|required|string|max:255',
            'destino' => 'sometimes|required|string|max:255',
            'distancia' => 'sometimes|required|numeric',
        ]);

        $rota->update($validatedData);
        return response()->json($rota, 200);
    }

    public function destroy(string $id)
    {
        Rota::destroy($id);
        return response()->json(null, 204);
    }
}
