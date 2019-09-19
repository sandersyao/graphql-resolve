<?php


namespace GraphQLResolve\Tests;


use GraphQL\Type\Definition\Type;
use GraphQLResolve\AbstractObjectType;

class Order extends AbstractObjectType
{
    public function fields()
    {
        return  [
            'id'    => [
                'type'          => Type::nonNull(Type::id()),
                'description'   => '订单ID',
            ],
            'sn'    => [
                'type'          => Type::nonNull(Type::string()),
                'description'   => '订单编号',
            ],
        ];
    }
}
