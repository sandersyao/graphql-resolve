<?php


namespace GraphQLResolve\Tests\Sim;

use GraphQLResolve\Builders\AbstractBuilder;

/**
 * 构建器模拟
 *
 * Class Builder
 * @package GraphQLResolve\Tests\Sim
 */
class Builder extends AbstractBuilder
{
    /**
     * @return array
     */
    public function getItems(): array
    {
        return  [
            'fields'    => 'required|type:array,callable',
            'resolve'   => 'type:callable',
        ];
    }

    /**
     * @param mixed ...$args
     * @return array|mixed
     */
    public function fetch(...$args)
    {
        return  $this->options();
    }
}