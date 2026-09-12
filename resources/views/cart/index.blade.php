<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-slate-900 dark:text-white leading-tight">
            Meu Carrinho
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">

            @if (session('status'))
                <div class="mb-6 p-4 bg-amber-50 dark:bg-amber-950/40 border border-amber-200 dark:border-amber-800 text-amber-800 dark:text-amber-300 rounded-xl text-sm flex items-center gap-3">
                    <svg class="w-5 h-5 shrink-0 text-amber-600 dark:text-amber-400" fill="none" stroke="currentColor" stroke-width="1.75" viewBox="0 0 24 24">
                        <circle cx="12" cy="12" r="10"></circle>
                        <line x1="12" y1="8" x2="12" y2="12"></line>
                        <line x1="12" y1="16" x2="12.01" y2="16"></line>
                    </svg>
                    <span>{{ session('status') }}</span>
                </div>
            @endif

            <div class="mb-6">
                <a href="{{ route('products.index') }}" class="inline-flex items-center gap-2 text-sm font-medium text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.75" viewBox="0 0 24 24">
                        <path d="M19 12H5M12 19l-7-7 7-7"></path>
                    </svg>
                    <span>Continuar comprando</span>
                </a>
            </div>

            @if ($items->isEmpty())
                <div class="bg-white dark:bg-slate-900 border border-slate-200/80 dark:border-slate-800 rounded-xl p-12 text-center shadow-xs">
                    <div class="w-16 h-16 mx-auto mb-4 rounded-full bg-slate-100 dark:bg-slate-800 flex items-center justify-center text-slate-400">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" stroke-width="1.75" viewBox="0 0 24 24">
                            <circle cx="9" cy="21" r="1"></circle>
                            <circle cx="20" cy="21" r="1"></circle>
                            <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path>
                        </svg>
                    </div>
                    <h3 class="text-base font-semibold text-slate-900 dark:text-white">Seu carrinho está vazio</h3>
                    <p class="text-sm text-slate-500 dark:text-slate-400 mt-1 mb-6">Explore o catálogo e adicione os itens que desejar.</p>
                    <a href="{{ route('products.index') }}" class="inline-flex items-center gap-2 px-5 py-2.5 bg-slate-900 dark:bg-slate-100 text-white dark:text-slate-900 text-sm font-medium rounded-lg hover:bg-slate-800 dark:hover:bg-white transition-colors shadow-xs">
                        Explorar produtos
                    </a>
                </div>
            @else
                <div class="bg-white dark:bg-slate-900 border border-slate-200/80 dark:border-slate-800 rounded-xl shadow-xs overflow-hidden divide-y divide-slate-100 dark:divide-slate-800">
                    @foreach ($items as $item)
                        <div class="p-5 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                            <div class="flex-1 min-w-0">
                                <h3 class="font-semibold text-base text-slate-900 dark:text-white">{{ $item->product->name }}</h3>
                                <p class="text-sm text-slate-500 dark:text-slate-400 mt-0.5">
                                    Valor unitário: R$ {{ number_format($item->product->price, 2, ',', '.') }}
                                </p>
                            </div>

                            <div class="flex items-center justify-between sm:justify-end gap-6">
                                <form method="POST" action="{{ route('cart.update', $item) }}" class="flex items-center gap-2">
                                    @csrf
                                    @method('PATCH')
                                    <label class="text-xs font-medium uppercase tracking-wider text-slate-500 dark:text-slate-400">Qtd:</label>
                                    <input type="number" name="quantity" value="{{ $item->quantity }}" min="1"
                                        onchange="this.form.submit()"
                                        class="w-16 rounded-lg border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-900 text-slate-900 dark:text-slate-100 text-sm py-1.5 focus:border-slate-900 dark:focus:border-slate-300 focus:ring-1 focus:ring-slate-900 dark:focus:ring-slate-300 transition-colors" />
                                </form>

                                <p class="w-28 text-right font-bold text-base text-slate-900 dark:text-white">
                                    R$ {{ number_format($item->subtotal(), 2, ',', '.') }}
                                </p>

                                <form method="POST" action="{{ route('cart.remove', $item) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" title="Remover item" class="p-2 text-slate-400 hover:text-rose-600 dark:hover:text-rose-400 rounded-lg hover:bg-rose-50 dark:hover:bg-rose-950/30 transition-colors cursor-pointer">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.75" viewBox="0 0 24 24">
                                            <polyline points="3 6 5 6 21 6"></polyline>
                                            <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                                            <line x1="10" y1="11" x2="10" y2="17"></line>
                                            <line x1="14" y1="11" x2="14" y2="17"></line>
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="mt-6 bg-white dark:bg-slate-900 border border-slate-200/80 dark:border-slate-800 rounded-xl p-5 shadow-xs flex items-center justify-between">
                    <div>
                        <span class="text-xs font-semibold uppercase tracking-wider text-slate-500 dark:text-slate-400 block">Total do Pedido</span>
                        <span class="text-sm text-slate-500 dark:text-slate-400">Subtotal com tributos inclusos</span>
                    </div>
                    <span class="text-2xl font-bold text-emerald-600 dark:text-emerald-400">
                        R$ {{ number_format($total, 2, ',', '.') }}
                    </span>
                </div>

                <div class="mt-6 flex justify-end">
                    <a href="{{ route('orders.create') }}" class="inline-flex items-center justify-center gap-2 bg-slate-900 dark:bg-slate-100 text-white dark:text-slate-900 text-sm font-semibold px-6 py-3 rounded-lg hover:bg-slate-800 dark:hover:bg-white shadow-xs transition-colors cursor-pointer">
                        <span>Finalizar Compra</span>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.75" viewBox="0 0 24 24">
                            <path d="M5 12h14M12 5l7 7-7 7"></path>
                        </svg>
                    </a>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>