<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Lista de Cidades') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <ul>
                        @if(isset($cidades) && is_array($cidades))
                            @foreach($cidades as $cidade)
                                <li>
                                    {{ $cidade['nome'] }} - {{ $cidade['municipio']['microrregiao']['mesorregiao']['UF']['nome'] }}
                                </li>
                            @endforeach
                        @else
                            <li>Nenhuma cidade encontrada.</li>
                        @endif
                    </ul>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
