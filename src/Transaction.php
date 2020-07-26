<?php

namespace ParkwayProjects\PayWithBank3D;

use ParkwayProjects\PayWithBank3D\Actions\Facade;
use ParkwayProjects\PayWithBank3D\Actions\TransactionService;

class Transaction
{
    use Facade;

    public static function service()
    {
        return new TransactionService();
    }
}
