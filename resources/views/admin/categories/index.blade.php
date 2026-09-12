<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h2 class="text-2xl font-bold tracking-tight text-slate-900 dark:text-white">
                    Painel Admin — Categorias
                </h2>
                <p class="text-sm text-slate-500 dark:text-slate-400 mt-0.5">
                    Organize os departamentos e setores dos produtos
                </p>
            </div>
            <div>
                <a href="{{ route('admin.categories.create') }}" class="inline-flex items-center gap-1.5 px-4 py-2 text-sm font-semibold rounded-lg text-white bg-slate-900 dark:bg-slate-100 dark:text-slate-900 hover:bg-slate-800 dark:hover:bg-white shadow-sm transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                    </svg>
                    <span>Nova Categoria</span>
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

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
                                <th class="py-3.5 px-4 font-semibold">Nome da Categoria</th>
                                <th class="py-3.5 px-4 font-semibold">Qtd. Produtos</th>
                                <th class="py-3.5 px-4 font-semibold text-right">Ações</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                            @forelse ($categories as $category)
                                <tr class="hover:bg-slate-50/70 dark:hover:bg-slate-800/30 transition-colors">
                                    <td class="py-3.5 px-4 font-semibold text-slate-900 dark:text-white">
                                        {{ $category->name }}
                                    </td>
                                    <td class="py-3.5 px-4">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-300">
                                            {{ $category->products_count }} vinculados
                                        </span>
                                    </td>
                                    <td class="py-3.5 px-4 text-right whitespace-nowrap">
                                        <div class="inline-flex items-center gap-3">
                                            <a href="{{ route('admin.categories.edit', $category) }}" class="text-xs font-semibold text-navy-600 dark:text-navy-400 hover:text-navy-800 dark:hover:text-navy-300 transition-colors">
                                                Editar
                                            </a>
                                            <form method="POST" action="{{ route('admin.categories.destroy', $category) }}" class="inline"
                                                onsubmit="return confirm('Tem certeza que deseja excluir esta categoria? Os produtos vinculados ficarão sem categoria.');">
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
                                    <td colspan="3" class="py-8 text-center text-slate-500 dark:text-slate-400">
                                        Nenhuma categoria cadastrada ainda.
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