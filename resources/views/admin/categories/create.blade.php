<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-2">
            <a href="{{ route('admin.categories.index') }}" class="text-slate-400 hover:text-slate-600 dark:hover:text-slate-300 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
                </svg>
            </a>
            <h2 class="text-2xl font-bold tracking-tight text-slate-900 dark:text-white">
                Nova Categoria
            </h2>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-md mx-auto px-4 sm:px-6 lg:px-8">
            <form method="POST" action="{{ route('admin.categories.store') }}" class="bg-white dark:bg-slate-900 rounded-xl border border-slate-200/80 dark:border-slate-800 shadow-sm p-6 space-y-5">
                @csrf

                <div>
                    <x-input-label for="name" :value="__('Nome da Categoria')" />
                    <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name')" required autofocus placeholder="Ex: Calçados, Eletrônicos" />
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>

                <div class="pt-3 border-t border-slate-100 dark:border-slate-800 flex items-center justify-between">
                    <a href="{{ route('admin.categories.index') }}" class="text-sm font-medium text-slate-500 hover:text-slate-800 dark:text-slate-400 dark:hover:text-slate-200 transition-colors">
                        Cancelar
                    </a>
                    <x-primary-button>
                        Salvar Categoria
                    </x-primary-button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>