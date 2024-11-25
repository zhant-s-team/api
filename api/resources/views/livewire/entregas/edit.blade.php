<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Editar Entrega') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('entregas.update', $entrega->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <!-- Campo Empresa -->
                        <div class="mb-4">
                            <label for="empresa_id" class="block text-sm font-medium text-gray-700">Empresa:</label>
                            <select name="empresa_id" id="empresa_id" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2" required>
                                @foreach ($empresas as $empresa)
                                    <option value="{{ $empresa->id }}" {{ $empresa->id == $entrega->empresa_id ? 'selected' : '' }}>
                                        {{ $empresa->nome }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Campo Título -->
                        <div class="mb-4">
                            <label for="titulo" class="block text-sm font-medium text-gray-700">Título:</label>
                            <input type="text" name="titulo" id="titulo" value="{{ old('titulo', $entrega->titulo) }}" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2" required>
                        </div>

                        <!-- Campo Descrição -->
                        <div class="mb-4">
                            <label for="descricao" class="block text-sm font-medium text-gray-700">Descrição:</label>
                            <textarea name="descricao" id="descricao" rows="4" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2" required>{{ old('descricao', $entrega->descricao) }}</textarea>
                        </div>

<!-- Campo Cidade Origem -->
<div class="mb-4">
    <label for="cidade_origem" class="block text-sm font-medium text-gray-700">Cidade de Origem:</label>
    <select name="cidade_origem" id="cidade_origem" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2" required>
        @foreach ($cidades as $cidade)
            <option value="{{ $cidade['nome'] }}" {{ $cidade['nome'] == $entrega->cidade_origem ? 'selected' : '' }}>
                {{ $cidade['nome'] }}
            </option>
        @endforeach
    </select>
</div>

<!-- Campo Cidade Destino -->
<div class="mb-4">
    <label for="cidade_destino" class="block text-sm font-medium text-gray-700">Cidade de Destino:</label>
    <select name="cidade_destino" id="cidade_destino" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2" required>
        @foreach ($cidades as $cidade)
            <option value="{{ $cidade['nome'] }}" {{ $cidade['nome'] == $entrega->cidade_destino ? 'selected' : '' }}>
                {{ $cidade['nome'] }}
            </option>
        @endforeach
    </select>
</div>


                        <!-- Campo Tipo de Veículo -->
                        <div class="mb-4">
                            <label for="tipo_veiculo" class="block text-sm font-medium text-gray-700">Tipo de Veículo:</label>
                            <select name="tipo_veiculo" id="tipo_veiculo" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2" required>
                                @foreach (\App\Enum\TipoCarro::cases() as $tipo)
                                    <option value="{{ $tipo->value }}" {{ $tipo->value == $entrega->tipo_veiculo ? 'selected' : '' }}>
                                        {{ $tipo->label() }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Campo Carga -->
                        <div class="mb-4">
                            <label for="carga" class="block text-sm font-medium text-gray-700">Carga:</label>
                            <input type="text" name="carga" id="carga" value="{{ old('carga', $entrega->carga) }}" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2" required>
                        </div>

                        <!-- Campo Percurso -->
                        <div class="mb-4">
                            <label for="percurso" class="block text-sm font-medium text-gray-700">Percurso (km):</label>
                            <input type="number" name="percurso" id="percurso" value="{{ old('percurso', $entrega->percurso) }}" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2" required>
                        </div>

                        <button type="submit" class="mt-4 bg-blue-500 text-white py-2 px-4 rounded">Atualizar Entrega</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
