<?php


namespace GraphQLResolve\Tests;


use GraphQL\Type\Definition\ResolveInfo;
use GraphQLResolve\AbstractInterfaceType;
use GraphQLResolve\TypeRegistry;

/**
 * Class Node
 * @package GraphQLResolve\Tests
 */
class Node extends AbstractInterfaceType
{
    public $description = '测试接口';

    public function fields()
    {
        return  [
            new NodeIdField(),
        ];
    }

    public function getType($objectValue, $context, ResolveInfo $info)
    {
        list($type)   = explode(':', $objectValue['id'], 2);

        switch ($type) {
            case 'sku'  :
                return  TypeRegistry::get('Sku');
            case 'order'    :
                return  TypeRegistry::get('Order');
        }
    }

    /**
     * Node constructor.
     * @param array $config 配置数据
     */
    public function __construct(array $config = [])
    {
        $config['name']         = 'Node';
        $config['description']  = '测试接口';
        parent::__construct($config);
    }
}
