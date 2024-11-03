<?php

use App\Models\Entrega;
use Livewire\Attributes\Validate;
use Livewire\Volt\Component;

new class extends Component {
    public Entrega $entrega;

    #[Validate('required')]
    public string $titulo = '';
    #[Validate('required|string')]
    public string $descricao = '';
    #[Validate('required|string')]
    public string $inicio = '';
    #[Validate('required|string')]
    public string $destino = '';
    #[Validate('required')]
    public string $porte_veiculo = '';
    #[Validate('required')]
    public string $carga = '';
    #[Validate('required')]
    public string $percurso = '';

    public function mount(Entrega $entrega): void
    {
        $this->entrega = $entrega;
        $this->titulo = $entrega->titulo ?? '';
        $this->descricao = $entrega->descricao ?? '';
        $this->inicio = $entrega->inicio ?? '';
        $this->destino = $entrega->destino ?? '';
        $this->porte_veiculo = $entrega->porte_veiculo ?? '';
        $this->carga = $entrega->carga ?? '';
        $this->percurso = $entrega->percurso ?? '';
    }

    public function update(): void
    {
        $this->authorize('update', $this->entrega);

        $validated = $this->validate();

        $this->entrega->update($validated);

        $this->dispatch('entrega-updated');
    }

    public function cancel(): void
    {
        $this->dispatch('entrega-edit-canceled');
    }
}; ?>

<div>
    <form wire:submit="update">
        <label for="titulo" class="block font-medium text-sm text-gray-700">Título</label>
        <textarea
            id="titulo"
            wire:model="titulo"
            class="block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
        ></textarea>

        <label for="descricao" class="block font-medium text-sm text-gray-700">Descrição</label>
        <textarea
            id="descricao"
            wire:model="descricao"
            class="block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
        ></textarea>

        <label for="inicio" class="block font-medium text-sm text-gray-700">Início</label>
        <textarea
            id="inicio"
            wire:model="inicio"
            class="block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
        ></textarea>

        <label for="destino" class="block font-medium text-sm text-gray-700">Destino</label>
        <textarea
            id="destino"
            wire:model="destino"
            class="block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
        ></textarea>

        <label for="porte_veiculo" class="block font-medium text-sm text-gray-700">Porte do Veículo</label>
        <textarea
            id="porte_veiculo"
            wire:model="porte_veiculo"
            class="block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
        ></textarea>

        <label for="carga" class="block font-medium text-sm text-gray-700">Carga</label>
        <textarea
            id="carga"
            wire:model="carga"
            class="block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
        ></textarea>

        <label for="percurso" class="block font-medium text-sm text-gray-700">Percurso</label>
        <textarea
            id="percurso"
            wire:model="percurso"
            class="block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
        ></textarea>

        <x-input-error :messages="$errors->get('titulo')" class="mt-2" />
        <x-input-error :messages="$errors->get('descricao')" class="mt-2" />
        <x-input-error :messages="$errors->get('inicio')" class="mt-2" />
        <x-input-error :messages="$errors->get('destino')" class="mt-2" />
        <x-input-error :messages="$errors->get('porte_veiculo')" class="mt-2" />
        <x-input-error :messages="$errors->get('carga')" class="mt-2" />
        <x-input-error :messages="$errors->get('percurso')" class="mt-2" />

        <x-primary-button class="mt-4">{{ __('Save') }}</x-primary-button>
        <button class="mt-4" wire:click.prevent="cancel">Cancel</button>
    </form>
</div>

