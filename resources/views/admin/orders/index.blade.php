<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2">
            <div>
                <h2 class="text-2xl font-bold tracking-tight text-slate-900 dark:text-white">
                    Painel Admin — Pedidos
                </h2>
                <p class="text-sm text-slate-500 dark:text-slate-400 mt-0.5">
                    Visão geral de métricas, gráficos e gerenciamento de pedidos
                </p>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

            <!-- KPIs -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                <div class="bg-white dark:bg-slate-900 rounded-xl p-5 border border-slate-200/80 dark:border-slate-800 shadow-sm">
                    <div class="flex items-center justify-between">
                        <span class="text-xs font-semibold uppercase tracking-wider text-slate-500 dark:text-slate-400">Total Vendido</span>
                        <span class="p-2 rounded-lg bg-emerald-50 dark:bg-emerald-950/50 text-emerald-600 dark:text-emerald-400">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.75">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m-3-2.818l.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </span>
                    </div>
                    <p class="text-2xl font-bold tracking-tight text-slate-900 dark:text-white mt-2">
                        R$ {{ number_format($totalVendido, 2, ',', '.') }}
                    </p>
                </div>

                <div class="bg-white dark:bg-slate-900 rounded-xl p-5 border border-slate-200/80 dark:border-slate-800 shadow-sm">
                    <div class="flex items-center justify-between">
                        <span class="text-xs font-semibold uppercase tracking-wider text-slate-500 dark:text-slate-400">Total de Pedidos</span>
                        <span class="p-2 rounded-lg bg-navy-50 dark:bg-navy-950/50 text-navy-600 dark:text-navy-400">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.75">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 10-7.5 0v4.5m11.356-1.993l1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 01-1.12-1.243l1.264-12A1.125 1.125 0 015.513 7.5h12.974c.576 0 1.059.435 1.119 1.007zM8.625 10.5a.375.375 0 11-.75 0 .375.375 0 01.75 0zm7.5 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" />
                            </svg>
                        </span>
                    </div>
                    <p class="text-2xl font-bold tracking-tight text-slate-900 dark:text-white mt-2">
                        {{ $totalPedidos }}
                    </p>
                </div>

                <div class="bg-white dark:bg-slate-900 rounded-xl p-5 border border-slate-200/80 dark:border-slate-800 shadow-sm">
                    <div class="flex items-center justify-between">
                        <span class="text-xs font-semibold uppercase tracking-wider text-slate-500 dark:text-slate-400">Ticket Médio</span>
                        <span class="p-2 rounded-lg bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-300">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.75">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 013 19.875v-6.75zM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V8.625zM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V4.125z" />
                            </svg>
                        </span>
                    </div>
                    <p class="text-2xl font-bold tracking-tight text-slate-900 dark:text-white mt-2">
                        R$ {{ number_format($ticketMedio, 2, ',', '.') }}
                    </p>
                </div>

                <div class="bg-white dark:bg-slate-900 rounded-xl p-5 border border-slate-200/80 dark:border-slate-800 shadow-sm">
                    <div class="flex items-center justify-between">
                        <span class="text-xs font-semibold uppercase tracking-wider text-slate-500 dark:text-slate-400">Pedidos Pendentes</span>
                        <span class="p-2 rounded-lg bg-amber-50 dark:bg-amber-950/50 text-amber-600 dark:text-amber-400">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.75">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </span>
                    </div>
                    <p class="text-2xl font-bold tracking-tight text-amber-600 dark:text-amber-400 mt-2">
                        {{ $pedidosPendentes }}
                    </p>
                </div>
            </div>

            <!-- Gráficos -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <div class="lg:col-span-2 bg-white dark:bg-slate-900 rounded-xl p-5 border border-slate-200/80 dark:border-slate-800 shadow-sm">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-base font-semibold text-slate-900 dark:text-white">Vendas por Dia</h3>
                        <span class="text-xs text-slate-500 dark:text-slate-400">Últimos períodos</span>
                    </div>
                    <div class="relative h-72 w-full">
                        <canvas id="vendasPorDiaChart"></canvas>
                    </div>
                </div>

                <div class="bg-white dark:bg-slate-900 rounded-xl p-5 border border-slate-200/80 dark:border-slate-800 shadow-sm">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-base font-semibold text-slate-900 dark:text-white">Pedidos por Status</h3>
                        <span class="text-xs text-slate-500 dark:text-slate-400">Distribuição</span>
                    </div>
                    <div class="relative h-72 w-full flex items-center justify-center">
                        <canvas id="pedidosPorStatusChart"></canvas>
                    </div>
                </div>
            </div>

            <!-- Filtro de Pedidos -->
            <div class="bg-white dark:bg-slate-900 p-5 rounded-xl border border-slate-200/80 dark:border-slate-800 shadow-sm">
                <form method="GET" action="{{ route('admin.orders.index') }}" class="flex flex-col sm:flex-row sm:items-end gap-3">
                    <div class="w-full sm:w-64">
                        <label class="block text-xs font-medium uppercase tracking-wider text-slate-500 dark:text-slate-400 mb-1.5">Filtrar por Status</label>
                        <select name="status" class="w-full rounded-lg border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-800 dark:text-slate-200 text-sm focus:border-navy-500 focus:ring-navy-500">
                            <option value="">Todos os status</option>
                            <option value="pending" @selected(request('status') === 'pending')>Pendente</option>
                            <option value="paid" @selected(request('status') === 'paid')>Pago</option>
                            <option value="shipped" @selected(request('status') === 'shipped')>Enviado</option>
                            <option value="cancelled" @selected(request('status') === 'cancelled')>Cancelado</option>
                        </select>
                    </div>
                    <div class="flex items-center gap-2">
                        <button type="submit" class="inline-flex items-center gap-1.5 px-4 py-2 text-sm font-medium rounded-lg text-white bg-slate-900 dark:bg-slate-100 dark:text-slate-900 hover:bg-slate-800 dark:hover:bg-white transition shadow-sm">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 3c2.755 0 5.455.232 8.083.678.533.09.917.556.917 1.096v1.044a2.25 2.25 0 01-.659 1.591l-5.432 5.432a2.25 2.25 0 00-.659 1.591v2.927a2.25 2.25 0 01-1.244 2.013L9.75 21v-6.568a2.25 2.25 0 00-.659-1.591L3.659 7.409A2.25 2.25 0 013 5.818V4.774c0-.54.384-1.006.917-1.096A48.32 48.32 0 0112 3z" />
                            </svg>
                            Filtrar
                        </button>
                        @if (request('status'))
                            <a href="{{ route('admin.orders.index') }}" class="text-sm font-medium text-slate-500 hover:text-slate-800 dark:text-slate-400 dark:hover:text-slate-200 px-3 py-2 transition-colors">
                                Limpar
                            </a>
                        @endif
                    </div>
                </form>
            </div>

            <!-- Tabela de Pedidos -->
            <div class="bg-white dark:bg-slate-900 rounded-xl border border-slate-200/80 dark:border-slate-800 shadow-sm overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left">
                        <thead class="bg-slate-50 dark:bg-slate-800/60 text-slate-500 dark:text-slate-400 border-b border-slate-200 dark:border-slate-800 text-xs uppercase tracking-wider">
                            <tr>
                                <th class="py-3.5 px-4 font-semibold">Cliente</th>
                                <th class="py-3.5 px-4 font-semibold">Pedido</th>
                                <th class="py-3.5 px-4 font-semibold">Data</th>
                                <th class="py-3.5 px-4 font-semibold">Status</th>
                                <th class="py-3.5 px-4 font-semibold">Pagamento</th>
                                <th class="py-3.5 px-4 font-semibold text-right">Total</th>
                                <th class="py-3.5 px-4 font-semibold text-right">Ação</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                            @forelse ($orders as $order)
                                <tr class="hover:bg-slate-50/70 dark:hover:bg-slate-800/30 transition-colors">
                                    <td class="py-3.5 px-4 font-medium text-slate-900 dark:text-white">
                                        {{ $order->user->name }}
                                        <div class="text-xs text-slate-400 font-normal">{{ $order->user->email }}</div>
                                    </td>
                                    <td class="py-3.5 px-4 font-mono text-xs text-slate-600 dark:text-slate-400">
                                        #{{ $order->order_number }}
                                    </td>
                                    <td class="py-3.5 px-4 text-slate-500 dark:text-slate-400 text-xs whitespace-nowrap">
                                        {{ $order->created_at->format('d/m/Y H:i') }}
                                    </td>
                                    <td class="py-3.5 px-4 whitespace-nowrap">
                                        <form method="POST" action="{{ route('admin.orders.update-status', $order) }}"
                                            onchange="this.submit()">
                                            @csrf
                                            @method('PATCH')
                                            <select name="status" @class([
                                                'text-xs font-semibold rounded-full border border-transparent py-1 pl-2.5 pr-7 cursor-pointer focus:outline-none focus:ring-2 focus:ring-offset-1 transition',
                                                'bg-emerald-100 text-emerald-800 dark:bg-emerald-950/60 dark:text-emerald-300 dark:border-emerald-800/50' => $order->status === 'paid',
                                                'bg-amber-100 text-amber-800 dark:bg-amber-950/60 dark:text-amber-300 dark:border-amber-800/50' => $order->status === 'pending',
                                                'bg-sky-100 text-sky-800 dark:bg-sky-950/60 dark:text-sky-300 dark:border-sky-800/50' => $order->status === 'shipped',
                                                'bg-rose-100 text-rose-800 dark:bg-rose-950/60 dark:text-rose-300 dark:border-rose-800/50' => $order->status === 'cancelled',
                                            ])>
                                                <option value="pending" @selected($order->status === 'pending')>Pendente</option>
                                                <option value="paid" @selected($order->status === 'paid')>Pago</option>
                                                <option value="shipped" @selected($order->status === 'shipped')>Enviado</option>
                                                <option value="cancelled" @selected($order->status === 'cancelled')>Cancelado</option>
                                            </select>
                                        </form>
                                    </td>
                                    <td class="py-3.5 px-4 text-slate-600 dark:text-slate-400 capitalize whitespace-nowrap">
                                        {{ $order->payment_method }}
                                    </td>
                                    <td class="py-3.5 px-4 text-right font-semibold text-slate-900 dark:text-white whitespace-nowrap">
                                        R$ {{ number_format($order->total, 2, ',', '.') }}
                                    </td>
                                    <td class="py-3.5 px-4 text-right whitespace-nowrap">
                                        <a href="{{ route('admin.orders.show', $order) }}" class="inline-flex items-center gap-1 text-xs font-semibold text-navy-600 dark:text-navy-400 hover:text-navy-800 dark:hover:text-navy-300 transition-colors">
                                            <span>Detalhes</span>
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                                            </svg>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="py-8 text-center text-slate-500 dark:text-slate-400">
                                        Nenhum pedido encontrado.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            (function() {
                const isDark = document.documentElement.classList.contains('dark');
                const textColor = isDark ? '#94a3b8' : '#64748b';
                const gridColor = isDark ? 'rgba(51, 65, 85, 0.4)' : 'rgba(226, 232, 240, 0.8)';
                const navyPrimary = isDark ? '#38bdf8' : '#0f172a';
                const navyFill = isDark ? 'rgba(56, 189, 248, 0.12)' : 'rgba(15, 23, 42, 0.06)';

                // Vendas por Dia
                const vendasEl = document.getElementById('vendasPorDiaChart');
                if (vendasEl) {
                    new Chart(vendasEl, {
                        type: 'line',
                        data: {
                            labels: {!! json_encode($vendasPorDia->keys()) !!},
                            datasets: [{
                                label: 'Vendas (R$)',
                                data: {!! json_encode($vendasPorDia->values()) !!},
                                borderColor: navyPrimary,
                                backgroundColor: navyFill,
                                borderWidth: 2.5,
                                pointBackgroundColor: navyPrimary,
                                pointBorderColor: isDark ? '#0f172a' : '#ffffff',
                                pointBorderWidth: 2,
                                pointRadius: 4,
                                pointHoverRadius: 6,
                                tension: 0.3,
                                fill: true,
                            }],
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: {
                                legend: { display: false },
                                tooltip: {
                                    callbacks: {
                                        label: function(context) {
                                            return ' R$ ' + Number(context.raw).toLocaleString('pt-BR', { minimumFractionDigits: 2 });
                                        }
                                    }
                                }
                            },
                            scales: {
                                x: {
                                    ticks: { color: textColor, font: { size: 11 } },
                                    grid: { color: gridColor, drawBorder: false },
                                },
                                y: {
                                    ticks: {
                                        color: textColor,
                                        font: { size: 11 },
                                        callback: function(val) { return 'R$ ' + val; }
                                    },
                                    grid: { color: gridColor, drawBorder: false },
                                }
                            }
                        },
                    });
                }

                // Pedidos por Status
                const statusEl = document.getElementById('pedidosPorStatusChart');
                if (statusEl) {
                    new Chart(statusEl, {
                        type: 'doughnut',
                        data: {
                            labels: {!! json_encode(array_keys($pedidosPorStatus)) !!},
                            datasets: [{
                                data: {!! json_encode(array_values($pedidosPorStatus)) !!},
                                backgroundColor: ['#10b981', '#f59e0b', '#0284c7', '#f43f5e'],
                                borderWidth: 2,
                                borderColor: isDark ? '#0f172a' : '#ffffff',
                            }],
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: {
                                legend: {
                                    position: 'bottom',
                                    labels: {
                                        color: textColor,
                                        padding: 14,
                                        font: { size: 12, weight: '500' }
                                    }
                                }
                            },
                            cutout: '68%',
                        },
                    });
                }
            })();
        </script>
    @endpush
</x-app-layout>