<?php

namespace Bishopm\Connexion\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\SlackMessage;
use Bishopm\Connexion\Models\Setting;

class SendMessage extends Notification
{

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    private $message, $sender;

    public function __construct($message,$sender)
    {
        $this->message=$message;
        $this->sender=$sender;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        if ($notifiable->notification_channel=="Slack"){
            return ['slack'];
        } else {
            return ['mail'];
        }
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $this->sitename=Setting::where('setting_key','site_abbreviation')->first()->setting_value;
        return (new MailMessage)
            ->subject("Message from " . $this->sender->firstname . " " . $this->sender->surname)
            ->greeting("Hi " . $notifiable->individual->firstname . "!")
            ->line("This note is to let you know that you have received the following message from " . $this->sender->firstname . " " . $this->sender->surname . " on the " . $this->sitename . " website:")
            ->line($this->message)
            ->line("Don't reply to this mail (it will go to the church office!). Rather contact " . $this->sender->firstname . " directly or via the website if you wish to reply. Also, note that your email address has been kept private and that if you wish to prevent other church members from sending you messages, you can change this setting on your user profile page on the website.");
    }

    public function toSlack($notifiable)
    {
        $this->sitename=Setting::where('setting_key','site_abbreviation')->first()->setting_value;
        return (new SlackMessage)
            ->to($notifiable->slack_username)
            ->content("*Hi " . $notifiable->individual->firstname . "!* \n" . "Here is a message from  " . $this->sender->firstname . " " . $this->sender->surname . " (via the " . $this->sitename . " website): " . $this->message);
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
