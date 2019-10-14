<?php


namespace GraphQLResolve\Tests\Laravel\DataLoader;


use GraphQLResolve\AbstractDataLoader;
use GraphQLResolve\Tests\Laravel\Models\User as UserModel;
use GraphQLResolve\Tests\Laravel\Resources\User as UserResource;

class User extends AbstractDataLoader
{
    public function resolve($keys)
    {
        $listId     = collect($keys)->pluck(0)->toArray();
        $fields     = array_keys(collect($keys)->pluck(1)->reduce(function ($a, $b) {
            return array_merge($a, $b);
        }, []));
        $mapUser    = UserModel::query()
            ->select(['id'])
            ->selectTransform([
                'name'  => 'name',
            ], $fields)
            ->whereIn('id', $listId)
            ->get()
            ->keyBy('id');

        $result = collect($listId)->map(function ($id) use ($mapUser) {

            $user   = $mapUser->get($id, null);

            return  null === $user ? null  : (new UserResource($user))->toArray(request());
        });

        return  $this->promise()->createAll($result);
    }
}
