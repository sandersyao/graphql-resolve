<?php


namespace GraphQLResolve\Tools;


use GraphQLResolve\Traits\Singleton;

/**
 * 类型图抽象类
 *
 * Class ClassMap
 * @package GraphQLResolve\Tools
 */
abstract class ClassMap
{
    use Singleton;

    /**
     * @var
     */
    protected $map;

    /**
     * 设置数据
     *
     * @param string $name
     * @param string $value
     */
    public function setMap(string $name, string $value)
    {
        $class = get_called_class();

        if (!isset($this->map[$class])) {

            $this->map[$class] = [];
        }

        $this->map[$class][$name] = $value;
    }

    /**
     * 获取类型对应的class
     *
     * @param string $name
     * @return string|null
     */
    public function getMap(string $name)
    {
        $class = get_called_class();

        if (
            !isset($this->map[$class]) ||
            !isset($this->map[$class][$name])
        ) {

            return null;
        }

        return $this->map[$class][$name];
    }

    /**
     * 设置类型对应关系
     *
     * @param string $name
     * @param string $value
     */
    public static function set(string $name, string $value)
    {
        static::getInstance()->setMap($name, $value);
    }

    /**
     * 获取类型
     *
     * @param string $name
     * @return mixed
     */
    public static function get(string $name)
    {
        return static::getInstance()->getMap($name);
    }
}