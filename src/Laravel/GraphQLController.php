<?php


namespace GraphQLResolve\Laravel;


use GraphQL\GraphQL;
use GraphQL\Type\Schema;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

/**
 * Class GraphQLController
 *
 * @package GraphQLResolve\Laravel
 */
class GraphQLController extends Controller
{
    /**
     * 解析
     *
     * @param Request $request 请求
     * @param Schema $schema Schema
     * @param ContextInterface $context 上下文
     * @return mixed[] 响应结果
     */
    public function resolve(Request $request, Schema $schema, ContextInterface $context)
    {
        $operationName  = $request->input('operationName');
        $queryString    = $request->input('query');
        $variables      = $request->input('variables');
        $promise        = GraphQL::promiseToExecute(
            AbstractDataLoader::promiseDefault(),
            $schema,
            $queryString,
            $context->getRoot($request, $schema),
            $context->getContext($request, $schema),
            $variables,
            $operationName
        );
        $result         = AbstractDataLoader::promiseDefault()->wait($promise);
        $debug          = config('graphql.debug', true);

        return          $result->toArray($debug);
    }
}
