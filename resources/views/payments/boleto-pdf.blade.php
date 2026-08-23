<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; color: #222; }
        .box { border: 1px solid #333; padding: 12px; margin-bottom: 12px; }
        .row { display: flex; justify-content: space-between; margin-bottom: 6px; }
        .label { font-size: 9px; color: #666; text-transform: uppercase; }
        .value { font-size: 13px; font-weight: bold; }
        .barcode { font-family: 'Libre Barcode 128', monospace; font-size: 46px; letter-spacing: 2px; margin: 16px 0; }
        h1 { font-size: 16px; border-bottom: 2px solid #333; padding-bottom: 8px; }
    </style>
</head>
<body>
    <h1>Boleto Bancário — Pedido #{{ $order->id }}</h1>

    <div class="box">
        <div class="row">
            <div>
                <div class="label">Beneficiário</div>
                <div class="value">Vendas Laravel LTDA</div>
            </div>
            <div>
                <div class="label">Vencimento</div>
                <div class="value">{{ now()->addDays(3)->format('d/m/Y') }}</div>
            </div>
        </div>
        <div class="row">
            <div>
                <div class="label">Pagador</div>
                <div class="value">{{ $order->user->name }} — CPF: {{ $order->user->cpf }}</div>
            </div>
            <div>
                <div class="label">Valor</div>
                <div class="value">R$ {{ number_format($order->total, 2, ',', '.') }}</div>
            </div>
        </div>
    </div>

    <p class="label">Linha Digitável</p>
    <p class="value" style="font-size: 15px; letter-spacing: 1px;">{{ $linhaDigitavel }}</p>

    <p class="label" style="margin-top: 16px;">Código de Barras</p>
    <p style="font-family: monospace; font-size: 13px; letter-spacing: 1px;">{{ $barcode }}</p>

    <p style="margin-top: 24px; font-size: 10px; color: #888;">
        Documento simulado gerado para fins acadêmicos. Não constitui título de cobrança real.
    </p>
</body>
</html>