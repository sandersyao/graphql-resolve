<?php

namespace GraphQLResolve\Tests\Laravel\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Spu extends Model
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

    /**
     * SKU 列表
     *
     * @return HasMany
     */
    public function skus()
    {
        return  $this->hasMany(Sku::class);
    }

    /**
     * 标签列表
     *
     * @return MorphToMany
     */
    public function tags()
    {
        return  $this->morphToMany(Tag::class, 'taggable')
            ->orderByDesc('pivot_tag_id');
    }
}
