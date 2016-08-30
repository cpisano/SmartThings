<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Redirect;
use URL;

class SmartThingsController extends Controller
{
    private $client_id = 'd6e8e499-27a9-4b95-b307-cae48e7096b4';
    //private $client_id = '3e55f0df-9c93-4242-baf9-70ab6cdf94c6';
    private $client_secret = '16573f89-1033-434f-a0de-952324ea991a';
    //private $client_secret = 'd77b1daa-efd4-4651-9434-c4f7bb883857';
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        
    }

/*
object(League\OAuth2\Client\Token\AccessToken)#202 (5) { ["accessToken":protected]=> string(36) "2ebf7781-9f56-4465-92bf-53b6ef732ece" ["expires":protected]=> float(3048967887) ["refreshToken":protected]=> NULL ["resourceOwnerId":protected]=> NULL ["values":protected]=> array(2) { ["token_type"]=> string(6) "bearer" ["scope"]=> string(3) "app" } }
*/
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function getOauth()
    {
        $redirect_uri = 'http://hub.pisano.org/smartthings/callback';
      //  $redirect_uri = 'http://localhost:8282/smartthings/callback';
        $endpoints_uri = 'https://graph.api.smartthings.com/api/smartapps/endpoints';
        $endpoints_uri = 'https://graph-na02-useast1.api.smartthings.comapi/smartapps/endpoints';

        $provider = new \League\OAuth2\Client\Provider\GenericProvider([
            'clientId'                => $this->client_id,    // The client ID assigned to you by the provider
            'clientSecret'            => $this->client_secret,   // The client password assigned to you by the provider
            'redirectUri'             => $redirect_uri,//URL::action('SmartThingsController@getCallback'),
            'urlAuthorize'            => 'https://graph.api.smartthings.com/oauth/authorize',
            'urlAccessToken'          => 'https://graph.api.smartthings.com/oauth/token',
            'urlResourceOwnerDetails' => null
        ]);

        $authorizationUrl = $provider->getAuthorizationUrl(['scope' => 'app', 'response_type' => 'code']);
        session(['oauth2state' => $provider->getState()]);

        $url = str_replace("{0}", $this->client_id, str_replace("{1}", $redirect_uri, "https://graph.api.smartthings.com/oauth/authorize?response_type=code&client_id={0}&scope=app&redirect_uri={1}"));

        return Redirect::to($url);
    }

    public function getCallback()
    {
         $redirect_uri = 'http://hub.pisano.org/smartthings/callback';
        $provider = new \League\OAuth2\Client\Provider\GenericProvider([
            'clientId'                => $this->client_id,    // The client ID assigned to you by the provider
            'clientSecret'            => $this->client_secret,   // The client password assigned to you by the provider
            'redirectUri'             => $redirect_uri,//URL::action('SmartThingsController@getCallback'),
            'urlAuthorize'            => 'https://graph.api.smartthings.com/oauth/authorize',
            'urlAccessToken'          => 'https://graph.api.smartthings.com/oauth/token',
            'urlResourceOwnerDetails' => 'http://brentertainment.moc/oauth2/lockdin/resource'
        ]);

        $accessToken = $provider->getAccessToken('authorization_code', [
            'code' => $_GET['code']
        ]);

        var_dump($accessToken);

        // echo $accessToken->getToken() . "\n";
        // echo $accessToken->getRefreshToken() . "\n";
        // echo $accessToken->getExpires() . "\n";

       // $resourceOwner = $provider->getResourceOwner($accessToken);

     //   var_export($resourceOwner->toArray());        


    }
}
