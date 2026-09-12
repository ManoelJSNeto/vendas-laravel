<x-guest-layout>
    <div class="mb-6 text-center">
        <h2 class="text-xl font-bold tracking-tight text-slate-900 dark:text-white">Acesse sua conta</h2>
        <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">Informe seus dados para continuar</p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-5" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-4">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" placeholder="seu@email.com" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div>
            <div class="flex items-center justify-between">
                <x-input-label for="password" :value="__('Password')" />
                @if (Route::has('password.request'))
                    <a class="text-xs font-medium text-navy-600 dark:text-navy-400 hover:text-navy-700 dark:hover:text-navy-300 transition-colors" href="{{ route('password.request') }}">
                        {{ __('Forgot your password?') }}
                    </a>
                @endif
            </div>

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="current-password"
                            placeholder="••••••••" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="pt-1">
            <label for="remember_me" class="inline-flex items-center cursor-pointer select-none">
                <input id="remember_me" type="checkbox" class="w-4 h-4 rounded border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-900 text-navy-600 focus:ring-navy-500 focus:ring-offset-0 transition" name="remember">
                <span class="ms-2 text-sm text-slate-600 dark:text-slate-400">{{ __('Remember me') }}</span>
            </label>
        </div>

        <div class="pt-2">
            <x-primary-button class="w-full justify-center py-2.5">
                {{ __('Log in') }}
            </x-primary-button>
        </div>

        @if (Route::has('register'))
            <div class="text-center pt-4 border-t border-slate-100 dark:border-slate-800">
                <span class="text-sm text-slate-500 dark:text-slate-400">Ainda não tem conta?</span>
                <a class="text-sm font-semibold text-navy-600 dark:text-navy-400 hover:text-navy-700 dark:hover:text-navy-300 ml-1 transition-colors" href="{{ route('register') }}">
                    Cadastre-se
                </a>
            </div>
        @endif
    </form>
</x-guest-layout>
