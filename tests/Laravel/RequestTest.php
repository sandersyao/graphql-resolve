<?php


namespace GraphQLResolve\Tests\Laravel;


use GraphQL\Error\Debug;
use GraphQLResolve\DirectiveRegistry;
use GraphQLResolve\Tests\Laravel\Http\GraphQLController;
use GraphQLResolve\Tests\Laravel\Models\Order;
use GraphQLResolve\Tests\Laravel\Models\Sku;
use GraphQLResolve\Tests\Laravel\Models\Spu;
use GraphQLResolve\Tests\Laravel\Models\User;
use GraphQLResolve\Tests\Laravel\Types\Query;
use GraphQLResolve\TypeRegistry;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Orchestra\Testbench\TestCase;
use GraphQLResolve\Laravel\GraphQLResolveServiceProvider;

class RequestTest extends TestCase
{
    use RefreshDatabase;

    /**
     * 数据库配置
     */
    const DATABASE  = 'graphql_test';

    /**
     * 注册服务提供者
     *
     * @param Application $app
     * @return array
     */
    protected function getPackageProviders($app)
    {
        return  [GraphQLResolveServiceProvider::class];
    }

    /**
     * 环境配置
     *
     * @param Application $app
     */
    protected function getEnvironmentSetUp($app)
    {
        $app['config']->set('database.default', self::DATABASE);
        $app['config']->set('database.connections.' . self::DATABASE, [
            'driver'    => 'sqlite',
            'database'  => ':memory:',
            'prefix'    => '',
        ]);
        $app['router']->post('graphql', GraphQLController::class . '@resolve');
        $app['config']->set('graphql.types', [
            Types\User::class,
            Types\Order::class,
            Query::class,
        ]);
        $app['config']->set('graphql.directives', []);
        $app['config']->set('graphql.loaders', []);
        $app['config']->set('graphql.debug', Debug::INCLUDE_TRACE|Debug::INCLUDE_DEBUG_MESSAGE);
    }

    /**
     * 构建基境
     */
    protected function setUp(): void
    {
        parent::setUp();

        // Laravel application initialize
        $this->loadMigrationsFrom(__DIR__ . '/database/migrations');
        $this->withFactories(__DIR__ . '/database/factories');

        // Testing data generate
        factory(User::class, 10)->create();
        factory(Spu::class, 10)->create();
        factory(Order::class, 10)->create();
    }

    /**
     * 销毁基境
     */
    protected function tearDown(): void
    {
        TypeRegistry::destroy();
        DirectiveRegistry::destroy();
        parent::tearDown();
    }

    /**
     * 冒烟用例
     */
    public function testSmoke()
    {
        $this->assertEquals(1, User::query()->findOrFail(1)->getKey());
        $this->assertEquals(1, Spu::query()->findOrFail(1)->getKey());
        $this->assertEquals(1, Sku::query()->findOrFail(1)->getKey());
        $this->assertEquals(1, Order::query()->findOrFail(1)->getKey());
    }

    /**
     * 简单查询用例
     */
    public function testSimpleRequest()
    {
        $queryString    = <<<'GQL'
{
hello
}
GQL;
        $response       = $this->postJson('/graphql', [
            'operationName' => '',
            'query'         => $queryString,
            'variables'     => null,
        ]);
        $response->assertStatus(200)
            ->assertSee('Hello World');
    }

    /**
     * 数据查询测试用例
     */
    public function testDataQuery()
    {
        $queryString    = <<<'GQL'
query findOrder ($first:ID!,$second:ID!) {
hello
first:order(id:$first){
  id
  sn
}
second:order(id:$second){
  id
  sn
}
}
GQL;
        $response       = $this->postJson('/graphql', [
            'operationName' => '',
            'query'         => $queryString,
            'variables'     => ['first' => '1', 'second' => '2',],
        ]);
        $response->dump();
        $response->assertStatus(200)
            ->assertSee('"id":"1"')
            ->assertSee('"id":"2"');
    }
}
