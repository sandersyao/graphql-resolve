<?php


namespace GraphQLResolve\Tests\Laravel\Types;


use GraphQLResolve\AbstractObjectType;
use GraphQLResolve\Tests\Laravel\Queries\HelloQuery;

class Query extends AbstractObjectType
{
    public function fields()
    {
        return  [
            new HelloQuery(),
        ];
    }

    public function __construct(array $config = [])
    {
        parent::__construct($config);
    }
}
