<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\User;
use App\Models\Empresa;
use App\Models\Motorista;
use Illuminate\Support\Facades\Hash;

class UserRegistration extends Component
{
    public $name, $email, $password, $password_confirmation;
    public $userType = 'empresa'; // Pode ser 'empresa' ou 'motorista'
    public $cnpj, $rua, $bairro, $numero, $logo, $cnh;

    protected $rules = [
        'userType' => 'required',
    ];

    public function updatedUserType($value)
    {
        // Reseta os campos ao mudar o tipo de usuário
        $this->reset(['name', 'email', 'password', 'password_confirmation', 'cnpj', 'rua', 'bairro', 'numero', 'logo', 'cnh']);
    }

    public function registerCompany()
    {
        $this->validate([
            'cnpj' => 'required|string|max:18',
            'rua' => 'required|string|max:255',
            'bairro' => 'required|string|max:255',
            'numero' => 'required|string|max:10',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Criação da empresa
        $logoPath = $this->logo ? $this->logo->store('logos') : null;

        Empresa::create([
            'cnpj' => $this->cnpj,
            'rua' => $this->rua,
            'bairro' => $this->bairro,
            'numero' => $this->numero,
            'logo' => $logoPath,
        ]);

        session()->flash('message', 'Empresa cadastrada com sucesso!');
        $this->reset(); // Limpa os campos do formulário
    }

    public function registerDriver()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'cnh' => 'required|string|max:11',
        ]);

        // Criação do usuário
        $user = User::create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => Hash::make($this->password),
        ]);

        // Criação do motorista
        Motorista::create([
            'user_id' => $user->id,
            'cnh' => $this->cnh,
        ]);

        session()->flash('message', 'Motorista cadastrado com sucesso!');
        $this->reset(); // Limpa os campos do formulário
    }

    public function render()
    {
        return view('livewire.user-registration');
    }
}
