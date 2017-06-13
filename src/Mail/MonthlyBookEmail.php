<?php

namespace Bishopm\Connexion\Mail;

use Illuminate\Mail\Mailable;

class MonthlyBookEmail extends Mailable
{
    use SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $emaildata;

    public function __construct($emaildata)
    {
        $this->emaildata=$emaildata;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject($this->emaildata['subject'])
            ->from($this->emaildata['sender'])
            ->markdown('connexion::emails.monthlybook');
    }
}
