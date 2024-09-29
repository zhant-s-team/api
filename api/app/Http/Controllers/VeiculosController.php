<?php

namespace App\Http\Controllers;

use App\Models\Veiculo;
use Illuminate\Http\Request;

class VeiculosController extends Controller
{
    public function index()
    {
        $veiculos = Veiculo::all();
        return response()->json($veiculos);
    }


    public function store(Request $request)
    {
        $request->validate([
            'tipo' => 'required|string|max:255',
            'capacidade' => 'required|numeric',
            'status' => 'required|string|max:255',
            'placa' => 'required|string|max:20',
        ]);

        $veiculo = Veiculo::create($request->all());
        return response()->json($veiculo, 201);
    }

    // Exibe um veículo específico
    public function show($id)
    {
        $veiculo = Veiculo::findOrFail($id);
        return response()->json($veiculo);
    }

    // Atualiza um veículo específico
    public function update(Request $request, $id)
    {
        $request->validate([
            'tipo' => 'required|string|max:255',
            'capacidade' => 'required|numeric',
            'status' => 'required|string|max:255',
            'placa' => 'required|string|max:20',
        ]);

        $veiculo = Veiculo::findOrFail($id);
        $veiculo->update($request->all());
        return response()->json($veiculo);
    }

    // Remove um veículo específico
    public function destroy($id)
    {
        $veiculo = Veiculo::findOrFail($id);
        $veiculo->delete();
        return response()->json(null, 204);
    }
}
