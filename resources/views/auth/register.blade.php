<x-guest-layout>
    <div class="mb-6 text-center">
        <h2 class="text-xl font-bold tracking-tight text-slate-900 dark:text-white">Criar nova conta</h2>
        <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">Cadastre-se para comprar e gerenciar seus pedidos</p>
    </div>

    <form method="POST" action="{{ route('register') }}" class="space-y-6">
        @csrf

        <!-- Dados Pessoais -->
        <div class="space-y-4">
            <h3 class="text-xs font-semibold text-slate-400 dark:text-slate-500 uppercase tracking-wider">Dados Básicos</h3>

            <!-- Name -->
            <div>
                <x-input-label for="name" :value="__('Name')" />
                <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" placeholder="Seu nome completo" />
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>

            <!-- Email Address -->
            <div>
                <x-input-label for="email" :value="__('Email')" />
                <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" placeholder="seu@email.com" />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <!-- CPF -->
                <div>
                    <x-input-label for="cpf" :value="__('CPF')" />
                    <x-text-input id="cpf" class="block mt-1 w-full" type="text" name="cpf" :value="old('cpf')" required maxlength="14" placeholder="000.000.000-00" />
                    <x-input-error :messages="$errors->get('cpf')" class="mt-2" />
                </div>

                <!-- Telefone -->
                <div>
                    <x-input-label for="telefone" :value="__('Telefone')" />
                    <x-text-input id="telefone" class="block mt-1 w-full" type="text" name="telefone" :value="old('telefone')" required maxlength="20" placeholder="(00) 00000-0000" />
                    <x-input-error :messages="$errors->get('telefone')" class="mt-2" />
                </div>
            </div>
        </div>

        <!-- Endereço (opcional) -->
        <div class="pt-5 border-t border-slate-200 dark:border-slate-800 space-y-4" x-data="{
            cep: '',
            buscando: false,
            async buscarCep() {
                let cepLimpo = this.cep.replace(/\D/g, '');
                if (cepLimpo.length !== 8) return;
                this.buscando = true;
                try {
                    let res = await fetch(`https://viacep.com.br/ws/${cepLimpo}/json/`);
                    let data = await res.json();
                    if (!data.erro) {
                        document.getElementById('logradouro').value = data.logradouro;
                        document.getElementById('bairro').value = data.bairro;
                        document.getElementById('cidade').value = data.localidade;
                        document.getElementById('uf').value = data.uf;
                    }
                } catch (e) {
                    console.error('Erro ao buscar CEP', e);
                }
                this.buscando = false;
            }
        }">
            <div class="flex items-center justify-between">
                <h3 class="text-xs font-semibold text-slate-400 dark:text-slate-500 uppercase tracking-wider">Endereço de Entrega</h3>
                <span class="text-xs text-slate-400 dark:text-slate-500 font-medium">Opcional</span>
            </div>

            <div>
                <x-input-label for="cep" :value="__('CEP')" />
                <div class="relative mt-1">
                    <x-text-input id="cep" class="block w-full" type="text" name="cep"
                        x-model="cep" @blur="buscarCep()" placeholder="00000-000" maxlength="9" />
                    <div x-show="buscando" class="absolute right-3 top-1/2 -translate-y-1/2 flex items-center gap-1.5 text-xs text-navy-600 dark:text-navy-400">
                        <svg class="animate-spin w-3.5 h-3.5" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path>
                        </svg>
                        <span>Buscando...</span>
                    </div>
                </div>
                <x-input-error :messages="$errors->get('cep')" class="mt-2" />
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                <div class="sm:col-span-2">
                    <x-input-label for="logradouro" :value="__('Logradouro')" />
                    <x-text-input id="logradouro" class="block mt-1 w-full" type="text" name="logradouro" :value="old('logradouro')" placeholder="Rua, Avenida..." />
                </div>
                <div>
                    <x-input-label for="numero" :value="__('Número')" />
                    <x-text-input id="numero" class="block mt-1 w-full" type="text" name="numero" :value="old('numero')" placeholder="123" />
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                <div>
                    <x-input-label for="complemento" :value="__('Complemento')" />
                    <x-text-input id="complemento" class="block mt-1 w-full" type="text" name="complemento" :value="old('complemento')" placeholder="Apto, Bloco..." />
                </div>
                <div>
                    <x-input-label for="bairro" :value="__('Bairro')" />
                    <x-text-input id="bairro" class="block mt-1 w-full" type="text" name="bairro" :value="old('bairro')" />
                </div>
            </div>

            <div class="grid grid-cols-3 gap-3">
                <div class="col-span-2">
                    <x-input-label for="cidade" :value="__('Cidade')" />
                    <x-text-input id="cidade" class="block mt-1 w-full" type="text" name="cidade" :value="old('cidade')" />
                </div>
                <div>
                    <x-input-label for="uf" :value="__('UF')" />
                    <x-text-input id="uf" class="block mt-1 w-full uppercase" type="text" name="uf" :value="old('uf')" maxlength="2" placeholder="SP" />
                </div>
            </div>
        </div>

        <!-- Segurança -->
        <div class="pt-5 border-t border-slate-200 dark:border-slate-800 space-y-4">
            <h3 class="text-xs font-semibold text-slate-400 dark:text-slate-500 uppercase tracking-wider">Segurança</h3>

            <!-- Password -->
            <div>
                <x-input-label for="password" :value="__('Password')" />
                <x-text-input id="password" class="block mt-1 w-full"
                                type="password"
                                name="password"
                                required autocomplete="new-password"
                                placeholder="••••••••" />
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <!-- Confirm Password -->
            <div>
                <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
                <x-text-input id="password_confirmation" class="block mt-1 w-full"
                                type="password"
                                name="password_confirmation" required autocomplete="new-password"
                                placeholder="••••••••" />
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
            </div>
        </div>

        <div class="pt-2">
            <x-primary-button class="w-full justify-center py-2.5">
                {{ __('Register') }}
            </x-primary-button>
        </div>

        <div class="text-center pt-3 border-t border-slate-100 dark:border-slate-800">
            <span class="text-sm text-slate-500 dark:text-slate-400">Já possui cadastro?</span>
            <a class="text-sm font-semibold text-navy-600 dark:text-navy-400 hover:text-navy-700 dark:hover:text-navy-300 ml-1 transition-colors" href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>
        </div>
    </form>
</x-guest-layout>
