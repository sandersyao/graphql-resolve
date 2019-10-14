<?php


namespace GraphQLResolve\Tests\Laravel\DataLoader;


use GraphQLResolve\AbstractDataLoader;
use GraphQLResolve\Tests\Laravel\Models\Order;
use GraphQLResolve\Tests\Laravel\Resources\Order as OrderResource;

class OrderDataLoader extends AbstractDataLoader
{
    /**
     * 测试：调用次数
     *
     * @var int 调用次数
     */
    public static $countCall    = 0;

    public function resolve($keys)
    {
        self::$countCall ++;
        $mapOrder   = Order::query()
            ->select(['id'])
            ->selectTransform([
                'id'    => 'id',
                'sn'    => 'order_sn',
            ], $this->getResolveInfo())
            ->whereIn('id', $keys)
            ->get()
            ->keyBy('id');

        $result = collect($keys)->map(function ($id) use ($mapOrder) {

            $order  = $mapOrder->get($id, null);

            return  null === $order ? null  : (new OrderResource($order))->toArray(request());
        });
        $promise    = $this->promise()->createAll($result); //@todo 这里有鬼

        return  $promise;
    }
}
