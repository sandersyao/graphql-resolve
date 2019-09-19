<?php


namespace GraphQLResolve\Tests;


use GraphQL\GraphQL;
use GraphQL\Type\Schema;
use GraphQL\Type\SchemaConfig;
use GraphQLResolve\TypeRegistry;
use PHPUnit\Framework\TestCase;

class SchemaTest extends TestCase
{
    private $schema;

    /**
     * 建立基境
     */
    public function setUp()
    {
        parent::setUp();
        TypeRegistry::load([
            Query::class,
            Order::class,
        ]);
        $config = SchemaConfig::create()
            ->setQuery(TypeRegistry::get('Query'))
            ->setTypeLoader(function ($name) {
                return  TypeRegistry::get($name);
            });
        $this->schema = new Schema($config);
        $this->schema->assertValid();
    }

    /**
     * 简单查询
     *
     * @covers \GraphQLResolve\TypeRegistry::load
     */
    public function testSimpleQuery()
    {
        $queryString    = '{
orders{
id
sn
}
}';

        $result = GraphQL::executeQuery(
            $this->schema,
            $queryString,
            null,
            null,
            []
        );
        $data   = $result->toArray();
        $this->assertEquals(Query::TEST_DATA, $data['data']['orders']);
    }

    public function testArguments()
    {
        $position       = 0;
        $queryString    = '{
orders (pos:' . $position . ') {
id
sn
}
}';

        $result = GraphQL::executeQuery(
            $this->schema,
            $queryString,
            null,
            null,
            []
        );
        $data   = $result->toArray();
        $this->assertEquals([Query::TEST_DATA[$position]], $data['data']['orders']);
    }
}
