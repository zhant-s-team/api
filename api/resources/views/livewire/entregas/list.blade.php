<?php

use App\Models\Entrega;
use App\Models\Empresa;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Volt\Component;
use Livewire\Attributes\On;

new class extends Component {
    public Collection $entregas;
    public Collection $empresas;
    public array $cidadesOrigem;
    public array $tiposVeiculo = ['BITREM', 'RODOTREM', 'CAVALO MECÂNICO', 'TOCO', 'TRUCK'];  // Tipos de veículo disponíveis
    public ?int $empresaId = null;
    public ?string $cidadeOrigem = null;
    public ?string $tipoVeiculo = null;  // Propriedade para armazenar o tipo de veículo selecionado
    public ?Entrega $editing = null;

    public function mount(): void
    {
        $this->empresas = Empresa::all();
        $this->cidadesOrigem = Entrega::distinct()->pluck('cidade_origem')->toArray();
        $this->getEntregas();
    }

    #[On('entrega-created')]
    public function getEntregas(): void
    {
        $query = Entrega::with('user');

        // Filtro por empresa
        if ($this->empresaId) {
            $query->where('empresa_id', $this->empresaId);
        }

        // Filtro por cidade de origem
        if ($this->cidadeOrigem) {
            $query->where('cidade_origem', $this->cidadeOrigem);
        }

        // Filtro por tipo de veículo
        if ($this->tipoVeiculo) {
            $query->where('tipo_veiculo', $this->tipoVeiculo);
        }

        $this->entregas = $query->latest()->get();
    }

    public function edit(Entrega $entrega): void
    {
        $this->editing = $entrega;
    }

    #[On('entrega-edit-canceled')]
    #[On('entrega-updated')]
    public function disableEditing(): void
    {
        $this->editing = null;
        $this->getEntregas();
    }

    public function delete(Entrega $entrega): void
    {
        $this->authorize('delete', $entrega);
        $entrega->delete();
        $this->getEntregas();
    }
};
?>

<div>
    <!-- Filtros alinhados em uma linha -->
    <div class="flex space-x-4 mb-4">
        <!-- Campo de seleção de empresa -->
        <div>
            <label for="empresaId" class="block text-gray-700">Selecionar Empresa:</label>
            <select wire:model="empresaId" id="empresaId" class="form-select mt-1 block w-full" wire:change="getEntregas">
                <option value="">Todas as Empresas</option>
                @foreach($empresas as $empresa)
                    <option value="{{ $empresa->id }}">{{ $empresa->nome }}</option>
                @endforeach
            </select>
        </div>

        <!-- Campo de seleção da cidade de origem -->
        <div>
            <label for="cidadeOrigem" class="block text-gray-700">Selecionar Cidade de Origem:</label>
            <select wire:model="cidadeOrigem" id="cidadeOrigem" class="form-select mt-1 block w-full" wire:change="getEntregas">
                <option value="">Todas as Cidades</option>
                @foreach($cidadesOrigem as $cidade)
                    <option value="{{ $cidade }}">{{ $cidade }}</option>
                @endforeach
            </select>
        </div>

        <!-- Campo de seleção do tipo de veículo -->
        <div>
            <label for="tipoVeiculo" class="block text-gray-700">Selecionar Tipo de Veículo:</label>
            <select wire:model="tipoVeiculo" id="tipoVeiculo" class="form-select mt-1 block w-full" wire:change="getEntregas">
                <option value="">Todos os Tipos de Veículo</option>
                @foreach($tiposVeiculo as $tipo)
                    <option value="{{ $tipo }}">{{ $tipo }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <!-- Lista de entregas filtradas -->
    <div class="mt-6 bg-white shadow-sm rounded-lg divide-y">
        @foreach ($entregas as $entrega)
            <div class="p-6 flex space-x-2" wire:key="{{ $entrega->id }}">
                <div class="flex-1">
                    <div class="flex justify-between items-center">
                        <div>
                            <span class="text-gray-800">{{ $entrega->empresa->nome }}</span>
                            <small class="ml-2 text-sm text-gray-600">{{ $entrega->created_at->format('j M Y, g:i a') }}</small>
                            @unless ($entrega->created_at->eq($entrega->updated_at))
                                <small class="text-sm text-gray-600"> &middot; {{ __('edited') }}</small>
                            @endunless
                        </div>
                        @if ($entrega->user->is(auth()->user()))
                            <x-dropdown>
                                <x-slot name="trigger">
                                    <button>
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                                            <path d="M6 10a2 2 0 11-4 0 2 2 0 014 0zM12 10a2 2 0 11-4 0 2 2 0 014 0zM16 12a2 2 0 100-4 2 2 0 000 4z" />
                                        </svg>
                                    </button>
                                </x-slot>
                                <x-slot name="content">
                                    <x-dropdown-link wire:click="edit({{ $entrega->id }})">
                                        {{ __('Edit') }}
                                    </x-dropdown-link>
                                    <x-dropdown-link wire:click="delete({{ $entrega->id }})" wire:confirm="Are you sure to delete this entrega?">
                                        {{ __('Delete') }}
                                    </x-dropdown-link>
                                </x-slot>
                            </x-dropdown>
                        @endif
                    </div>
                    @if ($entrega->is($editing))
                        <livewire:entregas.edit :entrega="$entrega" :key="$entrega->id" />
                    @else
                        <p class="mt-4 text-lg text-gray-900">{{ $entrega->titulo }}</p>
                        <p class="mt-4 text-lg text-gray-900">{{ $entrega->descricao }}</p>
                        <p class="mt-4 text-lg text-gray-900">Cidade inicial: {{ $entrega->cidade_origem }}</p>
                        <p class="mt-4 text-lg text-gray-900">Cidade destino: {{ $entrega->cidade_destino }}</p>
                        <p class="mt-4 text-lg text-gray-900">Tipo de Veículo: {{ $entrega->tipo_veiculo->label() }}</p>
                        <p class="mt-4 text-lg text-gray-900">Carga: {{ $entrega->carga }}</p>
                        <p class="mt-4 text-lg text-gray-900">Percurso em km: {{ $entrega->percurso }}</p>
                    @endif
                </div>
            </div>
        @endforeach
    </div>
</div>
