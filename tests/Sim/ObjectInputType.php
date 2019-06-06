<?php


namespace GraphQLResolve\Tests\Sim;


use GraphQL\Type\Definition\Type;
use GraphQLResolve\AbstractInputObjectType;

class ObjectInputType extends AbstractInputObjectType
{
    public function fields()
    {
        return function () {
            return [
                [
                    'name' => 'orderId',
                    'type' => Type::id(),
                ],
                [
                    'name' => 'skuId',
                    'type' => Type::id(),
                ],
            ];
        };
    }
}