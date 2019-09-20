<?php


namespace GraphQLResolve;


use GraphQLResolve\Traits\Singleton;

abstract class AbstractRegistry
{
    use Singleton;

    /**
     * @var array
     */
    protected $map  = [];

    /**
     * 获取key
     *
     * @param $object
     * @return string
     */
    abstract protected function getKey($object): string;

    /**
     * 新增类型
     *
     * @param $object
     * @return AbstractRegistry
     */
    public function add($object)
    {
        $key    = $this->getKey($object);

        if (isset($this->map[$key])) {

            throw new \UnexpectedValueException(
                'Object by key ' . $key . ' already exists by class ' . get_class($this->map[$key]) .
                ' can not registry class ' . get_class($object) . ' as same key.'
            );
        }

        $this->map[$key]    = $object;

        return  $this;
    }

    /**
     * 析出实例
     *
     * @param $key
     * @return mixed
     */
    public function resolve($key)
    {
        if (!isset($this->map[$key])) {

            throw new \UnexpectedValueException('Key ' . $key . ' not registry');
        }

        return  $this->map[$key];
    }

    /**
     * 加载
     *
     * @param array $listClass
     */
    static public function load(array $listClass)
    {
        array_map(function ($class) {
            self::getInstance()->add(new $class);
        }, $listClass);
    }

    /**
     * 获取
     *
     * @param $name
     * @return mixed
     */
    static public function get($name)
    {
        return  self::getInstance()->resolve($name);
    }
}
