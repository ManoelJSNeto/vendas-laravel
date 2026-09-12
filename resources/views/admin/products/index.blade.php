<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h2 class="text-2xl font-bold tracking-tight text-slate-900 dark:text-white">
                    Painel Admin — Produtos
                </h2>
                <p class="text-sm text-slate-500 dark:text-slate-400 mt-0.5">
                    Gerencie o catálogo de produtos e estoques
                </p>
            </div>
            <div>
                <a href="{{ route('admin.products.create') }}" class="inline-flex items-center gap-1.5 px-4 py-2 text-sm font-semibold rounded-lg text-white bg-slate-900 dark:bg-slate-100 dark:text-slate-900 hover:bg-slate-800 dark:hover:bg-white shadow-sm transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                    </svg>
                    <span>Novo Produto</span>
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

            @if (session('status'))
                <div class="flex items-center gap-2 p-4 text-sm font-medium text-emerald-800 dark:text-emerald-300 bg-emerald-50 dark:bg-emerald-950/40 border border-emerald-200 dark:border-emerald-800/60 rounded-xl">
                    <svg class="w-5 h-5 text-emerald-600 dark:text-emerald-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span>{{ session('status') }}</span>
                </div>
            @endif

            <div class="bg-white dark:bg-slate-900 rounded-xl border border-slate-200/80 dark:border-slate-800 shadow-sm overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left">
                        <thead class="bg-slate-50 dark:bg-slate-800/60 text-slate-500 dark:text-slate-400 border-b border-slate-200 dark:border-slate-800 text-xs uppercase tracking-wider">
                            <tr>
                                <th class="py-3.5 px-4 font-semibold w-16">Imagem</th>
                                <th class="py-3.5 px-4 font-semibold">Nome</th>
                                <th class="py-3.5 px-4 font-semibold">Categoria</th>
                                <th class="py-3.5 px-4 font-semibold">Preço</th>
                                <th class="py-3.5 px-4 font-semibold">Estoque</th>
                                <th class="py-3.5 px-4 font-semibold text-right">Ações</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                            @forelse ($products as $product)
                                <tr class="hover:bg-slate-50/70 dark:hover:bg-slate-800/30 transition-colors">
                                    <td class="py-3 px-4">
                                        @if ($product->image_path)
                                            <img src="{{ Storage::url($product->image_path) }}" alt="{{ $product->name }}" class="w-12 h-12 object-cover rounded-lg border border-slate-200 dark:border-slate-700 bg-slate-100 dark:bg-slate-800">
                                        @else
                                            <div class="w-12 h-12 bg-slate-100 dark:bg-slate-800 rounded-lg flex items-center justify-center text-slate-400 border border-slate-200 dark:border-slate-700">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.75">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v12a1.5 1.5 0 001.5 1.5zm10.5-11.25h.008v.008h-.008V8.25zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" />
                                                </svg>
                                            </div>
                                        @endif
                                    </td>
                                    <td class="py-3 px-4 font-semibold text-slate-900 dark:text-white">
                                        {{ $product->name }}
                                    </td>
                                    <td class="py-3 px-4">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-300">
                                            {{ $product->category->name ?? 'Sem categoria' }}
                                        </span>
                                    </td>
                                    <td class="py-3 px-4 font-bold text-slate-900 dark:text-white whitespace-nowrap">
                                        R$ {{ number_format($product->price, 2, ',', '.') }}
                                    </td>
                                    <td class="py-3 px-4 whitespace-nowrap">
                                        <span @class([
                                            'inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium',
                                            'bg-emerald-100 text-emerald-800 dark:bg-emerald-950/60 dark:text-emerald-300' => $product->stock > 5,
                                            'bg-amber-100 text-amber-800 dark:bg-amber-950/60 dark:text-amber-300' => $product->stock > 0 && $product->stock <= 5,
                                            'bg-rose-100 text-rose-800 dark:bg-rose-950/60 dark:text-rose-300' => $product->stock == 0,
                                        ])>
                                            {{ $product->stock }} un.
                                        </span>
                                    </td>
                                    <td class="py-3 px-4 text-right whitespace-nowrap">
                                        <div class="inline-flex items-center gap-3">
                                            <a href="{{ route('admin.products.edit', $product) }}" class="text-xs font-semibold text-navy-600 dark:text-navy-400 hover:text-navy-800 dark:hover:text-navy-300 transition-colors">
                                                Editar
                                            </a>
                                            <form method="POST" action="{{ route('admin.products.destroy', $product) }}" class="inline"
                                                onsubmit="return confirm('Tem certeza que deseja excluir este produto?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-xs font-semibold text-rose-600 dark:text-rose-400 hover:text-rose-800 dark:hover:text-rose-300 transition-colors">
                                                    Excluir
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="py-8 text-center text-slate-500 dark:text-slate-400">
                                        Nenhum produto cadastrado no catálogo.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>