<?php


namespace GraphQLResolve\Tests;


use GraphQLResolve\Tests\Sim\ResolveQuery;
use PHPUnit\Framework\TestCase;
use GraphQLResolve\Tests\Sim\ObjectType;

class QueryTest extends TestCase
{
    public function testQueryCreate()
    {
        $fieldInfo = ResolveQuery::fetchOptions();
        $this->assertEquals('resolveQuery', $fieldInfo['name']);
        $this->assertEquals(ObjectType::getObject(), $fieldInfo['type']);
    }
}