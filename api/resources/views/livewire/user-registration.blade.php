<form wire:submit.prevent="registerUser" class="space-y-6 p-6 bg-white shadow-md rounded-lg">
    <!-- Nome -->
    <div>
        <label for="name" class="block text-sm font-semibold text-gray-700">Nome</label>
        <input type="text" wire:model="name" id="name" required
            class="w-full px-4 py-2 mt-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none">
        @error('name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
    </div>

    <!-- E-mail -->
    <div>
        <label for="email" class="block text-sm font-semibold text-gray-700">E-mail</label>
        <input type="email" wire:model="email" id="email" required
            class="w-full px-4 py-2 mt-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none">
        @error('email') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
    </div>

    <!-- Senha -->
    <div>
        <label for="password" class="block text-sm font-semibold text-gray-700">Senha</label>
        <input type="password" wire:model="password" id="password" required
            class="w-full px-4 py-2 mt-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none">
        @error('password') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
    </div>

    <!-- Confirmação de Senha -->
    <div>
        <label for="password_confirmation" class="block text-sm font-semibold text-gray-700">Confirme a Senha</label>
        <input type="password" wire:model="password_confirmation" id="password_confirmation" required
            class="w-full px-4 py-2 mt-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none">
        @error('password_confirmation') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
    </div>

    <!-- Botão de envio -->
    <button type="submit" class="w-full py-3 mt-4 text-white bg-blue-500 hover:bg-blue-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
        Cadastrar Usuário
    </button>

    @if (session()->has('message'))
        <div class="mt-4 text-green-500">{{ session('message') }}</div>
    @endif
</form>
