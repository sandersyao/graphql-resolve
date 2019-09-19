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
            'userId'=> 1,
            'sn'    => 'abc',
        ],
        [
            'id'    => 2,
            'userId'=> 2,
            'sn'    => 'bcd',
        ],
    ];

    const POS_ALL   = 'all';

    public function description()
    {
        return  '根查询';
    }

    public function fields()
    {
        return  array_filter([
            'orders' => [
                'type'          => Type::nonNull(Type::listOf(TypeRegistry::get('Order'))),
                'description'   => '查询测试',
                'resolve'       => function ($rootValue, $args) {

                    if (isset($args['user'])) {

                        return  array_filter(self::TEST_DATA, function ($item) use ($args) {
                            return  $item['userId'] == $args['user']['id'];
                        });
                    }

                    if (self::POS_ALL === $args['pos']) {

                        return  self::TEST_DATA;
                    }

                    return  [self::TEST_DATA[$args['pos']]];
                },
                'args'          => [
                    'pos'   => [
                        'type'          => Type::int(),
                        'description'   => '简单参数测试',
                        'defaultValue'  => self::POS_ALL,
                    ],
                    'user'  => [
                        'type'          => TypeRegistry::get('UserInput'),
                        'description'   => '输入类型参数测试',
                    ]
                ],
            ],
        ]);
    }
}
