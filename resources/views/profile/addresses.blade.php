<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-slate-900 dark:text-white leading-tight">
            Meus Endereços
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

            @if (session('status'))
                <div class="p-4 bg-emerald-50 dark:bg-emerald-950/40 border border-emerald-200 dark:border-emerald-800 text-emerald-800 dark:text-emerald-300 rounded-xl text-sm font-medium flex items-center gap-3">
                    <svg class="w-5 h-5 shrink-0 text-emerald-600 dark:text-emerald-400" fill="none" stroke="currentColor" stroke-width="1.75" viewBox="0 0 24 24">
                        <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                        <polyline points="22 4 12 14.01 9 11.01"></polyline>
                    </svg>
                    <span>{{ session('status') }}</span>
                </div>
            @endif

            <div class="bg-white dark:bg-slate-900 border border-slate-200/80 dark:border-slate-800 rounded-xl shadow-xs p-6">
                <div class="flex items-center gap-2 mb-4">
                    <svg class="w-5 h-5 text-slate-500 dark:text-slate-400" fill="none" stroke="currentColor" stroke-width="1.75" viewBox="0 0 24 24">
                        <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path>
                        <circle cx="12" cy="10" r="3"></circle>
                    </svg>
                    <h3 class="font-bold text-lg text-slate-900 dark:text-white">Endereços Salvos</h3>
                </div>

                @if ($addresses->isEmpty())
                    <p class="text-sm text-slate-500 dark:text-slate-400">Você ainda não tem nenhum endereço salvo.</p>
                @else
                    <div class="space-y-3">
                        @foreach ($addresses as $address)
                            <div class="border border-slate-200 dark:border-slate-700 rounded-xl p-4 flex items-start justify-between gap-4 hover:border-slate-300 dark:hover:border-slate-600 transition-colors">
                                <div>
                                    <div class="flex items-center gap-2 mb-1">
                                        <p class="font-semibold text-sm text-slate-900 dark:text-white">{{ $address->label ?: 'Endereço' }}</p>
                                        @if ($address->is_default)
                                            <span class="text-xs bg-slate-900 dark:bg-slate-100 text-white dark:text-slate-900 font-semibold px-2 py-0.5 rounded-full">Padrão</span>
                                        @endif
                                    </div>
                                    <p class="text-sm text-slate-600 dark:text-slate-300">
                                        {{ $address->logradouro }}, {{ $address->numero }}
                                        @if ($address->complemento) — {{ $address->complemento }} @endif
                                        <br>
                                        {{ $address->bairro }} — {{ $address->cidade }}/{{ $address->uf }}, <span class="text-xs text-slate-500 dark:text-slate-400">CEP {{ $address->cep }}</span>
                                    </p>
                                </div>
                                <div class="flex flex-col items-end gap-2 shrink-0">
                                    @unless ($address->is_default)
                                        <form method="POST" action="{{ route('addresses.set-default', $address) }}">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="text-xs font-medium text-slate-900 dark:text-sky-400 hover:underline cursor-pointer">Tornar padrão</button>
                                        </form>
                                    @endunless
                                    <form method="POST" action="{{ route('addresses.destroy', $address) }}"
                                        onsubmit="return confirm('Remover este endereço?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-xs font-medium text-rose-600 dark:text-rose-400 hover:underline cursor-pointer">Remover</button>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

            <div class="bg-white dark:bg-slate-900 border border-slate-200/80 dark:border-slate-800 rounded-xl shadow-xs p-6">
                <h3 class="font-bold text-lg text-slate-900 dark:text-white mb-4">Adicionar Novo Endereço</h3>

                <form method="POST" action="{{ route('addresses.store') }}" class="space-y-4" x-data="{
                    cep: '',
                    logradouro: '',
                    bairro: '',
                    cidade: '',
                    uf: '',
                    buscando: false,
                    timer: null,
                    buscarCep() {
                        clearTimeout(this.timer);
                        this.timer = setTimeout(async () => {
                            let cepLimpo = this.cep.replace(/\D/g, '');
                            if (cepLimpo.length !== 8) return;
                            this.buscando = true;
                            try {
                                let res = await fetch(`https://viacep.com.br/ws/${cepLimpo}/json/`);
                                let data = await res.json();
                                if (!data.erro) {
                                    this.logradouro = data.logradouro;
                                    this.bairro = data.bairro;
                                    this.cidade = data.localidade;
                                    this.uf = data.uf;
                                }
                            } catch (e) {
                                console.error('Erro ao buscar CEP', e);
                            }
                            this.buscando = false;
                        }, 400);
                    }
                }">
                    @csrf

                    <div>
                        <x-input-label for="label" :value="__('Apelido (opcional)')" />
                        <x-text-input id="label" name="label" type="text" class="mt-1 block w-full" placeholder="Ex: Casa, Trabalho" :value="old('label')" />
                        <x-input-error :messages="$errors->get('label')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="cep" :value="__('CEP')" />
                        <div class="relative mt-1">
                            <x-text-input id="cep" name="cep" type="text" class="block w-full"
                                x-model="cep" @input="buscarCep()" maxlength="9" placeholder="00000-000" required />
                            <span x-show="buscando" class="absolute end-3 top-2.5 text-xs font-medium text-slate-500 animate-pulse">
                                Buscando endereço...
                            </span>
                        </div>
                        <x-input-error :messages="$errors->get('cep')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="logradouro" :value="__('Logradouro')" />
                        <x-text-input id="logradouro" name="logradouro" type="text" class="mt-1 block w-full" x-model="logradouro" required />
                        <x-input-error :messages="$errors->get('logradouro')" class="mt-2" />
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <x-input-label for="numero" :value="__('Número')" />
                            <x-text-input id="numero" name="numero" type="text" class="mt-1 block w-full" :value="old('numero')" />
                        </div>
                        <div>
                            <x-input-label for="complemento" :value="__('Complemento')" />
                            <x-text-input id="complemento" name="complemento" type="text" class="mt-1 block w-full" :value="old('complemento')" placeholder="Apto, Bloco..." />
                        </div>
                    </div>

                    <div>
                        <x-input-label for="bairro" :value="__('Bairro')" />
                        <x-text-input id="bairro" name="bairro" type="text" class="mt-1 block w-full" x-model="bairro" required />
                        <x-input-error :messages="$errors->get('bairro')" class="mt-2" />
                    </div>

                    <div class="grid grid-cols-3 gap-4">
                        <div class="col-span-2">
                            <x-input-label for="cidade" :value="__('Cidade')" />
                            <x-text-input id="cidade" name="cidade" type="text" class="mt-1 block w-full" x-model="cidade" required />
                        </div>
                        <div>
                            <x-input-label for="uf" :value="__('UF')" />
                            <x-text-input id="uf" name="uf" type="text" class="mt-1 block w-full uppercase" x-model="uf" maxlength="2" required />
                        </div>
                    </div>

                    <div class="pt-2">
                        <x-primary-button>Adicionar Endereço</x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>