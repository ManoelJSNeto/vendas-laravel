<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-slate-900 dark:text-white leading-tight">
            {{ __('Perfil') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
            <div class="p-6 sm:p-8 bg-white dark:bg-slate-900 border border-slate-200/80 dark:border-slate-800 rounded-xl shadow-xs">
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <div class="p-6 sm:p-8 bg-white dark:bg-slate-900 border border-slate-200/80 dark:border-slate-800 rounded-xl shadow-xs">
                <div class="max-w-xl flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                    <div>
                        <h2 class="text-lg font-bold text-slate-900 dark:text-white">{{ __('Endereços') }}</h2>
                        <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">{{ __('Gerencie seus endereços de entrega cadastrados.') }}</p>
                    </div>
                    <a href="{{ route('addresses.index') }}" class="inline-flex items-center justify-center gap-1.5 text-sm font-medium bg-slate-900 dark:bg-slate-100 text-white dark:text-slate-900 px-4 py-2.5 rounded-lg hover:bg-slate-800 dark:hover:bg-white transition-colors shadow-xs">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.75" viewBox="0 0 24 24">
                            <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path>
                            <circle cx="12" cy="10" r="3"></circle>
                        </svg>
                        <span>{{ __('Gerenciar') }}</span>
                    </a>
                </div>
            </div>

            <div class="p-6 sm:p-8 bg-white dark:bg-slate-900 border border-slate-200/80 dark:border-slate-800 rounded-xl shadow-xs">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <div class="p-6 sm:p-8 bg-white dark:bg-slate-900 border border-slate-200/80 dark:border-slate-800 rounded-xl shadow-xs">
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
