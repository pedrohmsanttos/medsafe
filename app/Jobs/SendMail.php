<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
// Mails class
use App\Mail\CadastroCorretor;
use App\Mail\CadastroCliente;
use App\Mail\EnvioCheckout;
use App\Mail\MensagemSolicitacao;
// mail
use Mail;

class SendMail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $destinatarioNome;  // Nome do cliente
    protected $destinatarioEmail; // Email do cliente
    protected $logo;              // logo - Imagem da logo da empresa
    protected $emailTipo;          // Tipo de email
    protected $template;          // HTML do email
    protected $PDF;               // PDF no disco
    protected $assunto;           // Assunto do email

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($variaveis, $dados, $template, $pdf = false)
    {
        //
        $this->template          = str_replace(array_keys($variaveis), $variaveis, $template->conteudo);
        $this->assunto           = $template->assunto;
        $this->destinatarioNome  = $dados->destinatarioNome;
        $this->destinatarioEmail = $dados->destinatarioEmail;
        $this->logo              = $dados->logo;
        $this->emailTipo         = $dados->tipo;
        $this->PDF               = $pdf;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        switch ($this->emailTipo) {
            case "cadastro_corretor":
                Mail::to($this->destinatarioEmail)->send(new CadastroCorretor($this->template, $this->assunto));
            break;
            case "cadastro_cliente":
                Mail::to($this->destinatarioEmail)->send(new CadastroCliente($this->template, $this->assunto));
            break;
            case "mensagem_solicitacao":
                Mail::to($this->destinatarioEmail)->send(new MensagemSolicitacao($this->template, $this->assunto));
            break;
            case "envio_checkout":
                Mail::to($this->destinatarioEmail)->send(new EnvioCheckout($this->template, $this->assunto));
            break;
        }
    }
}
