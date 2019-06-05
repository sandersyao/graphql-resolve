<?php


namespace GraphQLResolve\Tests\Sim;

use GraphQL\Type\Definition\Type;
use GraphQLResolve\AbstractObjectType;
use GraphQLResolve\Contracts\HasInterface;

/**
 * 模拟接口实现类型
 *
 * Class ObjectImplements
 * @package GraphQLResolve\Tests\Sim
 */
class ObjectImplements extends AbstractObjectType
    implements HasInterface
{
    /**
     * 字段
     *
     * @return array|mixed
     */
    public function fields()
    {
        return InterfaceType::mergeFields([
            [
                'name' => 'skuName',
                'description' => 'SKU名称',
                'type' => Type::string(),
            ],
            [
                'name' => 'quantity',
                'description' => '数量',
                'type' => Type::float(),
            ],
        ]);
    }

    /**
     * 接口类型对象列表
     *
     * @return array
     */
    public function implements(): array
    {
        return [
            InterfaceType::getObject(),
        ];
    }
}