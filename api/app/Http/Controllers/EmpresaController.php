<?php

namespace App\Http\Controllers;

use App\Models\Empresa;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class EmpresaController extends Controller
{
    public function index()
    {
        $empresas = Empresa::all(); // Busca todas as empresas
        return response()->json($empresas); // Retorna as empresas como JSON
    }

    // Método para armazenar uma nova empresa
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'cnpj' => 'required|string',
            'rua' => 'required|string',
            'bairro' => 'required|string',
            'numero' => 'required|integer',
            'logo' => 'nullable|string', // Adapte conforme necessário
        ]);

        // Define o user_id como o ID do usuário autenticado
        $validatedData['user_id'] = auth()->id(); // Obtém o ID do usuário autenticado

        $empresa = Empresa::create($validatedData);
        return response()->json($empresa, 201);
    }

    // Método para exibir uma empresa específica
    public function show(Empresa $empresa)
    {
        return response()->json($empresa); // Retorna a empresa como JSON
    }

    // Método para atualizar uma empresa existente
    public function update(Request $request, Empresa $empresa)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'cnpj' => 'required|string|max:18',
            'rua' => 'required|string|max:255',
            'bairro' => 'required|string|max:255',
            'numero' => 'required|string|max:10',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $empresa->update($request->all());
        return response()->json($empresa); // Retorna a empresa atualizada como JSON
    }

    // Método para deletar uma empresa
    public function destroy(Empresa $empresa)
    {
        $empresa->delete();
        return response()->json(null, 204); // Retorna status 204 sem conteúdo
    }
}
