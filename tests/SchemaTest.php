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
            UserInput::class,
        ]);
        $config = SchemaConfig::create()
            ->setQuery(TypeRegistry::get('Query'))
            ->setTypeLoader(function ($name) {
                return TypeRegistry::get($name);
            });
        $this->schema = new Schema($config);
        $this->schema->assertValid();
    }

    public function tearDown()
    {
        TypeRegistry::destroy();
        parent::tearDown();
    }

    /**
     * 简单查询
     *
     * @covers \GraphQLResolve\TypeRegistry::load
     */
    public function testSimpleQuery()
    {
        $queryString = '{
orders{
id
userId
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
        $data = $result->toArray(true);
        $this->assertEquals(Query::TEST_DATA, $data['data']['orders']);
    }

    /**
     * 测试简单参数
     *
     * @covers \GraphQLResolve\AbstractObjectType::fields
     */
    public function testArguments()
    {
        $position = 0;
        $queryString = '{
orders (pos:' . $position . ') {
id
userId
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
        $data = $result->toArray();
        $this->assertEquals([Query::TEST_DATA[$position]], $data['data']['orders']);
    }

    public function testInputObject()
    {
        $variables      = ['user'=>['id'=>1]];
        $queryString    = 'query Test($user:UserInput) {
orders (user:$user) {
id
userId
sn
}
}';
        $result = GraphQL::executeQuery(
            $this->schema,
            $queryString,
            null,
            null,
            ['user'=>['id'=>1]]
        );
        $data = $result->toArray(true);
        $this->assertEquals(array_filter(Query::TEST_DATA, function ($item) use ($variables) {
            return  $variables['user']['id'] == $item['userId'];
        }), $data['data']['orders']);
    }
}
