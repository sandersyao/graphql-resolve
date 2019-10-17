<?php


namespace GraphQLResolve\Tests\Laravel\DataLoader;


use GraphQLResolve\Laravel\AbstractDataLoader;
use GraphQLResolve\Tests\Laravel\Models\User as UserModel;
use GraphQLResolve\Tests\Laravel\Resources\User as UserResource;

class User extends AbstractDataLoader
{
    /**
     * 查询解析
     *
     * @param iterable $query 查询
     * @return mixed 结果
     */
    public function resolve($query)
    {
        return  UserModel::query()
            ->select(['id'])
            ->selectTransform([
                'name'  => 'name',
            ], $query['fields'])
            ->whereIn('id', $query['keys'])
            ->get()
            ->keyBy('id')
            ->map(function ($user) {
                return  (new UserResource($user))->toArray(request());
            });
    }
}
