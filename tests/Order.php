<?php


namespace GraphQLResolve\Tests;


use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use GraphQLResolve\AbstractObjectType;
use GraphQLResolve\SimpleField;
use GraphQLResolve\TypeRegistry;

class Order extends AbstractObjectType
{

    /**
     * @var string 描述
     */
    public $description = '订单类型';

    /**
     * Order constructor.
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
     * @return array|mixed
     */
    public function fields()
    {
        return  [
            'id'    => [
                'type'          => Type::nonNull(Type::id()),
                'description'   => '订单ID',
            ],
            new SimpleField([
                'name'          => 'sn',
                'type'          => Type::nonNull(Type::string()),
                'description'   => '订单编号',
            ]),
            'userId'    => [
                'type'          => Type::nonNull(Type::string()),
                'description'   => '用户ID',
            ],
        ];
    }
}
