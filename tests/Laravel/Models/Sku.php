<?php

namespace GraphQLResolve\Tests\Laravel\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Sku extends Model
{
    use SoftDeletes;

    /**
     * 是否上架
     */
    const IS_ONLINE     = 1;    // 上架
    const NOT_ONLINE    = 0;    // 下架

    /**
     * 不可以被批量赋值的属性
     *
     * @var array
     */
    protected $guarded  = ['id'];
}
