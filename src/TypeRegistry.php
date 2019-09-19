<?php


namespace GraphQLResolve;


use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;
use GraphQLResolve\Traits\Singleton;

/**
 * Class TypeRegistry
 * @package GraphQLResolve
 *
 * 注册并管理GraphQL类型（包括输出和输入类型、标量、接口和联合类型）
 */
class TypeRegistry
{
    use Singleton;

    /**
     * 类型实例图
     *
     * @var array
     */
    private $mapType    = [];

    /**
     * 新增类型
     *
     * @param $type
     * @return TypeRegistry
     */
    public function add($type)
    {
        if (!($type instanceof Type)) {

            throw new \UnexpectedValueException(
                'unexpected argument $type, must be an instance of ' .
                Type::class . ' or its subclass.'
            );
        }

        $name   = $type->name;

        if (isset($this->mapType[$name]) && $this->mapType[$name] instanceof ObjectType) {

            throw new \UnexpectedValueException(
                'ObjectType name ' . $name . ' already exists by class ' . get_class($this->mapType[$name]) .
                ' can not registry class ' . get_class($type) . ' as same name.'
            );
        }

        $this->mapType[$name]   = $type;

        return  $this;
    }

    /**
     * 析出实例
     *
     * @param $name
     * @return mixed
     */
    public function resolve($name)
    {
        if (!isset($this->mapType[$name])) {

            throw new \UnexpectedValueException('Type Name ' . $name . ' not registry');
        }

        return  $this->mapType[$name];
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
