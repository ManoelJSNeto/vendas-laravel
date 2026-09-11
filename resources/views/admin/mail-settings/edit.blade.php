<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Configurações de E-mail (SMTP)
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @if (session('status'))
                <div class="p-4 bg-green-100 text-green-800 rounded-md text-sm font-medium">
                    {{ session('status') }}
                </div>
            @endif

            <div class="bg-white rounded-lg shadow-sm p-4 text-sm text-gray-600">
                Configure aqui as credenciais SMTP para envio real de e-mails (ex: Gmail). Se os campos ficarem
                em branco, o sistema continua usando o driver de log (padrão de desenvolvimento).
            </div>

            <form method="POST" action="{{ route('admin.mail-settings.update') }}" class="bg-white rounded-lg shadow-sm p-6 space-y-4">
                @csrf
                @method('PATCH')

                <div>
                    <x-input-label for="mail_host" :value="__('Host SMTP')" />
                    <x-text-input id="mail_host" name="mail_host" type="text" class="mt-1 block w-full"
                        placeholder="smtp.gmail.com" :value="old('mail_host', $mailSetting->mail_host)" required />
                    <x-input-error :messages="$errors->get('mail_host')" class="mt-2" />
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <x-input-label for="mail_port" :value="__('Porta')" />
                        <x-text-input id="mail_port" name="mail_port" type="text" class="mt-1 block w-full"
                            placeholder="587" :value="old('mail_port', $mailSetting->mail_port)" required />
                        <x-input-error :messages="$errors->get('mail_port')" class="mt-2" />
                    </div>
                    <div>
                        <x-input-label for="mail_encryption" :value="__('Criptografia')" />
                        <select id="mail_encryption" name="mail_encryption" class="mt-1 block w-full rounded-md border-gray-300" required>
                            <option value="tls" @selected(old('mail_encryption', $mailSetting->mail_encryption) === 'tls')>TLS</option>
                            <option value="ssl" @selected(old('mail_encryption', $mailSetting->mail_encryption) === 'ssl')>SSL</option>
                        </select>
                        <x-input-error :messages="$errors->get('mail_encryption')" class="mt-2" />
                    </div>
                </div>

                <div>
                    <x-input-label for="mail_username" :value="__('Usuário (e-mail de login)')" />
                    <x-text-input id="mail_username" name="mail_username" type="email" class="mt-1 block w-full"
                        :value="old('mail_username', $mailSetting->mail_username)" required />
                    <x-input-error :messages="$errors->get('mail_username')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="mail_password" :value="__('Senha de App')" />
                    <x-text-input id="mail_password" name="mail_password" type="password" class="mt-1 block w-full"
                        placeholder="Deixe em branco para manter a senha atual" />
                    <x-input-error :messages="$errors->get('mail_password')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="mail_from_address" :value="__('E-mail de Remetente')" />
                    <x-text-input id="mail_from_address" name="mail_from_address" type="email" class="mt-1 block w-full"
                        :value="old('mail_from_address', $mailSetting->mail_from_address)" required />
                    <x-input-error :messages="$errors->get('mail_from_address')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="mail_from_name" :value="__('Nome de Remetente')" />
                    <x-text-input id="mail_from_name" name="mail_from_name" type="text" class="mt-1 block w-full"
                        placeholder="Vendas Laravel" :value="old('mail_from_name', $mailSetting->mail_from_name)" required />
                    <x-input-error :messages="$errors->get('mail_from_name')" class="mt-2" />
                </div>

                <x-primary-button>Salvar Configurações</x-primary-button>
            </form>

            <div class="bg-white rounded-lg shadow-sm p-6">
                <h3 class="font-semibold text-gray-900 mb-2">Testar Configuração</h3>
                <p class="text-sm text-gray-600 mb-4">
                    Envia um e-mail de teste para o seu próprio e-mail ({{ auth()->user()->email }}), usando a configuração salva acima.
                </p>
                <form method="POST" action="{{ route('admin.mail-settings.test') }}">
                    @csrf
                    <x-secondary-button type="submit">Enviar E-mail de Teste</x-secondary-button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>