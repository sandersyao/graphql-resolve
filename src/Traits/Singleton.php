<?php
namespace GraphQLResolve\Traits;

use \Exception;
use \LogicException;

/**
 * 单例
 */
trait Singleton
{
    /**
     * 获取实例
     *
     * @return mixed
     * @throws Exception
     */
    public static function getInstance(...$args)
    {
        static $mapInstance = [];
        $className  = get_called_class();

        if (!isset($mapInstance[$className])) {

            $mapInstance[$className]    = new $className(...$args);
        }

        return  $mapInstance[$className];
    }

    /**
     * 禁用外部创建实例
     */
    protected function __construct()
    {
        //禁止外部创建实例
    }

    /**
     * 禁止序列化
     *
     * @throws LogicException
     */
    final public function __sleep()
    {
        throw new LogicException('cannot serialize object from Singleton instance (class: ' . get_called_class() . ').');
    }

    /**
     * 禁止通过反序列化创建实例
     *
     * @throws LogicException
     */
    final public function __wakeup()
    {
        throw new LogicException('cannot unserialize object from Singleton instance (class: ' . get_called_class() . ').');
    }

    /**
     * 禁止克隆实例
     *
     * @throws LogicException
     */
    final public function __clone()
    {
        throw new LogicException('cannot clone object from Singleton instance (class: ' . get_called_class() . ')');
    }
}
