<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Meu Carrinho
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            <div class="mb-4">
                <a href="{{ route('products.index') }}" class="text-indigo-600 hover:underline text-sm">
                    ← Continuar comprando
                </a>
            </div>

            @if ($items->isEmpty())
                <div class="bg-white p-6 rounded-lg shadow-sm text-gray-600">
                    Seu carrinho está vazio.
                </div>
            @else
                <div class="bg-white rounded-lg shadow-sm divide-y">
                    @foreach ($items as $item)
                        <div class="p-4 flex items-center justify-between gap-4">
                            <div class="flex-1">
                                <h3 class="font-semibold text-gray-900">{{ $item->product->name }}</h3>
                                <p class="text-sm text-gray-500">
                                    Valor unitário: R$ {{ number_format($item->product->price, 2, ',', '.') }}
                                </p>
                            </div>

                            <form method="POST" action="{{ route('cart.update', $item) }}" class="flex items-center gap-2">
                                @csrf
                                @method('PATCH')
                                <label class="text-sm text-gray-600">Qtd:</label>
                                <input type="number" name="quantity" value="{{ $item->quantity }}" min="1"
                                    onchange="this.form.submit()"
                                    class="w-16 rounded-md border-gray-300 text-sm" />
                            </form>

                            <p class="w-28 text-right font-semibold text-gray-900">
                                R$ {{ number_format($item->subtotal(), 2, ',', '.') }}
                            </p>

                            <form method="POST" action="{{ route('cart.remove', $item) }}">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-sm text-red-600 hover:underline">
                                    Remover
                                </button>
                            </form>
                        </div>
                    @endforeach
                </div>

                <div class="mt-6 bg-white p-4 rounded-lg shadow-sm flex items-center justify-between">
                    <span class="text-lg font-semibold text-gray-900">Total:</span>
                    <span class="text-2xl font-bold text-green-600">
                        R$ {{ number_format($total, 2, ',', '.') }}
                    </span>
                </div>

                <div class="mt-4 text-right">
                    <button disabled class="bg-gray-300 text-gray-600 px-6 py-2 rounded-md cursor-not-allowed">
                        Finalizar Compra (em breve)
                    </button>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>