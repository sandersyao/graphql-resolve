<?php


namespace GraphQLResolve\Tests\Laravel\DataLoader;


use GraphQLResolve\Laravel\AbstractDataLoader;
use GraphQLResolve\Tests\Laravel\Models\User as UserModel;

class User extends AbstractDataLoader
{
    public function resolve($query)
    {
        return  UserModel::query()
            ->select(['id'])
            ->selectTransform([
                'name'  => 'name',
            ], $query['fields'])
            ->whereIn('id', $query['keys'])
            ->get()
            ->keyBy('id');
    }
}
