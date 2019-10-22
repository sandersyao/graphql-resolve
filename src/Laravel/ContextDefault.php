<?php


namespace GraphQLResolve\Laravel;


use GraphQL\Type\Schema;
use Illuminate\Http\Request;

class ContextDefault implements ContextInterface
{
    public function getRoot(Request $request, Schema $schema) : array
    {
        return  [];
    }

    public function getContext(Request $request, Schema $schema)
    {
        return  null;
    }
}
