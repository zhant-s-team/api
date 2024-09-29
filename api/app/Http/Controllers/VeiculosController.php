<?php

namespace App\Http\Controllers;

use App\Models\Veiculos;
use Illuminate\Http\Request;

class VeiculosController extends Controller
{
    // Exibe uma lista de veículos
    public function index()
    {
        $veiculos = Veiculos::all();
        return response()->json($veiculos);
    }

    // Exibe o formulário para criar um novo veículo
    public function create()
    {
        // Você pode retornar uma view aqui, se necessário
    }

    // Armazena um novo veículo
    public function store(Request $request)
    {
        $request->validate([
            'tipo' => 'required|string|max:255',
            'capacidade' => 'required|numeric',
            'status' => 'required|string|max:255',
            'placa' => 'required|string|max:20',
        ]);

        $veiculo = Veiculos::create($request->all());
        return response()->json($veiculo, 201);
    }

    // Exibe um veículo específico
    public function show($id)
    {
        $veiculo = Veiculos::findOrFail($id);
        return response()->json($veiculo);
    }

    // Exibe o formulário para editar um veículo
    public function edit($id)
    {
        // Você pode retornar uma view aqui, se necessário
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

        $veiculo = Veiculos::findOrFail($id);
        $veiculo->update($request->all());
        return response()->json($veiculo);
    }

    // Remove um veículo específico
    public function destroy($id)
    {
        $veiculo = Veiculos::findOrFail($id);
        $veiculo->delete();
        return response()->json(null, 204);
    }
}
