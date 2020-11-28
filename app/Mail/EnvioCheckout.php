<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class EnvioCheckout extends Mailable
{
    use Queueable, SerializesModels;

    protected $dados;
    protected $assunto;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($dados, $assunto)
    {
        $this->dados   = $dados;
        $this->assunto = $assunto;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('vendor.notifications.envio_checkout')
                ->with([
                    'conteudo' => $this->dados
                ])
                ->subject($this->assunto);
    }
}
