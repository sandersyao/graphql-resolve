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
        $listId     = collect($keys)->pluck(0)->toArray();
        $fields     = array_keys(collect($keys)->pluck(1)->reduce(function ($a, $b) {
            return array_merge($a, $b);
        }, []));
        $mapOrder   = Order::query()
            ->select(['id'])
            ->selectTransform([
                'id'        => 'id',
                'sn'        => 'order_sn',
                'user'      => 'user_id',
            ], $fields)
            ->whereIn('id', $listId)
            ->get()
            ->keyBy('id');

        $result = collect($listId)->map(function ($id) use ($mapOrder) {

            $order  = $mapOrder->get($id, null);

            return  null === $order ? null  : (new OrderResource($order))->toArray(request());
        });

        return  $this->promise()->createAll($result);
    }
}
