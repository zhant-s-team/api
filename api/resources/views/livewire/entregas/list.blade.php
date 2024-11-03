<?php

use App\Models\Entrega;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Volt\Component;
use Livewire\Attributes\On;
use App\Enum\TipoCarro;

new class extends Component {
    public Collection $entregas;
    public ?Entrega $editing = null;

    public function mount(): void
    {
        $this->getEntregas();
    }

    #[On('entrega-created')]
    public function getEntregas(): void
    {
        $this->entregas = Entrega::with('user')
            ->latest()
            ->get();
    }

    public function edit(Entrega $entrega): void
    {
        $this->editing = $entrega;
        // Não precisa chamar getEntregas aqui, pois já temos as entregas carregadas
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
    <div class="mt-6 bg-white shadow-sm rounded-lg divide-y">
        @foreach ($entregas as $entrega)
            <div class="p-6 flex space-x-2" wire:key="{{ $entrega->id }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-600 -scale-x-100" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                </svg>
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
                        <p class="mt-4 text-lg text-gray-900">Porte do veículo: {{ $entrega->tipo_veiculo }}</p>
                        <p class="mt-4 text-lg text-gray-900">Carga: {{ $entrega->carga }}</p>
                        <p class="mt-4 text-lg text-gray-900">Percurso em km: {{ $entrega->percurso }}</p>
                    @endif
                </div>
            </div>
        @endforeach
    </div>
</div>

