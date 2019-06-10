<?php


namespace GraphQLResolve\Tests\Sim;

use GraphQL\Type\Definition\Type;
use GraphQLResolve\AbstractObjectType;

/**
 * 订单商品
 *
 * Class OrderGoods
 * @package GraphQLResolve\Tests\Sim
 */
class OrderGoods extends AbstractObjectType
{
    public function fields()
    {
        return function () {

            return [
                [
                    'name' => 'id',
                    'type' => Type::id(),
                ],
                [
                    'name' => 'sn',
                    'type' => Type::string(),
                ],
                [
                    'name' => 'name',
                    'type' => Type::string(),
                ],
                [
                    'name' => 'quantity',
                    'type' => Type::float(),
                ],
                [
                    'name' => 'unit',
                    'type' => GoodsUnit::getObject(),
                ],
            ];
        };
    }
}