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

    const TEST_NODES    = [
        [
            'id'    => 'sku:1',
            'name'  => 'abc',
        ],
        [
            'id'    => 'order:3',
            'userId'=> '1',
            'sn'    => 'cde',
        ],
    ];

    const POS_ALL   = 'all';

    /**
     * @var string 描述
     */
    public $description = '根查询';

    /**
     * @return array|mixed 字段定义
     */
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
                    ],
                ],
            ],
            'node'  => [
                'type'          => Type::nonNull(TypeRegistry::get('Node')),
                'description'   => '测试查询2',
                'args'          => [
                    'id'    => [
                        'type'          => Type::id(),
                        'description'   => '查询ID',
                    ],
                ],
            ],
        ]);
    }

    public function resolveNodeField($parent, $args)
    {
        return current(array_filter(self::TEST_NODES, function ($item) use ($args) {
            return  $args['id'] == $item['id'];
        }));
    }
}
