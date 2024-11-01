<div class="max-w-2xl mx-auto p-4 sm:p-6 lg:p-8">
    <form method="POST" action="{{ route('empresas.store') }}">
        @csrf
        <!-- Campo CNPJ -->
        <div>
            <label for="cnpj">CNPJ</label>
            <input type="text" id="cnpj" name="cnpj" required>
        </div>

        <!-- Campo Nome -->
        <div>
            <label for="nome">Nome</label>
            <input type="text" id="nome" name="nome" required>
        </div>

        <!-- Campo Rua -->
        <div>
            <label for="rua">Rua</label>
            <input type="text" id="rua" name="rua" required>
        </div>

        <!-- Campo Bairro -->
        <div>
            <label for="bairro">Bairro</label>
            <input type="text" id="bairro" name="bairro" required>
        </div>

        <!-- Campo Número -->
        <div>
            <label for="numero">Número</label>
            <input type="number" id="numero" name="numero" required>
        </div>

        <!-- Campo Logo -->
        <div>
            <label for="logo">Logo</label>
            <input type="text" id="logo" name="logo">
        </div>

        <button type="submit">Criar Empresa</button>
    </form>
</div>
