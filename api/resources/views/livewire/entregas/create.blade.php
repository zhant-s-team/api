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

<form wire:submit.prevent="store">
    <input
        wire:model="titulo"
        placeholder="Título"
        class="block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mb-2"
    />

    <textarea
        wire:model="descricao"
        placeholder="Descrição"
        class="block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mb-2"
    ></textarea>

    <select
        wire:model="inicio"
        class="block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mb-2"
    >
        <option value="">Selecione a cidade de início</option>
        @foreach ($cidades as $cidade)
            <option value="{{ $cidade['nome'] }}">{{ $cidade['nome'] }}</option>
        @endforeach
    </select>

    <select
        wire:model="destino"
        class="block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mb-2"
    >
        <option value="">Selecione a cidade de destino</option>
        @foreach ($cidades as $cidade)
            <option value="{{ $cidade['nome'] }}">{{ $cidade['nome'] }}</option>
        @endforeach
    </select>

    <!-- Campo de seleção para tipo do Veículo -->
    <select
        wire:model="tipo_veiculo"
        class="block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mb-2"
    >
        <option value="">Selecione o tipo de veículo</option>
        @foreach ($tipoVeiculos as $tipo)
            <option value="{{ $tipo['id'] }}">{{ $tipo['label'] }}</option>
        @endforeach
    </select>

    <input
        wire:model="carga"
        placeholder="Carga"
        class="block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mb-2"
    />

    <input
        type="number"
        wire:model="percurso"
        placeholder="Percurso em km"
        class="block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mb-2"
    />

    <select
        wire:model="empresa_id"
        class="block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mb-2"
    >
        <option value="">Selecione a Empresa</option>
        @foreach ($empresas as $empresa)
            <option value="{{ $empresa['id'] }}">{{ $empresa['nome'] }}</option>
        @endforeach
    </select>

    <x-input-error :messages="$errors->get('titulo')" class="mt-2" />
    <x-input-error :messages="$errors->get('descricao')" class="mt-2" />
    <x-input-error :messages="$errors->get('inicio')" class="mt-2" />
    <x-input-error :messages="$errors->get('destino')" class="mt-2" />
    <x-input-error :messages="$errors->get('tipo_veiculo')" class="mt-2" />
    <x-input-error :messages="$errors->get('carga')" class="mt-2" />
    <x-input-error :messages="$errors->get('percurso')" class="mt-2" />

    <x-primary-button class="mt-4">{{ __('Salvar') }}</x-primary-button>
</form>
