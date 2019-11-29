<?php

use PHPUnit\Framework\TestCase;
use Fgsl\Microserviceframework\Handler\AclHandler;
use Fgsl\Microserviceframework\Model\AclFactory;
use Fgsl\Microserviceframework\Handler\AclHandlerFactory;
use Fgsl\Microserviceframework\Handler\LogoutHandler;
use Fgsl\Microserviceframework\Handler\LogoutHandlerFactory;
use Fgsl\Microserviceframework\Middleware\SessionMiddleware;

/**
 *  test case.
 */
class MicroserviceTest extends TestCase
{
    public function testInstances()
    {
        $this->assertTrue(class_exists(AclFactory::class));
        $this->assertTrue(class_exists(AclHandler::class));
        $this->assertTrue(class_exists(AclHandlerFactory::class));
        $this->assertTrue(class_exists(LogoutHandler::class));
        $this->assertTrue(class_exists(LogoutHandlerFactory::class));
        $this->assertTrue(class_exists(SessionMiddleware::class));
    }    
}