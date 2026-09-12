<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h2 class="font-bold text-2xl text-slate-900 dark:text-white leading-tight">
                    Catálogo de Produtos
                </h2>
                <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">Explore os produtos disponíveis em nossa loja</p>
            </div>
            <div>
                <a href="{{ route('cart.index') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-lg text-sm font-medium text-slate-700 dark:text-slate-200 hover:bg-slate-50 dark:hover:bg-slate-750 shadow-xs transition-colors">
                    <svg class="w-4 h-4 text-slate-500 dark:text-slate-400" fill="none" stroke="currentColor" stroke-width="1.75" viewBox="0 0 24 24">
                        <circle cx="9" cy="21" r="1"></circle>
                        <circle cx="20" cy="21" r="1"></circle>
                        <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path>
                    </svg>
                    <span>Ver Carrinho</span>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.75" viewBox="0 0 24 24">
                        <path d="M5 12h14M12 5l7 7-7 7"></path>
                    </svg>
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            @if (session('status'))
                <div class="mb-6 p-4 bg-emerald-50 dark:bg-emerald-950/40 border border-emerald-200 dark:border-emerald-800 text-emerald-800 dark:text-emerald-300 rounded-xl text-sm flex items-center gap-3">
                    <svg class="w-5 h-5 shrink-0 text-emerald-600 dark:text-emerald-400" fill="none" stroke="currentColor" stroke-width="1.75" viewBox="0 0 24 24">
                        <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                        <polyline points="22 4 12 14.01 9 11.01"></polyline>
                    </svg>
                    <span>{{ session('status') }}</span>
                </div>
            @endif

            <!-- Filtros e Busca -->
            <form method="GET" action="{{ route('products.index') }}" class="mb-8 bg-white dark:bg-slate-900 p-5 rounded-xl border border-slate-200/80 dark:border-slate-800 shadow-xs flex flex-wrap gap-4 items-end">
                <div class="flex-1 min-w-[220px]">
                    <label class="block text-xs font-semibold uppercase tracking-wider text-slate-500 dark:text-slate-400 mb-1.5">Buscar</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none text-slate-400">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.75" viewBox="0 0 24 24">
                                <circle cx="11" cy="11" r="8"></circle>
                                <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                            </svg>
                        </div>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Nome do produto..."
                            class="w-full ps-9 rounded-lg border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-900 text-slate-900 dark:text-slate-100 text-sm focus:border-slate-900 dark:focus:border-slate-300 focus:ring-1 focus:ring-slate-900 dark:focus:ring-slate-300 placeholder:text-slate-400 transition-colors" />
                    </div>
                </div>

                <div class="w-full sm:w-56">
                    <label class="block text-xs font-semibold uppercase tracking-wider text-slate-500 dark:text-slate-400 mb-1.5">Categoria</label>
                    <select name="category_id" class="w-full rounded-lg border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-900 text-slate-900 dark:text-slate-100 text-sm focus:border-slate-900 dark:focus:border-slate-300 focus:ring-1 focus:ring-slate-900 dark:focus:ring-slate-300 transition-colors">
                        <option value="">Todas as categorias</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}" @selected(request('category_id') == $category->id)>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="flex items-center gap-3">
                    <button type="submit" class="inline-flex items-center gap-2 bg-slate-900 dark:bg-slate-100 text-white dark:text-slate-900 text-sm font-medium px-4 py-2.5 rounded-lg hover:bg-slate-800 dark:hover:bg-white shadow-xs transition-colors cursor-pointer">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.75" viewBox="0 0 24 24">
                            <polygon points="22 3 2 3 10 12.46 10 19 14 21 14 12.46 22 3"></polygon>
                        </svg>
                        <span>Filtrar</span>
                    </button>

                    @if (request('search') || request('category_id'))
                        <a href="{{ route('products.index') }}" class="text-sm font-medium text-slate-500 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white transition-colors">
                            Limpar filtros
                        </a>
                    @endif
                </div>
            </form>

            @if ($products->isEmpty())
                <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-xl p-12 text-center">
                    <div class="w-12 h-12 mx-auto mb-3 rounded-full bg-slate-100 dark:bg-slate-800 flex items-center justify-center text-slate-400">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="1.75" viewBox="0 0 24 24">
                            <circle cx="11" cy="11" r="8"></circle>
                            <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                        </svg>
                    </div>
                    <h3 class="text-base font-semibold text-slate-900 dark:text-white">Nenhum produto encontrado</h3>
                    <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">Tente ajustar seus termos de busca ou filtros.</p>
                </div>
            @else
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach ($products as $product)
                        <div class="bg-white dark:bg-slate-900 border border-slate-200/80 dark:border-slate-800 rounded-xl overflow-hidden shadow-xs hover:shadow-md transition-all flex flex-col justify-between">
                            <div>
                                <div class="relative bg-slate-100 dark:bg-slate-800">
                                    @if ($product->image_path)
                                        <img src="{{ Storage::url($product->image_path) }}" alt="{{ $product->name }}" class="w-full h-48 object-cover">
                                    @else
                                        <div class="w-full h-48 flex flex-col items-center justify-center text-slate-400">
                                            <svg class="w-10 h-10 mb-1" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                                <rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect>
                                                <circle cx="8.5" cy="8.5" r="1.5"></circle>
                                                <polyline points="21 15 16 10 5 21"></polyline>
                                            </svg>
                                            <span class="text-xs">Sem imagem</span>
                                        </div>
                                    @endif
                                </div>

                                <div class="p-5">
                                    <span class="inline-block text-xs font-semibold px-2 py-0.5 rounded bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-300 mb-2">
                                        {{ $product->category->name ?? 'Sem categoria' }}
                                    </span>
                                    <h3 class="text-base font-bold text-slate-900 dark:text-white line-clamp-1">{{ $product->name }}</h3>
                                    <p class="text-sm text-slate-600 dark:text-slate-400 mt-1 mb-4 line-clamp-2">{{ $product->description }}</p>
                                </div>
                            </div>

                            <div class="p-5 pt-0 border-t border-slate-100 dark:border-slate-800/60 mt-auto">
                                <div class="flex items-baseline justify-between pt-4 mb-4">
                                    <span class="text-xs text-slate-500 dark:text-slate-400">Preço à vista</span>
                                    <span class="text-xl font-bold text-emerald-600 dark:text-emerald-400">
                                        R$ {{ number_format($product->price, 2, ',', '.') }}
                                    </span>
                                </div>

                                <form method="POST" action="{{ route('cart.add', $product) }}">
                                    @csrf
                                    <button type="submit" class="w-full inline-flex items-center justify-center gap-2 bg-slate-900 dark:bg-slate-100 text-white dark:text-slate-900 text-sm font-medium py-2.5 rounded-lg hover:bg-slate-800 dark:hover:bg-white shadow-xs transition-colors cursor-pointer">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.75" viewBox="0 0 24 24">
                                            <circle cx="9" cy="21" r="1"></circle>
                                            <circle cx="20" cy="21" r="1"></circle>
                                            <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path>
                                        </svg>
                                        <span>Adicionar ao carrinho</span>
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</x-app-layout>