<?php namespace bishopm\base\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;

class GoogleCalendar {

    protected $client;

    protected $service;

    function __construct() {
        /* Get config variables */
        $client_id = Config::get('google.client_id');
        $service_account_name = Config::get('google.service_account_name');
        $key_file_location = base_path() . Config::get('google.key_file_location');

        $this->client = new \Google_Client();
        $this->client->setApplicationName("Your Application Name");
        $this->service = new \Google_Service_Calendar($this->client);

        /* If we have an access token */
        if (Cache::has('service_token')) {
          $this->client->setAccessToken(Cache::get('service_token'));
        }

        $key = file_get_contents($key_file_location);
        /* Add the scopes you need */
        $scopes = array('https://www.googleapis.com/auth/calendar');
        $cred = new \Google_Auth_AssertionCredentials(
            $service_account_name,
            $scopes,
            $key
        );

        $this->client->setAssertionCredentials($cred);
        if ($this->client->getAuth()->isAccessTokenExpired()) {
          $this->client->getAuth()->refreshTokenWithAssertion($cred);
        }
        Cache::forever('service_token', $this->client->getAccessToken());
    }

    public function getTen($calendarId,$num=80)
    {
       if ($num==80){
           $optParams = array(
             'maxResults' => 80,
             'orderBy' => 'startTime',
             'singleEvents' => TRUE,
             'timeMin' => date('c',strtotime('-3 weeks'))
           );
       } else {
           $optParams = array(
             'maxResults' => $num,
             'orderBy' => 'startTime',
             'singleEvents' => TRUE,
             'timeMin' => date('c',strtotime(date('Y-m-d H:i:s')))             
           );
       }
       $events = $this->service->events->listEvents($calendarId, $optParams);
       if (count($events)){
         foreach ($events as $event){
           $dum['title']=$event->summary;
           $dum['start']=$event->start->dateTime;
           $dum['description']=$event->location . ": " . $event->description;
           if (strlen($dum['description'])<3){
             $dum['description']="";
           }
           if (!$dum['start']){
             $dum['start']=$event->start->date;
             $dum['stime']="";
           } else {
             $dum['stime']=date("G:i",strtotime($dum['start']));
           }
           $tendates[]=$dum;
         }
       } else {
         $tendates[0]['title']="Calendar is empty";
         $tendates[0]['description']="Add some events to your Google Calendar";
         $tendates[0]['start']=date("d-M");
         $tendates[0]['stime']="";
       }
       return $tendates;
    }
}
