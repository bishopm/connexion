<?php namespace Bishopm\Connexion\Repositories;

use Bishopm\Connexion\Repositories\McsaBaseRepository;
use Bishopm\Connexion\Models\Setting;

class CircuitsRepository extends McsaBaseRepository
{
    public function all()
    {
        $url = $this->api_url . $this->circuit . '/' . $this->model . '?token=' . $this->token;
        $res = $this->client->request('GET', $url);
        return $res->getBody()->getContents();
    }
}
