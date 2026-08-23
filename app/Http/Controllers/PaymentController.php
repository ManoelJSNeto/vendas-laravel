<?php

namespace App\Http\Controllers;

use App\Mail\OrderPaid;
use App\Models\Order;
use App\Services\BoletoGenerator;
use App\Services\PixPayloadGenerator;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;

class PaymentController extends Controller
{
    public function show(Order $order): View
    {
        $data = ['order' => $order];

        if ($order->payment_method === 'pix') {
            $payload = PixPayloadGenerator::generate(
                'contato@vendaslaravel.com.br',
                'Vendas Laravel LTDA',
                'Presidente Prudente',
                (float) $order->total,
                'PEDIDO'.$order->id
            );

            $qrCode = new QrCode($payload);
            $writer = new PngWriter();
            $qrImage = base64_encode($writer->write($qrCode)->getString());

            $data['pixPayload'] = $payload;
            $data['pixQrImage'] = $qrImage;
        }

        if ($order->payment_method === 'boleto') {
            $barcode = BoletoGenerator::generateBarcode($order->id, (float) $order->total);
            $data['barcode'] = $barcode;
            $data['linhaDigitavel'] = BoletoGenerator::formatLinhaDigitavel($barcode);
        }

        return view('payments.show', $data);
    }

    public function process(Request $request, Order $order): RedirectResponse
    {
        if ($order->payment_method === 'cartao') {
            $request->validate([
                'card_number' => ['required', 'string'],
                'card_name' => ['required', 'string'],
                'card_expiry' => ['required', 'string'],
                'card_cvv' => ['required', 'string', 'max:4'],
            ]);

            $digits = preg_replace('/\D/', '', $request->card_number);

            if (! $this->isValidLuhn($digits)) {
                return back()->withErrors(['card_number' => 'Número de cartão inválido.']);
            }
        }

        $order->update([
            'status' => 'paid',
            'paid_at' => now(),
        ]);

        Mail::to($order->user->email)->send(new OrderPaid($order));

        return redirect()->route('orders.show', $order)->with('status', 'Pagamento aprovado com sucesso!');
    }

    private function isValidLuhn(string $number): bool
    {
        $sum = 0;
        $alt = false;

        for ($i = strlen($number) - 1; $i >= 0; $i--) {
            $n = (int) $number[$i];

            if ($alt) {
                $n *= 2;
                if ($n > 9) {
                    $n -= 9;
                }
            }

            $sum += $n;
            $alt = ! $alt;
        }

        return $sum % 10 === 0;
    }
}