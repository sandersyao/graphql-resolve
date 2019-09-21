<?php


namespace GraphQLResolve\Tests;


use GraphQL\Type\Definition\Type;
use GraphQLResolve\AbstractObjectType;
use GraphQLResolve\TypeRegistry;

class Mutation extends AbstractObjectType
{
    /**
     * @var string 描述
     */
    public $description = '根变更';

    /**
     * 字段定义
     *
     * @return array|mixed
     */
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
