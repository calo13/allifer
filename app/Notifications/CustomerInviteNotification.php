<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class CustomerInviteNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public $actionUrl;

    /**
     * Create a new notification instance.
     */
    public function __construct($token, $email)
    {
        $this->actionUrl = url(route('password.reset', [
            'token' => $token,
            'email' => $email,
        ], false));
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Invitación para activar tu cuenta')
            ->greeting('¡Hola ' . $notifiable->name . '!')
            ->line('Has sido invitado a activar tu cuenta en nuestra Tienda Virtual como cliente.')
            ->line('Para completar el registro y establecer tu contraseña, haz clic en el siguiente botón:')
            ->action('Activar Cuenta', $this->actionUrl)
            ->line('Si no creaste esta solicitud, puedes ignorar este correo.')
            ->line('¡Gracias por preferirnos!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
