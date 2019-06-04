<?php


namespace GraphQLResolve\Tests\Sim;

use GraphQLResolve\AbstractObjectType;
use GraphQL\Type\Definition\Type;

/**
 * 模拟ObjectType继承类
 *
 * Class ObjectType
 * @package GraphQLResolve\Tests\Sim
 */
class ObjectType extends AbstractObjectType
{
    /**
     * 字段列表
     *
     * @return \Closure|array
     */
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