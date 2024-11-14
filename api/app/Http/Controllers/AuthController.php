<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;


class AuthController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::all(); // Obter todos os usuários
        return view('livewire.users.list', compact('users'));
        //return UserResource::collection(User::all());
        //return view('livewire.users.list', compact('users'));
    }

    public function register(Request $request)
    {
        // Validação dos dados de entrada
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'cnh' => 'nullable|string', // CNH será preenchida apenas para motoristas
        ]);

        // Definir se o usuário é administrador com base na ausência de CNH
        $data['is_admin'] = is_null($data['cnh']);

        // Criação do usuário
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'cnh' => $data['cnh'],
            'is_admin' => $data['is_admin'],
        ]);

        // Gerar token de autenticação para o usuário
        $token = $user->createToken('auth-token')->plainTextToken;
        $user->token = $token;

        // Retornar o usuário registrado com o token
        $resource = new UserResource($user);
        return $resource->response()->setStatusCode(201);
    }

/**
     * Método de login de um usuário.
     *
     * @param  \App\Http\Requests\LoginRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(LoginRequest $request)
    {
        // Validação já feita pelo LoginRequest
        $credentials = $request->only('email', 'password');

        // Tenta autenticar o usuário com as credenciais fornecidas
        if (Auth::attempt($credentials)) {
            // Usuário autenticado com sucesso
            $user = Auth::user();

            // Cria o token de autenticação
            $token = $user->createToken('MeuAppToken')->plainTextToken;

            // Retorna o token junto com o usuário autenticado
            return response()->json([
                'token' => $token,
                'user'  => $user, // Retorna os dados do usuário também
            ]);
        }

        // Se as credenciais forem inválidas
        return response()->json(['message' => 'Credenciais inválidas'], 401);
    }

    public function validateToken(Request $request)
    {
        if ($token = $request->bearerToken()) {
            $user = auth('sanctum')->user();
            $user->token = $token;
            return new UserResource($user);
        }
    }


    public function logout()
    {
        /** @var User $user */
        $user = Auth()->user();
        $user->tokens()->delete();

        return response(['message' => 'Logout realizado com sucesso.'], 200);
    }
}
