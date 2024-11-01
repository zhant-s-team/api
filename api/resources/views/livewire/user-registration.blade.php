<form wire:submit.prevent="registerDriver">
    <div>
        <label for="name">Nome</label>
        <input type="text" wire:model="name" required>
        @error('name') <span>{{ $message }}</span> @enderror
    </div>

    <div>
        <label for="email">E-mail</label>
        <input type="email" wire:model="email" required>
        @error('email') <span>{{ $message }}</span> @enderror
    </div>

    <div>
        <label for="password">Senha</label>
        <input type="password" wire:model="password" required>
        @error('password') <span>{{ $message }}</span> @enderror
    </div>

    <div>
        <label for="password_confirmation">Confirme a Senha</label>
        <input type="password" wire:model="password_confirmation" required>
        @error('password_confirmation') <span>{{ $message }}</span> @enderror
    </div>

    <div>
        <label for="cnh">CNH</label>
        <input type="text" wire:model="cnh" required>
        @error('cnh') <span>{{ $message }}</span> @enderror
    </div>

    <button type="submit">Cadastrar Motorista</button>

    @if (session()->has('message'))
        <div>{{ session('message') }}</div>
    @endif
</form>
