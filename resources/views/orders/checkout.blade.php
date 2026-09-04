<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Finalizar Compra
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <div class="bg-white rounded-lg shadow-sm p-6">
                <h3 class="font-semibold text-gray-900 mb-4">Resumo do Pedido</h3>
                <div class="divide-y">
                    @foreach ($items as $item)
                        <div class="py-2 flex justify-between text-sm">
                            <span>{{ $item->product->name }} × {{ $item->quantity }}</span>
                            <span class="font-medium">R$ {{ number_format($item->subtotal(), 2, ',', '.') }}</span>
                        </div>
                    @endforeach
                </div>
                <div class="mt-4 pt-4 border-t flex justify-between font-bold text-lg">
                    <span>Total</span>
                    <span class="text-green-600">R$ {{ number_format($total, 2, ',', '.') }}</span>
                </div>
            </div>

            <form method="POST" action="{{ route('orders.store') }}" class="bg-white rounded-lg shadow-sm p-6 space-y-4" x-data="{
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

                <h3 class="font-semibold text-gray-900">Endereço de Entrega</h3>

                @if ($addresses->isNotEmpty())
                    <div class="space-y-2" x-show="!usarNovo">
                        @foreach ($addresses as $address)
                            <label class="flex items-start gap-3 border rounded-md p-3 cursor-pointer">
                                <input type="radio" name="address_id" value="{{ $address->id }}"
                                    class="mt-1" {{ $loop->first ? 'checked' : '' }}>
                                <span class="text-sm">
                                    <span class="font-medium">{{ $address->label ?: 'Endereço' }}</span><br>
                                    {{ $address->logradouro }}, {{ $address->numero }} — {{ $address->bairro }},
                                    {{ $address->cidade }}/{{ $address->uf }}
                                </span>
                            </label>
                        @endforeach
                    </div>

                    <button type="button" @click="usarNovo = !usarNovo" class="text-sm text-indigo-600 hover:underline">
                        <span x-show="!usarNovo">+ Usar um novo endereço</span>
                        <span x-show="usarNovo">← Usar um endereço salvo</span>
                    </button>
                @endif

                <div class="space-y-4" x-show="usarNovo">
                    <div>
                        <x-input-label for="cep" :value="__('CEP')" />
                        <x-text-input id="cep" name="cep" type="text" class="mt-1 block w-full"
                            x-model="cep" @input="buscarCep()" maxlength="9" />
                        <span x-show="buscando" class="text-xs text-gray-500">Buscando endereço...</span>
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
                            <x-text-input id="complemento" name="complemento" type="text" class="mt-1 block w-full" />
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
                            <x-text-input id="uf" name="uf" type="text" class="mt-1 block w-full" x-model="uf" maxlength="2" />
                            <x-input-error :messages="$errors->get('uf')" class="mt-2" />
                        </div>
                    </div>
                </div>

                <h3 class="font-semibold text-gray-900 pt-4 border-t">Forma de Pagamento</h3>

                <div class="space-y-2">
                    <label class="flex items-center gap-2">
                        <input type="radio" name="payment_method" value="pix" required>
                        <span>Pix</span>
                    </label>
                    <label class="flex items-center gap-2">
                        <input type="radio" name="payment_method" value="cartao">
                        <span>Cartão de Crédito</span>
                    </label>
                    <label class="flex items-center gap-2">
                        <input type="radio" name="payment_method" value="boleto">
                        <span>Boleto</span>
                    </label>
                </div>
                <x-input-error :messages="$errors->get('payment_method')" class="mt-2" />

                <x-primary-button class="w-full justify-center py-3">
                    Confirmar Pedido
                </x-primary-button>
            </form>
        </div>
    </div>
</x-app-layout>