<?php

namespace App\Http\Livewire\Empresas;

use App\Models\Empresa;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;

class Edit extends Component
{
    use WithFileUploads;

    public Empresa $empresa;
    public $nome;
    public $cnpj;
    public $rua;
    public $bairro;
    public $numero;
    public $logo;

    public function mount(Empresa $empresa)
    {
        $this->empresa = $empresa;
        $this->nome = $empresa->nome;
        $this->cnpj = $empresa->cnpj;
        $this->rua = $empresa->rua;
        $this->bairro = $empresa->bairro;
        $this->numero = $empresa->numero;
    }

    public function update()
    {
        $this->validate([
            'cnpj' => 'required|string|max:18',
            'nome' => 'required|string',
            'rua' => 'required|string|max:255',
            'bairro' => 'required|string|max:255',
            'numero' => 'required|integer|max:10',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Atualiza os dados da empresa
        $this->empresa->nome = $this->nome;
        $this->empresa->cnpj = $this->cnpj;
        $this->empresa->rua = $this->rua;
        $this->empresa->bairro = $this->bairro;
        $this->empresa->numero = $this->numero;

        // Atualiza o logo se houver um novo upload
        if ($this->logo) {
            if ($this->empresa->logo) {
                Storage::delete($this->empresa->logo); // Remove o logo antigo
            }
            $path = $this->logo->store('logos', 'public');
            $this->empresa->logo = $path;
        }

        $this->empresa->save();

        // Redireciona para a lista de empresas
        return redirect()->route('/empresas')->with('success', 'Empresa atualizada com sucesso!');
    }

    public function render()
    {
        return view('livewire.empresas.edit');
    }
}
