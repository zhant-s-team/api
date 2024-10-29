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
    }

    public function show($id)
    {
        $motorista = Motorista::find($id);
        return response()->json($motorista);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nome' => 'required|string',
            'cpf' => 'required|string|size:11',
            'email' => 'required|email',
            'senha' => 'required|string|min:8',
            'telefone' => 'required|string',
            'data_nascimento' => 'required|date',
            'cep' => 'required|string',
            'estado' => 'required|string',
            'bairro' => 'required|string',
            'rua' => 'required|string',
        ]);

        $motorista = Motorista::create($validatedData);
        return response()->json($motorista, 201);
    }

    public function update(Request $request, $id)
    {
        $motorista = Motorista::find($id);
        $motorista->update($request->all());
        return response()->json($motorista);
    }

    public function destroy($id)
    {
        Motorista::destroy($id);
        return response()->json(null, 204);
    }
}
