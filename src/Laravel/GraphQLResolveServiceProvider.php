<?php


namespace GraphQLResolve\Laravel;

class GraphQLResolveServiceProvider extends \Illuminate\Support\ServiceProvider
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
        parent::register();
    }
}
