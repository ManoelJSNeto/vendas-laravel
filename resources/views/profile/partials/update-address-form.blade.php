<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Endereço') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __('Atualize seu endereço de entrega.') }}
        </p>
    </header>

    <form method="post" action="{{ route('address.update') }}" class="mt-6 space-y-6" x-data="{
        cep: '{{ old('cep', $address->cep ?? '') }}',
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
        @csrf
        @method('patch')

        <div>
            <x-input-label for="cep" :value="__('CEP')" />
            <x-text-input id="cep" name="cep" type="text" class="mt-1 block w-full"
                x-model="cep" @blur="buscarCep()" maxlength="9" />
            <span x-show="buscando" class="text-xs text-gray-500">Buscando endereço...</span>
            <x-input-error class="mt-2" :messages="$errors->get('cep')" />
        </div>

        <div>
            <x-input-label for="logradouro" :value="__('Logradouro')" />
            <x-text-input id="logradouro" name="logradouro" type="text" class="mt-1 block w-full" :value="old('logradouro', $address->logradouro ?? '')" />
            <x-input-error class="mt-2" :messages="$errors->get('logradouro')" />
        </div>

        <div>
            <x-input-label for="numero" :value="__('Número')" />
            <x-text-input id="numero" name="numero" type="text" class="mt-1 block w-full" :value="old('numero', $address->numero ?? '')" />
            <x-input-error class="mt-2" :messages="$errors->get('numero')" />
        </div>

        <div>
            <x-input-label for="complemento" :value="__('Complemento')" />
            <x-text-input id="complemento" name="complemento" type="text" class="mt-1 block w-full" :value="old('complemento', $address->complemento ?? '')" />
            <x-input-error class="mt-2" :messages="$errors->get('complemento')" />
        </div>

        <div>
            <x-input-label for="bairro" :value="__('Bairro')" />
            <x-text-input id="bairro" name="bairro" type="text" class="mt-1 block w-full" :value="old('bairro', $address->bairro ?? '')" />
            <x-input-error class="mt-2" :messages="$errors->get('bairro')" />
        </div>

        <div>
            <x-input-label for="cidade" :value="__('Cidade')" />
            <x-text-input id="cidade" name="cidade" type="text" class="mt-1 block w-full" :value="old('cidade', $address->cidade ?? '')" />
            <x-input-error class="mt-2" :messages="$errors->get('cidade')" />
        </div>

        <div>
            <x-input-label for="uf" :value="__('UF')" />
            <x-text-input id="uf" name="uf" type="text" class="mt-1 block w-full" :value="old('uf', $address->uf ?? '')" maxlength="2" />
            <x-input-error class="mt-2" :messages="$errors->get('uf')" />
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Salvar Endereço') }}</x-primary-button>

            @if (session('status') === 'address-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600"
                >{{ __('Salvo.') }}</p>
            @endif
        </div>
    </form>
</section>