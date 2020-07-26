<?php

namespace ParkwayProjects\PayWithBank3D\Actions;

use Exception;
use ParkwayProjects\PayWithBank3D\PRequest;

class TransactionService extends PRequest
{
    protected $initializeUrl = 'transaction/initialize';
    protected $verifyUrl = 'payment/verify/';

    protected $redirectUrl;

    public function getAuthorizationUrl()
    {
        try {
            $data = $this->performPostRequest($this->initializeUrl);
            $this->redirectUrl = $data['body']['data']['paymentUrl'];

            return $this;
        } catch (Exception $exception) {
            throw new Exception($exception->getMessage());
        }
    }

    public function redirectNow()
    {
        header('Location: '.$this->redirectUrl);
        exit;
    }

    public function verify()
    {
        $reference = isset($_GET['reference']) ? $_GET['reference'] : null;
        if (is_null($reference) || ! is_string($reference)) {
            die('No Reference');
        }
        try {
            return $this->performGetRequest($this->verifyUrl.$reference);
        } catch (Exception $exception) {
            throw new Exception($exception->getMessage());
        }
    }
}
