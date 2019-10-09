<?php


namespace GraphQLResolve\Tests\Laravel\Queries;


use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use GraphQLResolve\AbstractResolveField;
use GraphQLResolve\Tests\Laravel\Models\Order;
use GraphQLResolve\TypeRegistry;
use GraphQLResolve\Tests\Laravel\Resources\Order as OrderResource;
use Illuminate\Support\Facades\Log;

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
        $order  = Order::query()->selectTransform([
            'id'    => 'id',
            'sn'    => 'order_sn',
        ], $resolveInfo)->findOrFail($args['id']);

        return  (new OrderResource($order))->toArray($args);
    }
}
