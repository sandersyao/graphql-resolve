<?php


namespace GraphQLResolve\Tests\Laravel\DataLoader;


use GraphQL\Executor\Promise\Promise;
use GraphQLResolve\Laravel\AbstractDataLoader;
use GraphQLResolve\Tests\Laravel\Models\Order;
use GraphQLResolve\Tests\Laravel\Resources\Order as OrderResource;
use function foo\func;

class OrderDataLoader extends AbstractDataLoader
{
    /**
     * 测试：调用次数
     *
     * @var int 调用次数
     */
    public static $countCall    = 0;

    /**
     * 获取数据
     *
     * @param array $query 查询
     * @return Promise|mixed 结果
     */
    public function resolve($query)
    {
        return  Order::query()
            ->select(['id'])
            ->selectTransform([
                'sn'        => 'order_sn',
                'user'      => 'user_id',
            ], $query['fields'])
            ->whereIn('id', $query['keys'])
            ->get()
            ->keyBy('id')
            ->map(function ($order) {
                return  (new OrderResource($order))->toArray(request());
            });
    }
}
