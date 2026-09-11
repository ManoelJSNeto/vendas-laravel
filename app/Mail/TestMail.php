<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class TestMail extends Mailable
{
    use Queueable, SerializesModels;

    public function build()
    {
        return $this->subject('E-mail de Teste — Vendas Laravel')
            ->html('<p>Se você recebeu este e-mail, a configuração SMTP está funcionando corretamente.</p>');
    }
}