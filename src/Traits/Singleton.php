<?php


namespace GraphQLResolve\Traits;


trait Singleton
{
    /**
     * @var
     */
    static protected $mapInstance   = [];

    /**
     * 获取实例
     *
     * @param mixed ...$args
     * @return mixed
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
     * 删除
     */
    static public function destroy()
    {
        self::$mapInstance[get_called_class()]  = null;
    }

    private function __construct(...$args)
    {
    }

    private function __sleep()
    {
    }

    private function __clone()
    {
    }
}
