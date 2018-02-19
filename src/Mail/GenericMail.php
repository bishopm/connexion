<?php

namespace Bishopm\Connexion\Mail;

use Illuminate\Mail\Mailable;
use Bishopm\Connexion\Models\Setting;

class GenericMail extends Mailable
{

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $emaildata;

    protected $theme = '';

    public function __construct($emaildata)
    {
        $emaildata->header=Setting::where('setting_key', 'site_name')->first()->setting_value;
        $emaildata->footer=Setting::where('setting_key', 'church_mission')->first()->setting_value;
        $emaildata->address=Setting::where('setting_key', 'church_address')->first()->setting_value . " | " . Setting::where('setting_key', 'church_phone')->first()->setting_value;
        $emaildata->facebook=Setting::where('setting_key', 'facebook_page')->first()->setting_value;
        $emaildata->youtube=Setting::where('setting_key', 'youtube_page')->first()->setting_value;
        $emaildata->twitter=Setting::where('setting_key', 'twitter_profile')->first()->setting_value;
        $this->theme = Setting::where('setting_key', 'website_theme')->first()->setting_value;
        $this->emaildata=$emaildata;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        if ($this->emaildata->hasFile('attachment')) {
            return $this->subject($this->emaildata->subject)
                    ->from($this->emaildata->sender)
                    ->attach($this->emaildata->file('attachment'), array('as' => $this->emaildata->file('attachment')->getClientOriginalName(), 'mime' => $this->emaildata->file('attachment')->getMimeType()))
                    ->markdown('connexion::emails.generic');
        } else {
            return $this->subject($this->emaildata->subject)
                    ->from($this->emaildata->sender)
                    ->markdown('connexion::emails.generic');
        }
    }
}
