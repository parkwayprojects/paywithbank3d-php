<?php

namespace ParkwayProjects\PayWithBank3D\Tests;

use ParkwayProjects\PayWithBank3D\Exceptions\Exceptions;
use ParkwayProjects\PayWithBank3D\PayWithBank3D;
use PHPUnit\Framework\TestCase;
use ReflectionClass;

class PayWithBank3DTest extends TestCase
{
    /** @test */
    public function true_is_true()
    {
        $this->assertTrue(true);
    }

    /** @test */
    public function inValidKeys(){
        $this->expectException(Exceptions::class);
        new PayWithBank3D('staging', '', '');
    }

    public function testConstructorCallsInternalMethods()
    {

        $mock = $this->getMockBuilder(PayWithBank3D::class)
            ->setConstructorArgs(['staging', 'test@payzone', 'PayzoneAPP'])
            ->setMethods(array('prepareRequest'))
            ->getMock();

        $mock->expects($this->once())
            ->method('prepareRequest');

        $this->expectOutputString('YOU SHALL NOT PASS');

        $mock->addBody('hi', 'me');
    }


}
