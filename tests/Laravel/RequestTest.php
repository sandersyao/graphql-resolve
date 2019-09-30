<?php


namespace GraphQLResolve\Tests\Laravel;


use GraphQLResolve\Tests\Laravel\Models\Order;
use GraphQLResolve\Tests\Laravel\Models\Sku;
use GraphQLResolve\Tests\Laravel\Models\Spu;
use GraphQLResolve\Tests\Laravel\Models\User;
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
    }

    /**
     * 构建基境
     */
    protected function setUp(): void
    {
        parent::setUp();
        $this->loadMigrationsFrom(__DIR__ . '/database/migrations');
        $this->withFactories(__DIR__ . '/database/factories');
        factory(User::class, 10)->create();
        factory(Spu::class, 10)->create();
        factory(Order::class, 10)->create();
    }

    /**
     * 销毁基境
     */
    protected function tearDown(): void
    {
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
}
