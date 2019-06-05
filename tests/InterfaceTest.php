<?php


namespace GraphQLResolve\Tests;

use GraphQLResolve\Tests\Sim\ObjectImplements;
use PHPUnit\Framework\TestCase;

/**
 * 抽象接口测试用例
 *
 * Class InterfaceTest
 * @package GraphQLResolve\Tests
 */
class InterfaceTest extends TestCase
{
    /**
     * 测试继承关系
     *
     * @covers \GraphQLResolve\AbstractInterface::getObject
     * @covers \GraphQLResolve\AbstractInterface::mergeFields
     */
    public function testImplement()
    {
        $object = ObjectImplements::getObject();
        $this->assertArrayHasKey('id', $object->getFields());
        $this->assertArrayHasKey('skuName', $object->getFields());
        $this->assertArrayHasKey('quantity', $object->getFields());
    }
}