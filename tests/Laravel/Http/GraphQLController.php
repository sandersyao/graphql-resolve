<?php


namespace GraphQLResolve\Tests\Laravel\Http;


use GraphQL\GraphQL;
use GraphQL\Type\Schema;
use GraphQLResolve\AbstractDataLoader;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class GraphQLController extends Controller
{
    public function resolve(Request $request, Schema $schema)
    {
        $operationName  = $request->input('operationName');
        $queryString    = $request->input('query');
        $variables      = $request->input('variables');
        $promise        = GraphQL::promiseToExecute(
            AbstractDataLoader::promiseDefault(),
            $schema,
            $queryString,
            $variables,
            $operationName
        );
        $result         = AbstractDataLoader::promiseDefault()->wait($promise);
        $debug          = config('graphql.debug', true);

        return          $result->toArray($debug);
    }
}
