<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(User::all(), 200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Lógica para criar um novo usuário, se necessário
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validação simples para testar
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $data['password'] = Hash::make($data['password']);
        $user = User::create($data);

        return response()->json(['message' => 'Usuário criado com sucesso.', 'user' => $user], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json(['message' => 'Usuário não encontrado.'], 404);
        }

        return response()->json($user, 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $user = User::find($id);

        if (!$user) {
            return redirect()->route('users.index')->with('error', 'Usuário não encontrado');
        }

        return view('livewire.users.edit', compact('user'));  // Altere o nome da view conforme sua estrutura
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Busca o usuário no banco de dados
        $user = User::find($id);

        if (!$user) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Usuário não encontrado.'], 404);
            }
            return redirect()->route('users.index')->with('error', 'Usuário não encontrado');
        }

        // Validação dos dados recebidos
        $data = $request->validate([
            'name' => 'nullable|string|max:255',
            'email' => 'nullable|string|email|max:255|unique:users,email,' . $id,
            'password' => 'nullable|string|min:8|confirmed',
            'cnh' => 'nullable|string',
        ]);

        // Lógica para definir o tipo de usuário (admin ou motorista)
        if (is_null($data['cnh'])) {
            $data['is_admin'] = true; // Se CNH for null, o usuário é admin
        } else {
            $data['is_admin'] = false; // Caso contrário, o usuário é motorista
        }

        // Atualizar a senha, se for fornecida
        if (isset($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        }

        // Atualizar os dados do usuário
        $user->update($data);

        // Resposta para API (JSON)
        if ($request->expectsJson()) {
            return response()->json(['message' => 'Usuário atualizado com sucesso.', 'user' => $user], 200);
        }

        // Redirecionar para a lista de usuários com sucesso na web
        return redirect()->route('users.index')->with('success', 'Usuário atualizado com sucesso');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $user = User::find($id);

        if (!$user) {
            // Para API
            if (request()->expectsJson()) {
                return response()->json(['message' => 'Usuário não encontrado.'], 404);
            }

            // Para Web
            return redirect()->route('users.index')->with('error', 'Usuário não encontrado');
        }

        // Deletar o usuário
        $user->delete();

        // Para API
        if (request()->expectsJson()) {
            return response()->json(['message' => 'Usuário excluído com sucesso.'], 200);
        }

        // Para Web
        return redirect()->route('users.index')->with('success', 'Usuário excluído com sucesso');
    }


}
