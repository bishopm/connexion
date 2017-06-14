<?php

namespace Bishopm\Connexion\Mail;

use Illuminate\Mail\Mailable;
use Bishopm\Connexion\Models\Setting;

class MonthlySupplierMail extends Mailable
{
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $data;

    public function __construct($data)
    {
        $data['sender']=Setting::where('setting_key','church_email')->first()->setting_value;
        $this->data=$data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject($this->data['subject'])
            ->from($this->data['sender'])
            ->markdown('connexion::emails.monthlysupplier');
    }
}
