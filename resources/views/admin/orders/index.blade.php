<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Painel Admin — Pedidos
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">

            <div class="grid grid-cols-1 sm:grid-cols-4 gap-4 mb-6">
                <div class="bg-white rounded-lg shadow-sm p-4">
                    <p class="text-sm text-gray-500">Total Vendido</p>
                    <p class="text-2xl font-bold text-green-600">R$ {{ number_format($totalVendido, 2, ',', '.') }}</p>
                </div>
                <div class="bg-white rounded-lg shadow-sm p-4">
                    <p class="text-sm text-gray-500">Total de Pedidos</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $totalPedidos }}</p>
                </div>
                <div class="bg-white rounded-lg shadow-sm p-4">
                    <p class="text-sm text-gray-500">Ticket Médio</p>
                    <p class="text-2xl font-bold text-gray-900">R$ {{ number_format($ticketMedio, 2, ',', '.') }}</p>
                </div>
                <div class="bg-white rounded-lg shadow-sm p-4">
                    <p class="text-sm text-gray-500">Pedidos Pendentes</p>
                    <p class="text-2xl font-bold text-yellow-600">{{ $pedidosPendentes }}</p>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-6">
                <div class="bg-white rounded-lg shadow-sm p-4">
                    <p class="text-sm text-gray-500 mb-2">Vendas por Dia</p>
                    <div class="relative h-64">
                        <canvas id="vendasPorDiaChart"></canvas>
                    </div>
                </div>
                <div class="bg-white rounded-lg shadow-sm p-4">
                    <p class="text-sm text-gray-500 mb-2">Pedidos por Status</p>
                    <div class="relative h-64">
                        <canvas id="pedidosPorStatusChart"></canvas>
                    </div>
                </div>
            </div>

            <form method="GET" action="{{ route('admin.orders.index') }}" class="mb-4 bg-white p-4 rounded-lg shadow-sm flex items-end gap-3">
                <div>
                    <label class="block text-sm text-gray-600 mb-1">Status</label>
                    <select name="status" class="rounded-md border-gray-300 text-sm">
                        <option value="">Todos</option>
                        <option value="pending" @selected(request('status') === 'pending')>Pendente</option>
                        <option value="paid" @selected(request('status') === 'paid')>Pago</option>
                    </select>
                </div>
                <button type="submit" class="bg-indigo-600 text-white text-sm px-4 py-2 rounded-md hover:bg-indigo-700">
                    Filtrar
                </button>
                @if (request('status'))
                    <a href="{{ route('admin.orders.index') }}" class="text-sm text-gray-500 hover:underline">Limpar</a>
                @endif
            </form>

            <div class="bg-white rounded-lg shadow-sm overflow-hidden">
                <table class="w-full text-sm">
                    <thead class="bg-gray-50 text-left text-gray-500">
                        <tr>
                            <th class="p-3">Cliente</th>
                            <th class="p-3">Pedido</th>
                            <th class="p-3">Data</th>
                            <th class="p-3">Status</th>
                            <th class="p-3">Pagamento</th>
                            <th class="p-3 text-right">Total</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y">
                        @foreach ($orders as $order)
                            <tr>
                                <td class="p-3 font-medium text-gray-900">{{ $order->user->name }}</td>
                                <td class="p-3 text-gray-500">#{{ $order->order_number }}</td>
                                <td class="p-3 text-gray-500">{{ $order->created_at->format('d/m/Y H:i') }}</td>
                                <td class="p-3">
                                    <span @class([
                                        'inline-block px-2 py-1 text-xs font-semibold rounded-full',
                                        'bg-green-100 text-green-800' => $order->status === 'paid',
                                        'bg-yellow-100 text-yellow-800' => $order->status === 'pending',
                                    ])>
                                        {{ ucfirst($order->status) }}
                                    </span>
                                </td>
                                <td class="p-3 text-gray-500 capitalize">{{ $order->payment_method }}</td>
                                <td class="p-3 text-right font-semibold text-green-600">
                                    R$ {{ number_format($order->total, 2, ',', '.') }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            new Chart(document.getElementById('vendasPorDiaChart'), {
                type: 'line',
                data: {
                    labels: {!! json_encode($vendasPorDia->keys()) !!},
                    datasets: [{
                        label: 'Vendas (R$)',
                        data: {!! json_encode($vendasPorDia->values()) !!},
                        borderColor: '#4f46e5',
                        backgroundColor: 'rgba(79, 70, 229, 0.1)',
                        tension: 0.3,
                        fill: true,
                    }],
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: { legend: { display: false } },
                },
            });

            new Chart(document.getElementById('pedidosPorStatusChart'), {
                type: 'pie',
                data: {
                    labels: {!! json_encode(array_keys($pedidosPorStatus)) !!},
                    datasets: [{
                        data: {!! json_encode(array_values($pedidosPorStatus)) !!},
                        backgroundColor: ['#16a34a', '#eab308'],
                    }],
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                },
            });
        </script>
    @endpush
</x-app-layout>