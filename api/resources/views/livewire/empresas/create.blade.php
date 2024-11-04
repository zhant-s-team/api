<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Criar Empresa') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('empresas.store') }}" enctype="multipart/form-data">
                        @csrf

                        <!-- Campo CNPJ -->
                        <div class="mb-4">
                            <label for="cnpj" class="block text-sm font-medium text-gray-700">CNPJ:</label>
                            <input type="text" id="cnpj" name="cnpj" required class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2">
                        </div>

                        <!-- Campo Nome -->
                        <div class="mb-4">
                            <label for="nome" class="block text-sm font-medium text-gray-700">Nome:</label>
                            <input type="text" id="nome" name="nome" required class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2">
                        </div>

                        <!-- Campo Rua -->
                        <div class="mb-4">
                            <label for="rua" class="block text-sm font-medium text-gray-700">Rua:</label>
                            <input type="text" id="rua" name="rua" required class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2">
                        </div>

                        <!-- Campo Bairro -->
                        <div class="mb-4">
                            <label for="bairro" class="block text-sm font-medium text-gray-700">Bairro:</label>
                            <input type="text" id="bairro" name="bairro" required class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2">
                        </div>

                        <!-- Campo Número -->
                        <div class="mb-4">
                            <label for="numero" class="block text-sm font-medium text-gray-700">Número:</label>
                            <input type="number" id="numero" name="numero" required class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2">
                        </div>

                        <!-- Campo Logo -->
                        <div class="mb-4">
                            <label for="logo" class="block text-sm font-medium text-gray-700">Logo (opcional):</label>
                            <input type="file" id="logo" name="logo" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2">
                        </div>

                        <button type="submit" class="mt-4 bg-blue-500 text-white py-2 px-4 rounded">Criar Empresa</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
