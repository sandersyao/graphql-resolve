<?php


namespace GraphQLResolve;


use Overblog\DataLoader\DataLoader;
use Overblog\DataLoader\Option;
use Overblog\DataLoader\Promise\Adapter\Webonyx\GraphQL\SyncPromiseAdapter;
use Overblog\PromiseAdapter\Adapter\WebonyxGraphQLSyncPromiseAdapter;

/**
 * Class AbstractDataLoader
 *
 * @package GraphQLResolve
 */
abstract class AbstractDataLoader extends DataLoader
{
    /**
     * DataLoader Promise实例
     *
     * @var SyncPromiseAdapter
     */
    protected static $promise;

    /**
     * DataLoader Promise适配器
     *
     * @var WebonyxGraphQLSyncPromiseAdapter
     */
    protected static $promiseAdapter;

    /**
     * 解析
     *
     * @param $keys
     * @return mixed
     */
    abstract public function resolve($keys);

    /**
     * AbstractDataLoader constructor.
     *
     * @param Option|null $options
     */
    public function __construct(Option $options = null)
    {
        parent::__construct([$this, 'resolve'], $this->promise(), $options);
    }

    /**
     * 获取Promise实例
     *
     * @return SyncPromiseAdapter
     */
    public static function promiseDefault()
    {
        if (self::$promise) {

            return  self::$promise;
        }

        return  self::$promise  = new SyncPromiseAdapter();
    }

    /**
     * 获取Promise适配器
     *
     * @return WebonyxGraphQLSyncPromiseAdapter
     */
    public static function promise()
    {
        if (self::$promiseAdapter) {

            return  self::$promiseAdapter;
        }

        return  self::$promiseAdapter   = new WebonyxGraphQLSyncPromiseAdapter(self::promiseDefault());
    }
}
