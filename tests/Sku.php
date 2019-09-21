<?php


namespace GraphQLResolve\Tests;


use GraphQL\Type\Definition\Type;
use GraphQLResolve\AbstractObjectType;
use GraphQLResolve\TypeRegistry;

/**
 * Class Sku
 * @package GraphQLResolve\Tests
 */
class Sku extends AbstractObjectType
{
    /**
     * Sku constructor.
     * @param array $config
     */
    public function __construct(array $config = [])
    {
        $config['interfaces']   = [
            TypeRegistry::get('Node'),
        ];
        parent::__construct($config);
    }

    /**
     * 字段定义
     *
     * @return array|callable
     */
    public function fields()
    {
        return  [
            TypeRegistry::get('Node')->getField('id'),
            'name'  => [
                'type'          => Type::string(),
                'description'   => 'SKU名',
            ],
        ];
    }
}
