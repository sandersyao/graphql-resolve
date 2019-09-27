<?php


namespace GraphQLResolve\Tests;


use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use GraphQLResolve\AbstractResolveField;
use GraphQLResolve\LoaderRegistry;

class FriendsQuery extends AbstractResolveField
{
    public function __construct(array $config)
    {
        $config = array_merge($config, [
            'name'          => 'friends',
            'type'          => Type::listOf($config['user']),
            'description'   => '好友列表',
        ]);
        parent::__construct($config);
    }

    public function invoke($parent, array $args, $context, ResolveInfo $resolveInfo)
    {
        return  LoaderRegistry::get(UserLoader::class)->loadMany(DataLoaderQuery::DATA_FRIENDS[$parent['id']]);
    }
}
