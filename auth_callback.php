<?php

include_once('instagram.php');
//using guzzle
use GuzzleHttp\Client;

define("SITE_URL", "http://localhost/instagram/");


if (isset($_GET['code'])) {

	$instagram = new Instagram();

	$instagramConfig = $instagram->getConfig();

	$client = new Client([
	    // Base URI is used with relative requests
	    'base_uri' => 'https://api.instagram.com',
	    // You can set any number of default request options.
	    'timeout'  => 2.0,
	]);	
	


	//creating guzzle client to communicate with instagram
	$response = $client->request('POST', '/oauth/access_token', [
			'form_params' => [
				'client_id'		=> $instagramConfig->Client_ID,
				'client_secret' => $instagramConfig->Client_Secret,
				'grant_type'	=> 'authorization_code',
				'redirect_uri'	=> $instagramConfig->Redirect_Url,
				'code'			=> $_GET['code']
			]
		]);

	//print_r($response);

	$code = $response->getStatusCode(); // 200
	$reason = $response->getReasonPhrase(); // OK

	$body = $response->getBody();
	$json = $body->getContents();

	//echo $json;

	$instagram->saveToken($json);

	//sleep(1);

	header("location: " . SITE_URL);
	exit();

	// Implicitly cast the body to a string and echo it
	//echo $body;
	// Explicitly cast the body to a string
	//$stringBody = (string) $body;
	// Read 10 bytes from the body
	//$tenBytes = $body->read(10);
	// Read the remaining contents of the body as a string
	//$remainingBytes = $body->getContents();
} else if (isset($_GET['error'])) {
	//if error returned by isntagram
	print_r($_GET['error']);
}