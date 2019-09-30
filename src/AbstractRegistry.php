<?php


namespace GraphQLResolve;


use GraphQLResolve\Traits\Singleton;

/**
 * Class AbstractRegistry
 * @package GraphQLResolve
 */
abstract class AbstractRegistry
{
    use Singleton;

    /**
     * @var array 注册数据
     */
    protected $map  = [];

    /**
     * 获取键
     *
     * @param mixed $object 对象
     * @return string 键
     * @api
     */
    abstract protected function getKey($object): string;

    /**
     * 新增对象
     *
     * @param mixed $object 对象
     * @return AbstractRegistry 自身对象
     * @api
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
     * @param string $key 键
     * @return mixed 对象
     * @api
     */
    public function resolve(string $key)
    {
        if (!isset($this->map[$key])) {

            throw new \UnexpectedValueException('Key ' . $key . ' not registry');
        }

        return  $this->map[$key];
    }

    /**
     * 实例化并加载
     *
     * @param array[string] $listClass 类型列表
     * @return mixed 自身对象
     * @api
     */
    static public function load(array $listClass)
    {
        array_map(function ($class) {
            self::getInstance()->add(new $class);
        }, $listClass);

        return  self::getInstance();
    }

    /**
     * 根据键获取对象
     *
     * @param string $key 键
     * @return mixed 对象
     * @api
     */
    static public function get($key)
    {
        return  self::getInstance()->resolve($key);
    }

    /**
     * 判断是否存在键
     *
     * @param string $key 键
     * @return bool 判断结果
     * @api
     */
    public static function has(string $key): bool
    {
        try {

            self::getInstance()->resolve($key);

        } catch (\UnexpectedValueException $e) {

            return  false;
        }

        return true;
    }

}
