<?php


namespace GraphQLResolve\Tests\Laravel\Resources;


use Illuminate\Http\Resources\Json\Resource;

class Sku extends Resource
{
    public function toArray($request)
    {
        return  [
            'id'                    => $this->id,
            'sn'                    => $this->sn,
            'name'                  => $this->name,
            'inventoryCount'        => $this->inventory_count,
            'inventoryCountLock'    => $this->inventory_count_lock,
            'isOnline'              => $this->is_online,
            'sort'                  => $this->sort,
            'description'           => $this->description,
            'tagPrice'              => $this->tag_price,
        ];
    }
}
