<?php

namespace App\Http\Controllers;

use App\Models\Viagem;
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
            'rota_id' => 'required|exists:rotas,id',
            'veiculo_id' => 'required|exists:veiculos,id',
            'motorista_id' => 'required|exists:motoristas,id',
            'cargas_id' => 'required|exists:cargas,id',
            'data_hora' => 'required|date',
            'status' => 'required|string|max:20',
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
            'rota_id' => 'sometimes|required|exists:rotas,id',
            'veiculo_id' => 'sometimes|required|exists:veiculos,id',
            'motorista_id' => 'sometimes|required|exists:motoristas,id',
            'cargas_id' => 'sometimes|required|exists:cargas,id',
            'data_hora' => 'sometimes|required|date',
            'status' => 'sometimes|required|string|max:20',
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
