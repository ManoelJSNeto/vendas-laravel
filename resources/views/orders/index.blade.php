<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-slate-900 dark:text-white leading-tight">
            Meus Pedidos
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">

            @if ($orders->isEmpty())
                <div class="bg-white dark:bg-slate-900 border border-slate-200/80 dark:border-slate-800 rounded-xl p-12 text-center shadow-xs">
                    <div class="w-16 h-16 mx-auto mb-4 rounded-full bg-slate-100 dark:bg-slate-800 flex items-center justify-center text-slate-400">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" stroke-width="1.75" viewBox="0 0 24 24">
                            <rect x="2" y="7" width="20" height="14" rx="2" ry="2"></rect>
                            <path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"></path>
                        </svg>
                    </div>
                    <h3 class="text-base font-semibold text-slate-900 dark:text-white">Você ainda não fez nenhum pedido</h3>
                    <p class="text-sm text-slate-500 dark:text-slate-400 mt-1 mb-6">Que tal conferir as novidades no catálogo?</p>
                    <a href="{{ route('products.index') }}" class="inline-flex items-center gap-2 px-5 py-2.5 bg-slate-900 dark:bg-slate-100 text-white dark:text-slate-900 text-sm font-medium rounded-lg hover:bg-slate-800 dark:hover:bg-white transition-colors shadow-xs">
                        Ver catálogo de produtos
                    </a>
                </div>
            @else
                <div class="bg-white dark:bg-slate-900 border border-slate-200/80 dark:border-slate-800 rounded-xl shadow-xs overflow-hidden divide-y divide-slate-100 dark:divide-slate-800">
                    @foreach ($orders as $order)
                        <a href="{{ route('orders.show', $order->order_number) }}" class="block p-5 hover:bg-slate-50 dark:hover:bg-slate-800/50 transition-colors group">
                            <div class="flex items-center justify-between gap-4">
                                <div class="flex items-center gap-4">
                                    <div class="w-10 h-10 rounded-lg bg-slate-100 dark:bg-slate-800 flex items-center justify-center text-slate-500 dark:text-slate-400 group-hover:bg-slate-200 dark:group-hover:bg-slate-700 transition-colors">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.75" viewBox="0 0 24 24">
                                            <rect x="2" y="7" width="20" height="14" rx="2" ry="2"></rect>
                                            <path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="font-bold text-base text-slate-900 dark:text-white">Pedido #{{ $order->order_number }}</p>
                                        <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">{{ $order->created_at->format('d/m/Y H:i') }}</p>
                                    </div>
                                </div>

                                <div class="flex items-center gap-6">
                                    <div class="text-right">
                                        <span @class([
                                            'inline-flex items-center px-2.5 py-1 text-xs font-semibold rounded-full border',
                                            'bg-emerald-50 text-emerald-700 dark:bg-emerald-950/40 dark:text-emerald-300 border-emerald-200 dark:border-emerald-800' => $order->status === 'paid',
                                            'bg-amber-50 text-amber-700 dark:bg-amber-950/40 dark:text-amber-300 border-amber-200 dark:border-amber-800' => $order->status === 'pending',
                                            'bg-sky-50 text-sky-700 dark:bg-sky-950/40 dark:text-sky-300 border-sky-200 dark:border-sky-800' => $order->status === 'shipped',
                                            'bg-rose-50 text-rose-700 dark:bg-rose-950/40 dark:text-rose-300 border-rose-200 dark:border-rose-800' => $order->status === 'cancelled',
                                        ])>
                                            {{ ucfirst($order->status) }}
                                        </span>
                                        <p class="font-bold text-base text-emerald-600 dark:text-emerald-400 mt-1">
                                            R$ {{ number_format($order->total, 2, ',', '.') }}
                                        </p>
                                    </div>

                                    <svg class="w-5 h-5 text-slate-400 group-hover:translate-x-0.5 transition-transform" fill="none" stroke="currentColor" stroke-width="1.75" viewBox="0 0 24 24">
                                        <path d="M9 18l6-6-6-6"></path>
                                    </svg>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</x-app-layout>