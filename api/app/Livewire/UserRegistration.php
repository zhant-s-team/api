<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserRegistration extends Component
{
    public $name, $email, $password, $password_confirmation, $cnh;
    public $userType = 'motorista';

    protected $rules = [
        'userType' => 'required',
    ];

    public function updatedUserType($value)
    {
        // Reseta os campos ao mudar o tipo de usuário
        $this->reset(['name', 'email', 'password', 'password_confirmation', 'cnh']);
    }

    public function registerUser()
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
            'cnh' => $this->cnh,
        ]);

        session()->flash('message', 'Usuario cadastrado com sucesso!');
        $this->reset(); // Limpa os campos do formulário
    }

    public function render()
    {
        return view('livewire.user-registration');
    }
}
