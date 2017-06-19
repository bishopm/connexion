<?php

namespace Bishopm\Connexion\Mail;

use Illuminate\Mail\Mailable;

class NewUserMail extends Mailable
{

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
        return $this->markdown('connexion::newuser.generic');
    }
}
