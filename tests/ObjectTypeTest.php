<?php
/**
 * TODO complete ObjectType test case
 */

namespace GraphQLResolve\Tests;

use GraphQL\Type\Definition\Type;
use GraphQLResolve\AbstractObjectType;
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
        $objectType = TestObjectType::getObject();
        $this->assertEquals($objectType->name, 'TestObjectType');
        $this->assertArrayHasKey('id', $objectType->getFields());
        $this->assertArrayHasKey('data', $objectType->getFields());
        $this->assertArrayHasKey('listData', $objectType->getFields());
    }
}

class TestObjectType extends AbstractObjectType
{
    public function fields()
    {
        return  function () {
            return  [
                'id'    => Type::nonNull(Type::id()),
                [
                    'name'  => 'data',
                    'type'  => Type::nonNull(Type::string()),
                ],
                [
                    'name'          => 'listData',
                    'type'          => Type::listOf(Type::float()),
                    'description'   => '列表数据',
                ],
            ];
        };
    }
}