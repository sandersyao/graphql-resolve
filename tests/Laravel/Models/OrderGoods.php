<?php

namespace GraphQLResolve\Tests\Laravel\Models;

use GraphQLResolve\Laravel\SelectTransform;
use Illuminate\Database\Eloquent\Model;

class OrderGoods extends Model
{
    use SelectTransform;

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
