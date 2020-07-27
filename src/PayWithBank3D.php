<?php

namespace ParkwayProjects\PayWithBank3D;

use ParkwayProjects\PayWithBank3D\Exceptions\Exceptions;

class PayWithBank3D
{
    public static $baseUrl = [
        'staging' => 'https://staging.paywithbank3d.com/api/',
        'live' => 'https://paywithbank3d.com/api/',
    ];

    public static $mode;
    /**
     * @var null
     */
    public static $secretKey;

    public static $publicKey;

    public static function setup($publicKey, $secretKey, $mode = 'live')
    {
        if (empty($secretKey) || empty($publicKey)) {
            throw Exceptions::create('format.is_null');
        }
        if (empty($mode)) {
            throw Exceptions::create('format.null_mode');
        }

        self::$secretKey = $secretKey;
        self::$publicKey = $publicKey;
        self::$mode = $mode;
    }
}
