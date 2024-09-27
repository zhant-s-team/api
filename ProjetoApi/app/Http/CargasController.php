<?php

namespace App\Http\Controllers;

use App\Models\Carga;
use Illuminate\Http\Request;

class CargaController extends Controller
{
    /**
     * Exibe todas as cargas.
     */
    public function index()
    {
        // Retorna todas as cargas do banco de dados
        return Carga::all();
    }

    /**
     * Armazena uma nova carga no banco de dados.
     */
    public function store(Request $request)
    {
        // Validação dos dados recebidos
        $validatedData = $request->validate([
            'remetente' => 'required|string|max:255',
            'descricao' => 'required|string|max:255',
            'peso' => 'required|numeric|min:0',
            'tipo' => 'required|string|max:50',
            'destinatario' => 'required|string|max:100',
            'data_envio' => 'required|date',
            'previsao_entrega' => 'required|date|after_or_equal:data_envio',
        ]);

        // Cria a carga com os dados validados
        $carga = Carga::create($validatedData);

        // Retorna a nova carga criada com o código HTTP 201
        return response()->json($carga, 201);
    }

    /**
     * Exibe uma carga específica.
     */
    public function show(int $id)
    {
        // Encontra a carga pelo ID ou falha
        return Carga::findOrFail($id);
    }

    /**
     * Atualiza uma carga existente.
     */
    public function update(Request $request, int $id)
    {
        // Encontra a carga pelo ID
        $carga = Carga::findOrFail($id);

        // Validação dos dados recebidos
        $validatedData = $request->validate([
            'remetente' => 'sometimes|required|string|max:255',
            'descricao' => 'sometimes|required|string|max:255',
            'peso' => 'sometimes|required|numeric|min:0',
            'tipo' => 'sometimes|required|string|max:50',
            'destinatario' => 'sometimes|required|string|max:100',
            'data_envio' => 'sometimes|required|date',
            'previsao_entrega' => 'sometimes|required|date|after_or_equal:data_envio',
        ]);

        // Atualiza a carga com os dados validados
        $carga->update($validatedData);

        // Retorna a carga atualizada
        return response()->json($carga, 200);
    }

    /**
     * Remove uma carga específica do banco de dados.
     */
    public function destroy(int $id)
    {
        // Encontra e remove a carga
        Carga::destroy($id);

        // Retorna resposta de sucesso sem conteúdo (HTTP 204)
        return response()->json(null, 204);
    }
}
