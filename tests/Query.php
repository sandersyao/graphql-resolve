<?php


namespace GraphQLResolve\Tests;


use GraphQL\Type\Definition\Type;
use GraphQLResolve\AbstractObjectType;
use GraphQLResolve\TypeRegistry;

class Query extends AbstractObjectType
{
    const TEST_DATA = [
        [
            'id'    => 1,
            'sn'    => 'abc',
        ],
    ];

    public function fields()
    {
        return  array_filter([
            'orders' => [
                'type'          => Type::nonNull(Type::listOf(TypeRegistry::get('Order'))),
                'description'   => '查询测试',
                'resolve'       => function ($rootValue) {
                    return  self::TEST_DATA;
                }
            ],
        ]);
    }
}
