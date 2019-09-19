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
        [
            'id'    => 2,
            'sn'    => 'bcd',
        ],
    ];

    public function fields()
    {
        return  array_filter([
            'orders' => [
                'type'          => Type::nonNull(Type::listOf(TypeRegistry::get('Order'))),
                'description'   => '查询测试',
                'resolve'       => function ($rootValue, $args) {

                    if ('' === $args['pos']) {

                        return  self::TEST_DATA;
                    }

                    return  [self::TEST_DATA[$args['pos']]];
                },
                'args'          => [
                    'pos'   => [
                        'type'          => Type::int(),
                        'description'   => '简单参数测试',
                        'defaultValue'  => '',
                    ],
                ],
            ],
        ]);
    }
}
