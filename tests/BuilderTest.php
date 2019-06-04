<?php

/**
 * Builder测试用例
 */
namespace GraphQLResolve\Tests;


use GraphQLResolve\Builders\AbstractBuilder;
use PHPUnit\Framework\TestCase;

class BuilderTest extends TestCase
{
    /**
     * 测试正常工作状态
     *
     * @covers \GraphQLResolve\Builders\AbstractBuilder::fetch
     */
    public function testBuilderCreate()
    {
        $callbackA  = function () {};
        $callbackB  = function () {};
        $builder    = A::getInstance()
            ->fields($callbackA)
            ->resolve($callbackB);
        $object     = $builder->fetch();

        $this->assertEquals($callbackA, $builder->fields());
        $this->assertEquals($callbackB, $builder->resolve());
        $this->assertEquals($object, [
            'fields'    => $callbackA,
            'resolve'   => $callbackB,
        ]);
    }
}

class A extends AbstractBuilder
{
    public function getItems(): array
    {
        return  [
            'fields'    => 'required|type:array,callable',
            'resolve'   => 'type:callable',
        ];
    }

    public function fetch(...$args)
    {
        return  $this->options();
    }
}