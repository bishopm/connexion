<?php

namespace Bishopm\Connexion\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Bishopm\Connexion\Models\Setting;

class ResetPasswordNotification extends Notification
{
    use Queueable;

    private $settings;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($token)
    {
        $this->tokenurl=url('/') . '/password/reset/' . $token;
        $this->salutation=Setting::where('setting_key','=','site_name')->first()->setting_value;
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
                    ->subject('Reset your password')
                    ->line('If you recently requested a password reset, please click the button below:')
                    ->action('Reset my password', $this->tokenurl)
                    ->line('Please ignore this mail if you did not request a password reset')
                    ->line('Thank you!');
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
