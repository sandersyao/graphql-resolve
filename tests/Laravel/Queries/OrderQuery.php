<?php


namespace GraphQLResolve\Tests\Laravel\Queries;


use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use GraphQLResolve\AbstractResolveField;
use GraphQLResolve\LoaderRegistry;
use GraphQLResolve\Tests\Laravel\DataLoader\OrderDataLoader;
use GraphQLResolve\TypeRegistry;

class OrderQuery extends AbstractResolveField
{
    public function __construct(array $config = [])
    {
        $config = array_merge($config, [
            'name'          => 'order',
            'type'          => TypeRegistry::get('Order'),
            'args'          => [
                'id'    => [
                    'type'          => Type::nonNull(Type::id()),
                    'description'   => '订单ID',
                ],
            ],
            'description'   => '订单数据查询测试',
        ]);
        parent::__construct($config);
    }

    public function invoke($parent, array $args, $context, ResolveInfo $resolveInfo)
    {
        $result = LoaderRegistry::get(OrderDataLoader::class)
            ->setResolveInfo($resolveInfo)
            ->load($args['id']);

        return $result;
    }
}
