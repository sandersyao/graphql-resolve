<?php


namespace GraphQLResolve\Tests;


use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use GraphQLResolve\AbstractResolveField;
use GraphQLResolve\TypeRegistry;

class NodeField extends AbstractResolveField
{
    const TEST_NODES    = [
        [
            'id'    => 'sku:1',
            'name'  => 'abc',
        ],
        [
            'id'    => 'order:3',
            'userId'=> '1',
            'sn'    => 'cde',
        ],
    ];

    public function __construct(array $config = [])
    {
        $config = array_merge($config, [
            'type'          => Type::nonNull(TypeRegistry::get('Node')),
            'description'   => '测试查询2',
            'args'          => [
                'id'    => [
                    'type'          => Type::id(),
                    'description'   => '查询ID',
                ],
            ],
        ]);
        parent::__construct($config);
    }

    public function invoke($parent, array $args, $context, ResolveInfo $resolveInfo)
    {
        return current(array_filter(self::TEST_NODES, function ($item) use ($args) {

            return  $args['id'] == $item['id'];
        }));
    }
}
