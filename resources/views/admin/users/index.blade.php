<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Painel Admin — Usuários
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            @if (session('status'))
                <div class="mb-4 p-3 bg-blue-100 text-blue-800 rounded-md text-sm">
                    {{ session('status') }}
                </div>
            @endif

            <div class="bg-white rounded-lg shadow-sm overflow-hidden">
                <table class="w-full text-sm">
                    <thead class="bg-gray-50 text-left text-gray-500">
                        <tr>
                            <th class="p-3">Nome</th>
                            <th class="p-3">E-mail</th>
                            <th class="p-3">Permissão</th>
                            <th class="p-3 text-right">Ação</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y">
                        @foreach ($users as $user)
                            <tr>
                                <td class="p-3 font-medium text-gray-900">{{ $user->name }}</td>
                                <td class="p-3 text-gray-500">{{ $user->email }}</td>
                                <td class="p-3">
                                    <span @class([
                                        'inline-block px-2 py-1 text-xs font-semibold rounded-full',
                                        'bg-indigo-100 text-indigo-800' => $user->is_admin,
                                        'bg-gray-100 text-gray-600' => ! $user->is_admin,
                                    ])>
                                        {{ $user->is_admin ? 'Admin' : 'Cliente' }}
                                    </span>
                                </td>
                                <td class="p-3 text-right">
                                    @if ($user->id === auth()->id())
                                        <span class="text-gray-400 text-xs">Você</span>
                                    @else
                                        <form method="POST" action="{{ route('admin.users.toggle-admin', $user) }}"
                                            onsubmit="return confirm('{{ $user->is_admin ? 'Remover' : 'Conceder' }} permissão de admin para {{ $user->name }}?');">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="text-indigo-600 hover:underline text-xs">
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
</x-app-layout>