<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class ResetPassword extends Notification
{
    use Queueable;

    // /**
    //  * Create a new notification instance.
    //  *
    //  * @return void
    //  */
    private $token;
    public function __construct($token){
        $this->token = $token;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
        ->greeting('Ola!')
        ->subject('Alterar Senha - MedSafer')
        ->line('Você está recebendo este e-mail porque recebemos um pedido de redefinição de senha para sua conta.')
        ->action('Resetar Senha', url(config('app.url').route('password.reset', $this->token, false)))
        ->line('Se você não solicitou uma alteração da senha, nenhuma ação adicional é necessária.')
        ->line('Se você estiver com problemas para clicar no botão "Resetar senha", copie e cole o URL abaixo em seu navegador da web:'."\t".url(config('app.url').route('password.reset', $this->token, false)))
        ->salutation('Atenciosamente, MedSafer. ');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
