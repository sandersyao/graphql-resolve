<?php


namespace GraphQLResolve\Laravel;

use GraphQL\Type\Schema;
use GraphQL\Type\SchemaConfig;
use GraphQLResolve\DirectiveRegistry;
use GraphQLResolve\LoaderRegistry;
use GraphQLResolve\TypeRegistry;
use Illuminate\Support\ServiceProvider;

class GraphQLResolveServiceProvider extends ServiceProvider
{

    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../config/config.php' => $this->app->make('path.config') . DIRECTORY_SEPARATOR .
                'graphqlresolve.php',
        ], 'config');
    }

    public function register()
    {
        $this->app->singleton(Schema::class, function () {

            TypeRegistry::load(config('graphql.types'));
            DirectiveRegistry::load(config('graphql.directives'));
            LoaderRegistry::load(config('graphql.loaders'));
            $config = SchemaConfig::create();

            if (TypeRegistry::has('Query')) {

                $config->setQuery(TypeRegistry::get('Query'));
            }

            if (TypeRegistry::has('Mutation')) {

                $config->setQuery(TypeRegistry::get('Mutation'));
            }

            if (TypeRegistry::has('Subscription')) {

                $config->setQuery(TypeRegistry::get('Subscription'));
            }

            $config->setDirectives(DirectiveRegistry::getAll())
                ->setTypeLoader([TypeRegistry::class, 'get']);
            $schema = new Schema($config);
            $schema->assertValid();

            return  $schema;
        });
    }
}
