<?php
//toDO Adicionar no menu hamburguer as outras rotas também
//toDO Testar relacionamentos entre usuario motorista ao aceitar a entrega//para mobile apenas
//toDO Remover percurso em KMs, acho desnecessario para o motorista.
namespace App\Http\Controllers;

use App\Models\Empresa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EmpresaController extends Controller
{
    public function index(Request $request)
    {
        $empresas = Empresa::all();

        // Verifique se a requisição foi feita via API (verificando o tipo de aceitação de resposta)
        if ($request->wantsJson()) {
            return response()->json($empresas);
        }

        return view('livewire.empresas.list', compact('empresas'));

    }

    public function create()
{
    return view('livewire.empresas.create');
}
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'cnpj' => 'required|string',
            'nome' => 'required|string',
            'rua' => 'required|string',
            'bairro' => 'required|string',
            'numero' => 'required|integer',
            'logo' => 'nullable|url',
        ]);

        $validatedData['user_id'] = auth()->id();

        Empresa::create($validatedData);

        return redirect()->route('empresas')->with('success', 'Empresa criada com sucesso!');
    }

    public function show(Empresa $empresa)
    {
        return response()->json($empresa);
    }

    public function update(Request $request, Empresa $empresa)
    {
        $validatedData = $request->validate([
            'cnpj' => 'sometimes|string|max:18',
            'nome' => 'sometimes|string|max:255',
            'rua' => 'sometimes|string|max:255',
            'bairro' => 'sometimes|string|max:255',
            'numero' => 'sometimes|integer',
            'logo' => 'nullable|url',
        ]);

        $empresa->fill($validatedData);
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
        return redirect()->route('empresas')->with('success', 'Empresa excluída com sucesso!');
    }
}
