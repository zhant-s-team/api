<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Lista de Usuários') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <!-- Botão para redirecionar para a página de criação de usuário -->
                    <a href="{{ route('users.create') }}" class="inline-flex items-center px-4 py-2 mb-4 text-sm font-semibold text-white bg-blue-500 hover:bg-blue-600 rounded">
                        + Adicionar Usuário
                    </a>

                    <!-- Exibir lista de usuários -->
                    @if($users->isEmpty())
                        <p>Nenhum usuário cadastrado.</p>
                    @else
                        <table class="table-auto w-full">
                            <thead>
                                <tr>
                                    <th class="px-4 py-2">Nome</th>
                                    <th class="px-4 py-2">E-mail</th>
                                    <th class="px-4 py-2">CNH</th>
                                    <th class="px-4 py-2">Administrador</th>
                                    <th class="px-4 py-2">Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($users as $user)
                                    <tr>
                                        <td class="border px-4 py-2">{{ $user->name }}</td>
                                        <td class="border px-4 py-2">{{ $user->email }}</td>
                                        <td class="border px-4 py-2">{{ $user->cnh ?? 'Sem CNH' }}</td>
                                        <td class="border px-4 py-2">{{ $user->is_admin ? 'Sim' : 'Não' }}</td>
                                        <td class="border px-4 py-2">
                                            <a href="{{ route('users.edit', $user->id) }}" class="text-blue-600 hover:text-blue-800">Editar</a>
                                            |
                                            <form action="{{ route('users.destroy', $user->id) }}" method="DELETE" class="inline">
    @csrf
    @method('DELETE')
    <button type="submit" class="text-red-600 hover:text-red-800" onclick="return confirm('Tem certeza que deseja excluir este usuário?')">Excluir</button>
</form>

                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
