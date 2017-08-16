<?php namespace Bishopm\Connexion\Repositories;

use Bishopm\Connexion\Repositories\McsaBaseRepository;
use Bishopm\Connexion\Models\Setting;

class SocietiesRepository extends McsaBaseRepository
{

    public function dropdown(){
        return $this->model->orderBy('society', 'ASC')->select('id','society')->get();
    }

    public function all()
    {
        $circuitbits=explode(' ',Setting::where('setting_key','circuit')->first()->setting_value);
        $url = $this->api_url . '/circuits/' . $circuitbits[0] . '/societies';
        $res = $this->client->request('GET', $url);
        return json_decode($res->getBody()->getContents());
    }

}
