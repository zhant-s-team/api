<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Editar Empresa') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('empresas.update', $empresa->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <!-- Campo Nome -->
                        <div class="mb-4">
                            <label for="nome" class="block text-sm font-medium text-gray-700">Nome:</label>
                            <input type="text" name="nome" id="nome" value="{{ old('nome', $empresa->nome) }}" required class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2">
                        </div>

                        <!-- Campo CNPJ -->
                        <div class="mb-4">
                            <label for="cnpj" class="block text-sm font-medium text-gray-700">CNPJ:</label>
                            <input type="text" name="cnpj" id="cnpj" value="{{ old('cnpj', $empresa->cnpj) }}" required class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2">
                        </div>

                        <!-- Campo Rua -->
                        <div class="mb-4">
                            <label for="rua" class="block text-sm font-medium text-gray-700">Rua:</label>
                            <input type="text" name="rua" id="rua" value="{{ old('rua', $empresa->rua) }}" required class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2">
                        </div>

                        <!-- Campo Bairro -->
                        <div class="mb-4">
                            <label for="bairro" class="block text-sm font-medium text-gray-700">Bairro:</label>
                            <input type="text" name="bairro" id="bairro" value="{{ old('bairro', $empresa->bairro) }}" required class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2">
                        </div>

                        <!-- Campo Número -->
                        <div class="mb-4">
                            <label for="numero" class="block text-sm font-medium text-gray-700">Número:</label>
                            <input type="number" name="numero" id="numero" value="{{ old('numero', $empresa->numero) }}" required class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2">
                        </div>

                        <!-- Campo Logo -->
                        <div class="mb-4">
                            <label for="logo" class="block text-sm font-medium text-gray-700">Logo (deixe em branco para manter o logo atual):</label>
                            <input type="url" name="logo" id="logo" value="{{ old('logo', $empresa->logo) }}" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2" placeholder="https://exemplo.com/logo.png">
                            @if ($empresa->logo)
                                <p class="mt-2 text-gray-600">
                                    Logo atual:
                                    <img src="{{ $empresa->logo }}" alt="Logo atual" class="mt-1" width="50">
                                </p>
                            @endif
                        </div>

                        <button type="submit" class="mt-4 bg-blue-500 text-white py-2 px-4 rounded">Atualizar Empresa</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
