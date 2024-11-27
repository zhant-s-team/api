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

                    <div class="mt-4 sm:flex sm:items-center sm:gap-2">
                        <div class="flex items-center gap-1 text-gray-500">
                            <svg
                                class="size-4"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"
                                ></path>
                            </svg>

                            <p class="text-xs font-medium">{{ __('Última atualização: ') }}{{ $entrega->updated_at->format('d/m/Y H:i') }}</p>
                        </div>

                        <!-- Botões de ação -->
                       <!-- Botões de ação -->
                       <div class="mt-4 flex gap-2">
                        <a href="{{ route('entregas.edit', $entrega->id) }}" >
                        <button
                            class="px-4 py-2 text-sm font-medium text-white bg-blue-500 rounded hover:bg-blue-600"
                            wire:click="edit({{ $entrega->id }})"
                        >
                            {{ __('Editar') }}
                        </button>
                        </a>
                        <button
                            class="px-4 py-2 text-sm font-medium text-white bg-red-500 rounded hover:bg-red-600"
                            wire:click="delete({{ $entrega->id }})"
                        >
                            {{ __('Excluir') }}
                        </button>
                    </div>
                    </div>
                </div>
            </div>
        </article>
    @endforeach
</div>
