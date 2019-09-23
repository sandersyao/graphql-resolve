<?php


namespace GraphQLResolve\Tests;


use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use GraphQLResolve\AbstractResolveField;
use GraphQLResolve\TypeRegistry;

class OrdersField extends AbstractResolveField
{
    /**
     * 全部标识
     */
    const POS_ALL   = 'all';

    /**
     * 测试数据
     */
    const TEST_DATA = [
        [
            'id'    => 1,
            'userId'=> 1,
            'sn'    => 'abc',
        ],
        [
            'id'    => 2,
            'userId'=> 2,
            'sn'    => 'bcd',
        ],
    ];

    /**
     * OrdersField constructor.
     * @param array $config
     */
    public function __construct(array $config = [])
    {
        $config = array_merge($config, [
            'name'          => 'orders',
            'type'          => Type::nonNull(Type::listOf(TypeRegistry::get('Order'))),
            'description'   => '测试描述',
            'args'          => [
                'pos'   => [
                    'type'          => Type::int(),
                    'description'   => '简单参数测试',
                    'defaultValue'  => self::POS_ALL,
                ],
                'user'  => [
                    'type'          => TypeRegistry::get('UserInput'),
                    'description'   => '输入类型参数测试',
                ],
            ],
        ]);
        parent::__construct($config);
    }

    /**
     * @param mixed $parent 上级节点数据
     * @param array $args 参数
     * @param mixed $context 上下文数据
     * @param ResolveInfo $resolveInfo 解析数据
     * @return array|mixed 执行结果
     */
    public function invoke($parent, array $args, $context, ResolveInfo $resolveInfo)
    {
        if (isset($args['user'])) {

            return  array_filter(self::TEST_DATA, function ($item) use ($args) {
                return  $item['userId'] == $args['user']['id'];
            });
        }

        if (self::POS_ALL === $args['pos']) {

            return  self::TEST_DATA;
        }

        return  [self::TEST_DATA[$args['pos']]];
    }
}
