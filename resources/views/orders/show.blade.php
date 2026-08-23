<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Pedido #{{ $order->id }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @if (session('status'))
                <div class="p-4 bg-green-100 text-green-800 rounded-md text-sm font-medium">
                    {{ session('status') }}
                </div>
            @endif

            <div class="bg-white rounded-lg shadow-sm p-6">
                <div class="flex justify-between items-start mb-4">
                    <div>
                        <p class="text-sm text-gray-500">Status</p>
                        <span class="inline-block mt-1 px-3 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">
                            {{ ucfirst($order->status) }}
                        </span>
                    </div>
                    <div class="text-right">
                        <p class="text-sm text-gray-500">Data</p>
                        <p class="font-medium">{{ $order->created_at->format('d/m/Y H:i') }}</p>
                    </div>
                </div>

                <div class="border-t pt-4">
                    <p class="text-sm text-gray-500 mb-1">Forma de pagamento</p>
                    <p class="font-medium capitalize">{{ $order->payment_method }}</p>
                </div>

                @if ($order->status === 'pending')
                    <div class="mt-4 pt-4 border-t">
                        <a href="{{ route('payments.show', $order) }}" class="inline-block bg-green-600 text-white px-6 py-2 rounded-md hover:bg-green-700">
                            Pagar Agora
                        </a>
                    </div>
                @endif

            </div>

            <div class="bg-white rounded-lg shadow-sm p-6">
                <h3 class="font-semibold text-gray-900 mb-4">Itens do Pedido</h3>
                <div class="divide-y">
                    @foreach ($order->items as $item)
                        <div class="py-2 flex justify-between text-sm">
                            <span>{{ $item->product->name }} × {{ $item->quantity }}</span>
                            <span class="font-medium">R$ {{ number_format($item->quantity * $item->unit_price, 2, ',', '.') }}</span>
                        </div>
                    @endforeach
                </div>
                <div class="mt-4 pt-4 border-t flex justify-between font-bold text-lg">
                    <span>Total</span>
                    <span class="text-green-600">R$ {{ number_format($order->total, 2, ',', '.') }}</span>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-sm p-6">
                <h3 class="font-semibold text-gray-900 mb-2">Endereço de Entrega</h3>
                <p class="text-sm text-gray-700">
                    {{ $order->address->logradouro }}, {{ $order->address->numero }}
                    @if ($order->address->complemento) - {{ $order->address->complemento }} @endif
                    <br>
                    {{ $order->address->bairro }} — {{ $order->address->cidade }}/{{ $order->address->uf }}
                    <br>
                    CEP: {{ $order->address->cep }}
                </p>
            </div>

            <a href="{{ route('products.index') }}" class="inline-block text-indigo-600 hover:underline text-sm">
                ← Voltar ao catálogo
            </a>
        </div>
    </div>
</x-app-layout>