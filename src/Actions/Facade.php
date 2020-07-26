<?php


namespace ParkwayProjects\PayWithBank3D\Actions;


trait Facade
{

    public static function __callStatic($method, $arguments)
    {
        return self::service()->{$method}(...$arguments);
    }

}
