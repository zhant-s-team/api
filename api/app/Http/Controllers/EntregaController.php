<?php

namespace App\Http\Controllers;

use App\Enum\EntregaStatus;
use App\Enum\TipoCarro;
use App\Http\Controllers\Controller;
use App\Models\Entrega;
use Illuminate\Http\Request;
use Illuminate\View\View;
/* NÃO APAGAR AINDA, TEM INFORMAÇÃO PARA USO POSTERIOR.
class EntregaController extends Controller
{

    public function index(Request $request)
    {
        $entregas = Entrega::all();

        // Verifica se é uma requisição de API (espera um JSON)
        if ($request->expectsJson()) {
            return response()->json($entregas);
        }

        // Caso contrário, retorna a view tradicional para a web
        return view('entregas', compact('entregas'));
    }


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


    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'empresa_id' => 'required|exists:empresas,id',
            'motorista_id' => 'required|exists:users,id',
            'status' => 'required|in:' . implode(',', EntregaStatus::getValues()),
            'tipo_carro' => 'required|in:' . implode(',', TipoCarro::getValues()),
            'data_prevista' => 'required|date',
            // outros campos necessários para a entrega
        ]);

        $entrega = Entrega::create($validatedData);

        return response()->json(['message' => 'Entrega criada com sucesso!', 'entrega' => $entrega], 201);
    }


    public function update(Request $request, $id)
    {
        $entrega = Entrega::findOrFail($id);

        $validatedData = $request->validate([
            'empresa_id' => 'sometimes|required|exists:empresas,id',
            'motorista_id' => 'sometimes|required|exists:users,id',
            'status' => 'sometimes|required|in:' . implode(',', EntregaStatus::getValues()),
            'tipo_carro' => 'sometimes|required|in:' . implode(',', TipoCarro::getValues()),
            'data_prevista' => 'sometimes|required|date',
            // outros campos para atualização
        ]);

        $entrega->update($validatedData);

        return response()->json(['message' => 'Entrega atualizada com sucesso!', 'entrega' => $entrega]);
    }

    public function destroy($id)
    {
        $entrega = Entrega::findOrFail($id);
        $entrega->delete();

        return response()->json(['message' => 'Entrega deletada com sucesso!']);
    }


    public function aceitarEntrega($entregaId)
    {
        $entrega = Entrega::findOrFail($entregaId);
        $motorista = auth()->user();

        // Verifica se o usuário é um motorista
        if (! $motorista->isMotorista()) {
            return response()->json(['message' => 'Usuário não autorizado a aceitar entregas.'], 403);
        }

        // Aceita a entrega
        $entrega->aceitarEntrega($motorista);

        return response()->json(['message' => 'Entrega aceita com sucesso!']);
    }
}
*/
namespace App\Http\Controllers;

use App\Enum\EntregaStatus;
use App\Enum\TipoCarro;
use App\Http\Controllers\Controller;
use App\Models\Entrega;
use App\Models\Empresa;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\JsonResponse;

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

    /**
     * Cria uma nova entrega.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\View\View
     */
    public function create()
    {
        $empresas = Empresa::all(); // Carregar todas as empresas

        // Retorna a view para criação de entrega
        return view('entregas.create', compact('empresas'));
    }

    /**
     * Salva uma nova entrega.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
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

        // Se for uma requisição API, retornar JSON
        if ($request->expectsJson()) {
            return response()->json(['message' => 'Entrega criada com sucesso!', 'entrega' => $entrega], 201);
        }

        // toDo concertar rota
        return redirect()->route('entregas.index')->with('success', 'Entrega criada com sucesso.');
    }

    /**
     * Exibe o formulário para editar uma entrega.
     *
     * @param  int  $id
     * @return \Illuminate\View\View|\Illuminate\Http\JsonResponse
     */
    public function edit($id)
    {
        $entrega = Entrega::findOrFail($id);
        $empresas = Empresa::all();

        return view('entregas.edit', compact('entrega', 'empresas'));
    }

    /**
     * Atualiza uma entrega existente.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse|\Illuminate\View\View
     */
    public function update(Request $request, $id)
    {
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

        // Se for uma requisição API, retornar JSON
        if ($request->expectsJson()) {
            return response()->json(['message' => 'Entrega atualizada com sucesso!', 'entrega' => $entrega]);
        }

        // toDo concertar rota
        return redirect()->route('entregas.index')->with('success', 'Entrega atualizada com sucesso.');
    }

    /**
     * Deleta uma entrega.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse|\Illuminate\View\View
     */
    public function destroy($id)
    {
        $entrega = Entrega::findOrFail($id);
        $entrega->delete();

        // Se for uma requisição API, retornar JSON
        if (request()->expectsJson()) {
            return response()->json(['message' => 'Entrega deletada com sucesso!']);
        }

        // toDo concertar rota
        return redirect()->route('entregas.index')->with('success', 'Entrega excluída com sucesso.');
    }

    /**
     * Aceita uma entrega, caso o usuário seja um motorista.
     *
     * @param  int  $entregaId
     * @return \Illuminate\Http\JsonResponse
     */
    public function aceitarEntrega($entregaId)
    {
        $entrega = Entrega::findOrFail($entregaId);

        $entrega->status = 'A'; // Exemplo: status alterado para aceito
        $entrega->save();

        return response()->json(['message' => 'Entrega aceita com sucesso!']);
    }
}
