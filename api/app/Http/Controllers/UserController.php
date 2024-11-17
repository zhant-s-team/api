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
        // Lógica para editar um usuário, se necessário
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json(['message' => 'Usuário não encontrado.'], 404);
        }

        // Validação dos dados recebidos
        $data = $request->validate([
            'name' => 'nullable|string|max:255',
            'email' => 'nullable|string|email|max:255|unique:users,email,' . $id,
            'password' => 'nullable|string|min:8|confirmed',
            'cnh' => 'nullable|string', // CNH também pode ser atualizada
        ]);

        // Verificar se a CNH foi preenchida e definir is_admin como false
        if (is_null($data['cnh'])) {
            $data['is_admin'] = true; // Se CNH for null, usuário é admin
        } else {
            $data['is_admin'] = false; // Caso contrário, ele é motorista
        }

        // Verificar e atualizar a senha, se necessário
        if (isset($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        }

        $user->update($data);

        return response()->json(['message' => 'Usuário atualizado com sucesso.', 'user' => $user], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json(['message' => 'Usuário não encontrado.'], 404);
        }

        // Deletar o usuário
        $user->delete();

        return response()->json(['message' => 'Usuário excluído com sucesso.'], 200);
    }
}
