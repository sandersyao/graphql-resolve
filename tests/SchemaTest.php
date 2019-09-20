<?php


namespace GraphQLResolve\Tests;


use GraphQL\Error\Debug;
use GraphQL\GraphQL;
use GraphQL\Type\Schema;
use GraphQL\Type\SchemaConfig;
use GraphQLResolve\DirectiveRegistry;
use GraphQLResolve\TypeRegistry;
use PHPUnit\Framework\TestCase;

/**
 * Class SchemaTest
 * @package GraphQLResolve\Tests
 */
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
            UserInput::class,
            Order::class,
            Query::class,
            Mutation::class,
        ]);
        DirectiveRegistry::load([
            UpperCase::class,
            Substr::class,
        ]);
        $config = SchemaConfig::create()
            ->setQuery(TypeRegistry::get('Query'))
            ->setMutation(TypeRegistry::get('Mutation'))
            ->setDirectives(DirectiveRegistry::getAll())
            ->setTypeLoader(function ($name) {
                return TypeRegistry::get($name);
            });
        $this->schema = new Schema($config);
        $this->schema->assertValid();
    }

    /**
     * 销毁基境
     */
    public function tearDown()
    {
        TypeRegistry::destroy();
        DirectiveRegistry::destroy();
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
        $data = $result->toArray(Debug::INCLUDE_TRACE|Debug::INCLUDE_DEBUG_MESSAGE);
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

    /**
     * 测试输入对象类型
     */
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
            $variables
        );
        $data = $result->toArray(true);
        $this->assertEquals(array_filter(Query::TEST_DATA, function ($item) use ($variables) {
            return  $variables['user']['id'] == $item['userId'];
        }), $data['data']['orders']);
    }

    /**
     * 测试变更
     */
    public function testMutation()
    {
        $variables      = ['user'=>['id'=>2]];
        $queryString    = 'mutation Test($user:UserInput!) {
createOrder (user:$user) {
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
            $variables
        );
        $data = $result->toArray(true);
        $this->assertEquals(current(array_filter(Query::TEST_DATA, function ($item) use ($variables) {
            return  $variables['user']['id'] == $item['userId'];
        })), $data['data']['createOrder']);
    }

    /**
     * 测试指令
     */
    public function testDirective()
    {
        $queryString = '{
orders{
id
userId
sn @uppercase @substr(offset:1)
}
}';
        $result = GraphQL::executeQuery(
            $this->schema,
            $queryString,
            null,
            null,
            []
        );
        $data = $result->toArray(Debug::INCLUDE_DEBUG_MESSAGE|Debug::INCLUDE_TRACE);
        $this->assertEquals(array_map(function ($item) {

            $item['sn'] = substr(strtoupper($item['sn']), 1);

            return  $item;
        },Query::TEST_DATA), $data['data']['orders']);
    }
}
