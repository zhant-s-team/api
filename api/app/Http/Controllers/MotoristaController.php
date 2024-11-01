<?php

namespace App\Http\Controllers;

use App\Models\Motorista;
use Illuminate\Http\Request;

class MotoristaController extends Controller
{
    public function index()
    {
        $motoristas = Motorista::all();
        return response()->json($motoristas);
        //return view('motoristas');
    }

    public function show($id)
    {
        $motorista = Motorista::find($id);

        if (!$motorista) {
            return response()->json(['message' => 'Motorista não encontrado'], 404);
        }

        return response()->json($motorista);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'user_id' => 'required|exists:users,id', // Adicione a validação para user_id
            'cnh' => 'required|string', // Ajuste para validar apenas a CNH
        ]);

        $motorista = Motorista::create($validatedData);
        return response()->json($motorista, 201);
    }

    public function update(Request $request, $id)
    {
        $motorista = Motorista::find($id);

        if (!$motorista) {
            return response()->json(['message' => 'Motorista não encontrado'], 404);
        }

        $validatedData = $request->validate([
            'user_id' => 'sometimes|exists:users,id', // Validação condicional
            'cnh' => 'sometimes|string', // Validação condicional
        ]);

        $motorista->update($validatedData);
        return response()->json($motorista);
    }

    public function destroy($id)
    {
        $motorista = Motorista::find($id);

        if (!$motorista) {
            return response()->json(['message' => 'Motorista não encontrado'], 404);
        }

        $motorista->delete();
        return response()->json(null, 204);
    }
}
