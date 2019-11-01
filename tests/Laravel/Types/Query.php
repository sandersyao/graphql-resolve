<?php


namespace GraphQLResolve\Tests\Laravel\Types;


use GraphQLResolve\AbstractObjectType;
use GraphQLResolve\Tests\Laravel\Queries\HelloQuery;
use GraphQLResolve\Tests\Laravel\Queries\OrderQuery;
use GraphQLResolve\Tests\Laravel\Queries\SpuSnQuery;

class Query extends AbstractObjectType
{
    public function fields()
    {
        return  [
            new HelloQuery(),
            new OrderQuery(),
            new SpuSnQuery(),
        ];
    }

    public function __construct(array $config = [])
    {
        parent::__construct($config);
    }
}
