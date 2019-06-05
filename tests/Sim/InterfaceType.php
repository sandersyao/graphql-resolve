<?php


namespace GraphQLResolve\Tests\Sim;

use GraphQL\Type\Definition\Type;
use GraphQLResolve\AbstractInterface;

/**
 * 模拟接口类型
 *
 * Class InterfaceType
 * @package GraphQLResolve\Tests\Sim
 */
class InterfaceType extends AbstractInterface
{
    public function fields()
    {
        return function () {

            return [
                [
                    'name' => 'id',
                    'type' => Type::id(),
                ],
            ];
        };
    }
}