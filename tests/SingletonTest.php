<?php


namespace GraphQLResolve\Tests;

use GraphQLResolve\Tests\Sim\SingletonClass;
use PHPUnit\Framework\TestCase;

/**
 * 单例单元测试
 *
 * Class SingletonTest
 * @package GraphQLResolve\Tests
 */
class SingletonTest extends TestCase
{
    /**
     * 验证实例相等
     *
     * @covers Singleton::getInstance
     */
    public function testSingleton()
    {
        $objectA = SingletonClass::getInstance();
        $objectB = SingletonClass::getInstance();

        $this->assertTrue($objectA === $objectB);
    }
}