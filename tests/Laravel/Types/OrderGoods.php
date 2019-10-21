<?php


namespace GraphQLResolve\Tests\Laravel\Types;


use GraphQL\Type\Definition\Type;
use GraphQLResolve\AbstractObjectType;
use GraphQLResolve\SimpleField;
use GraphQLResolve\TypeRegistry;

class OrderGoods extends AbstractObjectType
{
    public function fields()
    {
        return  [
            new SimpleField([
                'name'          => 'sku',
                'type'          => TypeRegistry::get('Sku'),
                'description'   => '订单商品',
            ]),
            new SimpleField([
                'name'          => 'quantity',
                'type'          => Type::int(),
                'description'   => '商品数量',
            ]),
            new SimpleField([
                'name'          => 'tagPrice',
                'type'          => Type::float(),
                'description'   => '吊牌价',
            ]),
            new SimpleField([
                'name'          => 'tagAmount',
                'type'          => Type::float(),
                'description'   => '吊牌金额',
            ]),
            new SimpleField([
                'name'          => 'shouldPayAmount',
                'type'          => Type::float(),
                'description'   => '应付金额',
            ]),
            new SimpleField([
                'name'          => 'realPayAmount',
                'type'          => Type::float(),
                'description'   => '实付金额',
            ]),
        ];
    }
}
