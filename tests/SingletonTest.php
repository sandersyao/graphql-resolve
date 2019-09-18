<?php


namespace GraphQLResolve\Tests;


use PHPUnit\Framework\TestCase;

class SingletonTest extends TestCase
{
    /**
     * @covers Singleton::getInstance
     */
    public function testGetInstance()
    {
        $this->assertEquals(SingletonClass::class, get_class(SingletonClass::getInstance()));
    }
}
