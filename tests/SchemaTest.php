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

            // Interfaces
            Node::class,

            // Input Object Types
            UserInput::class,

            // Output Object Types
            Sku::class,
            Order::class,

            // Union Types
            SearchResult::class,

            // Root Types
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
        $position       = 0;
        $queryString    = '{
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
     *
     * @covers \GraphQLResolve\AbstractInputObjectType
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
     *
     * @covers \GraphQLResolve\AbstractObjectType
     * @covers \GraphQLResolve\AbstractInputObjectType
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
     *
     * @covers \GraphQLResolve\AbstractDirective
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

    /**
     * 测试接口
     *
     * @covers \GraphQLResolve\AbstractObjectType
     */
    public function testInterfaceType()
    {
        $idSku          = 'sku:1';
        $idOrder        = 'order:3';
        $queryString    = '{
sku:node (id:"' . $idSku . '"){
id
... on Sku {
name
}
}
order:node (id:"' . $idOrder . '"){
id
... on Order {
userId
sn
}
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
        $this->assertEquals([
            'sku'   => current(array_filter(Query::TEST_NODES, function ($item) use ($idSku) {
                return  $idSku == $item['id'];
            })),
            'order' => current(array_filter(Query::TEST_NODES, function ($item) use ($idOrder) {
                return  $idOrder == $item['id'];
            })),
        ], $data['data']);
    }

    /**
     * 测试联合类型
     *
     * @covers \GraphQLResolve\AbstractObjectType
     */
    public function testUnionType()
    {
        $queryString    = '{
search{
__typename
... on Order{
id
userId
sn
}
... on Sku{
id
name
}
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
            list($type) = explode(':', $item['id'], 2);
            $item['__typename'] = ucfirst($type);
            return  $item;
        },Query::TEST_NODES), $data['data']['search']);
    }
}
