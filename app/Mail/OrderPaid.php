<?php

namespace App\Mail;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OrderPaid extends Mailable
{
    use Queueable, SerializesModels;

    public Order $order;

    public function __construct(Order $order)
    {
        $this->order = $order->load('items.product', 'address', 'user');
    }

    public function build()
    {
        return $this->subject('Nota Fiscal - Pedido #'.$this->order->id)
            ->view('emails.order-paid');
    }
}