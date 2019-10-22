<?php


namespace GraphQLResolve\Tests\Laravel\Resources;


use Illuminate\Http\Resources\Json\Resource;

class OrderGoods extends Resource
{
    public function toArray($request)
    {
        return  [
            'sku_id'            => $this->sku_id,
            'sku'               => $this->sku,
            'quantity'          => $this->quantity,
            'tagPrice'          => $this->tag_price,
            'tagAmount'         => $this->tag_amount,
            'shouldPayAmount'   => $this->should_pay_amount,
            'realPayAmount'     => $this->real_pay_amount,
        ];
    }
}
