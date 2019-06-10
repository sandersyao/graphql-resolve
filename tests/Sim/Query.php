<?php


namespace GraphQLResolve\Tests\Sim;

use GraphQLResolve\AbstractObjectType;

class Query extends AbstractObjectType
{
    public function fields()
    {
        return function () {

            return [
                Orders::fetchOptions(),
            ];
        };
    }
}