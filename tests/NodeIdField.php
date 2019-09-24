<?php


namespace GraphQLResolve\Tests;


use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use GraphQLResolve\AbstractResolveField;

class NodeIdField extends AbstractResolveField
{
    /**
     * NodeIdField constructor.
     *
     * @param array $config
     */
    public function __construct(array $config = [])
    {
        $config = array_merge($config, [
            'name'          => 'id',
            'type'          => Type::nonNull(Type::id()),
            'description'   => '测试接口字段',
        ]);
        parent::__construct($config);
    }

    /**
     * 执行
     *
     * @param mixed $parent
     * @param array $args
     * @param mixed $context
     * @param ResolveInfo $resolveInfo
     * @return mixed|string
     */
    public function invoke($parent, array $args, $context, ResolveInfo $resolveInfo)
    {
        return  base64_encode($parent['id']);
    }
}
