<?php

use Livewire\Attributes\Validate;
use Livewire\Volt\Component;

new class extends Component
{
    #[Validate('required|string|max:255')]
    public string $titulo = '';

    #[Validate('required|string')]
    public string $descricao = '';

    #[Validate('required|string|max:255')]
    public string $inicio = '';

    #[Validate('required|string|max:255')]
    public string $destino = '';

    #[Validate('required|string|max:255')]
    public string $porte_veiculo = '';

    #[Validate('required|string|max:255')]
    public string $carga = '';

    #[Validate('required|integer|min:1')]
    public int $percurso = 0;

    public function store(): void
    {
        $validated = $this->validate();

        auth()->user()->entregas()->create($validated);

        // Limpar os campos após o salvamento
        $this->reset(['titulo', 'descricao', 'inicio', 'destino', 'porte_veiculo', 'carga', 'percurso']);
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

    <input
        wire:model="inicio"
        placeholder="Início"
        class="block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mb-2"
    />

    <input
        wire:model="destino"
        placeholder="Destino"
        class="block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mb-2"
    />

    <!-- Campo de seleção para Porte do Veículo -->
    <select
        wire:model="porte_veiculo"
        class="block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mb-2"
    >
        <option value="">Selecione o porte do veículo</option>
        <option value="baixo">Pequeno</option>
        <option value="medio">Médio</option>
        <option value="grande">Grande</option>
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

    <x-input-error :messages="$errors->get('titulo')" class="mt-2" />
    <x-input-error :messages="$errors->get('descricao')" class="mt-2" />
    <x-input-error :messages="$errors->get('inicio')" class="mt-2" />
    <x-input-error :messages="$errors->get('destino')" class="mt-2" />
    <x-input-error :messages="$errors->get('porte_veiculo')" class="mt-2" />
    <x-input-error :messages="$errors->get('carga')" class="mt-2" />
    <x-input-error :messages="$errors->get('percurso')" class="mt-2" />

    <x-primary-button class="mt-4">{{ __('Salvar') }}</x-primary-button>
</form>

