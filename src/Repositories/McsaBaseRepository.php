<?php

namespace Bishopm\Connexion\Repositories;

use Bishopm\Connexion\Repositories\BaseRepository;
use Bishopm\Connexion\Repositories\SettingsRepository;
use Bishopm\Connexion\Models\Setting;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Client;

/**
 * Class MCSARepository
 *
 */
abstract class McsaBaseRepository implements BaseRepository
{
    protected $model;

    public function __construct($model)
    {
        $this->api_url = Setting::where('setting_key', 'church_api_url')->first()->setting_value;
        $this->token = Setting::where('setting_key', 'church_api_token')->first()->setting_value;
        $this->client = new Client();
        $this->circuit=Setting::where('setting_key', 'circuit')->first()->setting_value;
        $this->model = $model;
        $this->checked = self::check();
    }

    public function check()
    {
        if (!filter_var($this->api_url, FILTER_VALIDATE_URL)) {
            return "No valid url";
        } elseif (!$this->token) {
            return "No token";
        } else {
            $url = $this->api_url . '/check?token=' . $this->token;
            $res = $this->client->request('GET', $url);
            return json_decode($res->getBody()->getContents());
        }
    }

    /**
     * @inheritdoc
     */
    public function find($id)
    {
        if ($this->model<>"circuits") {
            $url = $this->api_url . '/circuits/' . $this->circuit . '/' . $this->model . '/' . $id . '?token=' . $this->token;
        } else {
            $url = $this->api_url . '/' . $this->model . '/' . $id . '?token=' . $this->token;
        }
        $res = $this->client->request('GET', $url);
        return json_decode($res->getBody()->getContents());
    }

    public function all()
    {
        if (($this->model<>"circuits") and (gettype($this->checked)=="string")) {
            return $this->checked;
        } else {
            if ($this->model=="circuits") {
                $url = $this->api_url . '/circuits/';
            } else {
                $url = $this->api_url . '/circuits/' . $this->circuit . '/' . $this->model . '?token=' . $this->token;
            }
            $res = $this->client->request('GET', $url);
            return json_decode($res->getBody()->getContents());
        }
    }

    public function settings()
    {
        $url = $url = $this->api_url . '/circuits/' . $this->circuit . '/settings?token=' . $this->token;
        $res = $this->client->request('GET', $url);
        return json_decode($res->getBody()->getContents());
    }

    public function setting($id)
    {
        $url = $this->api_url . '/circuits/' . $this->circuit . '/settings/' . $id . '?token=' . $this->token;
        $res = $this->client->request('GET', $url);
        return json_decode($res->getBody()->getContents());
    }

    public function updatesetting($id, $data)
    {
        $this->model="settings";
        $this->update($id, $data);
    }

    public function valueBetween($field, $low, $high)
    {
        $data['sql']="SELECT * from " . $this->model . " where " . $field . " >= '" . $low . "' and " . $field . " <= '" . $high . "' order by " . $field;
        $url = $this->api_url . '/circuits/' . $this->circuit . '/query?token=' . $this->token;
        $res = $this->client->request('POST', $url, ['form_params' => $data]);
        return json_decode($res->getBody()->getContents());
    }

    public function sqlQuery($query)
    {
        $data['sql']=$query;
        $url = $this->api_url . '/circuits/' . $this->circuit . '/query?token=' . $this->token;
        $res = $this->client->request('POST', $url, ['form_params' => $data]);
        return json_decode($res->getBody()->getContents());
    }

    /**
     * @inheritdoc
     */
    public function paginate($perPage = 15)
    {
        return $this->model->orderBy('created_at', 'DESC')->paginate($perPage);
    }

    /**
     * @inheritdoc
     */
    public function create($data)
    {
        $url = $this->api_url . '/circuits/' . $this->circuit . '/' . $this->model . '?token=' . $this->token;
        try {
            $res = $this->client->request('POST', $url, ['form_params' => $data]);
            return $res->getBody()->getContents();
        } catch (ClientException $e) {
            $response = $e->getResponse();
            $responseBodyAsString = $response->getBody()->getContents();
            return json_decode($responseBodyAsString);
        }
    }

    /**
     * @inheritdoc
     */
    public function update($id, $data)
    {
        $url = $this->api_url . '/circuits/' . $this->circuit . '/' . $this->model . '/' . $id . '?token=' . $this->token;
        try {
            $res = $this->client->request('PUT', $url, ['form_params' => $data]);
            return $res->getBody()->getContents();
        } catch (ClientException $e) {
            $response = $e->getResponse();
            $responseBodyAsString = $response->getBody()->getContents();
            return json_decode($responseBodyAsString);
        }
    }

    /**
     * @inheritdoc
     */
    public function destroy($model)
    {
        return $model->delete();
    }


    /**
     * @inheritdoc
     */
    public function findBySlug($slug)
    {
        return $this->model->where('slug', $slug)->first();
    }

    /**
     * @inheritdoc
     */
    public function findByAttributes(array $attributes)
    {
        $query = $this->buildQueryByAttributes($attributes);

        return $query->first();
    }

    /**
     * @inheritdoc
     */
    public function getByAttributes(array $attributes, $orderBy = null, $sortOrder = 'asc')
    {
        $query = $this->buildQueryByAttributes($attributes, $orderBy, $sortOrder);

        return $query->get();
    }

    /**
     * Build Query to catch resources by an array of attributes and params
     * @param  array $attributes
     * @param  null|string $orderBy
     * @param  string $sortOrder
     * @return \Illuminate\Database\Eloquent\Builder
     */
    private function buildQueryByAttributes(array $attributes, $orderBy = null, $sortOrder = 'asc')
    {
        $query = $this->model->query();
        foreach ($attributes as $field => $value) {
            $query = $query->where($field, $value);
        }
        if (null !== $orderBy) {
            $query->orderBy($orderBy, $sortOrder);
        }
        return $query;
    }

    /**
     * @inheritdoc
     */
    public function findByMany(array $ids)
    {
        $query = $this->model->query();
        return $query->whereIn("id", $ids)->get();
    }
}
