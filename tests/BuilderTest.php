<?php

/**
 * Builder测试用例
 */
namespace GraphQLResolve\Tests;


use GraphQL\Type\Definition\ObjectType;
use GraphQLResolve\Builders\ObjectTypeBuilder;
use GraphQLResolve\Tests\Sim\Builder;
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
        $builder    = Builder::getInstance()
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

    /**
     * 测试ObjectTypeBuilder
     *
     * @covers \GraphQLResolve\Builders\AbstractBuilder::fetch
     */
    public function testObjectTypeBuilder()
    {
        $callback   = function(){};
        $fields     = [];
        $options    = ObjectTypeBuilder::getInstance()
            ->name('typeName')
            ->description('typeDescription')
            ->fields($fields)
            ->resolve($callback)
            ->fetch();

        $this->assertEquals($options, new ObjectType([
            'name'          => 'typeName',
            'description'   => 'typeDescription',
            'fields'        => $fields,
            'resolve'       => $callback,
        ]));
    }
}
