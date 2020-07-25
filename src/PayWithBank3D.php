<?php

namespace ParkwayProjects\PayWithBank3D;

use Exception;
use GuzzleHttp\Client;
use ParkwayProjects\PayWithBank3D\Exceptions\Exceptions;


class PayWithBank3D
{
    protected $baseUrl = [
        'staging' => 'https://staging.paywithbank3d.com/api/',
        'live' => 'https://paywithbank3d.com/api/'
    ];

    protected $mode;
    /**
     * @var null
     */
    protected $secretKey;

    protected $publicKey;

    protected $data;

    protected $client;

    protected $response;

    protected $redirectUrl;

    /**
     * PayWithBank3D constructor.
     *
     * @param string $mode
     * @param null $secretKey
     * @param null $publicKey
     *
     * @throws \ParkwayProjects\PayWithBank3D\Exceptions\Exceptions
     */
    public function __construct($secretKey, $publicKey, $mode='live')
    {
        if (empty($secretKey) || empty($publicKey)) {
            throw Exceptions::create('format.is_null');
        }
        if (empty($mode)) {
            throw Exceptions::create('format.null_mode');
        }

        $this->secretKey = $secretKey;
        $this->publicKey = $publicKey;
        $this->mode = $mode;

        $this->prepareRequest();
    }

    protected function prepareRequest()
    {
        $this->client = new Client([
            'base_uri' => $this->baseUrl[$this->mode],
            'auth' => [$this->publicKey, $this->secretKey],
            'headers' => ['Content-Type' => 'application/json', 'Accept' => 'application/json']
        ]);
    }


    /**
     * @return mixed
     */
    public function getResponse()
    {
        $response = new Response($this->response);
        $json = $response->toJSON();

        return json_decode($json, true);
    }

    protected function performPostRequest($relativeUrl){
        $this->response = $this->client->request('POST', $relativeUrl, ['json'=> $this->data]);
        return $this->getResponse();
    }

    protected function performGetRequest($relativeUrl){
        $this->response = $this->client->request('GET', $relativeUrl);
        return $this->getResponse();
    }

    public function addBody($name, $value){
        $this->data[$name] = $value;
        return $this;
    }

    public function getAuthorizationUrl(){
        try {
            $data = $this->performPostRequest('transaction/initialize');
            $this->redirectUrl = $data['body']['data']['paymentUrl'];
            return $this;
        }catch (Exception $exception){
            throw new Exception($exception->getMessage());
        }

    }

    public function redirectNow(){
        header('Location: '.$this->redirectUrl);
        exit;
    }

    public function verify(){
        $reference  = isset($_GET['reference']) ? $_GET['reference'] : null;
        if(is_null($reference) || !is_string($reference)){
            die('No Reference');
        }
        try {
           return $this->performGetRequest('payment/verify/'.$reference);
        } catch (Exception $exception){
            throw new Exception($exception->getMessage());
        }
    }
}
