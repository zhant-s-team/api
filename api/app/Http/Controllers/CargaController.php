<?php

namespace App\Http\Controllers;

use App\Models\Carga;
use Illuminate\Http\Request;

class CargaController extends Controller
{
    // Exibe a lista de cargas
    public function index()
    {
        $cargas = Carga::all();
        return response()->json($cargas);
    }

    // Exibe o formulário de criação de uma nova carga
    public function create()
    {
        return view('cargas.create');
    }

    // Armazena uma nova carga no banco de dados
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'remetente' => 'required|string|max:255',
            'descricao' => 'required|string',
            'peso' => 'required|numeric',
            'tipo' => 'required|string|max:255',
            'destinatario' => 'required|string|max:255',
            'data_envio' => 'required|date',
            'previsao_entrega' => 'required|date',
        ]);

        Carga::create($validatedData);

        return redirect()->route('cargas.index')->with('success', 'Carga criada com sucesso!');
    }

    // Exibe os detalhes de uma carga específica
    public function show($id)
    {
        $carga = Carga::findOrFail($id);
        return view('cargas.show', compact('carga'));
    }

    // Exibe o formulário de edição de uma carga existente
    public function edit($id)
    {
        $carga = Carga::findOrFail($id);
        return view('cargas.edit', compact('carga'));
    }

    // Atualiza uma carga existente no banco de dados
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'remetente' => 'required|string|max:255',
            'descricao' => 'required|string',
            'peso' => 'required|numeric',
            'tipo' => 'required|string|max:255',
            'destinatario' => 'required|string|max:255',
            'data_envio' => 'required|date',
            'previsao_entrega' => 'required|date',
        ]);

        $carga = Carga::findOrFail($id);
        $carga->update($validatedData);

        return redirect()->route('cargas.index')->with('success', 'Carga atualizada com sucesso!');
    }

    // Remove uma carga do banco de dados
    public function destroy($id)
    {
        $carga = Carga::findOrFail($id);
        $carga->delete();

        return redirect()->route('cargas.index')->with('success', 'Carga removida com sucesso!');
    }
}
