<div class="container-fluid">
        <!-- Caixa com "Rotas Disponíveis" -->
        <div class="row mt-3">
            <div class="col-12">
                <div class="text-center p-3" style="background-color: #FFF9BF; height: 120px; line-height: 120px; width: 100%; font-size: 2rem;">
                    <strong>Rotas Disponíveis</strong>
                </div>
            </div>
        </div><div class="text-center mt-3">
            <a href="{{ route('entregas') }}" class="btn btn-primary">Criar Nova Entrega</a>
        </div>
        <!-- Fim da Caixa com "Rotas Disponíveis" -->
        <livewire:entregas.list />

    </div>
