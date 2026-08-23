<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class OrderController extends Controller
{
    public function create(Request $request): View|RedirectResponse
    {
        $items = $request->user()->cartItems()->with('product')->get();

        if ($items->isEmpty()) {
            return redirect()->route('cart.index')->with('status', 'Seu carrinho está vazio.');
        }

        $total = $items->sum(fn ($item) => $item->subtotal());
        $address = $request->user()->addresses()->first();

        return view('orders.checkout', compact('items', 'total', 'address'));
    }

    public function store(Request $request): RedirectResponse
    {
        $cartItems = $request->user()->cartItems()->with('product')->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('status', 'Seu carrinho está vazio.');
        }

        $request->validate([
            'cep' => ['required', 'string', 'max:9'],
            'logradouro' => ['required', 'string', 'max:255'],
            'numero' => ['nullable', 'string', 'max:20'],
            'complemento' => ['nullable', 'string', 'max:255'],
            'bairro' => ['required', 'string', 'max:255'],
            'cidade' => ['required', 'string', 'max:255'],
            'uf' => ['required', 'string', 'max:2'],
            'payment_method' => ['required', 'in:pix,cartao,boleto'],
        ]);

        $address = $request->user()->addresses()->updateOrCreate(
            ['user_id' => $request->user()->id],
            $request->only(['cep', 'logradouro', 'numero', 'complemento', 'bairro', 'cidade', 'uf'])
        );

        $total = $cartItems->sum(fn ($item) => $item->subtotal());
        
        $nextNumber = $request->user()->orders()->max('order_number') + 1;

        $order = Order::create([
            'user_id' => $request->user()->id,
            'order_number' => $nextNumber,
            'address_id' => $address->id,
            'status' => 'pending',
            'payment_method' => $request->payment_method,
            'total' => $total,
        ]);

        foreach ($cartItems as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item->product_id,
                'quantity' => $item->quantity,
                'unit_price' => $item->product->price,
            ]);
        }

        $request->user()->cartItems()->delete();

        return redirect()->route('orders.show', $order)->with('status', 'Pedido realizado com sucesso!');
    }

    public function index(Request $request): View
    {
        $orders = $request->user()->orders()->latest()->get();

        return view('orders.index', compact('orders'));
    }

    public function show(Order $order): View
    {
        $order->load('items.product', 'address');

        return view('orders.show', compact('order'));
    }
}