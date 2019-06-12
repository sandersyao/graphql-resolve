<?php


namespace GraphQLResolve\Tests;


use GraphQL\GraphQL;
use GraphQL\Type\Schema;
use GraphQLResolve\Tests\Sim\Mutation;
use GraphQLResolve\Tests\Sim\Order;
use GraphQLResolve\Tests\Sim\Orders;
use GraphQLResolve\Tests\Sim\Query;
use GraphQLResolve\Tools\QueryMap;
use GraphQLResolve\Tools\TypeMap;
use PHPUnit\Framework\TestCase;

class SchemaTest extends TestCase
{
    protected $schema;

    public function setUp()
    {
        parent::setUp();
        $this->schema = new Schema([
            'query' => Query::getObject(),
            'mutation' => Mutation::getObject(),
        ]);
    }

    public function testSchemaCreate()
    {
        $query = '{orders{
    id
    sn
    orderStatus
}}';
        $rootValue = null;
        $variableValues = [];
        $context = [];
        $operationName = null;

        $result = GraphQL::executeQuery(
            $this->schema,
            $query,
            $rootValue,
            $context,
            $variableValues,
            $operationName
        );
        $data = $result->toArray();
        $this->assertEquals('NEW', $data['data']['orders'][0]['orderStatus']);
    }

    public function testClassMap()
    {
        $this->assertEquals(Orders::class, QueryMap::get('orders'));
        $this->assertEquals(Order::class, TypeMap::get('Order'));
    }
}