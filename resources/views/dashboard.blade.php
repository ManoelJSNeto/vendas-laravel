<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-slate-900 dark:text-white leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-slate-900 overflow-hidden shadow-sm rounded-xl border border-slate-200/80 dark:border-slate-800 p-6">
                <div class="text-slate-800 dark:text-slate-200 text-sm">
                    {{ __("You're logged in!") }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
