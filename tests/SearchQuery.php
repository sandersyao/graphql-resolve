<?php


namespace GraphQLResolve\Tests;


use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use GraphQLResolve\AbstractResolveField;
use GraphQLResolve\TypeRegistry;

class SearchQuery extends AbstractResolveField
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
            'type'          => Type::nonNull(Type::listOf(TypeRegistry::get('SearchResult'))),
            'description'   => '联合类型测试',
        ]);
        parent::__construct($config);
    }

    public function invoke($parent, array $args, $context, ResolveInfo $resolveInfo)
    {
        return  self::TEST_NODES;
    }
}
