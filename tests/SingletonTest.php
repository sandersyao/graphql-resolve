<?php


namespace GraphQLResolve\Tests;

use GraphQLResolve\Traits\Singleton;
use PHPUnit\Framework\TestCase;

class SingletonTest extends TestCase
{
    /**
     * 验证实例相等
     *
     * @throws \Exception
     * @covers Singleton::getInstance
     */
    public function testSingleton()
    {
        $objectA = Sim::getInstance();
        $objectB = Sim::getInstance();

        $this->assertTrue($objectA === $objectB);
    }
}

class Sim
{
    use Singleton;
}