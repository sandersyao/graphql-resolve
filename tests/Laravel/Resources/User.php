<?php


namespace GraphQLResolve\Tests\Laravel\Resources;


use Illuminate\Http\Resources\Json\Resource;

class User extends Resource
{
    public function toArray($args)
    {
        return  [
            'id'    => $this->id,
            'name'  => $this->name,
        ];
    }
}
