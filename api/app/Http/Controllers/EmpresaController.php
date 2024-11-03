<?php

namespace App\Http\Controllers;

use App\Models\Empresa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EmpresaController extends Controller
{
    public function index()
    {
        $empresas = Empresa::all();
        //return response()->json($empresas); RETORNAR EM JSON
        return view('livewire.empresas.list', compact('empresas')); // Retorna a view com as empresas
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'cnpj' => 'required|string',
            'nome' => 'required|string',
            'rua' => 'required|string',
            'bairro' => 'required|string',
            'numero' => 'required|integer',
            'logo' => 'nullable|string',
        ]);

        $validatedData['user_id'] = auth()->id();

        $empresa = Empresa::create($validatedData);
        return response()->json($empresa, 201);
    }

    public function show(Empresa $empresa)
    {
        return response()->json($empresa);
    }

    public function update(Request $request, Empresa $empresa)
    {
        // Validação dos dados
        $validatedData = $request->validate([
            'cnpj' => 'required|string|max:18',
            'nome' => 'required|string|max:255',
            'rua' => 'required|string|max:255',
            'bairro' => 'required|string|max:255',
            'numero' => 'required|integer',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Atualiza os dados da empresa
        $empresa->fill($validatedData);

        // Atualizar o logo se um novo arquivo foi enviado
        if ($request->hasFile('logo')) {
            // Se já houver um logo, exclui o anterior
            if ($empresa->logo) {
                Storage::disk('public')->delete($empresa->logo);
            }

            // Salva o novo logo e atualiza o caminho no model
            $path = $request->file('logo')->store('logos', 'public');
            $empresa->logo = $path;
        }

        // Salva as alterações
        $empresa->save();

        return redirect()->route('empresas')->with('success', 'Empresa atualizada com sucesso!');
    }

    public function edit(Empresa $empresa)
    {
        return view('livewire.empresas.edit', compact('empresa'));
    }

    public function destroy(Empresa $empresa)
    {
        $empresa->delete();
        return response()->json(null, 204);
    }
}
