<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-slate-900 dark:text-white leading-tight">
            Pagamento — Pedido #{{ $order->order_number }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

            @if ($errors->any())
                <div class="p-4 bg-rose-50 dark:bg-rose-950/40 border border-rose-200 dark:border-rose-800 text-rose-800 dark:text-rose-300 rounded-xl text-sm space-y-1">
                    @foreach ($errors->all() as $error)
                        <p class="flex items-center gap-2">
                            <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12.01" y2="16"></line></svg>
                            <span>{{ $error }}</span>
                        </p>
                    @endforeach
                </div>
            @endif

            <div class="bg-white dark:bg-slate-900 border border-slate-200/80 dark:border-slate-800 rounded-xl shadow-xs p-6 text-center">
                <p class="text-xs font-semibold uppercase tracking-wider text-slate-500 dark:text-slate-400">Total a pagar</p>
                <p class="text-3xl font-bold text-emerald-600 dark:text-emerald-400 mt-1">R$ {{ number_format($order->total, 2, ',', '.') }}</p>
            </div>

            @if ($order->payment_method === 'pix')
                <div class="bg-white dark:bg-slate-900 border border-slate-200/80 dark:border-slate-800 rounded-xl shadow-xs p-6 text-center" x-data="{ copiado: false }">
                    <div class="inline-flex items-center justify-center w-12 h-12 rounded-full bg-emerald-50 dark:bg-emerald-950/50 text-emerald-600 dark:text-emerald-400 mb-3">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="1.75" viewBox="0 0 24 24">
                            <polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"></polygon>
                        </svg>
                    </div>
                    <h3 class="font-bold text-lg text-slate-900 dark:text-white mb-2">Pague com Pix</h3>
                    <p class="text-xs text-slate-500 dark:text-slate-400 mb-5">Escaneie o QR Code com o aplicativo do seu banco</p>

                    <div class="inline-block p-3 bg-white rounded-xl shadow-xs border border-slate-200">
                        <img src="data:image/png;base64,{{ $pixQrImage }}" alt="QR Code Pix" class="w-52 h-52 mx-auto">
                    </div>

                    <div class="mt-6 text-left">
                        <p class="text-xs font-semibold uppercase tracking-wider text-slate-500 dark:text-slate-400 mb-2">Pix Copia e Cola:</p>
                        <div class="relative">
                            <div class="bg-slate-100 dark:bg-slate-800 p-3.5 pe-24 rounded-lg text-xs break-all font-mono text-slate-700 dark:text-slate-300 border border-slate-200 dark:border-slate-700 select-all">
                                {{ $pixPayload }}
                            </div>
                            <button type="button" @click="navigator.clipboard.writeText('{{ $pixPayload }}'); copiado = true; setTimeout(() => copiado = false, 2500)" class="absolute end-2 top-2 px-3 py-1.5 bg-slate-900 dark:bg-slate-100 text-white dark:text-slate-900 text-xs font-medium rounded-md hover:bg-slate-800 dark:hover:bg-white transition-colors cursor-pointer">
                                <span x-show="!copiado">Copiar</span>
                                <span x-show="copiado" class="text-emerald-400 dark:text-emerald-600 font-bold">Copiado!</span>
                            </button>
                        </div>
                    </div>

                    <form method="POST" action="{{ route('payments.process', $order->order_number) }}" class="mt-6">
                        @csrf
                        <x-primary-button class="w-full justify-center py-3.5 text-base">
                            <span>Já realizei o pagamento</span>
                            <svg class="w-4 h-4 ms-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"></polyline></svg>
                        </x-primary-button>
                    </form>
                </div>
            @endif

            @if ($order->payment_method === 'boleto')
                <div class="bg-white dark:bg-slate-900 border border-slate-200/80 dark:border-slate-800 rounded-xl shadow-xs p-6" x-data="{ copiado: false }">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-10 h-10 rounded-full bg-slate-100 dark:bg-slate-800 flex items-center justify-center text-slate-600 dark:text-slate-300">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.75" viewBox="0 0 24 24">
                                <line x1="3" y1="4" x2="3" y2="20"></line>
                                <line x1="7" y1="4" x2="7" y2="20"></line>
                                <line x1="11" y1="4" x2="11" y2="20"></line>
                                <line x1="15" y1="4" x2="15" y2="20"></line>
                                <line x1="19" y1="4" x2="19" y2="20"></line>
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-bold text-lg text-slate-900 dark:text-white">Boleto Bancário</h3>
                            <p class="text-xs text-slate-500 dark:text-slate-400">Pague pelo internet banking ou imprima para pagar na agência</p>
                        </div>
                    </div>

                    <div class="my-5">
                        <p class="text-xs font-semibold uppercase tracking-wider text-slate-500 dark:text-slate-400 mb-2">Linha digitável:</p>
                        <div class="relative">
                            <div class="bg-slate-100 dark:bg-slate-800 p-3.5 pe-24 rounded-lg text-sm font-mono text-slate-900 dark:text-slate-100 border border-slate-200 dark:border-slate-700 select-all">
                                {{ $linhaDigitavel }}
                            </div>
                            <button type="button" @click="navigator.clipboard.writeText('{{ $linhaDigitavel }}'); copiado = true; setTimeout(() => copiado = false, 2500)" class="absolute end-2 top-2 px-3 py-1.5 bg-slate-900 dark:bg-slate-100 text-white dark:text-slate-900 text-xs font-medium rounded-md hover:bg-slate-800 dark:hover:bg-white transition-colors cursor-pointer">
                                <span x-show="!copiado">Copiar</span>
                                <span x-show="copiado" class="text-emerald-400 dark:text-emerald-600 font-bold">Copiado!</span>
                            </button>
                        </div>
                    </div>

                    <div class="mb-6">
                        <a href="{{ route('payments.boleto-pdf', $order->order_number) }}" target="_blank"
                            class="inline-flex items-center gap-2 bg-white dark:bg-slate-800 border border-slate-300 dark:border-slate-700 text-slate-800 dark:text-slate-200 text-sm font-medium px-4 py-2.5 rounded-lg hover:bg-slate-50 dark:hover:bg-slate-700/60 transition-colors shadow-xs">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.75" viewBox="0 0 24 24">
                                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                                <polyline points="14 2 14 8 20 8"></polyline>
                                <line x1="12" y1="18" x2="12" y2="12"></line>
                                <line x1="9" y1="15" x2="15" y2="15"></line>
                            </svg>
                            <span>Baixar boleto em PDF</span>
                        </a>
                    </div>

                    <form method="POST" action="{{ route('payments.process', $order->order_number) }}">
                        @csrf
                        <x-primary-button class="w-full justify-center py-3.5 text-base">
                            <span>Já efetuei o pagamento</span>
                            <svg class="w-4 h-4 ms-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"></polyline></svg>
                        </x-primary-button>
                    </form>
                </div>
            @endif

            @if ($order->payment_method === 'cartao')
                <form method="POST" action="{{ route('payments.process', $order->order_number) }}" class="bg-white dark:bg-slate-900 border border-slate-200/80 dark:border-slate-800 rounded-xl shadow-xs p-6 space-y-4" x-data="{
                    number: '',
                    brand: '',
                    detectBrand() {
                        let n = this.number.replace(/\D/g, '');
                        if (/^4/.test(n)) this.brand = 'Visa';
                        else if (/^5[1-5]/.test(n) || /^2(2[2-9]|[3-6]\d|7[01]|720)/.test(n)) this.brand = 'Mastercard';
                        else if (/^3[47]/.test(n)) this.brand = 'American Express';
                        else if (/^636368|^438935|^504175|^451416|^636297|^5067|^4576|^4011/.test(n)) this.brand = 'Elo';
                        else if (/^606282/.test(n)) this.brand = 'Hipercard';
                        else this.brand = n.length >= 4 ? 'Não identificada' : '';
                    }
                }">
                    @csrf
                    <div class="flex items-center gap-3 mb-2">
                        <div class="w-10 h-10 rounded-full bg-slate-100 dark:bg-slate-800 flex items-center justify-center text-slate-600 dark:text-slate-300">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.75" viewBox="0 0 24 24">
                                <rect x="1" y="4" width="22" height="16" rx="2" ry="2"></rect>
                                <line x1="1" y1="10" x2="23" y2="10"></line>
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-bold text-lg text-slate-900 dark:text-white">Dados do Cartão</h3>
                            <p class="text-xs text-slate-500 dark:text-slate-400">Transação criptografada em ambiente de teste</p>
                        </div>
                    </div>

                    <div>
                        <x-input-label for="card_number" :value="__('Número do Cartão')" />
                        <div class="relative mt-1">
                            <x-text-input id="card_number" name="card_number" type="text" class="block w-full pe-24"
                                x-model="number" @input="detectBrand()" placeholder="0000 0000 0000 0000" maxlength="19" required />
                            <span class="absolute end-3 top-2.5 px-2 py-0.5 text-xs font-semibold rounded bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-300" x-show="brand" x-text="brand"></span>
                        </div>
                        <x-input-error :messages="$errors->get('card_number')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="card_name" :value="__('Nome impresso no cartão')" />
                        <x-text-input id="card_name" name="card_name" type="text" class="mt-1 block w-full" placeholder="Ex: NOME COMPLETO" required />
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <x-input-label for="card_expiry" :value="__('Validade (MM/AA)')" />
                            <x-text-input id="card_expiry" name="card_expiry" type="text" class="mt-1 block w-full" placeholder="12/28" maxlength="5" required />
                        </div>
                        <div>
                            <x-input-label for="card_cvv" :value="__('CVV')" />
                            <x-text-input id="card_cvv" name="card_cvv" type="text" class="mt-1 block w-full" placeholder="123" maxlength="4" required />
                        </div>
                    </div>

                    <div class="p-3 bg-slate-50 dark:bg-slate-800/60 rounded-lg border border-slate-200 dark:border-slate-700/60 flex items-center gap-2 text-xs text-slate-500 dark:text-slate-400">
                        <svg class="w-4 h-4 shrink-0 text-slate-400" fill="none" stroke="currentColor" stroke-width="1.75" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="16" x2="12" y2="12"></line><line x1="12" y1="8" x2="12.01" y2="8"></line></svg>
                        <span>Ambiente simulado para fins acadêmicos. Nenhum dado de cartão real é armazenado.</span>
                    </div>

                    <div class="pt-2">
                        <x-primary-button class="w-full justify-center py-3.5 text-base">
                            <span>Pagar Agora</span>
                            <svg class="w-4 h-4 ms-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"></polyline></svg>
                        </x-primary-button>
                    </div>
                </form>
            @endif
        </div>
    </div>
</x-app-layout>