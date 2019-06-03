<?php

/**
 * @todo 完善Builder测试用例
 */
namespace GraphQLResolve\Tests;


use GraphQLResolve\Builders\AbstractBuilder;
use PHPUnit\Framework\TestCase;

class BuilderTest extends TestCase
{
    public function testBuilderCreate()
    {
    }
}

class A extends AbstractBuilder
{
    public function getItems(): array
    {
        return  [
            'a',
            'b',
        ];
    }

    public function fetch(...$args)
    {
        return [];
    }
}