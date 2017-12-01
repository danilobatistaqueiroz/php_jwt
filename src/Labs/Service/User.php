<?php

namespace Labs\Service;

use \Firebase\JWT\JWT;
use \Labs\Persistence\UserDao;

class User {

	public $action;
	public $login;
	public $pwd;

	public function doLogin() {
		define('SECRET_KEY','Your-Secret-Key');  /// secret key can be a random string and keep in secret from anyone
		define('ALGORITHM','HS512');   // Algorithm used to sign the token, see
		//                               https://tools.ietf.org/html/draft-ietf-jose-json-web-algorithms-40#section-3
		//// Suppose you have submitted your form data here with username and password

		if ($this->login && $this->pwd && $this->action == 'login' ) {
			// if there is no error below code run
			$user = new UserDao();
			$row = $user->getByLogin($this->login);
			$hashAndSalt = password_hash($this->pwd, PASSWORD_BCRYPT);
			if(count($row)>0 && password_verify($row[0]['pwd'],$hashAndSalt))
			{
				$tokenId    = base64_encode(random_bytes(32));
				$issuedAt   = time();
				$notBefore  = $issuedAt + 10;  //Adding 10 seconds
				$expire     = $notBefore + 7200; // Adding 60 seconds
				$serverName = 'http://localhost:8082/php-jwt/'; /// set your domain name 
				/*
				* Create the token as an array
				*/
				$data = [
					'iat'  => $issuedAt,         // Issued at: time when the token was generated
					'jti'  => $tokenId,          // Json Token Id: an unique identifier for the token
					'iss'  => $serverName,       // Issuer
					'nbf'  => $notBefore,        // Not before
					'exp'  => $expire,           // Expire
					'data' => [                  // Data related to the logged user you can set your required data
						'id'   => $row[0]['id'], // id from the users table
						'login' => $row[0]['login'], // login
					]
				];
				$secretKey = base64_decode(SECRET_KEY);
				/// Here we will transform this array into JWT:
				$jwt = JWT::encode(
									$data, //Data to be encoded in the JWT
									$secretKey, // The signing key
									ALGORITHM 
								); 
				return  json_encode(['status'=>'success','jwt'=>$jwt]);
			} else {
				return  json_encode(['status'=>'error','msg'=>'Invalid user or password']);
			}
		}
	}
}