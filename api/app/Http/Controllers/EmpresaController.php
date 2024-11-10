<?php
//toDO Corrigir problema com variavel is_admin dos usuarios, fazer a edição e exclusão de usuarios
//toDO Adicionar no menu hamburguer as outras rotas também
//toDO Todos os usuarios Web poderão editar e apagar, afinal todos são admnistradores.
//toDO Trabalhar questão visual do site.
//toDO Entender porque o formulario de criação de empresa não está sendo personalizado
//toDO Testar relacionamentos entre usuario motorista ao aceitar a entrega//para mobile apenas
//toDO Remover percurso em KMs, acho desnecessario para o motorista.
//toDO No momento de autentiacação conferir junto se o is_admin é true, caso consiga resolver o problema, se não, conferir se a cnh é nula, se for nula logicamente é o admin
//toDO Ver se consigo colocar o create de empresas como uma view da pasta livewire sem dar erro ou permitindo estilização como planejo
//toDO Estilizar as entregas de acordo com o modelo criado anteriormente
//toDO Se der tempo tentar fazer upload de imagem, se não utilizar link de url que converte para a imagem.
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

        // Caso contrário, retorna a view padrão
        return view('livewire.empresas.list', compact('empresas'));
    }

    public function create()
{
    return view('livewire.empresas.create'); // Ajuste o caminho se necessário
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
        return redirect()->route('empresas')->with('success', 'Empresa atualizada com sucesso!');
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
        return redirect()->route('empresas')->with('success', 'Empresa excluída com sucesso!');
    }
}
