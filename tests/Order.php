<?php


namespace GraphQLResolve\Tests;


use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use GraphQLResolve\AbstractObjectType;

class Order extends AbstractObjectType
{
    public function description()
    {
        return  '订单类型';
    }

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
                'resolve'       => function ($rootValue, $args, $context, ResolveInfo $resolveInfo) {
                    return  $rootValue[$resolveInfo->fieldName];
                }
            ],
            'userId'    => [
                'type'          => Type::nonNull(Type::string()),
                'description'   => '用户ID',
            ],
        ];
    }
}
