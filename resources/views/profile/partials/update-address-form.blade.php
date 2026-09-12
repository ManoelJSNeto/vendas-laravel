<section>
    <header>
        <h2 class="text-lg font-bold text-slate-900 dark:text-white">
            {{ __('Endereço Padrão') }}
        </h2>

        <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">
            {{ __('Atualize seu endereço principal de entrega.') }}
        </p>
    </header>

    <form method="post" action="{{ route('address.update') }}" class="mt-6 space-y-4" x-data="{
        cep: '{{ old('cep', $address->cep ?? '') }}',
        logradouro: '{{ old('logradouro', $address->logradouro ?? '') }}',
        bairro: '{{ old('bairro', $address->bairro ?? '') }}',
        cidade: '{{ old('cidade', $address->cidade ?? '') }}',
        uf: '{{ old('uf', $address->uf ?? '') }}',
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
        @method('patch')

        <div>
            <x-input-label for="cep" :value="__('CEP')" />
            <div class="relative mt-1">
                <x-text-input id="cep" name="cep" type="text" class="block w-full"
                    x-model="cep" @input="buscarCep()" maxlength="9" placeholder="00000-000" />
                <span x-show="buscando" class="absolute end-3 top-2.5 text-xs font-medium text-slate-500 animate-pulse">
                    Buscando endereço...
                </span>
            </div>
            <x-input-error class="mt-2" :messages="$errors->get('cep')" />
        </div>

        <div>
            <x-input-label for="logradouro" :value="__('Logradouro')" />
            <x-text-input id="logradouro" name="logradouro" type="text" class="mt-1 block w-full" x-model="logradouro" />
            <x-input-error class="mt-2" :messages="$errors->get('logradouro')" />
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <x-input-label for="numero" :value="__('Número')" />
                <x-text-input id="numero" name="numero" type="text" class="mt-1 block w-full" :value="old('numero', $address->numero ?? '')" />
                <x-input-error class="mt-2" :messages="$errors->get('numero')" />
            </div>

            <div>
                <x-input-label for="complemento" :value="__('Complemento')" />
                <x-text-input id="complemento" name="complemento" type="text" class="mt-1 block w-full" :value="old('complemento', $address->complemento ?? '')" placeholder="Apto, Bloco..." />
                <x-input-error class="mt-2" :messages="$errors->get('complemento')" />
            </div>
        </div>

        <div>
            <x-input-label for="bairro" :value="__('Bairro')" />
            <x-text-input id="bairro" name="bairro" type="text" class="mt-1 block w-full" x-model="bairro" />
            <x-input-error class="mt-2" :messages="$errors->get('bairro')" />
        </div>

        <div class="grid grid-cols-3 gap-4">
            <div class="col-span-2">
                <x-input-label for="cidade" :value="__('Cidade')" />
                <x-text-input id="cidade" name="cidade" type="text" class="mt-1 block w-full" x-model="cidade" />
                <x-input-error class="mt-2" :messages="$errors->get('cidade')" />
            </div>

            <div>
                <x-input-label for="uf" :value="__('UF')" />
                <x-text-input id="uf" name="uf" type="text" class="mt-1 block w-full uppercase" x-model="uf" maxlength="2" />
                <x-input-error class="mt-2" :messages="$errors->get('uf')" />
            </div>
        </div>

        <div class="flex items-center gap-4 pt-2">
            <x-primary-button>{{ __('Salvar Endereço') }}</x-primary-button>

            @if (session('status') === 'address-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2500)"
                    class="text-sm font-medium text-emerald-600 dark:text-emerald-400"
                >{{ __('Endereço salvo com sucesso.') }}</p>
            @endif
        </div>
    </form>
</section>