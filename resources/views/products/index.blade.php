<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Catálogo de Produtos
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($products as $product)
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-4">
                        <h3 class="text-lg font-bold text-gray-900">{{ $product->name }}</h3>
                        <p class="text-sm text-gray-500 mb-2">{{ $product->category->name ?? 'Sem categoria' }}</p>
                        <p class="text-gray-700 mb-3">{{ $product->description }}</p>
                        <p class="text-xl font-semibold text-green-600">R$ {{ number_format($product->price, 2, ',', '.') }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</x-app-layout>