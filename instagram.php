<?php

//requesting guzzle library

require 'vendor/autoload.php';

//using guzzle
use GuzzleHttp\Client;

class Instagram {

	const TOKEN_FILE =  __DIR__ . '/.cred/token.json';

	public $authUrl;
	public $client;
	public $token = false;
	public $config = false;

	public function __construct($auth_url = null) {

		if ($auth_url ) {
			$this->authUrl = $auth_url;
		}
	}

	public function redirectAuth() 
	{
		header("Location: " . $this->authUrl);
		exit();
	}

	//authenticate the token
	public function getToken()
	{
		if (!$this->token) {
			//first check if token already created
			if (file_exists(self::TOKEN_FILE)) {
				$this->token = file_get_contents(self::TOKEN_FILE);		
			}	
		}
		

		return $this->token;
	}

	public function saveToken($json)
	{
		file_put_contents(self::TOKEN_FILE, $json);
		return $json;
	}

	public function authenticateToken() {
		if ($token = $this->getToken()) {
			//authenticate token by instagram
			$tokenValid = true;
			//we will check here if token was expired
			if ($tokenValid) {
				return $token;
			} else {
				// if token was not valid
				$this->redirectAuth();
			}
		} else{
			$this->redirectAuth();
		}
	}


	public function getClient() {
		if (!$this->client) {
			$this->client = new Client([
			    // Base URI is used with relative requests
			    'base_uri' => $this->getConfig()->API_ENDPOINT,
			    // You can set any number of default request options.
			    'timeout'  => 2.0,
			]);	
		}
		
		return $this->client;
	}

	public function setAuth(&$params) {
		if (!$params) {
			$params = [];
		}

		$config = json_decode($this->getToken());
		$params['access_token'] = $config->access_token;
	}

	public function getConfig()
	{
		if (!$this->config) {
			$this->config = json_decode(file_get_contents(__DIR__ . '/conf/instagram.json'));
		}

		return $this->config;
	}


	public function get($endpoint, $params = null) {
		$this->authenticateToken();

		$this->setAuth($params);
		try {

			$response = $this->getClient()->request('GET', $endpoint, [
					'query'	=> $params
				]);

			return $this->parseResponse($response);

		} catch (RequestException $e) {

		    echo Psr7\str($e->getRequest());
		    
		    if ($e->hasResponse()) {
		        echo Psr7\str($e->getResponse());
		    }
		} catch (Exception $e) {
			echo $e->getMessage();
		}
	}

	public function parseResponse($response) {

		$code = $response->getStatusCode(); // 200
		$reason = $response->getReasonPhrase(); // OK
		
		if ($code == 200) {
			$body = $response->getBody();
			$json = $body->getContents();
		
			return json_decode($json);
		} else {
			throw new Exception($reason);				
		}

	}
}