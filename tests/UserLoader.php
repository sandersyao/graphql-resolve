<?php


namespace GraphQLResolve\Tests;


use GraphQLResolve\AbstractDataLoader;

class UserLoader extends AbstractDataLoader
{
    public function resolve($keys)
    {
        $map    = DataLoaderQuery::DATA_USER;
        return  $this->promise()->createAll(array_map(function ($id) use ($map) {
            return  isset($map[$id])    ? $map[$id] : null;
        }, $keys));
    }
}
