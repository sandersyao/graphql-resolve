<?php


namespace GraphQLResolve\Tests;


use GraphQL\GraphQL;
use GraphQL\Type\Schema;
use GraphQL\Type\SchemaConfig;
use GraphQLResolve\TypeRegistry;
use PHPUnit\Framework\TestCase;

class SchemaTest extends TestCase
{
    /**
     * @covers \GraphQLResolve\TypeRegistry::load
     */
    public function testSchema()
    {
        $queryString    = '{
orders{
id
sn
}
}';
        TypeRegistry::load([
            Query::class,
            Order::class,
        ]);
        $config = SchemaConfig::create()
            ->setQuery(TypeRegistry::get('Query'))
            ->setTypeLoader(function ($name) {
                return  TypeRegistry::get($name);
            });
        $schema = new Schema($config);
        $schema->assertValid();
        $result = GraphQL::executeQuery(
            $schema,
            $queryString,
            null,
            null,
            []
        );
        $data   = $result->toArray();
        $this->assertEquals(Query::TEST_DATA, $data['data']['orders']);
    }
}
