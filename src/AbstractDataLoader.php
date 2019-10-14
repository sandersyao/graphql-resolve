<?php


namespace GraphQLResolve;


use GraphQL\Type\Definition\ResolveInfo;
use Overblog\DataLoader\DataLoader;
use Overblog\DataLoader\Option;
use Overblog\DataLoader\Promise\Adapter\Webonyx\GraphQL\SyncPromiseAdapter;
use GraphQLResolve\Laravel\WebonyxGraphQLSyncPromiseAdapter;

/**
 * Class AbstractDataLoader
 *
 * @package GraphQLResolve
 */
abstract class AbstractDataLoader extends DataLoader
{
    /**
     * 当前解析信息
     *
     * @var ResolveInfo 解析信息
     */
    protected $resolveInfo;

    /**
     * DataLoader Promise实例
     *
     * @var SyncPromiseAdapter Promise 实例
     */
    protected static $promise;

    /**
     * DataLoader Promise适配器
     *
     * @var WebonyxGraphQLSyncPromiseAdapter Promise适配器实例
     */
    protected static $promiseAdapter;

    /**
     * 解析
     *
     * @param iterable $keys 键列表
     * @return mixed 值列表
     */
    abstract public function resolve($keys);

    /**
     * AbstractDataLoader constructor.
     *
     * @param Option|null $options 配置信息
     */
    public function __construct(Option $options = null)
    {
        parent::__construct([$this, 'resolve'], $this->promise(), $options);
    }

    /**
     * 获取Promise实例
     *
     * @return SyncPromiseAdapter Promise实例
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
     * @return WebonyxGraphQLSyncPromiseAdapter Promise适配器
     */
    public static function promise()
    {
        if (self::$promiseAdapter) {

            return  self::$promiseAdapter;
        }

        return  self::$promiseAdapter   = new WebonyxGraphQLSyncPromiseAdapter(self::promiseDefault());
    }
}
