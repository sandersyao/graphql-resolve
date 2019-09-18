<?php


namespace GraphQLResolve\Traits;


trait Singleton
{
    /**
     * @var
     */
    static private $instance;

    /**
     * 获取实例
     *
     * @param mixed ...$args
     * @return mixed
     */
    static public function getInstance(...$args)
    {
        if (empty(static::$instance) || get_called_class() != get_class(static::$instance)) {

            static::$instance   = new static(...$args);
        }

        return  static::$instance;
    }

    /**
     * 删除
     */
    static public function destroy()
    {
        static::$instance   = null;
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
