<?php


namespace GraphQLResolve\Tests\Sim;


use Closure;
use GraphQLResolve\AbstractQuery;

/**
 * 模拟查询
 *
 * Class ResolveQuery
 * @package GraphQLResolve\Tests\Sim
 */
class ResolveQuery extends AbstractQuery
{
    public function type()
    {
        return ObjectType::getObject();
    }

    public function resolve(): Closure
    {
        return function () {

            return [
                'id' => 'someId',
                'data' => 'some data',
                'listData' => [
                    1.0,
                    2.5,
                    40.05,
                ],
            ];
        };
    }
}