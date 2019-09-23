<?php


namespace GraphQLResolve;


use GraphQL\Type\Definition\ObjectType;

/**
 * Class AbstractObjectType
 * @package GraphQLResolve
 */
abstract class AbstractObjectType extends ObjectType
{
    /**
     * 获取字段
     *
     * @return array|callable 字段配置
     * @api
     */
    abstract public function fields();

    /**
     * AbstractObjectType constructor.
     * @param array $config 配置数据
     * @api
     */
    public function __construct(array $config = [])
    {
        $config['fields']   = $this->fields();

        if (!empty($this->description)) {

            $config['descriptions'] = $this->description;
        }

        parent::__construct($config);
    }
}
