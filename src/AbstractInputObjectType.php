<?php


namespace GraphQLResolve;


use GraphQL\Type\Definition\InputObjectType;

/**
 * Class AbstractInputObjectType
 * @package GraphQLResolve
 */
abstract class AbstractInputObjectType extends InputObjectType
{
    /**
     * 获取字段
     *
     * @return mixed 字段配置
     * @api
     */
    abstract public function fields();

    /**
     * ObjectConstruct constructor.
     * @param array $config 配置数据
     */
    public function __construct(array $config = [])
    {
        $config['fields']       = [$this, 'fields'];
        $callbackDescription    = [$this, 'description'];

        if (is_callable($callbackDescription)) {

            $config['descriptions'] = $callbackDescription();
        }

        parent::__construct($config);
    }
}
