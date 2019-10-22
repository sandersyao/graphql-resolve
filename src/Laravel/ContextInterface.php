<?php


namespace GraphQLResolve\Laravel;


use GraphQL\Type\Schema;
use Illuminate\Http\Request;

/**
 * Interface ContextInterface
 * @package GraphQLResolve\Laravel
 */
interface ContextInterface
{
    /**
     * @param Request $request
     * @param Schema $schema
     * @return array
     */
    public function getRoot(Request $request, Schema $schema) : array;

    /**
     * @param Request $request
     * @param Schema $schema
     * @return mixed
     */
    public function getContext(Request $request, Schema $schema);
}
