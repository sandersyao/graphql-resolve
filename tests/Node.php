<?php


namespace GraphQLResolve\Tests;


use GraphQL\Type\Definition\InterfaceType;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use GraphQLResolve\TypeRegistry;

/**
 * Class Node
 * @package GraphQLResolve\Tests
 */
class Node extends InterfaceType
{
    /**
     * Node constructor.
     * @param array $config 配置数据
     */
    public function __construct(array $config = [])
    {
        $config['name']         = 'Node';
        $config['description']  = '测试接口';
        $config['fields']       = [
            'id'    => [
                'type'          => Type::nonNull(Type::id()),
                'description'   => '测试字段',
                'resolve'       => function ($parent, $args, $context, ResolveInfo $resolveInfo) {

                    return  base64_encode($parent['id']);
                }
            ],
        ];
        $config['resolveType']  = function ($value) {

            list($type)   = explode(':', $value['id'], 2);

            switch ($type) {
                case 'sku'  :
                    return  TypeRegistry::get('Sku');
                case 'order'    :
                    return  TypeRegistry::get('Order');
            }
        };
        parent::__construct($config);
    }
}
