<x-guest-layout>
    <div class="mb-6 text-center">
        <h2 class="text-xl font-bold tracking-tight text-slate-900 dark:text-white">Recuperar senha</h2>
        <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">
            {{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}
        </p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-5" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}" class="space-y-4">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus placeholder="seu@email.com" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="pt-2">
            <x-primary-button class="w-full justify-center py-2.5">
                {{ __('Email Password Reset Link') }}
            </x-primary-button>
        </div>

        <div class="text-center pt-3 border-t border-slate-100 dark:border-slate-800">
            <a class="text-sm font-semibold text-navy-600 dark:text-navy-400 hover:text-navy-700 dark:hover:text-navy-300 transition-colors" href="{{ route('login') }}">
                Voltar para o login
            </a>
        </div>
    </form>
</x-guest-layout>
