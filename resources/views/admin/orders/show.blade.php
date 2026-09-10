<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Pedido #{{ $order->order_number }} — {{ $order->user->name }}
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
                <div class="grid grid-cols-2 gap-4 mb-4">
                    <div>
                        <p class="text-sm text-gray-500">Cliente</p>
                        <p class="font-medium">{{ $order->user->name }}</p>
                        <p class="text-sm text-gray-500">{{ $order->user->email }}</p>
                    </div>
                    <div class="text-right">
                        <p class="text-sm text-gray-500">Data do Pedido</p>
                        <p class="font-medium">{{ $order->created_at->format('d/m/Y H:i') }}</p>
                        @if ($order->paid_at)
                            <p class="text-sm text-gray-500">Pago em {{ $order->paid_at->format('d/m/Y H:i') }}</p>
                        @endif
                    </div>
                </div>

                <div class="border-t pt-4 flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-500">Status</p>
                        <form method="POST" action="{{ route('admin.orders.update-status', $order) }}" class="mt-1">
                            @csrf
                            @method('PATCH')
                            <select name="status" onchange="this.form.submit()" @class([
                                'text-sm font-semibold rounded-full border-0 py-1 pl-3 pr-8',
                                'bg-green-100 text-green-800' => $order->status === 'paid',
                                'bg-yellow-100 text-yellow-800' => $order->status === 'pending',
                                'bg-blue-100 text-blue-800' => $order->status === 'shipped',
                                'bg-red-100 text-red-800' => $order->status === 'cancelled',
                            ])>
                                <option value="pending" @selected($order->status === 'pending')>Pending</option>
                                <option value="paid" @selected($order->status === 'paid')>Paid</option>
                                <option value="shipped" @selected($order->status === 'shipped')>Shipped</option>
                                <option value="cancelled" @selected($order->status === 'cancelled')>Cancelled</option>
                            </select>
                        </form>
                    </div>
                    <div class="text-right">
                        <p class="text-sm text-gray-500">Forma de Pagamento</p>
                        <p class="font-medium capitalize">{{ $order->payment_method }}</p>
                    </div>
                </div>
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

            <a href="{{ route('admin.orders.index') }}" class="inline-block text-indigo-600 hover:underline text-sm">
                ← Voltar para todos os pedidos
            </a>
        </div>
    </div>
</x-app-layout>