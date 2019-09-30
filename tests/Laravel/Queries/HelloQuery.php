<?php


namespace GraphQLResolve\Tests\Laravel\Queries;


use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use GraphQLResolve\AbstractResolveField;

class HelloQuery extends AbstractResolveField
{
    public function __construct(array $config = [])
    {
        $config = array_merge($config, [
            'name'          => 'hello',
            'type'          => Type::string(),
            'description'   => '简单查询测试',
        ]);
        parent::__construct($config);
    }

    public function invoke($parent, array $args, $context, ResolveInfo $resolveInfo)
    {
        return  'Hello World';
    }
}
