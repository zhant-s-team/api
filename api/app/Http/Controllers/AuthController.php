<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

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

    public function login(LoginRequest $request)
    {
        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return response(['error' => 'O e-mail informado não está cadastrado.'], 401); //Unauthorized
        }

        if ($user and Hash::check($request->password, $user->password)) {
            $token = $user->createToken('auth-token')->plainTextToken;
            $user->token = $token;

            return new UserResource($user);
        }

        return response(['error' => 'A senha informada está incorreta.'], 401); //Unauthorized
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
