<?php

namespace GraphQLResolve\Tests\Laravel\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TagGroup extends Model
{
    use SoftDeletes;

    protected $guarded  = ['id'];
}
