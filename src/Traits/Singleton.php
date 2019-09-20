<?php


namespace GraphQLResolve\Traits;

/**
 * Trait Singleton
 * @package GraphQLResolve\Traits
 */
trait Singleton
{
    /**
     * @var mixed 实例图
     */
    static protected $mapInstance   = [];

    /**
     * 获取实例
     *
     * @param mixed ...$args 构造函数参数
     * @return mixed 实例
     */
    static public function getInstance(...$args)
    {
        $className  = get_called_class();

        if (!isset(self::$mapInstance[$className])) {

            self::$mapInstance[$className]    = new $className(...$args);
        }

        return  self::$mapInstance[$className];
    }

    /**
     * 销毁实例
     */
    static public function destroy()
    {
        unset(self::$mapInstance[get_called_class()]);
    }

    /**
     * Singleton constructor.
     * @param mixed ...$args
     */
    private function __construct(...$args)
    {
    }

    /**
     * 禁用序列化
     */
    private function __sleep()
    {
    }

    /**
     * 禁用克隆
     */
    private function __clone()
    {
    }
}
