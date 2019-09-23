<?php


namespace GraphQLResolve\Tests;


use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use GraphQLResolve\AbstractResolveField;
use GraphQLResolve\TypeRegistry;

class CreateOrderQuery extends AbstractResolveField
{
    public function __construct(array $config = [])
    {
        $config = array_merge($config, [
            'args'  => [
                'user'  => [
                    'type'          => Type::nonNull(TypeRegistry::get('UserInput')),
                    'description'   => '下单用户',
                ],
            ],
            'type'          => Type::nonNull(TypeRegistry::get('Order')),
            'description'   => '测试订单创建',
        ]);
        parent::__construct($config);
    }

    public function invoke($parent, array $args, $context, ResolveInfo $resolveInfo)
    {
        return  current(array_filter(OrdersField::TEST_DATA, function ($item) use ($args) {
            return  $item['userId'] == $args['user']['id'];
        }));
    }
}
