<?php


namespace GraphQLResolve\Laravel;

use GraphQL\Executor\Promise\Promise;
use Illuminate\Support\Collection;
use Overblog\PromiseAdapter\Adapter\WebonyxGraphQLSyncPromiseAdapter as PromiseAdapter;

/**
 * Class WebonyxGraphQLSyncPromiseAdapter
 * @package GraphQLResolve\Laravel
 */
class WebonyxGraphQLSyncPromiseAdapter extends PromiseAdapter
{
    /**
     * 适配集合传值
     *
     * @param mixed $promisesOrValues
     * @return Promise|mixed
     */
    public function createAll($promisesOrValues)
    {
        if ($promisesOrValues instanceof Collection) {

            $promisesOrValues   = $promisesOrValues->toArray();
        }

        return parent::createAll($promisesOrValues);
    }
}
