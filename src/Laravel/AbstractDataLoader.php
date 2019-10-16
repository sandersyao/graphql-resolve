<?php


namespace GraphQLResolve\Laravel;


use Illuminate\Support\Collection;
use Overblog\DataLoader\Option;
use GraphQLResolve\AbstractDataLoader as Loader;

abstract class AbstractDataLoader extends Loader
{
    public function invoke($keys)
    {
        $groupByFields  = collect($keys)->groupBy(function ($item) {
            return  serialize($item[1]);
        });
        $mapData        = [];
        foreach ($groupByFields as $fieldKey => $listKeys) {

            $collectionKeys     = collect($listKeys);
            $mapData[$fieldKey] = parent::invoke([
                'keys'      => $collectionKeys->pluck(0)->toArray(),
                'fields'    => array_keys($collectionKeys->pluck(1)->reduce(function ($a, $b) {
                    return  array_merge($a, $b);
                }, [])),
            ]);
        }
        $result = collect($keys)->map(function ($key) use ($mapData) {

            list($id, $fields)  = $key;
            $keyFields          = serialize($fields);

            return  $mapData[$keyFields] instanceof Collection    ? $mapData[$keyFields]->get($id, null)  : null;
        });

        return  $this->promise()->createAll($result);
    }

    /**
     * AbstractDataLoader constructor.
     *
     * @param Option|null $options 配置信息
     */
    public function __construct(Option $options = null)
    {
        parent::__construct($options);
    }
}
