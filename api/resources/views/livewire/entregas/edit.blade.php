<?php

use App\Models\Empresa;
use App\Enum\TipoCarro;
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

    #[Validate('required|enum:App\Enum\TipoCarro')] // Validação para o enum
    public ?TipoCarro $tipo_veiculo = null; // Usar ?TipoCarro para permitir que seja null inicialmente

    #[Validate('required|string|max:255')]
    public string $carga = '';

    #[Validate('required|integer|min:1')]
    public int $percurso = 0;

    public array $cidades = [];
    public array $empresas = []; // Variável para armazenar as empresas
    public array $tipoVeiculos = []; // Array para armazenar os tipos de veículo

    public $entrega = null; // Variável para armazenar a entrega editada

    // Método chamado ao carregar o componente
    public function mount($entrega_id = null)
    {
        // Carregar as cidades e empresas
        $this->cidades = ['São Paulo', 'Rio de Janeiro', 'Belo Horizonte']; // Exemplo de cidades
        $this->empresas = Empresa::all()->toArray(); // Carrega todas as empresas

        // Carregar tipos de veículos do enum
        $this->tipoVeiculos = array_map(fn($tipo) => ['id' => $tipo->value, 'label' => $tipo->label()], TipoCarro::cases());

        if ($entrega_id) {
            // Carrega a entrega para edição
            $this->entrega = auth()->user()->entregas()->find($entrega_id);

            if ($this->entrega) {
                // Inicializar os campos com os valores da entrega
                $this->empresa_id = $this->entrega->empresa_id;
                $this->titulo = $this->entrega->titulo;
                $this->descricao = $this->entrega->descricao;
                $this->inicio = $this->entrega->cidade_origem;
                $this->destino = $this->entrega->cidade_destino;

                // Verificar se o tipo_veiculo existe antes de atribuir
                $this->tipo_veiculo = $this->entrega->tipo_veiculo ? TipoCarro::from($this->entrega->tipo_veiculo) : null;

                $this->carga = $this->entrega->carga;
                $this->percurso = $this->entrega->percurso;
            }
        }
    }

    // Método para salvar os dados da entrega
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

    // Método para atualizar os dados da entrega
    public function update(): void
    {
        $this->authorize('update', $this->entrega);

        // Validação dos dados
        $validated = $this->validate();

        // Atualiza a entrega com os novos dados
        $this->entrega->update([
            'empresa_id' => $this->empresa_id,
            'titulo' => $this->titulo,
            'descricao' => $this->descricao,
            'cidade_origem' => $this->inicio,
            'cidade_destino' => $this->destino,
            'tipo_veiculo' => $this->tipo_veiculo ? $this->tipo_veiculo->value : null, // Garantir que o valor de tipo_veiculo seja null se não estiver presente
            'carga' => $this->carga,
            'percurso' => $this->percurso,
        ]);

        $this->dispatch('entrega-updated');
    }

    // Método para cancelar a edição
    public function cancel(): void
    {
        $this->dispatch('entrega-edit-canceled');
    }
};
?>
<div>
    <form wire:submit.prevent="update">
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
                <option value="{{ $cidade }}" @selected($inicio == $cidade)>{{ $cidade }}</option>
            @endforeach
        </select>

        <select
            wire:model="destino"
            class="block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mb-2"
        >
            <option value="">Selecione a cidade de destino</option>
            @foreach ($cidades as $cidade)
                <option value="{{ $cidade }}" @selected($destino == $cidade)>{{ $cidade }}</option>
            @endforeach
        </select>

        <select
            wire:model="tipo_veiculo"
            class="block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mb-2"
        >
            <option value="">Selecione o tipo de veículo</option>
            @foreach ($tipoVeiculos as $tipo)
                <option value="{{ $tipo['id'] }}" @selected($tipo_veiculo && $tipo_veiculo->value == $tipo['id'])>{{ $tipo['label'] }}</option>
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
                <option value="{{ $empresa['id'] }}" @selected($empresa_id == $empresa['id'])>{{ $empresa['nome'] }}</option>
            @endforeach
        </select>

        <x-input-error :messages="$errors->get('titulo')" class="mt-2" />
        <x-input-error :messages="$errors->get('descricao')" class="mt-2" />
        <x-input
