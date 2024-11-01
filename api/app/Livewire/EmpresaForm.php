<?php

namespace App\Http\Livewire;

use App\Models\Empresa;
use Livewire\Component;

class EmpresaForm extends Component
{
    public $user_id;
    public $cnpj;
    public $rua;
    public $bairro;
    public $numero;
    public $logo;

    protected $rules = [
        'user_id' => 'required|exists:users,id',
        'cnpj' => 'required|string',
        'rua' => 'required|string',
        'bairro' => 'required|string',
        'numero' => 'required|string',
        'logo' => 'nullable|string', // Caso o logo seja opcional
    ];

    public function submit()
    {
        $this->validate();

        Empresa::create([
            'user_id' => $this->user_id,
            'cnpj' => $this->cnpj,
            'rua' => $this->rua,
            'bairro' => $this->bairro,
            'numero' => $this->numero,
            'logo' => $this->logo,
        ]);

        // Limpar os campos após a criação
        $this->reset();

        // Redirecionar ou mostrar uma mensagem de sucesso
        session()->flash('message', 'Empresa cadastrada com sucesso!');
    }

    public function render()
    {
        return view('livewire.empresa-form');
    }
}
