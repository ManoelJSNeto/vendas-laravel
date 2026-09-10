<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Painel Admin — Categorias
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">

            @if (session('status'))
                <div class="mb-4 p-3 bg-green-100 text-green-800 rounded-md text-sm">
                    {{ session('status') }}
                </div>
            @endif

            <div class="mb-4">
                <a href="{{ route('admin.categories.create') }}" class="inline-block bg-indigo-600 text-white text-sm px-4 py-2 rounded-md hover:bg-indigo-700">
                    + Nova Categoria
                </a>
            </div>

            <div class="bg-white rounded-lg shadow-sm overflow-hidden">
                <table class="w-full text-sm">
                    <thead class="bg-gray-50 text-left text-gray-500">
                        <tr>
                            <th class="p-3">Nome</th>
                            <th class="p-3">Produtos</th>
                            <th class="p-3 text-right"></th>
                        </tr>
                    </thead>
                    <tbody class="divide-y">
                        @foreach ($categories as $category)
                            <tr>
                                <td class="p-3 font-medium text-gray-900">{{ $category->name }}</td>
                                <td class="p-3 text-gray-500">{{ $category->products_count }}</td>
                                <td class="p-3 text-right space-x-2">
                                    <a href="{{ route('admin.categories.edit', $category) }}" class="text-indigo-600 hover:underline text-xs">Editar</a>
                                    <form method="POST" action="{{ route('admin.categories.destroy', $category) }}" class="inline"
                                        onsubmit="return confirm('Tem certeza que deseja excluir esta categoria? Os produtos vinculados ficarão sem categoria.');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:underline text-xs">Excluir</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>