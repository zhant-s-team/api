<?php

namespace App\Http\Livewire;

use App\Models\Entrega;
use App\Models\Empresa;
use App\Enum\TipoCarro; // Certifique-se de importar sua enum
use Illuminate\Database\Eloquent\Collection;
use Livewire\Volt\Component;
use Livewire\Attributes\On;

new class extends Component {
    public Collection $entregas;
    public Collection $empresas;
    public array $cidadesOrigem;
    public array $tiposVeiculo;
    public array $statusOptions = ['Pendente', 'Em andamento', 'Concluída']; // Exemplo de opções de status
    public ?int $empresaId = null;
    public ?string $cidadeOrigem = null;
    public ?string $tipoVeiculo = null;
    public ?string $status = null; // Filtro de status
    public ?Entrega $editing = null;

    public function mount(): void
    {
        $this->empresas = Empresa::all();
        $this->cidadesOrigem = Entrega::distinct()->pluck('cidade_origem')->toArray();
        $this->tiposVeiculo = TipoCarro::cases();
        $this->getEntregas();
    }

    #[On('entrega-created')]
    public function getEntregas(): void
    {
        $query = Entrega::with('empresa');

        // Filtros
        if ($this->empresaId) {
            $query->where('empresa_id', $this->empresaId);
        }

        if ($this->cidadeOrigem) {
            $query->where('cidade_origem', $this->cidadeOrigem);
        }

        if ($this->tipoVeiculo) {
            $query->where('tipo_veiculo', $this->tipoVeiculo);
        }

        if ($this->status) {
        $query->where('status', $this->status);
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
        $entrega->delete();
        $this->getEntregas();
    }
};


?>
<div>
    <!-- Formulário de Filtros -->
    <div class="bg-white p-4 rounded-lg shadow-sm">
        <form wire:submit.prevent="getEntregas">
            <div class="flex gap-4">
                <div class="w-1/3">
                    <label for="empresaId" class="block text-sm font-medium text-gray-700">{{ __('Empresa') }}</label>
                    <select id="empresaId" wire:model="empresaId" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm">
                        <option value="">{{ __('Selecione a Empresa') }}</option>
                        @foreach ($empresas as $empresa)
                            <option value="{{ $empresa->id }}">{{ $empresa->nome }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="w-1/3">
                    <label for="cidadeOrigem" class="block text-sm font-medium text-gray-700">{{ __('Cidade de Origem') }}</label>
                    <select id="cidadeOrigem" wire:model="cidadeOrigem" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm">
                        <option value="">{{ __('Selecione a Cidade de Origem') }}</option>
                        @foreach ($cidadesOrigem as $cidade)
                            <option value="{{ $cidade }}">{{ $cidade }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="w-1/3">
                    <label for="tipoVeiculo" class="block text-sm font-medium text-gray-700">{{ __('Tipo de Veículo') }}</label>
                    <select id="tipoVeiculo" wire:model="tipoVeiculo" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm">
                        <option value="">{{ __('Selecione o Tipo de Veículo') }}</option>
                        @foreach ($tiposVeiculo as $tipo)
                            <option value="{{ $tipo->value }}">{{ $tipo->label() }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Novo campo para filtro de status -->
                <div class="w-1/3">
                    <label for="status" class="block text-sm font-medium text-gray-700">{{ __('Status') }}</label>
                    <select id="status" wire:model="status" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm">
                        <option value="">{{ __('Selecione o Status') }}</option>
                        @foreach (\App\Enum\EntregaStatus::cases() as $statusOption)
                            <option value="{{ $statusOption->value }}">{{ $statusOption->label() }}</option>
                        @endforeach
                    </select>
                </div>

            <div class="mt-4 flex justify-end">
                <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
                    {{ __('Filtrar') }}
                </button>
            </div>
        </form>
    </div>

    <!-- Lista de Entregas -->
    <div class="mt-6 bg-white shadow-sm rounded-lg divide-y">
        @foreach ($entregas as $entrega)
            <article class="rounded-xl bg-white p-4 ring ring-indigo-50 sm:p-6 lg:p-8" wire:key="{{ $entrega->id }}">
                <div class="flex items-start sm:gap-8">
                    <div class="hidden sm:grid sm:w-20 sm:h-20 sm:shrink-0 sm:rounded-full sm:border-2 sm:border-indigo-500 overflow-hidden" aria-hidden="true">
                        @if($entrega->empresa->logo)
                            <img src="{{ $entrega->empresa->logo }}" alt="Logo da Empresa" class="w-full h-full object-cover rounded-full">
                        @else
                            <span class="text-gray-400 flex items-center justify-center w-full h-full">Sem logo</span> <!-- Caso a empresa não tenha logo -->
                        @endif
                    </div>

                    <div>
                        <strong class="rounded border border-indigo-500 bg-indigo-500 px-3 py-1.5 text-[10px] font-medium text-white">
                            {{ __('Entrega #') }}{{ $entrega->id }}
                        </strong>

                        <h3 class="mt-4 text-lg font-medium sm:text-xl">
                            {{ $entrega->titulo }}
                        </h3>

                        <p class="mt-1 text-sm text-gray-700">
                            {{ $entrega->descricao }}
                        </p>

                        <p class="mt-1 text-sm text-gray-700">
                            <strong>{{ __('Empresa: ') }}</strong>{{ $entrega->empresa->nome }}
                        </p>
                        <p class="mt-1 text-sm text-gray-700">
                            <strong>{{ __('Cidade Origem: ') }}</strong>{{ $entrega->cidade_origem }}
                        </p>
                        <p class="mt-1 text-sm text-gray-700">
                            <strong>{{ __('Cidade Destino: ') }}</strong>{{ $entrega->cidade_destino }}
                        </p>
                        <p class="mt-1 text-sm text-gray-700">
                            <strong>{{ __('Tipo de Veículo: ') }}</strong>{{ $entrega->tipo_veiculo->label() }}
                        </p>
                        <p class="mt-1 text-sm text-gray-700">
                            <strong>{{ __('Carga: ') }}</strong>{{ $entrega->carga }}
                        </p>
                        <p class="mt-1 text-sm text-gray-700">
                            <strong>{{ __('Percurso (km): ') }}</strong>{{ $entrega->percurso }}
                        </p>
                        <!-- Exibição do status da entrega -->
                        <p class="mt-1 text-sm text-gray-700">
                            <strong>{{ __('Status: ') }}</strong>{{ \App\Enum\EntregaStatus::from($entrega->status->value)->label() }}
                        </p>


                    </div>
                </div>
            </article>
        @endforeach
    </div>
</div>
