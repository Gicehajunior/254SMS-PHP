<?php

namespace SMS254\SDK;

class Token{

    private $username;
    private $client;
    private $environment;

    /*******
     * Token class instatiation
     */
    public function __construct($client, $username, $environment){
        $this->username = $username;
        $this->client = $client;
        $this->environment = $environment;
    }

    /*****
     * error handling
     */
    protected static function generateTokenError($data) {
		return [
			'status' 	=> 'error',
			'data'		=> $data
		];
	}

    /******
     * success responses
     */
	protected static function generateTokenSuccess($data) {
		return [
			'status' 	=> 'success',
			'data'		=> json_decode($data->getBody()->getContents())
		];
    }
    

    /*******
     * Token generation
     * we have to post the users data to 254API for token generation
     * data passed: client Token, environment and the authenticated user username
     */
    public function generateToken(){
        $request = json_encode(['username' => $this->username]);
        $response = $this->client->post('token/generate', ['body' => $request] );
        
		return $this->generateTokenSuccess($response);
    }
}