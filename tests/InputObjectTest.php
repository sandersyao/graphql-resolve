<?php


namespace GraphQLResolve\Tests;


use GraphQL\Type\Definition\InputObjectType;
use GraphQLResolve\Tests\Sim\ObjectInputType;
use PHPUnit\Framework\TestCase;

/**
 * 输入对象类型测试用例
 *
 * Class InputObjectTest
 * @package GraphQLResolve\Tests
 */
class InputObjectTest extends TestCase
{
    /**
     * 输入对象类型测试
     */
    public function testInputObject()
    {
        $object = ObjectInputType::getObject();

        $this->assertArrayHasKey('orderId', $object->getFields());
        $this->assertArrayHasKey('skuId', $object->getFields());
        $this->assertInstanceOf(InputObjectType::class, $object);
    }
}