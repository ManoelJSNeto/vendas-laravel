<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="text-2xl font-bold tracking-tight text-slate-900 dark:text-white">
                Configurações de E-mail (SMTP)
            </h2>
            <p class="text-sm text-slate-500 dark:text-slate-400 mt-0.5">
                Defina as credenciais para disparos de e-mails transacionais do sistema
            </p>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

            @if (session('status'))
                <div class="flex items-center gap-2 p-4 text-sm font-medium text-emerald-800 dark:text-emerald-300 bg-emerald-50 dark:bg-emerald-950/40 border border-emerald-200 dark:border-emerald-800/60 rounded-xl">
                    <svg class="w-5 h-5 text-emerald-600 dark:text-emerald-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span>{{ session('status') }}</span>
                </div>
            @endif

            <div class="flex items-start gap-3 p-4 bg-slate-50 dark:bg-slate-800/50 border border-slate-200/80 dark:border-slate-800 rounded-xl text-sm text-slate-600 dark:text-slate-300">
                <svg class="w-5 h-5 text-navy-600 dark:text-navy-400 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.75">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z" />
                </svg>
                <div class="leading-relaxed">
                    Configure aqui as credenciais SMTP para envio real de e-mails (ex: Gmail, Sendgrid). Se os campos ficarem em branco, o sistema continua usando o driver de log de desenvolvimento.
                </div>
            </div>

            <form method="POST" action="{{ route('admin.mail-settings.update') }}" class="bg-white dark:bg-slate-900 rounded-xl border border-slate-200/80 dark:border-slate-800 shadow-sm p-6 space-y-5">
                @csrf
                @method('PATCH')

                <div>
                    <x-input-label for="mail_host" :value="__('Host SMTP')" />
                    <x-text-input id="mail_host" name="mail_host" type="text" class="mt-1 block w-full"
                        placeholder="smtp.gmail.com" :value="old('mail_host', $mailSetting->mail_host)" required />
                    <x-input-error :messages="$errors->get('mail_host')" class="mt-2" />
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <x-input-label for="mail_port" :value="__('Porta')" />
                        <x-text-input id="mail_port" name="mail_port" type="text" class="mt-1 block w-full"
                            placeholder="587" :value="old('mail_port', $mailSetting->mail_port)" required />
                        <x-input-error :messages="$errors->get('mail_port')" class="mt-2" />
                    </div>
                    <div>
                        <x-input-label for="mail_encryption" :value="__('Criptografia')" />
                        <select id="mail_encryption" name="mail_encryption" class="mt-1 block w-full rounded-lg border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-900 dark:text-slate-100 text-sm focus:border-navy-500 focus:ring-navy-500 transition" required>
                            <option value="tls" @selected(old('mail_encryption', $mailSetting->mail_encryption) === 'tls')>TLS</option>
                            <option value="ssl" @selected(old('mail_encryption', $mailSetting->mail_encryption) === 'ssl')>SSL</option>
                        </select>
                        <x-input-error :messages="$errors->get('mail_encryption')" class="mt-2" />
                    </div>
                </div>

                <div>
                    <x-input-label for="mail_username" :value="__('Usuário (e-mail de login)')" />
                    <x-text-input id="mail_username" name="mail_username" type="email" class="mt-1 block w-full"
                        :value="old('mail_username', $mailSetting->mail_username)" required placeholder="seu-email@gmail.com" />
                    <x-input-error :messages="$errors->get('mail_username')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="mail_password" :value="__('Senha de App / SMTP')" />
                    <x-text-input id="mail_password" name="mail_password" type="password" class="mt-1 block w-full"
                        placeholder="Deixe em branco para manter a senha atual" />
                    <x-input-error :messages="$errors->get('mail_password')" class="mt-2" />
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <x-input-label for="mail_from_address" :value="__('E-mail de Remetente')" />
                        <x-text-input id="mail_from_address" name="mail_from_address" type="email" class="mt-1 block w-full"
                            :value="old('mail_from_address', $mailSetting->mail_from_address)" required placeholder="noreply@sualoja.com" />
                        <x-input-error :messages="$errors->get('mail_from_address')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="mail_from_name" :value="__('Nome de Remetente')" />
                        <x-text-input id="mail_from_name" name="mail_from_name" type="text" class="mt-1 block w-full"
                            placeholder="Vendas Laravel" :value="old('mail_from_name', $mailSetting->mail_from_name)" required />
                        <x-input-error :messages="$errors->get('mail_from_name')" class="mt-2" />
                    </div>
                </div>

                <div class="pt-2">
                    <x-primary-button>Salvar Configurações</x-primary-button>
                </div>
            </form>

            <div class="bg-white dark:bg-slate-900 rounded-xl border border-slate-200/80 dark:border-slate-800 shadow-sm p-6 space-y-3">
                <h3 class="text-base font-bold text-slate-900 dark:text-white">Testar Conexão de E-mail</h3>
                <p class="text-sm text-slate-500 dark:text-slate-400">
                    Envia uma mensagem de teste para o seu e-mail cadastrado (<strong class="font-medium text-slate-700 dark:text-slate-300">{{ auth()->user()->email }}</strong>) utilizando as credenciais salvas acima.
                </p>
                <form method="POST" action="{{ route('admin.mail-settings.test') }}" class="pt-1">
                    @csrf
                    <x-secondary-button type="submit" class="inline-flex items-center gap-1.5">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.75">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 12L3.269 3.126A59.768 59.768 0 0121.485 12 59.77 59.77 0 013.27 20.876L5.999 12zm0 0h7.5" />
                        </svg>
                        <span>Enviar E-mail de Teste</span>
                    </x-secondary-button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>