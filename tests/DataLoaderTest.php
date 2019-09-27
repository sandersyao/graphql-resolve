<?php


namespace GraphQLResolve\Tests;


use GraphQL\Error\Debug;
use GraphQL\GraphQL;
use GraphQL\Type\Schema;
use GraphQL\Type\SchemaConfig;
use GraphQLResolve\AbstractDataLoader;
use GraphQLResolve\DirectiveRegistry;
use GraphQLResolve\LoaderRegistry;
use GraphQLResolve\TypeRegistry;
use PHPUnit\Framework\TestCase;

/**
 * Class DataLoaderTest
 * @package GraphQLResolve\Tests
 */
class DataLoaderTest extends TestCase
{
    private $schema;

    /**
     * 建立基境
     */
    public function setUp()
    {
        parent::setUp();
        TypeRegistry::load([

            // Output Object Types
            User::class,

            // Root Types
            DataLoaderQuery::class,
        ]);
        DirectiveRegistry::load([
            UpperCase::class,
            Substr::class,
        ]);
        LoaderRegistry::load([
            UserLoader::class,
        ]);
        $config = SchemaConfig::create()
            ->setQuery(TypeRegistry::get('Query'))
            ->setDirectives(DirectiveRegistry::getAll())
            ->setTypeLoader(function ($name) {
                return TypeRegistry::get($name);
            });
        $this->schema           = new Schema($config);
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
me{
id
name
friends{
id
name
friends{
  id
  name
}
}
}
}';
        $promise    = GraphQL::promiseToExecute(
            AbstractDataLoader::promiseDefault(),
            $this->schema,
            $queryString
        );
        $result = AbstractDataLoader::promiseDefault()->wait($promise);
        $data   = $result->toArray(Debug::INCLUDE_TRACE|Debug::INCLUDE_DEBUG_MESSAGE);
        $this->assertEquals(DataLoaderQuery::DATA_USER[Me::ID]['id'], $data['data']['me']['id']);
        $this->assertEquals(2, UserLoader::$countCall);
    }
}
