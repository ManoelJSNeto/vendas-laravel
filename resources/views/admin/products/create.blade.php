<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-2">
            <a href="{{ route('admin.products.index') }}" class="text-slate-400 hover:text-slate-600 dark:hover:text-slate-300 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
                </svg>
            </a>
            <h2 class="text-2xl font-bold tracking-tight text-slate-900 dark:text-white">
                Novo Produto
            </h2>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
            <form method="POST" action="{{ route('admin.products.store') }}" enctype="multipart/form-data" class="bg-white dark:bg-slate-900 rounded-xl border border-slate-200/80 dark:border-slate-800 shadow-sm p-6 space-y-5">
                @csrf

                <div>
                    <x-input-label for="name" :value="__('Nome do Produto')" />
                    <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name')" required placeholder="Ex: Tênis Esportivo" />
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="category_id" :value="__('Categoria')" />
                    <select id="category_id" name="category_id" class="mt-1 block w-full rounded-lg border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-900 dark:text-slate-100 text-sm focus:border-navy-500 focus:ring-navy-500 transition">
                        <option value="">Sem categoria</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}" @selected(old('category_id') == $category->id)>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                    <x-input-error :messages="$errors->get('category_id')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="description" :value="__('Descrição')" />
                    <textarea id="description" name="description" rows="3" class="mt-1 block w-full rounded-lg border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-900 dark:text-slate-100 text-sm focus:border-navy-500 focus:ring-navy-500 transition" placeholder="Detalhes, especificações e diferenciais do produto">{{ old('description') }}</textarea>
                    <x-input-error :messages="$errors->get('description')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="image" :value="__('Imagem do Produto')" />
                    <input id="image" name="image" type="file" accept="image/*" class="mt-1 block w-full text-sm text-slate-500 dark:text-slate-400 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-slate-100 dark:file:bg-slate-800 file:text-slate-700 dark:file:text-slate-300 hover:file:bg-slate-200 dark:hover:file:bg-slate-700 cursor-pointer" />
                    <x-input-error :messages="$errors->get('image')" class="mt-2" />
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <x-input-label for="price" :value="__('Preço (R$)')" />
                        <x-text-input id="price" name="price" type="number" step="0.01" min="0" class="mt-1 block w-full" :value="old('price')" required placeholder="0.00" />
                        <x-input-error :messages="$errors->get('price')" class="mt-2" />
                    </div>
                    <div>
                        <x-input-label for="stock" :value="__('Estoque')" />
                        <x-text-input id="stock" name="stock" type="number" min="0" class="mt-1 block w-full" :value="old('stock')" required placeholder="0" />
                        <x-input-error :messages="$errors->get('stock')" class="mt-2" />
                    </div>
                </div>

                <div class="pt-3 border-t border-slate-100 dark:border-slate-800 flex items-center justify-between">
                    <a href="{{ route('admin.products.index') }}" class="text-sm font-medium text-slate-500 hover:text-slate-800 dark:text-slate-400 dark:hover:text-slate-200 transition-colors">
                        Cancelar
                    </a>
                    <x-primary-button>
                        Salvar Produto
                    </x-primary-button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>