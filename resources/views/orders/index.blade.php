<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Meus Pedidos
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            @if ($orders->isEmpty())
                <div class="bg-white p-6 rounded-lg shadow-sm text-gray-600">
                    Você ainda não fez nenhum pedido.
                    <a href="{{ route('products.index') }}" class="text-indigo-600 hover:underline">Ver produtos</a>
                </div>
            @else
                <div class="bg-white rounded-lg shadow-sm divide-y">
                    @foreach ($orders as $order)
                        <a href="{{ route('orders.show', $order) }}" class="block p-4 hover:bg-gray-50">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="font-semibold text-gray-900">Pedido #{{ $order->order_number }}</p>
                                    <p class="text-sm text-gray-500">{{ $order->created_at->format('d/m/Y H:i') }}</p>
                                </div>
                                <div class="text-right">
                                    <span class="inline-block px-3 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                        {{ ucfirst($order->status) }}
                                    </span>
                                    <p class="font-bold text-green-600 mt-1">
                                        R$ {{ number_format($order->total, 2, ',', '.') }}
                                    </p>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</x-app-layout>