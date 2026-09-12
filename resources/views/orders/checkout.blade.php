<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-slate-900 dark:text-white leading-tight">
            Finalizar Compra
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

            <!-- Resumo do Pedido -->
            <div class="bg-white dark:bg-slate-900 border border-slate-200/80 dark:border-slate-800 rounded-xl shadow-xs p-6">
                <div class="flex items-center gap-2 mb-4">
                    <svg class="w-5 h-5 text-slate-500 dark:text-slate-400" fill="none" stroke="currentColor" stroke-width="1.75" viewBox="0 0 24 24">
                        <path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"></path>
                        <line x1="3" y1="6" x2="21" y2="6"></line>
                        <path d="M16 10a4 4 0 0 1-8 0"></path>
                    </svg>
                    <h3 class="font-bold text-lg text-slate-900 dark:text-white">Resumo do Pedido</h3>
                </div>

                <div class="divide-y divide-slate-100 dark:divide-slate-800">
                    @foreach ($items as $item)
                        <div class="py-3 flex justify-between items-center text-sm">
                            <div>
                                <span class="font-medium text-slate-900 dark:text-white">{{ $item->product->name }}</span>
                                <span class="text-slate-500 dark:text-slate-400 text-xs ms-1">× {{ $item->quantity }}</span>
                            </div>
                            <span class="font-semibold text-slate-900 dark:text-white">R$ {{ number_format($item->subtotal(), 2, ',', '.') }}</span>
                        </div>
                    @endforeach
                </div>
                <div class="mt-4 pt-4 border-t border-slate-200 dark:border-slate-800 flex justify-between items-baseline font-bold">
                    <span class="text-base text-slate-700 dark:text-slate-300">Total</span>
                    <span class="text-2xl text-emerald-600 dark:text-emerald-400">R$ {{ number_format($total, 2, ',', '.') }}</span>
                </div>
            </div>

            <!-- Formulário de Finalização -->
            <form method="POST" action="{{ route('orders.store') }}" class="bg-white dark:bg-slate-900 border border-slate-200/80 dark:border-slate-800 rounded-xl shadow-xs p-6 space-y-6" x-data="{
                usarNovo: {{ $addresses->isEmpty() ? 'true' : 'false' }},
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

                <!-- Endereço de Entrega -->
                <div>
                    <div class="flex items-center gap-2 mb-4">
                        <svg class="w-5 h-5 text-slate-500 dark:text-slate-400" fill="none" stroke="currentColor" stroke-width="1.75" viewBox="0 0 24 24">
                            <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path>
                            <circle cx="12" cy="10" r="3"></circle>
                        </svg>
                        <h3 class="font-bold text-lg text-slate-900 dark:text-white">Endereço de Entrega</h3>
                    </div>

                    @if ($addresses->isNotEmpty())
                        <div class="space-y-3 mb-4" x-show="!usarNovo">
                            @foreach ($addresses as $address)
                                <label class="flex items-start gap-3.5 border border-slate-200 dark:border-slate-700 rounded-xl p-4 cursor-pointer hover:bg-slate-50 dark:hover:bg-slate-800/40 transition-colors">
                                    <input type="radio" name="address_id" value="{{ $address->id }}"
                                        class="mt-1 text-slate-900 focus:ring-slate-900 dark:text-sky-400" {{ $loop->first ? 'checked' : '' }}>
                                    <span class="text-sm">
                                        <span class="font-semibold text-slate-900 dark:text-white">{{ $address->label ?: 'Endereço' }}</span>
                                        <span class="block text-slate-600 dark:text-slate-400 mt-0.5">
                                            {{ $address->logradouro }}, {{ $address->numero }}
                                            @if ($address->complemento) — {{ $address->complemento }} @endif
                                        </span>
                                        <span class="block text-xs text-slate-500 dark:text-slate-400 mt-0.5">
                                            {{ $address->bairro }}, {{ $address->cidade }}/{{ $address->uf }} — CEP {{ $address->cep }}
                                        </span>
                                    </span>
                                </label>
                            @endforeach
                        </div>

                        <button type="button" @click="usarNovo = !usarNovo" class="inline-flex items-center gap-1.5 text-sm font-medium text-slate-900 dark:text-sky-400 hover:underline cursor-pointer mb-2">
                            <span x-show="!usarNovo" class="flex items-center gap-1">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                                Usar um novo endereço
                            </span>
                            <span x-show="usarNovo" class="flex items-center gap-1">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
                                Usar um endereço salvo
                            </span>
                        </button>
                    @endif

                    <div class="space-y-4 pt-2" x-show="usarNovo">
                        <div>
                            <x-input-label for="cep" :value="__('CEP')" />
                            <div class="relative mt-1">
                                <x-text-input id="cep" name="cep" type="text" class="block w-full"
                                    x-model="cep" @input="buscarCep()" maxlength="9" placeholder="00000-000" />
                                <span x-show="buscando" class="absolute end-3 top-2.5 text-xs font-medium text-slate-500 animate-pulse">
                                    Buscando endereço...
                                </span>
                            </div>
                            <x-input-error :messages="$errors->get('cep')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="logradouro" :value="__('Logradouro')" />
                            <x-text-input id="logradouro" name="logradouro" type="text" class="mt-1 block w-full" x-model="logradouro" />
                            <x-input-error :messages="$errors->get('logradouro')" class="mt-2" />
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <x-input-label for="numero" :value="__('Número')" />
                                <x-text-input id="numero" name="numero" type="text" class="mt-1 block w-full" />
                            </div>
                            <div>
                                <x-input-label for="complemento" :value="__('Complemento')" />
                                <x-text-input id="complemento" name="complemento" type="text" class="mt-1 block w-full" placeholder="Apto, Bloco..." />
                            </div>
                        </div>

                        <div>
                            <x-input-label for="bairro" :value="__('Bairro')" />
                            <x-text-input id="bairro" name="bairro" type="text" class="mt-1 block w-full" x-model="bairro" />
                            <x-input-error :messages="$errors->get('bairro')" class="mt-2" />
                        </div>

                        <div class="grid grid-cols-3 gap-4">
                            <div class="col-span-2">
                                <x-input-label for="cidade" :value="__('Cidade')" />
                                <x-text-input id="cidade" name="cidade" type="text" class="mt-1 block w-full" x-model="cidade" />
                                <x-input-error :messages="$errors->get('cidade')" class="mt-2" />
                            </div>
                            <div>
                                <x-input-label for="uf" :value="__('UF')" />
                                <x-text-input id="uf" name="uf" type="text" class="mt-1 block w-full uppercase" x-model="uf" maxlength="2" />
                                <x-input-error :messages="$errors->get('uf')" class="mt-2" />
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Forma de Pagamento -->
                <div class="pt-6 border-t border-slate-200 dark:border-slate-800">
                    <div class="flex items-center gap-2 mb-4">
                        <svg class="w-5 h-5 text-slate-500 dark:text-slate-400" fill="none" stroke="currentColor" stroke-width="1.75" viewBox="0 0 24 24">
                            <rect x="1" y="4" width="22" height="16" rx="2" ry="2"></rect>
                            <line x1="1" y1="10" x2="23" y2="10"></line>
                        </svg>
                        <h3 class="font-bold text-lg text-slate-900 dark:text-white">Forma de Pagamento</h3>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                        <label class="flex items-center gap-3 border border-slate-200 dark:border-slate-700 rounded-xl p-4 cursor-pointer hover:bg-slate-50 dark:hover:bg-slate-800/40 transition-colors">
                            <input type="radio" name="payment_method" value="pix" required class="text-slate-900 focus:ring-slate-900 dark:text-sky-400">
                            <div>
                                <span class="font-semibold text-sm text-slate-900 dark:text-white block">Pix</span>
                                <span class="text-xs text-slate-500 dark:text-slate-400">Aprovação imediata</span>
                            </div>
                        </label>

                        <label class="flex items-center gap-3 border border-slate-200 dark:border-slate-700 rounded-xl p-4 cursor-pointer hover:bg-slate-50 dark:hover:bg-slate-800/40 transition-colors">
                            <input type="radio" name="payment_method" value="cartao" class="text-slate-900 focus:ring-slate-900 dark:text-sky-400">
                            <div>
                                <span class="font-semibold text-sm text-slate-900 dark:text-white block">Cartão de Crédito</span>
                                <span class="text-xs text-slate-500 dark:text-slate-400">Até 12x</span>
                            </div>
                        </label>

                        <label class="flex items-center gap-3 border border-slate-200 dark:border-slate-700 rounded-xl p-4 cursor-pointer hover:bg-slate-50 dark:hover:bg-slate-800/40 transition-colors">
                            <input type="radio" name="payment_method" value="boleto" class="text-slate-900 focus:ring-slate-900 dark:text-sky-400">
                            <div>
                                <span class="font-semibold text-sm text-slate-900 dark:text-white block">Boleto Bancário</span>
                                <span class="text-xs text-slate-500 dark:text-slate-400">Vencimento em 3 dias</span>
                            </div>
                        </label>
                    </div>
                    <x-input-error :messages="$errors->get('payment_method')" class="mt-2" />
                </div>

                <div class="pt-4">
                    <x-primary-button class="w-full justify-center py-3.5 text-base">
                        <span>Confirmar Pedido</span>
                        <svg class="w-4 h-4 ms-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <polyline points="20 6 9 17 4 12"></polyline>
                        </svg>
                    </x-primary-button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>