<?php namespace Bishopm\Connexion\Repositories;

use Bishopm\Connexion\Repositories\McsaBaseRepository;
use Bishopm\Connexion\Repositories\SettingsRepository;
use Bishopm\Connexion\Models\Setting;

class SocietiesRepository extends McsaBaseRepository
{

    public function all()
    {
        $circuit=Setting::where('setting_key','circuit')->first()->setting_value;
        $url = $this->api_url . '/circuits/' . $circuit . '/societies';
        $res = $this->client->request('GET', $url);
        return json_decode($res->getBody()->getContents());
    }

}
