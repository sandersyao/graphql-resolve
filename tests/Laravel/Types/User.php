<?php


namespace GraphQLResolve\Tests\Laravel\Types;


use GraphQL\Type\Definition\Type;
use GraphQLResolve\AbstractObjectType;
use GraphQLResolve\SimpleField;

class User extends AbstractObjectType
{
    public function fields()
    {
        return  [
            new SimpleField([
                'name'          => 'id',
                'type'          => Type::id(),
                'description'   => '用户ID',
            ]),
            new SimpleField([
                'name'          => 'name',
                'type'          => Type::string(),
                'description'   => '用户名',
            ]),
        ];
    }
}
