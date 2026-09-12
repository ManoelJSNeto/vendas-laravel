<section class="space-y-6">
    <header>
        <h2 class="text-lg font-bold text-slate-900 dark:text-white">
            {{ __('Excluir Conta') }}
        </h2>

        <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">
            {{ __('Depois que sua conta for excluída, todos os recursos e dados associados serão excluídos permanentemente.') }}
        </p>
    </header>

    <x-danger-button
        x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
    >{{ __('Excluir Conta') }}</x-danger-button>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="p-6">
            @csrf
            @method('delete')

            <h2 class="text-lg font-bold text-slate-900 dark:text-white">
                {{ __('Tem certeza de que deseja excluir sua conta?') }}
            </h2>

            <p class="mt-2 text-sm text-slate-500 dark:text-slate-400">
                {{ __('Esta ação é permanente e não poderá ser desfeita. Digite sua senha para confirmar a exclusão definitiva.') }}
            </p>

            <div class="mt-6">
                <x-input-label for="password" value="{{ __('Senha') }}" class="sr-only" />

                <x-text-input
                    id="password"
                    name="password"
                    type="password"
                    class="mt-1 block w-full sm:w-3/4"
                    placeholder="{{ __('Digite sua senha para confirmar') }}"
                />

                <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2" />
            </div>

            <div class="mt-6 flex justify-end gap-3">
                <x-secondary-button x-on:click="$dispatch('close')">
                    {{ __('Cancelar') }}
                </x-secondary-button>

                <x-danger-button>
                    {{ __('Confirmar Exclusão') }}
                </x-danger-button>
            </div>
        </form>
    </x-modal>
</section>
