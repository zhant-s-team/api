<div class="container-fluid">


        <!-- Caixa com "Rotas Disponíveis" -->
        <div class="row mt-3">
            <div class="col-12">
                <div class="text-center p-3" style="background-color: #FFF9BF; height: 120px; line-height: 120px; width: 100%; font-size: 2rem;">
                    <strong>Rotas Disponíveis</strong>
                </div>
            </div>
        </div>
        <!-- Fim da Caixa com "Rotas Disponíveis" -->
        <livewire:entregas.list />
        <!-- Retângulos de Cargas Disponíveis -->
        <div class="row justify-content-center mt-4">
            <div class="col-md-12">
                <div class="row">
                    <!-- Carga 1 -->
                    <div class="col-md-4 mb-4">
                        <div class="card">
                            <img src="https://via.placeholder.com/300x200" class="card-img-top" alt="Carga 1">
                            <div class="card-body">
                                <h5 class="card-title">Carga 1</h5>
                                <div class="row">
                                    <div class="col-md-6">
                                        <strong>Empresa:</strong> Empresa A<br>
                                        <strong>Cidade:</strong> São Paulo<br>
                                        <strong>Destino:</strong> Rio de Janeiro<br>
                                        <strong>Estado:</strong> RJ<br>
                                    </div>
                                    <div class="col-md-6">
                                        <strong>Tamanho do Percurso:</strong> 450 km<br>
                                        <strong>Porte do Veículo:</strong> Médio<br>
                                        <strong>Tipo de Carga:</strong> Eletrônicos<br>
                                        <strong>Peso da Carga:</strong> 300 kg
                                    </div>
                                </div>
                                <form action="#" method="POST" class="mt-3">
                                    @csrf
                                    <button type="submit" class="btn btn-success">Aceitar Frete</button>
                                </form>
                            </div>
                        </div>
                    </div>
                    <!-- Carga 2 e demais cargas seguem o mesmo padrão... -->
                </div>
            </div>
        </div>
        <!-- Fim dos Retângulos de Cargas Disponíveis -->
    </div>
