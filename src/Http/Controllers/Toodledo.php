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

    public function getData($user,$type,$initial="hourly")
    {
        $client = New Client;
        try {
            if ($type<>'tasks'){
                if (($initial=="initial") and ($type=="account")){
                    $response=$client->request('GET','https://api.toodledo.com/3/account/get.php?access_token=' . $user);    
                } else {
                    $response=$client->request('GET','https://api.toodledo.com/3/' . $type . '/get.php?access_token=' . $user->toodledo_token);
                }
            } else {
                if ($initial=="initial"){
                    $taskquery="&fields=tag,context,status,duedate";
                } else {
                    $taskquery="&fields=tag,context,status,duedate&after=" . strval(time()-3600);
                }
                $response=$client->request('GET','https://api.toodledo.com/3/' . $type . '/get.php?access_token=' . $user->toodledo_token . $taskquery);
            }
            $data=json_decode($response->getBody()->getContents());
            return $data;
        } catch (RequestException $e) {
            if ($e->getCode()==401){
                print "Refreshing token ...\n";
                $grant = new \League\OAuth2\Client\Grant\RefreshToken();
                $token = self::getAccessToken($grant,['refresh_token' => $user->toodledo_refresh]);
                $user->toodledo_token=$token->getToken();
                $user->toodledo_refresh=$token->getRefreshToken();
                $user->save();
                try {
                    if ($type<>'tasks'){
                        $response=$client->request('GET','https://api.toodledo.com/3/' . $type . '/get.php?access_token=' . $user->toodledo_token);
                    } else {
                        $response=$client->request('GET','https://api.toodledo.com/3/' . $type . '/get.php?access_token=' . $user->toodledo_token . $taskquery);
                    }
                    $data=json_decode($response->getBody()->getContents());
                    return $data;
                } catch (RequestException $er){
                    return $er->getCode();
                }
            }
        }
    }

    public function addData($token,$type)
    {
        $client = New Client;
        try {
            $response=$client->request('POST','https://api.toodledo.com/3/' . $type . '/add.php?access_token=' . $token);
            $data=json_decode($response->getBody()->getContents());
        } catch (RequestException $e) {
            $data=json_decode($e->getCode());
        }
    }
}
