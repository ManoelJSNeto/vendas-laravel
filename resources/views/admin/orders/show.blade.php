<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <div>
                <div class="flex items-center gap-2">
                    <a href="{{ route('admin.orders.index') }}" class="text-slate-400 hover:text-slate-600 dark:hover:text-slate-300 transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
                        </svg>
                    </a>
                    <h2 class="text-2xl font-bold tracking-tight text-slate-900 dark:text-white">
                        Pedido #{{ $order->order_number }}
                    </h2>
                </div>
                <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">
                    Cliente: {{ $order->user->name }} ({{ $order->user->email }})
                </p>
            </div>
            <div>
                <a href="{{ route('admin.orders.index') }}" class="inline-flex items-center gap-1.5 px-3.5 py-2 text-xs font-semibold rounded-lg text-slate-700 dark:text-slate-200 bg-white dark:bg-slate-800 border border-slate-300 dark:border-slate-700 hover:bg-slate-50 dark:hover:bg-slate-700 transition">
                    Voltar aos pedidos
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

            @if (session('status'))
                <div class="flex items-center gap-2 p-4 text-sm font-medium text-emerald-800 dark:text-emerald-300 bg-emerald-50 dark:bg-emerald-950/40 border border-emerald-200 dark:border-emerald-800/60 rounded-xl">
                    <svg class="w-5 h-5 text-emerald-600 dark:text-emerald-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span>{{ session('status') }}</span>
                </div>
            @endif

            <!-- Informações do Pedido e Status -->
            <div class="bg-white dark:bg-slate-900 rounded-xl border border-slate-200/80 dark:border-slate-800 p-6 shadow-sm">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 pb-6 border-b border-slate-100 dark:divide-slate-800">
                    <div>
                        <span class="text-xs font-semibold uppercase tracking-wider text-slate-400 dark:text-slate-500">Dados do Cliente</span>
                        <p class="font-bold text-slate-900 dark:text-white mt-1.5 text-base">{{ $order->user->name }}</p>
                        <p class="text-sm text-slate-500 dark:text-slate-400">{{ $order->user->email }}</p>
                        @if ($order->user->telefone)
                            <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">{{ $order->user->telefone }}</p>
                        @endif
                    </div>
                    <div class="sm:text-right">
                        <span class="text-xs font-semibold uppercase tracking-wider text-slate-400 dark:text-slate-500">Data e Hora</span>
                        <p class="font-bold text-slate-900 dark:text-white mt-1.5 text-base">{{ $order->created_at->format('d/m/Y \à\s H:i') }}</p>
                        @if ($order->paid_at)
                            <p class="text-xs text-emerald-600 dark:text-emerald-400 font-medium mt-0.5">
                                Pago em {{ $order->paid_at->format('d/m/Y H:i') }}
                            </p>
                        @endif
                    </div>
                </div>

                <div class="pt-5 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                    <div>
                        <label class="block text-xs font-semibold uppercase tracking-wider text-slate-400 dark:text-slate-500 mb-1.5">Atualizar Status</label>
                        <form method="POST" action="{{ route('admin.orders.update-status', $order) }}">
                            @csrf
                            @method('PATCH')
                            <select name="status" onchange="this.form.submit()" @class([
                                'text-sm font-semibold rounded-lg border py-1.5 pl-3 pr-8 cursor-pointer focus:outline-none focus:ring-2 focus:ring-offset-1 transition',
                                'bg-emerald-50 text-emerald-800 border-emerald-200 dark:bg-emerald-950/50 dark:text-emerald-300 dark:border-emerald-800/60' => $order->status === 'paid',
                                'bg-amber-50 text-amber-800 border-amber-200 dark:bg-amber-950/50 dark:text-amber-300 dark:border-amber-800/60' => $order->status === 'pending',
                                'bg-sky-50 text-sky-800 border-sky-200 dark:bg-sky-950/50 dark:text-sky-300 dark:border-sky-800/60' => $order->status === 'shipped',
                                'bg-rose-50 text-rose-800 border-rose-200 dark:bg-rose-950/50 dark:text-rose-300 dark:border-rose-800/60' => $order->status === 'cancelled',
                            ])>
                                <option value="pending" @selected($order->status === 'pending')>Pendente</option>
                                <option value="paid" @selected($order->status === 'paid')>Pago</option>
                                <option value="shipped" @selected($order->status === 'shipped')>Enviado</option>
                                <option value="cancelled" @selected($order->status === 'cancelled')>Cancelado</option>
                            </select>
                        </form>
                    </div>
                    <div class="sm:text-right">
                        <span class="block text-xs font-semibold uppercase tracking-wider text-slate-400 dark:text-slate-500 mb-1">Método de Pagamento</span>
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold uppercase tracking-wide bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-300">
                            {{ $order->payment_method }}
                        </span>
                    </div>
                </div>
            </div>

            <!-- Itens do Pedido -->
            <div class="bg-white dark:bg-slate-900 rounded-xl border border-slate-200/80 dark:border-slate-800 p-6 shadow-sm">
                <h3 class="text-base font-bold text-slate-900 dark:text-white mb-4">Itens Comprados</h3>
                <div class="divide-y divide-slate-100 dark:divide-slate-800">
                    @foreach ($order->items as $item)
                        <div class="py-3 flex items-center justify-between text-sm">
                            <div>
                                <span class="font-medium text-slate-900 dark:text-white">{{ $item->product->name }}</span>
                                <span class="text-xs text-slate-500 dark:text-slate-400 ml-2">× {{ $item->quantity }}</span>
                            </div>
                            <span class="font-semibold text-slate-900 dark:text-white">
                                R$ {{ number_format($item->quantity * $item->unit_price, 2, ',', '.') }}
                            </span>
                        </div>
                    @endforeach
                </div>
                <div class="mt-4 pt-4 border-t border-slate-200 dark:border-slate-800 flex justify-between items-center text-base">
                    <span class="font-bold text-slate-900 dark:text-white">Valor Total</span>
                    <span class="font-extrabold text-xl text-slate-900 dark:text-white">
                        R$ {{ number_format($order->total, 2, ',', '.') }}
                    </span>
                </div>
            </div>

            <!-- Endereço de Entrega -->
            <div class="bg-white dark:bg-slate-900 rounded-xl border border-slate-200/80 dark:border-slate-800 p-6 shadow-sm">
                <h3 class="text-base font-bold text-slate-900 dark:text-white mb-3">Endereço de Entrega</h3>
                <p class="text-sm text-slate-600 dark:text-slate-300 leading-relaxed">
                    {{ $order->address->logradouro }}, {{ $order->address->numero }}
                    @if ($order->address->complemento) — {{ $order->address->complemento }} @endif
                    <br>
                    {{ $order->address->bairro }} — {{ $order->address->cidade }}/{{ $order->address->uf }}
                    <br>
                    <span class="font-mono text-xs text-slate-500 dark:text-slate-400">CEP: {{ $order->address->cep }}</span>
                </p>
            </div>

        </div>
    </div>
</x-app-layout>