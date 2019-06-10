<?php


namespace GraphQLResolve\Tests;


use GraphQL\GraphQL;
use GraphQL\Type\Schema;
use GraphQLResolve\Tests\Sim\Mutation;
use GraphQLResolve\Tests\Sim\Query;
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
}