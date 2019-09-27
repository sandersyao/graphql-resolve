<?php


namespace GraphQLResolve;


use GraphQL\Type\Definition\InterfaceType;
use GraphQL\Type\Definition\ResolveInfo;

/**
 * Class AbstractInterfaceType
 *
 * @package GraphQLResolve
 */
abstract class AbstractInterfaceType extends InterfaceType
{
    /**
     * 获取字段定义
     *
     * @return mixed 字段配置
     */
    abstract public function fields();

    /**
     * 获取类型
     *
     * @param mixed $objectValue 当前数据
     * @param mixed $context 上下文数据
     * @param ResolveInfo $info 解析信息
     * @return mixed 类型对象
     */
    abstract public function getType($objectValue, $context, ResolveInfo $info);

    /**
     * AbstractInterfaceType constructor.
     *
     * @param array $config 配置数据
     */
    public function __construct(array $config = [])
    {
        $config['fields']       = $this->fields();
        $config['resolveType']  = [$this, 'getType'];

        if (!empty($this->description)) {

            $config['descriptions'] = $this->description;
        }

        parent::__construct($config);
    }
}
