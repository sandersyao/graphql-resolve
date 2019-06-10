<?php


namespace GraphQLResolve\Tests\Sim;


use GraphQLResolve\AbstractObjectType;

class Mutation extends AbstractObjectType
{
    public function fields()
    {
        return function () {

            return [
                CreateOrder::fetchOptions(),
            ];
        };
    }
}