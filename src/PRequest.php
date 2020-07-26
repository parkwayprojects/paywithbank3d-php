<?php


namespace ParkwayProjects\PayWithBank3D;


use GuzzleHttp\Client;
use ParkwayProjects\PayWithBank3D\Exceptions\Exceptions;

abstract class PRequest
{
    protected $client;

    protected $response;

    protected  $data;

    public function __construct()
    {
        if (empty(PayWithBank3D::$secretKey) || empty(PayWithBank3D::$publicKey)) {
            throw Exceptions::create('format.is_null');
        }

        $this->prepareRequest();
    }

    protected function prepareRequest()
    {
        $this->client = new Client([
            'base_uri' => PayWithBank3D::$baseUrl[PayWithBank3D::$mode],
            'auth' => [PayWithBank3D::$publicKey, PayWithBank3D::$secretKey],
            'headers' => ['Content-Type' => 'application/json', 'Accept' => 'application/json']
        ]);
    }
    public function getResponse()
    {
        $response = new Response($this->response);
        $json = $response->toJSON();

        return json_decode($json, true);
    }

    protected function performGetRequest($relativeUrl){
        $this->response = $this->client->request('GET', $relativeUrl);
        return $this->getResponse();
    }

    protected function performPostRequest($relativeUrl){
        $this->response = $this->client->request('POST', $relativeUrl, ['json'=> $this->data]);
        return $this->getResponse();
    }

    public function addBody($name, $value){
        $this->data[$name] = $value;
        return $this;
    }
}
