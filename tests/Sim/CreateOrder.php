<?php


namespace GraphQLResolve\Tests\Sim;

use Closure;
use GraphQLResolve\AbstractQuery;

/**
 * 创建订单
 *
 * Class CreateOrder
 * @package GraphQLResolve\Tests\Sim
 */
class CreateOrder extends AbstractQuery
{
    public function type()
    {
        return Order::getObject();
    }

    public function resolve(): Closure
    {
        return function () {

            return [
                'id' => uniqid(),
                'sn' => uniqid('SN:'),
                'orderAt' => date('Y-m-d H:i:s'),
                'userId' => uniqid('USR:'),
                'orderStatus' => 0,
            ];
        };
    }
}