<x-guest-layout>
    <div class="mb-6 text-center">
        <h2 class="text-xl font-bold tracking-tight text-slate-900 dark:text-white">Confirme sua senha</h2>
        <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">
            {{ __('This is a secure area of the application. Please confirm your password before continuing.') }}
        </p>
    </div>

    <form method="POST" action="{{ route('password.confirm') }}" class="space-y-4">
        @csrf

        <!-- Password -->
        <div>
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="current-password"
                            placeholder="••••••••" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="pt-2">
            <x-primary-button class="w-full justify-center py-2.5">
                {{ __('Confirm') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
