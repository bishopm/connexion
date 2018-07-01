<?php namespace Bishopm\Connexion\Repositories;

use Bishopm\Connexion\Repositories\McsaBaseRepository;

class PositionsRepository extends McsaBaseRepository
{
    public function identify($position, $type)
    {
        $url = $this->api_url . '/circuits/' . $this->circuit . '/positions/identify/' . urlencode($position) . '/' . $type . '?token=' . $this->token;
        $res = $this->client->request('GET', $url);
        return json_decode($res->getBody()->getContents());
    }
}
