<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Lista de Cidades: Sul do maranhão') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <ul>
                        @if(isset($cidades) && is_array($cidades) && count($cidades) > 0)
                            @foreach($cidades as $cidade)
                                <li>
                                    <strong>Cidade:</strong> {{ $cidade['municipio']['nome'] }} <br>
                                    <strong>Microrregião:</strong> {{ $cidade['municipio']['microrregiao']['nome'] }} <br>
                                    <strong>Mesorregião:</strong> {{ $cidade['municipio']['microrregiao']['mesorregiao']['nome'] }} <br>
                                    <strong>Estado:</strong> {{ $cidade['municipio']['microrregiao']['mesorregiao']['UF']['nome'] }} <br>
                                    <hr>
                                </li>
                            @endforeach
                        @else
                            <li>Nenhuma cidade relacionada a Balsas encontrada.</li>
                        @endif
                    </ul>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
