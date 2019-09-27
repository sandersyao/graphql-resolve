<?php


namespace GraphQLResolve\Tests;


use GraphQL\Type\Definition\ResolveInfo;
use GraphQLResolve\AbstractResolveField;
use GraphQLResolve\LoaderRegistry;
use GraphQLResolve\TypeRegistry;

class Me extends AbstractResolveField
{
    const ID    = 1;

    public function __construct(array $config = [])
    {
        $config = array_merge($config, [
            'name'          => 'me',
            'type'          => TypeRegistry::get('User'),
            'description'   => '我',
        ]);
        parent::__construct($config);
    }

    public function invoke($parent, array $args, $context, ResolveInfo $resolveInfo)
    {
        return  LoaderRegistry::get(UserLoader::class)->load(self::ID);
    }
}
