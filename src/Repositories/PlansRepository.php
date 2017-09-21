<?php namespace Bishopm\Connexion\Repositories;

use Bishopm\Connexion\Repositories\McsaBaseRepository;
use Bishopm\Connexion\Repositories\SettingsRepository;
use Bishopm\Connexion\Models\Setting;

class PlansRepository extends McsaBaseRepository
{
    public function show($y,$q)
    {
        $url = $this->api_url . '/circuits/' . $this->circuit . '/plans/' . $y . '/' . $q . '?token=' . $this->token;
        $res = $this->client->request('GET', $url);
        return json_decode($res->getBody()->getContents(),TRUE);
    }

    public function updateplan($circuit,$box,$val)
    {       
        $url = $this->api_url . '/circuits/' . $circuit . '/planupdate/' . $box . '/' . $val . '?token=' . $this->token;
        $res = $this->client->request('GET', $url);
        return json_decode($res->getBody()->getContents(),TRUE);
    }

    
}
