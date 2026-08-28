<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Painel Admin — Produtos
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">

            @if (session('status'))
                <div class="mb-4 p-3 bg-green-100 text-green-800 rounded-md text-sm">
                    {{ session('status') }}
                </div>
            @endif

            <div class="mb-4">
                <a href="{{ route('admin.products.create') }}" class="inline-block bg-indigo-600 text-white text-sm px-4 py-2 rounded-md hover:bg-indigo-700">
                    + Novo Produto
                </a>
            </div>

            <div class="bg-white rounded-lg shadow-sm overflow-hidden">
                <table class="w-full text-sm">
                    <thead class="bg-gray-50 text-left text-gray-500">
                        <tr>
                            <th class="p-3">Nome</th>
                            <th class="p-3">Categoria</th>
                            <th class="p-3">Preço</th>
                            <th class="p-3">Estoque</th>
                            <th class="p-3"></th>
                        </tr>
                    </thead>
                    <tbody class="divide-y">
                        @foreach ($products as $product)
                            <tr>
                                <td class="p-3 font-medium text-gray-900">{{ $product->name }}</td>
                                <td class="p-3 text-gray-500">{{ $product->category->name ?? 'Sem categoria' }}</td>
                                <td class="p-3">R$ {{ number_format($product->price, 2, ',', '.') }}</td>
                                <td class="p-3">{{ $product->stock }}</td>
                                <td class="p-3 text-right space-x-2">
                                    <a href="{{ route('admin.products.edit', $product) }}" class="text-indigo-600 hover:underline text-xs">Editar</a>
                                    <span class="text-gray-300 text-xs">excluir em breve</span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>