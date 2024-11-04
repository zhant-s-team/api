<?php

namespace App\Http\Controllers;

use App\Enum\EntregaStatus;
use App\Enum\TipoCarro;
use App\Http\Controllers\Controller;
use App\Models\Entrega;
use Illuminate\View\View;

class EntregaController extends Controller
{
    public function index(): View
    {
        return view('entregas', [
            //
        ]);
    }
    public function aceitarEntrega($entregaId)
    {
        $entrega = Entrega::findOrFail($entregaId);
        $motorista = auth()->user();

        if (! $motorista->isMotorista()) {
            return response()->json(['message' => 'Usuário não autorizado a aceitar entregas.'], 403);
        }

        $entrega->aceitarEntrega($motorista);

        return response()->json(['message' => 'Entrega aceita com sucesso!']);
    }

}
