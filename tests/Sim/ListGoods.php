<?php


namespace GraphQLResolve\Tests\Sim;


use Closure;
use GraphQL\Type\Definition\Type;
use GraphQLResolve\AbstractQuery;

class ListGoods extends AbstractQuery
{
    public function name(): string
    {
        return 'orderGoods';
    }

    public function type()
    {
        return Type::listOf(OrderGoods::getObject());
    }

    public function resolve(): Closure
    {
        return function () {

            return [
                [
                    'id' => uniqid(),
                    'sn' => uniqid('SN:'),
                    'name' => '钢笔',
                    'quantity' => mt_rand(1, 2),
                    'unit' => 'unit',
                ],
                [
                    'id' => uniqid(),
                    'sn' => uniqid('SN:'),
                    'name' => '苹果',
                    'quantity' => mt_rand(125, 500) * 0.001,
                    'unit' => 'KG',
                ],
            ];
        };
    }
}