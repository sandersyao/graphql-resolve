<?php


namespace GraphQLResolve\Tests\Laravel\Resources;


use Illuminate\Http\Resources\Json\Resource;

class Order extends Resource
{
    public function toArray($request)
    {
        return  [
            'id'    => $this->id,
            'sn'    => $this->order_sn,
        ];
    }
}
