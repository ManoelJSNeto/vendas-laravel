<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;

class OrderController extends Controller
{
        public function index(Request $request): View
    {
        $allOrders = Order::with('user')->latest()->get();

        $paidOrders = $allOrders->where('status', 'paid');
        $totalVendido = $paidOrders->sum('total');
        $totalPedidos = $allOrders->count();
        $ticketMedio = $paidOrders->count() > 0 ? $totalVendido / $paidOrders->count() : 0;
        $pedidosPendentes = $allOrders->where('status', 'pending')->count();

        $vendasPorDia = $paidOrders
            ->groupBy(fn ($order) => $order->paid_at->format('d/m'))
            ->map(fn ($group) => $group->sum('total'));

        $pedidosPorStatus = [
            'Pago' => $paidOrders->count(),
            'Pendente' => $pedidosPendentes,
            'Enviado' => $allOrders->where('status', 'shipped')->count(),
            'Cancelado' => $allOrders->where('status', 'cancelled')->count(),
        ];

        $orders = $allOrders;

        if ($request->filled('status')) {
            $orders = $allOrders->where('status', $request->status);
        }

        return view('admin.orders.index', compact(
            'orders', 'totalVendido', 'totalPedidos', 'ticketMedio', 'pedidosPendentes',
            'vendasPorDia', 'pedidosPorStatus'
        ));
    }

    public function updateStatus(Request $request, Order $order): RedirectResponse
    {
        $request->validate([
            'status' => ['required', 'in:pending,paid,shipped,cancelled'],
        ]);

        $order->update(['status' => $request->status]);

        return back()->with('status', 'Status do pedido atualizado!');
    }
}