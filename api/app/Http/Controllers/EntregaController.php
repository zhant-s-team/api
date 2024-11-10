<?php

namespace App\Http\Controllers;

use App\Enum\EntregaStatus;
use App\Enum\TipoCarro;
use App\Http\Controllers\Controller;
use App\Models\Entrega;
use Illuminate\Http\Request;
use Illuminate\View\View;

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
        $entregas = Entrega::all();

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
     * @return \Illuminate\Http\JsonResponse
     */
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

    /**
     * Atualiza uma entrega existente.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
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

    /**
     * Deleta uma entrega.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $entrega = Entrega::findOrFail($id);
        $entrega->delete();

        return response()->json(['message' => 'Entrega deletada com sucesso!']);
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
