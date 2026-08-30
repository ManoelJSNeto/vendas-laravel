<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Meus Endereços
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @if (session('status'))
                <div class="p-3 bg-green-100 text-green-800 rounded-md text-sm">
                    {{ session('status') }}
                </div>
            @endif

            <div class="bg-white rounded-lg shadow-sm p-6">
                <h3 class="font-semibold text-gray-900 mb-4">Endereços Salvos</h3>

                @if ($addresses->isEmpty())
                    <p class="text-sm text-gray-500">Você ainda não tem nenhum endereço salvo.</p>
                @else
                    <div class="space-y-3">
                        @foreach ($addresses as $address)
                            <div class="border rounded-md p-4 flex items-start justify-between gap-4">
                                <div>
                                    <div class="flex items-center gap-2">
                                        <p class="font-medium text-gray-900">{{ $address->label ?: 'Endereço' }}</p>
                                        @if ($address->is_default)
                                            <span class="text-xs bg-indigo-100 text-indigo-800 px-2 py-0.5 rounded-full">Padrão</span>
                                        @endif
                                    </div>
                                    <p class="text-sm text-gray-500">
                                        {{ $address->logradouro }}, {{ $address->numero }}
                                        @if ($address->complemento) - {{ $address->complemento }} @endif
                                        <br>
                                        {{ $address->bairro }} — {{ $address->cidade }}/{{ $address->uf }}, CEP {{ $address->cep }}
                                    </p>
                                </div>
                                <div class="flex flex-col items-end gap-2 shrink-0">
                                    @unless ($address->is_default)
                                        <form method="POST" action="{{ route('addresses.set-default', $address) }}">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="text-xs text-indigo-600 hover:underline">Tornar padrão</button>
                                        </form>
                                    @endunless
                                    <form method="POST" action="{{ route('addresses.destroy', $address) }}"
                                        onsubmit="return confirm('Remover este endereço?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-xs text-red-600 hover:underline">Remover</button>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

            <div class="bg-white rounded-lg shadow-sm p-6">
                <h3 class="font-semibold text-gray-900 mb-4">Adicionar Novo Endereço</h3>

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
                        <x-text-input id="cep" name="cep" type="text" class="mt-1 block w-full"
                            x-model="cep" @input="buscarCep()" maxlength="9" required />
                        <span x-show="buscando" class="text-xs text-gray-500">Buscando endereço...</span>
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
                            <x-text-input id="complemento" name="complemento" type="text" class="mt-1 block w-full" :value="old('complemento')" />
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
                            <x-text-input id="uf" name="uf" type="text" class="mt-1 block w-full" x-model="uf" maxlength="2" required />
                        </div>
                    </div>

                    <x-primary-button>Adicionar Endereço</x-primary-button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>