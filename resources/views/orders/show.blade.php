<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2">
            <div>
                <h2 class="font-bold text-2xl text-slate-900 dark:text-white leading-tight">
                    Pedido #{{ $order->order_number }}
                </h2>
                <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">Realizado em {{ $order->created_at->format('d/m/Y \à\s H:i') }}</p>
            </div>
            <div>
                <span @class([
                    'inline-flex items-center px-3 py-1 text-xs font-semibold rounded-full border',
                    'bg-emerald-50 text-emerald-700 dark:bg-emerald-950/40 dark:text-emerald-300 border-emerald-200 dark:border-emerald-800' => $order->status === 'paid',
                    'bg-amber-50 text-amber-700 dark:bg-amber-950/40 dark:text-amber-300 border-amber-200 dark:border-amber-800' => $order->status === 'pending',
                    'bg-sky-50 text-sky-700 dark:bg-sky-950/40 dark:text-sky-300 border-sky-200 dark:border-sky-800' => $order->status === 'shipped',
                    'bg-rose-50 text-rose-700 dark:bg-rose-950/40 dark:text-rose-300 border-rose-200 dark:border-rose-800' => $order->status === 'cancelled',
                ])>
                    {{ ucfirst($order->status) }}
                </span>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

            @if (session('status'))
                <div class="p-4 bg-emerald-50 dark:bg-emerald-950/40 border border-emerald-200 dark:border-emerald-800 text-emerald-800 dark:text-emerald-300 rounded-xl text-sm font-medium flex items-center gap-3">
                    <svg class="w-5 h-5 shrink-0 text-emerald-600 dark:text-emerald-400" fill="none" stroke="currentColor" stroke-width="1.75" viewBox="0 0 24 24">
                        <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                        <polyline points="22 4 12 14.01 9 11.01"></polyline>
                    </svg>
                    <span>{{ session('status') }}</span>
                </div>
            @endif

            <div class="bg-white dark:bg-slate-900 border border-slate-200/80 dark:border-slate-800 rounded-xl shadow-xs p-6">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-wider text-slate-500 dark:text-slate-400">Forma de pagamento</p>
                        <p class="font-semibold text-base text-slate-900 dark:text-white capitalize mt-0.5">{{ $order->payment_method }}</p>
                    </div>
                    <div class="sm:text-right">
                        <p class="text-xs font-semibold uppercase tracking-wider text-slate-500 dark:text-slate-400">Data do Pedido</p>
                        <p class="font-medium text-sm text-slate-900 dark:text-white mt-0.5">{{ $order->created_at->format('d/m/Y H:i') }}</p>
                    </div>
                </div>

                @if ($order->status === 'pending')
                    <div class="mt-6 pt-6 border-t border-slate-200 dark:border-slate-800 flex flex-wrap gap-3">
                        <a href="{{ route('payments.show', $order->order_number) }}" class="inline-flex items-center gap-2 bg-emerald-600 hover:bg-emerald-700 text-white font-medium text-sm px-6 py-2.5 rounded-lg shadow-xs transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"></polygon></svg>
                            <span>Pagar Agora</span>
                        </a>
                        <form method="POST" action="{{ route('orders.cancel', $order->order_number) }}"
                            onsubmit="return confirm('Tem certeza que deseja cancelar este pedido?');">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="inline-flex items-center gap-2 bg-rose-50 hover:bg-rose-100 dark:bg-rose-950/30 dark:hover:bg-rose-950/60 text-rose-700 dark:text-rose-400 border border-rose-200 dark:border-rose-800 font-medium text-sm px-5 py-2.5 rounded-lg transition-colors cursor-pointer">
                                <span>Cancelar Pedido</span>
                            </button>
                        </form>
                    </div>
                @endif
            </div>

            <div class="bg-white dark:bg-slate-900 border border-slate-200/80 dark:border-slate-800 rounded-xl shadow-xs p-6">
                <h3 class="font-bold text-lg text-slate-900 dark:text-white mb-4">Itens do Pedido</h3>
                <div class="divide-y divide-slate-100 dark:divide-slate-800">
                    @foreach ($order->items as $item)
                        <div class="py-3 flex justify-between items-center text-sm">
                            <div>
                                <span class="font-medium text-slate-900 dark:text-white">{{ $item->product->name }}</span>
                                <span class="text-slate-500 dark:text-slate-400 text-xs ms-1">× {{ $item->quantity }}</span>
                            </div>
                            <span class="font-semibold text-slate-900 dark:text-white">R$ {{ number_format($item->quantity * $item->unit_price, 2, ',', '.') }}</span>
                        </div>
                    @endforeach
                </div>
                <div class="mt-4 pt-4 border-t border-slate-200 dark:border-slate-800 flex justify-between items-baseline font-bold">
                    <span class="text-base text-slate-700 dark:text-slate-300">Total</span>
                    <span class="text-2xl text-emerald-600 dark:text-emerald-400">R$ {{ number_format($order->total, 2, ',', '.') }}</span>
                </div>
            </div>

            <div class="bg-white dark:bg-slate-900 border border-slate-200/80 dark:border-slate-800 rounded-xl shadow-xs p-6">
                <h3 class="font-bold text-lg text-slate-900 dark:text-white mb-3">Endereço de Entrega</h3>
                <p class="text-sm text-slate-600 dark:text-slate-300 leading-relaxed">
                    {{ $order->address->logradouro }}, {{ $order->address->numero }}
                    @if ($order->address->complemento) — {{ $order->address->complemento }} @endif
                    <br>
                    {{ $order->address->bairro }} — {{ $order->address->cidade }}/{{ $order->address->uf }}
                    <br>
                    <span class="text-slate-500 dark:text-slate-400 text-xs">CEP: {{ $order->address->cep }}</span>
                </p>
            </div>

            <div>
                <a href="{{ route('products.index') }}" class="inline-flex items-center gap-2 text-sm font-medium text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.75" viewBox="0 0 24 24">
                        <path d="M19 12H5M12 19l-7-7 7-7"></path>
                    </svg>
                    <span>Voltar ao catálogo</span>
                </a>
            </div>
        </div>
    </div>
</x-app-layout>