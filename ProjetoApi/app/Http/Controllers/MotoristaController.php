<?php

namespace App\Http\Controllers;

use App\Models\Motorista;
use Illuminate\Http\Request;

class MotoristaController extends Controller
{
    public function index()
    {
        return Motorista::all();
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nome' => 'required|string|max:100',
            'disponibilidade' => 'required|string|max:20',
        ]);

        $motorista = Motorista::create($validatedData);
        return response()->json($motorista, 201);
    }

    public function show(int $id)
    {
        return Motorista::findOrFail($id);
    }

    public function update(Request $request, int $id)
    {
        $motorista = Motorista::findOrFail($id);

        $validatedData = $request->validate([
            'nome' => 'sometimes|required|string|max:100',
            'disponibilidade' => 'sometimes|required|string|max:20',
        ]);

        $motorista->update($validatedData);
        return response()->json($motorista, 200);
    }

    public function destroy(int $id)
    {
        Motorista::destroy($id);
        return response()->json(null, 204);
    }
}
