<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="text-2xl font-bold tracking-tight text-slate-900 dark:text-white">
                Painel Admin — Usuários
            </h2>
            <p class="text-sm text-slate-500 dark:text-slate-400 mt-0.5">
                Gerencie as contas de usuários e permissões de acesso administrativo
            </p>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

            @if (session('status'))
                <div class="flex items-center gap-2 p-4 text-sm font-medium text-sky-800 dark:text-sky-300 bg-sky-50 dark:bg-sky-950/40 border border-sky-200 dark:border-sky-800/60 rounded-xl">
                    <svg class="w-5 h-5 text-sky-600 dark:text-sky-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z" />
                    </svg>
                    <span>{{ session('status') }}</span>
                </div>
            @endif

            <div class="bg-white dark:bg-slate-900 rounded-xl border border-slate-200/80 dark:border-slate-800 shadow-sm overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left">
                        <thead class="bg-slate-50 dark:bg-slate-800/60 text-slate-500 dark:text-slate-400 border-b border-slate-200 dark:border-slate-800 text-xs uppercase tracking-wider">
                            <tr>
                                <th class="py-3.5 px-4 font-semibold">Nome</th>
                                <th class="py-3.5 px-4 font-semibold">E-mail</th>
                                <th class="py-3.5 px-4 font-semibold">Permissão</th>
                                <th class="py-3.5 px-4 font-semibold text-right">Ação</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                            @foreach ($users as $user)
                                <tr class="hover:bg-slate-50/70 dark:hover:bg-slate-800/30 transition-colors">
                                    <td class="py-3.5 px-4 font-semibold text-slate-900 dark:text-white">
                                        {{ $user->name }}
                                    </td>
                                    <td class="py-3.5 px-4 text-slate-600 dark:text-slate-400">
                                        {{ $user->email }}
                                    </td>
                                    <td class="py-3.5 px-4">
                                        <span @class([
                                            'inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold',
                                            'bg-navy-100 text-navy-800 dark:bg-navy-950/60 dark:text-navy-300' => $user->is_admin,
                                            'bg-slate-100 text-slate-700 dark:bg-slate-800 dark:text-slate-300' => ! $user->is_admin,
                                        ])>
                                            {{ $user->is_admin ? 'Admin' : 'Cliente' }}
                                        </span>
                                    </td>
                                    <td class="py-3.5 px-4 text-right whitespace-nowrap">
                                        @if ($user->id === auth()->id())
                                            <span class="inline-flex items-center text-xs font-medium text-slate-400 dark:text-slate-500 bg-slate-100 dark:bg-slate-800/50 px-2.5 py-1 rounded-full">
                                                Sua Conta
                                            </span>
                                        @else
                                            <form method="POST" action="{{ route('admin.users.toggle-admin', $user) }}" class="inline"
                                                onsubmit="return confirm('{{ $user->is_admin ? 'Remover' : 'Conceder' }} permissão de admin para {{ $user->name }}?');">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" @class([
                                                    'text-xs font-semibold transition-colors',
                                                    'text-rose-600 dark:text-rose-400 hover:text-rose-800 dark:hover:text-rose-300' => $user->is_admin,
                                                    'text-navy-600 dark:text-navy-400 hover:text-navy-800 dark:hover:text-navy-300' => ! $user->is_admin,
                                                ])>
                                                    {{ $user->is_admin ? 'Remover admin' : 'Tornar admin' }}
                                                </button>
                                            </form>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>