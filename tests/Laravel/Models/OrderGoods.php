<?php

namespace GraphQLResolve\Tests\Laravel\Models;

use Illuminate\Database\Eloquent\Model;

class OrderGoods extends Model
{
    protected $guarded  = ['id'];

    public function sku()
    {
        return  $this->belongsTo(Sku::class);
    }

    public function setSnapShootAttribute($key, $value)
    {
    }

    public function getSnapShootAttribute()
    {
    }
}
