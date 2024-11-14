@vite('resources/css/app.css')

<main class="grid min-h-full place-items-center bg-white px-6 py-24 sm:py-32 lg:px-8">
  <div class="text-center">
    <p class="text-base font-semibold text-indigo-600">Erro: 404</p>
    <h1 class="mt-4 text-balance text-5xl font-semibold tracking-tight text-gray-900 sm:text-7xl">Pagina não encontrada</h1>
    <p class="mt-6 text-pretty text-lg font-medium text-gray-500 sm:text-xl/8">A pagina que você está procurando não foi encontrada.</p>
    <div class="mt-10 flex items-center justify-center gap-x-6">
    <a href="{{ url('/dashboard') }}"
   class="rounded-md bg-indigo-600 px-7 py-5 text-lg font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
   Voltar ao Dashboard</a>
    </div>
  </div>
</main>
