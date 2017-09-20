<?php namespace Bishopm\Connexion\Repositories;

use Bishopm\Connexion\Repositories\McsaBaseRepository;
use Bishopm\Connexion\Repositories\SettingsRepository;
use Bishopm\Connexion\Models\Setting;

class WeekdaysRepository extends McsaBaseRepository
{
    public function findfordate($circuit,$weekday)
    {
        $url = $this->api_url . '/circuits/' . $circuit . '/weekdays/bydate/' . $weekday . '?token=' . $this->token;
        $res = $this->client->request('GET', $url);
        return json_decode($res->getBody()->getContents());
    }
}
