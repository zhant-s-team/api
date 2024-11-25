<?php

namespace App\Http\Controllers;

use App\Enum\EntregaStatus;
use App\Enum\TipoCarro;
use App\Http\Controllers\Controller;
use App\Models\Entrega;
use App\Models\Empresa;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\JsonResponse;
use App\Services\CidadeService;

class EntregaController extends Controller
{

        /**
     * Exibe a lista de entregas ou retorna um JSON se for uma requisição da API.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View|\Illuminate\Http\JsonResponse
     */

     public function index(Request $request)
     {
         // Obter todos os valores do TipoCarro
         $tiposCarro = TipoCarro::values();  // ['TC', 'BT', 'RT', 'BU', 'TQ']

 // Obter todos os valores do EntregaStatus
         $statusEntregas = EntregaStatus::values();  // ['D', 'A', 'C']
         $entregas = Entrega::with(['empresa', 'user'])->get();

         // Verifica se é uma requisição de API (espera um JSON)
         if ($request->expectsJson()) {
             return response()->json($entregas);
         }

         // Caso contrário, retorna a view tradicional para a web
         return view('entregas', compact('entregas'));
     }

     /**
      * Exibe os detalhes de uma entrega específica.
      *
      * @param  int  $id
      * @return \Illuminate\View\View|\Illuminate\Http\JsonResponse
      */
     public function show($id, Request $request)
     {
         $entrega = Entrega::findOrFail($id);

         // Verifica se é uma requisição de API (espera um JSON)
         if ($request->expectsJson()) {
             return response()->json($entrega);
         }

         // Caso contrário, retorna a view tradicional para a web
         return view('entregas.show', compact('entrega'));
     }
    public function create(CidadeService $cidadeService)
    {
        $empresas = Empresa::all(); // Carregar todas as empresas
        $cidades = $cidadeService->getCidades();
        return view('entregas', compact('empresas'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'empresa_id' => 'required|exists:empresas,id',
            'user_id' => 'nullable|exists:users,id',
            'titulo' => 'required|string|max:255',
            'descricao' => 'required|string',
            'cidade_origem' => 'required|string|max:255',
            'cidade_destino' => 'required|string|max:255',
            'tipo_veiculo' => 'required|in:TC,BT,RT,BU,TQ',
            'carga' => 'required|string|max:255',
            'percurso' => 'required|integer',
            'status' => 'nullable|in:D,A,C',
        ]);

        $entrega = Entrega::create([
            'empresa_id' => $request->empresa_id,
            'user_id' => $request->user_id,
            'titulo' => $request->titulo,
            'descricao' => $request->descricao,
            'cidade_origem' => $request->cidade_origem,
            'cidade_destino' => $request->cidade_destino,
            'tipo_veiculo' => $request->tipo_veiculo,
            'carga' => $request->carga,
            'percurso' => $request->percurso,
            'status' => $request->status ?? 'D',
        ]);

        if ($request->expectsJson()) {
            return response()->json(['message' => 'Entrega criada com sucesso!', 'entrega' => $entrega], 201);
        }

        return redirect()->route('dashboard')->with('success', 'Entrega criada com sucesso.');
    }

    public function edit($id)
    {

        $entrega = Entrega::findOrFail($id); // Buscar a entrega que será editada
        $cidadeService = new CidadeService();
        $cidades = $cidadeService->getCidades();  // Carregar todas as cidades
        $empresas = Empresa::all(); // Carregar todas as empresas
        return view('livewire.entregas.edit', compact('entrega', 'empresas', 'cidades'));
    }

    public function update(Request $request, $id)
    {
        $cidadeService = new CidadeService();
        $cidades = $cidadeService->getCidades();  // Carregar todas as cidades
        $empresas = Empresa::all(); // Carregar todas as empresas
        $entrega = Entrega::findOrFail($id);

        $validatedData = $request->validate([
            'empresa_id' => 'required|exists:empresas,id',
            'user_id' => 'nullable|exists:users,id',
            'titulo' => 'required|string|max:255',
            'descricao' => 'required|string',
            'cidade_origem' => 'required|string|max:255',
            'cidade_destino' => 'required|string|max:255',
            'tipo_veiculo' => 'required|in:TC,BT,RT,BU,TQ',
            'carga' => 'required|string|max:255',
            'percurso' => 'required|integer',
            'status' => 'nullable|in:D,A,C',
        ]);

        $entrega->update($validatedData);

        if ($request->expectsJson()) {
            return response()->json(['message' => 'Entrega atualizada com sucesso!', 'entrega' => $entrega]);
        }

        return redirect()->route('dashboard')->with('success', 'Entrega atualizada com sucesso.');
    }

    public function destroy($id)
    {
        $entrega = Entrega::findOrFail($id);
        $entrega->delete();

        if (request()->expectsJson()) {
            return response()->json(['message' => 'Entrega deletada com sucesso!']);
        }

        return redirect()->route('entregas.list')->with('success', 'Entrega excluída com sucesso.');
    }

    public function aceitarEntrega($entregaId)
    {
        $entrega = Entrega::findOrFail($entregaId);

        $entrega->status = 'A'; // Exemplo: status alterado para aceito
        $entrega->save();

        return response()->json(['message' => 'Entrega aceita com sucesso!']);
    }
}

