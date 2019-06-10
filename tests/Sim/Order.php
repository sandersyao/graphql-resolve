<?php


namespace GraphQLResolve\Tests\Sim;

use GraphQL\Type\Definition\Type;
use GraphQLResolve\AbstractObjectType;

/**
 * 订单
 *
 * Class Order
 * @package GraphQLResolve\Tests\Sim
 */
class Order extends AbstractObjectType
{
    public function fields()
    {
        return function () {

            $fields = [
                [
                    'name' => 'id',
                    'type' => Type::id(),
                ],
                [
                    'name' => 'sn',
                    'type' => Type::string(),
                ],
                [
                    'name' => 'userId',
                    'type' => Type::string(),
                ],
                [
                    'name' => 'orderAt',
                    'type' => Type::string(),
                ],
                [
                    'name' => 'orderStatus',
                    'type' => OrderStatus::getObject(),
                ],
                ListGoods::fetchOptions(),
            ];

            return $fields;
        };
    }
}