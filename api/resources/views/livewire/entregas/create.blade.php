<?php

use App\Services\CidadeService;
use App\Models\Empresa; // Importação do modelo Empresa
use App\Enum\TipoCarro; // Importar o enum TipoCarro
use Livewire\Attributes\Validate;
use Livewire\Volt\Component;

new class extends Component
{
    #[Validate('required|integer')]
    public int $empresa_id; // Campo para selecionar a empresa associada à entrega

    #[Validate('required|string|max:255')]
    public string $titulo = '';

    #[Validate('required|string')]
    public string $descricao = '';

    #[Validate('required|string|max:255')]
    public string $inicio = '';

    #[Validate('required|string|max:255')]
    public string $destino = '';

    #[Validate('required|string|max:255')]
    public string $tipo_veiculo = ''; // Agora este campo será um enum

    #[Validate('required|string|max:255')]
    public string $carga = '';

    #[Validate('required|integer|min:1')]
    public int $percurso = 0;

    public array $cidades = [];
    public array $empresas = []; // Variável para armazenar as empresas
    public array $tipoVeiculos = []; // Array para armazenar os tipos de veículo

    public function mount()
    {
        $cidadeService = new CidadeService();
        $this->cidades = $cidadeService->getCidades();
        $this->empresas = Empresa::all()->toArray(); // Carrega todas as empresas

        // Carregar tipos de veículos do enum
        $this->tipoVeiculos = array_map(fn($tipo) => ['id' => $tipo->value, 'label' => $tipo->label()], TipoCarro::cases());
    }

    public function store(): void
    {
        $validated = $this->validate();

        $validated['cidade_origem'] = $this->inicio;
        $validated['cidade_destino'] = $this->destino;
        $validated['created_by'] = auth()->id();

        // Salvar a entrega com o tipo de veículo do enum
        auth()->user()->entregas()->create($validated);

        // Limpar os campos após o salvamento
        $this->reset(['empresa_id', 'titulo', 'descricao', 'inicio', 'destino', 'tipo_veiculo', 'carga', 'percurso']);

        $this->dispatch('entrega-created');
    }
};

?>
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
                <form wire:submit.prevent="store">

                    <!-- Título do Formulário -->
                    <h2 class="font-semibold text-xl text-gray-800 mb-6">{{ __('Cadastrar Entrega') }}</h2>

                    <!-- Campo Título -->
                    <div class="mb-4">
                        <label for="titulo" class="block text-sm font-medium text-gray-700">{{ __('Título') }}</label>
                        <input
                            wire:model="titulo"
                            id="titulo"
                            placeholder="Título da entrega"
                            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2"
                        />
                        <x-input-error :messages="$errors->get('titulo')" class="mt-2" />
                    </div>

                    <!-- Campo Descrição -->
                    <div class="mb-4">
                        <label for="descricao" class="block text-sm font-medium text-gray-700">{{ __('Descrição') }}</label>
                        <textarea
                            wire:model="descricao"
                            id="descricao"
                            placeholder="Descrição detalhada"
                            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2"
                        ></textarea>
                        <x-input-error :messages="$errors->get('descricao')" class="mt-2" />
                    </div>

                    <!-- Seletor Cidade de Origem -->
                    <div class="mb-4">
                        <label for="inicio" class="block text-sm font-medium text-gray-700">{{ __('Cidade de Origem') }}</label>
                        <select
                            wire:model="inicio"
                            id="inicio"
                            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2"
                        >
                            <option value="">{{ __('Selecione a cidade de origem') }}</option>
                            @foreach($cidades as $cidade)
                                <option value="{{ $cidade['nome'] }}">{{ $cidade['nome'] }}</option>
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('inicio')" class="mt-2" />
                    </div>

                    <!-- Seletor Cidade de Destino -->
                    <div class="mb-4">
                        <label for="destino" class="block text-sm font-medium text-gray-700">{{ __('Cidade de Destino') }}</label>
                        <select
                            wire:model="destino"
                            id="destino"
                            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2"
                        >
                            <option value="">{{ __('Selecione a cidade de destino') }}</option>
                            @foreach($cidades as $cidade)
                                <option value="{{ $cidade['nome'] }}">{{ $cidade['nome'] }}</option>
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('destino')" class="mt-2" />
                    </div>

                    <!-- Seletor Tipo de Veículo -->
                    <div class="mb-4">
                        <label for="tipo_veiculo" class="block text-sm font-medium text-gray-700">{{ __('Tipo de Veículo') }}</label>
                        <select
                            wire:model="tipo_veiculo"
                            id="tipo_veiculo"
                            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2"
                        >
                            <option value="">{{ __('Selecione o tipo de veículo') }}</option>
                            @foreach ($tipoVeiculos as $tipo)
                                <option value="{{ $tipo['id'] }}">{{ $tipo['label'] }}</option>
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('tipo_veiculo')" class="mt-2" />
                    </div>

                    <!-- Campo Carga -->
                    <div class="mb-4">
                        <label for="carga" class="block text-sm font-medium text-gray-700">{{ __('Carga') }}</label>
                        <input
                            wire:model="carga"
                            id="carga"
                            placeholder="Peso da carga"
                            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2"
                        />
                        <x-input-error :messages="$errors->get('carga')" class="mt-2" />
                    </div>

                    <!-- Campo Percurso -->
                    <div class="mb-4">
                        <label for="percurso" class="block text-sm font-medium text-gray-700">{{ __('Percurso (km)') }}</label>
                        <input
                            type="number"
                            wire:model="percurso"
                            id="percurso"
                            placeholder="Distância em km"
                            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2"
                        />
                        <x-input-error :messages="$errors->get('percurso')" class="mt-2" />
                    </div>

                    <!-- Seletor Empresa -->
                    <div class="mb-4">
                        <label for="empresa_id" class="block text-sm font-medium text-gray-700">{{ __('Selecione a Empresa') }}</label>
                        <select
                            wire:model="empresa_id"
                            id="empresa_id"
                            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2"
                        >
                            <option value="">{{ __('Selecione a empresa') }}</option>
                            @foreach ($empresas as $empresa)
                                <option value="{{ $empresa['id'] }}">{{ $empresa['nome'] }}</option>
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('empresa_id')" class="mt-2" />
                    </div>

                    <!-- Botão de Enviar -->
                    <button type="submit" class="mt-6 w-full bg-blue-500 text-white py-2 px-4 rounded-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        {{ __('Salvar') }}
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>


