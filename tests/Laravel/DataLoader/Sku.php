<?php


namespace GraphQLResolve\Tests\Laravel\DataLoader;


use GraphQLResolve\Laravel\AbstractDataLoader;
use GraphQLResolve\Tests\Laravel\Models\Sku as SkuModel;
use GraphQLResolve\Tests\Laravel\Resources\Sku as SkuResource;

class Sku extends AbstractDataLoader
{
    public function resolve($query)
    {
        return  SkuModel::query()
            ->select(['id'])
            ->selectTransform([
                'sn'                    => 'sn',
                'name'                  => 'name',
                'inventoryCount'        => 'inventory_count',
                'inventoryCountLock'    => 'inventory_count_lock',
                'isOnline'              => 'is_online',
                'sort'                  => 'sort',
                'description'           => 'description',
                'tagPrice'              => 'tag_price',
            ], $query['fields'])
            ->whereIn('id', $query['keys'])
            ->get()
            ->keyBy('id')
            ->map(function ($sku) {
                return  (new SkuResource($sku))->toArray(request());
            });
    }
}
