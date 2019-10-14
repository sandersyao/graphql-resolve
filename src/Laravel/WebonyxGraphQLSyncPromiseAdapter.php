<?php


namespace GraphQLResolve\Laravel;

use Illuminate\Support\Collection;
use Overblog\PromiseAdapter\Adapter\WebonyxGraphQLSyncPromiseAdapter as PromiseAdapter;

class WebonyxGraphQLSyncPromiseAdapter extends PromiseAdapter
{
    /**
     * 适配集合传值
     *
     * @param mixed $promisesOrValues
     * @return \GraphQL\Executor\Promise\Promise|mixed
     */
    public function createAll($promisesOrValues)
    {
        if ($promisesOrValues instanceof Collection) {

            $promisesOrValues   = $promisesOrValues->toArray();
        }

        return parent::createAll($promisesOrValues);
    }
}
