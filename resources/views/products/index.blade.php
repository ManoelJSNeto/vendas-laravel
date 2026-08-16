<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Catálogo de Produtos
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if (session('status'))
                <div class="mb-4 p-3 bg-green-100 text-green-800 rounded-md text-sm">
                    {{ session('status') }}
                </div>
            @endif

            <div class="mb-4">
                <a href="{{ route('cart.index') }}" class="text-indigo-600 hover:underline text-sm">
                    Ver carrinho →
                </a>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($products as $product)
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-4">
                        <h3 class="text-lg font-bold text-gray-900">{{ $product->name }}</h3>
                        <p class="text-sm text-gray-500 mb-2">{{ $product->category->name ?? 'Sem categoria' }}</p>
                        <p class="text-gray-700 mb-3">{{ $product->description }}</p>
                        <p class="text-xl font-semibold text-green-600 mb-3">R$ {{ number_format($product->price, 2, ',', '.') }}</p>

                        <form method="POST" action="{{ route('cart.add', $product) }}">
                            @csrf
                            <button type="submit" class="w-full bg-indigo-600 text-white text-sm py-2 rounded-md hover:bg-indigo-700">
                                Adicionar ao carrinho
                            </button>
                        </form>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</x-app-layout>