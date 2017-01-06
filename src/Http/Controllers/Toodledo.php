<?php
namespace bishopm\base\Http\Controllers;

use League\OAuth2\Client\Provider\AbstractProvider;
use League\OAuth2\Client\Provider\Exception\IdentityProviderException;
use League\OAuth2\Client\Token\AccessToken;
use League\OAuth2\Client\Tool\BearerAuthorizationTrait;
use Psr\Http\Message\ResponseInterface;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use bishopm\base\Http\Controllers\ToodledoResourceOwner;
use bishopm\base\Models\Setting;

class Toodledo extends AbstractProvider
{
    use BearerAuthorizationTrait;

    public function __construct()
    {
        parent::__construct();
        $settings=Setting::all();
        foreach ($settings as $setting){
            $settingsarray[$setting->setting_key]=$setting->setting_value;
        }
        $this->clientId = $settingsarray['toodledo_clientid'];
        $this->clientSecret = $settingsarray['toodledo_secret'];
        $this->redirectUri = $settingsarray['toodledo_redirect_uri'];
    }

    /**
     * {@inheritdoc}
     */
    public function getBaseAuthorizationUrl()
    {
        return 'https://api.toodledo.com/3/account/authorize.php';
    }
    /**
     * {@inheritdoc}
     */
    public function getBaseAccessTokenUrl(array $params)
    {
        return 'https://api.toodledo.com/3/account/token.php';
    }
    /**
     * {@inheritdoc}
     */
    public function getResourceOwnerDetailsUrl(AccessToken $token)
    {
        return 'https://api.toodledo.com/3/account/get.php?access_token=' . $token;
    }
    /**
     * {@inheritdoc}
     */
    protected function getScopeSeparator()
    {
        return ' ';
    }
    /**
     * {@inheritdoc}
     */
     protected function createResourceOwner(array $response, AccessToken $token)
     {
         return new ToodledoResourceOwner($response, $token);
     }
    /**
     * {@inheritdoc}
     */
    protected function getDefaultScopes()
    {
        return ['basic tasks folders write'];
    }
    /**
     * {@inheritdoc}
     */
    protected function checkResponse(ResponseInterface $response, $data)
    {
        if (!empty($data['error'])) {
            $error = isset($data['error']['message']) ? $data['error']['message'] : '';
            $code = isset($data['error']['code']) ? intval($data['error']['code']) : 0;
            throw new IdentityProviderException($error, $code, $data);
        }
    }

    public function getData($user,$type,$commandtype="hourly"){
        $url='https://api.toodledo.com/3/' . $type . '/get.php?';
        if ($type=="tasks"){
            $url.="fields=tag,context,status,complete,duedate&";
            if ($commandtype=="hourly"){
                $url.="after=" . strval(time()-3600) . '&';
            }
        }
        return $this->attemptAccess('GET',$url,$user);
    }

    public function updateData($user,$type,$data)
    {
        $url='https://api.toodledo.com/3/' . $type . '/edit.php?' . $data;
        return $this->attemptAccess('POST',$url,$user);
    }

    public function addData($user,$type,$data)
    {
        $url='https://api.toodledo.com/3/' . $type . '/add.php?' . $data;
        return $this->attemptAccess('POST',$url,$user);
    }

    public function getInitial($token){
        $client = New Client;
        $response=$client->request('GET','https://api.toodledo.com/3/account/get.php?access_token=' . $token);
        return json_decode($response->getBody()->getContents());
    }

    protected function attemptAccess($method,$url,$user,$data=array()){
        $client = New Client;
        try {
            if ($method=="GET"){
                $response=$client->request('GET',$url . 'access_token=' . $user->toodledo_token);
            } elseif ($method=="POST"){
                $response=$client->request('POST',$url,['form_params' => $data]);
            }
            return json_decode($response->getBody()->getContents());
        } catch (RequestException $e) {
            if ($e->getCode()==401){
                $user=$this->renewToken($user);
                try {
                    if ($method=="GET"){
                        $response=$client->request('GET',$url . 'access_token=' . $user->toodledo_token);
                    } elseif ($method=="POST"){
                        $data['access_token']=$user->toodledo_token;
                        $response=$client->request('POST',$url,['form_params' => $data]);
                    }
                } catch (RequestException $er){
                    return $er->getCode();
                }
            }
        }
    }

    protected function renewToken($user){
        print "Refreshing token ...\n";
        $grant = new \League\OAuth2\Client\Grant\RefreshToken();
        $token = self::getAccessToken($grant,['refresh_token' => $user->toodledo_refresh]);
        $user->toodledo_token=$token->getToken();
        $user->toodledo_refresh=$token->getRefreshToken();
        $user->save();
        return $user;
    }

}
