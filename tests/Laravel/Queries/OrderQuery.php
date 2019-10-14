<?php


namespace GraphQLResolve\Tests\Laravel\Queries;


use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use GraphQLResolve\AbstractResolveField;
use GraphQLResolve\LoaderRegistry;
use GraphQLResolve\Tests\Laravel\DataLoader\OrderDataLoader;
use GraphQLResolve\TypeRegistry;

/**
 * Class OrderQuery
 * @package GraphQLResolve\Tests\Laravel\Queries
 */
class OrderQuery extends AbstractResolveField
{
    /**
     * OrderQuery constructor.
     * @param array $config
     */
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

    /**
     * @param mixed $parent
     * @param array $args
     * @param mixed $context
     * @param ResolveInfo $resolveInfo
     * @return mixed
     */
    public function invoke($parent, array $args, $context, ResolveInfo $resolveInfo)
    {
        $orderId    = $args['id'];
        $result     = LoaderRegistry::get(OrderDataLoader::class)
            ->load([$orderId, $resolveInfo->getFieldSelection()]);

        return $result;
    }
}
