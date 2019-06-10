<?php


namespace GraphQLResolve\Tests\Sim;

use Closure;
use GraphQL\Type\Definition\Type;
use GraphQLResolve\AbstractQuery;

/**
 * 订单查询
 *
 * Class Orders
 * @package GraphQLResolve\Tests\Sim
 */
class Orders extends AbstractQuery
{
    public function type()
    {
        return Type::nonNull(Type::listOf(Order::getObject()));
    }

    public function resolve(): Closure
    {
        return function () {

            return [
                [
                    'id' => uniqid(),
                    'sn' => uniqid('SN:'),
                    'orderAt' => date('Y-m-d H:i:s'),
                    'userId' => uniqid('USR:'),
                    'orderStatus' => '1',
                ],
                [
                    'id' => uniqid(),
                    'sn' => uniqid('SN:'),
                    'orderAt' => date('Y-m-d H:i:s'),
                    'userId' => uniqid('USR:'),
                    'orderStatus' => '2',
                ],
            ];
        };
    }
}