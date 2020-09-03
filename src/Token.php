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
    
    /*****
     * error handling for the wrong or null user inputs
     * username = users username
     * environment should be sandbox always for every user
     * 
     * username should be required
     * environment should be required else error!
     */
    public function createCheckoutToken()
    {
        if ($this->username == "") {
            return $this->error('phoneNumber must be provided');
        }

        $request = [
            'username' => $this->username,
            'environment' => $this->environment
        ];

		$response = $this->client->post('checkout/token/create', ['form_params' => $request]);
		return $this->success($response);
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