<?php
/**
 * TODO complete ObjectType test case
 */

namespace GraphQLResolve\Tests;

use GraphQLResolve\Tests\Sim\ObjectType;
use PHPUnit\Framework\TestCase;

class ObjectTypeTest extends TestCase
{
    /**
     * 测试创建实例
     *
     * @covers \GraphQLResolve\AbstractObjectType::getObject
     */
    public function testCreateInstance ()
    {
        $objectType = ObjectType::getObject();
        $this->assertEquals($objectType->name, 'ObjectType');
        $this->assertArrayHasKey('id', $objectType->getFields());
        $this->assertArrayHasKey('data', $objectType->getFields());
        $this->assertArrayHasKey('listData', $objectType->getFields());
    }
}
