<?php

namespace GraphQLResolve\Tests\Laravel\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tag extends Model
{
    use SoftDeletes;

    protected $guarded  = ['id'];

    /**
     * 多态多对多 SPU
     *
     * @return MorphToMany
     */
    public function spus()
    {
        return  $this->morphedByMany(Spu::class, 'taggable');
    }
}
