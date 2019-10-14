<?php


namespace GraphQLResolve\Tests\Laravel\Types;


use GraphQL\Type\Definition\Type;
use GraphQLResolve\AbstractObjectType;
use GraphQLResolve\SimpleField;
use GraphQLResolve\Tests\Laravel\Queries\UserQuery;
use GraphQLResolve\TypeRegistry;

class Order extends AbstractObjectType
{
    public function fields()
    {
        return  [
            new SimpleField([
                'name'          => 'id',
                'type'          => Type::id(),
                'description'   => '订单ID',
            ]),
            new SimpleField([
                'name'          => 'sn',
                'type'          => Type::string(),
                'description'   => '订单编号',
            ]),
            new UserQuery([
                'description'   => '下单用户',
            ]),
        ];
    }
}
