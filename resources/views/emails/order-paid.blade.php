<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        body { font-family: Arial, sans-serif; color: #333; margin: 0; padding: 0; background: #f4f4f4; }
        .container { max-width: 600px; margin: 20px auto; background: #fff; border-radius: 8px; overflow: hidden; }
        .header { background: #1e293b; color: #fff; padding: 24px; text-align: center; }
        .header h1 { margin: 0; font-size: 20px; }
        .content { padding: 24px; }
        .info-row { display: flex; justify-content: space-between; padding: 6px 0; font-size: 14px; }
        table { width: 100%; border-collapse: collapse; margin-top: 16px; }
        th, td { text-align: left; padding: 8px; border-bottom: 1px solid #eee; font-size: 14px; }
        .total { font-size: 18px; font-weight: bold; color: #16a34a; text-align: right; margin-top: 12px; }
        .footer { padding: 16px 24px; font-size: 12px; color: #888; text-align: center; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Nota Fiscal Simulada</h1>
            <p style="margin: 4px 0 0; font-size: 13px;">Pedido #{{ $order->id }}</p>
        </div>

        <div class="content">
            <p>Olá, {{ $order->user->name }}!</p>
            <p>Seu pagamento foi aprovado e seu pedido está confirmado. Confira os detalhes abaixo:</p>

            <div class="info-row"><span>Data do pagamento:</span><strong>{{ $order->paid_at->format('d/m/Y H:i') }}</strong></div>
            <div class="info-row"><span>Forma de pagamento:</span><strong>{{ ucfirst($order->payment_method) }}</strong></div>
            <div class="info-row"><span>CPF do comprador:</span><strong>{{ $order->user->cpf }}</strong></div>

            <table>
                <thead>
                    <tr>
                        <th>Produto</th>
                        <th>Qtd</th>
                        <th>Valor Unit.</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($order->items as $item)
                        <tr>
                            <td>{{ $item->product->name }}</td>
                            <td>{{ $item->quantity }}</td>
                            <td>R$ {{ number_format($item->unit_price, 2, ',', '.') }}</td>
                            <td>R$ {{ number_format($item->quantity * $item->unit_price, 2, ',', '.') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <p class="total">Total: R$ {{ number_format($order->total, 2, ',', '.') }}</p>

            <p style="margin-top: 24px;"><strong>Endereço de entrega:</strong><br>
                {{ $order->address->logradouro }}, {{ $order->address->numero }}<br>
                {{ $order->address->bairro }} — {{ $order->address->cidade }}/{{ $order->address->uf }}<br>
                CEP: {{ $order->address->cep }}
            </p>
        </div>

        <div class="footer">
            Este é um documento simulado gerado para fins acadêmicos, sem valor fiscal real.
        </div>
    </div>
</body>
</html>