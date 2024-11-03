<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Lista de Empresas') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if($empresas->isEmpty())
                        <p>Nenhuma empresa cadastrada.</p>
                    @else
                        <table class="table-auto w-full">
                            <thead>
                                <tr>
                                    <th class="px-4 py-2">Nome</th>
                                    <th class="px-4 py-2">CNPJ</th>
                                    <th class="px-4 py-2">Rua</th>
                                    <th class="px-4 py-2">Bairro</th>
                                    <th class="px-4 py-2">Número</th>
                                    <th class="px-4 py-2">Logo</th>
                                    <th class="px-4 py-2">Ações</th> <!-- Coluna para ações -->
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($empresas as $empresa)
                                    <tr>
                                        <td class="border px-4 py-2">{{ $empresa->nome }}</td>
                                        <td class="border px-4 py-2">{{ $empresa->cnpj }}</td>
                                        <td class="border px-4 py-2">{{ $empresa->rua }}</td>
                                        <td class="border px-4 py-2">{{ $empresa->bairro }}</td>
                                        <td class="border px-4 py-2">{{ $empresa->numero }}</td>
                                        <td class="border px-4 py-2">
                                            @if($empresa->logo)
                                                <img src="{{ asset('storage/' . $empresa->logo) }}" alt="Logo" width="50">
                                            @else
                                                Sem logo
                                            @endif
                                        </td>
                                        <td class="border px-4 py-2">
                                            <a href="{{ route('empresas.edit', $empresa) }}" class="text-blue-500 hover:underline">Editar</a>
                                        </td> <!-- Link para editar -->
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
