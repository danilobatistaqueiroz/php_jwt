<?php
error_reporting(E_ERROR);

require_once ('../vendor/autoload.php');

use \Firebase\JWT\JWT;
define('SECRET_KEY', 'Your-Secret-Key'); /// secret key can be a random string and keep in secret from anyone
define('ALGORITHM', 'HS512'); // Algorithm used to sign the token, see

// https://tools.ietf.org/html/draft-ietf-jose-json-web-algorithms-40#section-3
// // Suppose you have submitted your form data here with username and password

$hashAndSalt = password_hash("123", PASSWORD_BCRYPT);

if (password_verify("123", $hashAndSalt))
{
	$tokenId = base64_encode(mcrypt_create_iv(32));
	$issuedAt = time();
	$notBefore = $issuedAt + 10; //Adding 10 seconds
	$expire = $notBefore + 7200; // Adding 60 seconds
	$serverName = 'http://localhost:8082/php-json/'; /// set your domain name
	/*
	* Create the token as an array
	*/
	$data = ['iat' => $issuedAt, // Issued at: time when the token was generated
	'jti' => $tokenId, // Json Token Id: an unique identifier for the token
	'iss' => $serverName, // Issuer
	'nbf' => $notBefore, // Not before
	'exp' => $expire, // Expire
	'data' => [ // Data related to the logged user you can set your required data
		'id' => 1,
		'name' => "danilo", //  name
	]];
	$secretKey = base64_decode(SECRET_KEY);

	// / Here we will transform this array into JWT:

	$jwt = JWT::encode($data, //Data to be encoded in the JWT
	$secretKey, // The signing key
	ALGORITHM);
	$unencodedArray = ['jwt' => $jwt];
	echo "{'status' : 'success','resp':" . json_encode($unencodedArray) . "}";
}
else
{
	echo "{'status' : 'error','msg':'Invalid email or passowrd'}";
}