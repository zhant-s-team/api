<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use Illuminate\Http\Request;

class UsuarioController extends Controller
{
    public function index()
    {
        return Usuario::all();
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nome' => 'required|string|max:255',
            'email' => 'required|email|unique:usuarios',
            'senha' => 'required|string|min:8',
        ]);

        $usuario = Usuario::create($validatedData);
        return response()->json($usuario, 201);
    }

    public function show(string $id)
    {
        return Usuario::findOrFail($id);
    }

    public function update(Request $request, string $id)
    {
        $usuario = Usuario::findOrFail($id);
        $validatedData = $request->validate([
            'nome' => 'sometimes|required|string|max:255',
            'email' => 'sometimes|required|email|unique:usuarios,email,' . $id,
            'senha' => 'sometimes|required|string|min:8',
        ]);

        $usuario->update($validatedData);
        return response()->json($usuario, 200);
    }

    public function destroy(string $id)
    {
        Usuario::destroy($id);
        return response()->json(null, 204);
    }
}
