<?php


namespace GraphQLResolve\Tests;


use GraphQL\Type\Definition\Type;
use GraphQLResolve\AbstractObjectType;
use GraphQLResolve\TypeRegistry;

class Mutation extends AbstractObjectType
{
    public function fields()
    {
        return  [
            'createOrder'   => [
                'args'  => [
                    'user'  => [
                        'type'          => Type::nonNull(TypeRegistry::get('UserInput')),
                        'description'   => '下单用户',
                    ],
                ],
                'type'          => Type::nonNull(TypeRegistry::get('Order')),
                'description'   => '测试订单创建',
                'resolve'       => function ($rootValue, $args) {
                    return  current(array_filter(Query::TEST_DATA, function ($item) use ($args) {
                        return  $item['userId'] == $args['user']['id'];
                    }));
                },
            ],
        ];
    }
}
