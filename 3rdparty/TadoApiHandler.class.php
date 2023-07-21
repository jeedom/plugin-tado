<?php

/* This file is part of Jeedom.
*
* Jeedom is free software: you can redistribute it and/or modify
* it under the terms of the GNU General Public License as published by
* the Free Software Foundation, either version 3 of the License, or
* (at your option) any later version.
*
* Jeedom is distributed in the hope that it will be useful,
* but WITHOUT ANY WARRANTY; without even the implied warranty of
* MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
* GNU General Public License for more details.
*
* You should have received a copy of the GNU General Public License
* along with Jeedom. If not, see <http://www.gnu.org/licenses/>.
*/

/* * ***************************Includes********************************* */
require_once __DIR__ . '/autoload.php';

class TadoApiHandler {
    
    protected $ApiHandler = null;
	
	protected $_OAuthClient = null;
	protected $_ApiClient = null;
	protected $_User = '';
	
	protected $tokens = null;
	
	public function __construct($user) 
	{
		if ( empty($user) ) {
			throw new exception("Cannot create Tado Api Handler : empty user");
		}
		$this->_User = $user;
		$this->_OAuthClient = new League\OAuth2\Client\Provider\GenericProvider([
            'clientId'                => 'public-api-preview',
            'clientSecret'            => '4HJGRffVR8xb3XdEUQpjgZ1VplJi6Xgw',
            'urlAuthorize'            => 'https://auth.tado.com/oauth/authorize',
            'urlAccessToken'          => 'https://auth.tado.com/oauth/token',
            'urlResourceOwnerDetails' => null,
        ]);

	}
	
	public function __call($name, $arguments) 
	{
		if ( is_callable( array( $client = $this->getApiClient(), $name ) ) ) {
			try {
				$payload = (object) call_user_func_array( array( $client, $name ), $arguments );
				log::add('tado', 'debug', 'HomeApi->' . $name . '(' . json_encode($arguments) . '): ' . json_encode($payload));
				return $payload;
			} catch (Exception $e) {
				if ( $name == 'getZoneOverlay' && $e->getCode() == 404 ) {
					log::add('tado', 'debug', 'HomeApi->' . $name . ': No overlay defined for home ' . $arguments[0] . ' and zone ' . $arguments[1]);
					return (object) null;
				} else {
					log::add('tado', 'error', 'Exception when calling HomeApi->' . $name . ': '. $e->getMessage());
				}
			}
		} else {
			throw new exception("Call to undefined method " . get_class($this->_ApiClient) . "->" . $name);
		}
	}
		
	/*
	 * Gets the API CLient updated with valid tokens
	 *
	 * @returns XXX
	 */
	private function getApiClient() 
	{
		$token = $this->getTokens()->getToken();
		if (empty($token)) {
			throw new exception("No token granted, cannot initialise api client");
		}
			
		if (!$this->_ApiClient ) {
		
			// Configure OAuth2 access token for authorization: oauth
			$config = Tado\Api\Configuration::getDefaultConfiguration()->setAccessToken($token);		
			$this->_ApiClient = new Tado\Api\Client\HomeApi(
				// If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
				// This is optional, `GuzzleHttp\Client` will be used as default.
				new GuzzleHttp\Client(),
				$config
			);
		} else {
			$this->_ApiClient->getConfig()->setAccessToken($token);
		}
		return $this->_ApiClient;
	}
	
	/**
	 * Authorises the application using Tado OAuth server
	 *
     * @return \League\OAuth2\Client\Token\AccessToken
     */
    public function authorize($password)
    {
        try {
            // Try to get an access token using the resource owner password credentials grant.
            $tokens = $this->_OAuthClient->getAccessToken('password', [
				'username' => $this->_User,
				'password' => $password,
				'scope' => 'home.user',
            ]);
            if (!empty($tokens->getToken())) {
            	$this->setTokens($tokens);
            	return true;
            } else {
            	return false;
            }
        } catch (\League\OAuth2\Client\Provider\Exception\IdentityProviderException $e) {
            // Failed to get the access token
            throw new Exception($e->getMessage());
        }
    }
    	
	public function getTokens(){
		//retrieve stored token
		if(!$this->tokens) {
			$conf_tokens = config::byKey('tadoTokens', 'tado');
			if ( isset($conf_tokens[$this->_User]) && !empty($conf_tokens[$this->_User]) ) {
				$this->tokens = new League\OAuth2\Client\Token\AccessToken($conf_tokens[$this->_User]);
			}
		}
		if($this->tokens) {	
			if ($this->isTokensValid($this->tokens)) {
				//log::add('tado', 'debug', __METHOD__ . ' - Using stored token');
				$tokens = $this->tokens;
			} else if(!empty($this->tokens->getRefreshToken())) {
				log::add('tado', 'debug', __METHOD__ . ' - Getting new token from refresh token');
				$tokens = $this->getTokensFromRefreshToken($this->tokens->getRefreshToken());
			}
			
			if ($this->isTokensValid($this->tokens)) {
				return $tokens;
			}
		}
		throw new Exception("Failed getting access token. Verify authorization in plugin configuration");
	}
	
  	private function getTokensFromRefreshToken($refresh_token){
        try {
            // Try to get an access token using the resource owner password credentials grant.
            $tokens = $this->_OAuthClient->getAccessToken('refresh_token', [
				'refresh_token' => $refresh_token,
				'scope' => 'home.user',
            ]);
            $this->setTokens($tokens);
            return $tokens;
        } catch (\League\OAuth2\Client\Provider\Exception\IdentityProviderException $e) {
            // Failed to get the access token
            exit($e->getMessage());
        }
	}
	
	private function isTokensValid(League\OAuth2\Client\Token\AccessToken $tokens){	
		if(!empty($tokens->getToken())){
			if (time() <= $tokens->getExpires() - 30) {
				return true;
			}
		}
		return false;
	}
	
	private function setTokens(League\OAuth2\Client\Token\AccessToken $tokens){
		$this->tokens = $tokens;
		$conf_tokens = config::byKey('tadoTokens', 'tado');
		$newTokens = array();
		foreach ( $conf_tokens as $user => $conf_token) {
			if ( !empty($conf_token) ) {
				$newTokens[$user] = new League\OAuth2\Client\Token\AccessToken($conf_token);
			}
		}
		$newTokens[$this->_User] = $tokens;
		config::save('tadoTokens', json_encode($newTokens), 'tado');
	}
	

}
