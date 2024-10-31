<?php

namespace App\Http\Controllers;

use App\Services\CidadeService;
use Illuminate\Http\Request;

class CidadeController extends Controller
{
    protected $cidadeService;

    public function __construct(CidadeService $cidadeService)
    {
        $this->cidadeService = $cidadeService;
    }

    public function index()
    {
        $cidades = $this->cidadeService->getCidades();

        return view('cidades.index', compact('cidades')); // Exemplo de retorno para uma view
    }
}
