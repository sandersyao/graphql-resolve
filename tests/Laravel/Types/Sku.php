<?php


namespace GraphQLResolve\Tests\Laravel\Types;


use GraphQL\Type\Definition\Type;
use GraphQLResolve\AbstractObjectType;
use GraphQLResolve\SimpleField;

class Sku extends AbstractObjectType
{
    public function fields()
    {
        return  [
            new SimpleField([
                'name'          => 'id',
                'type'          =>  Type::id(),
                'description'   => 'SKU编号',
            ]),
            new SimpleField([
                'name'          => 'sn',
                'type'          =>  Type::string(),
                'description'   => 'SKU代码',
            ]),
            new SimpleField([
                'name'          => 'name',
                'type'          =>  Type::string(),
                'description'   => 'SKU名称',
            ]),
            new SimpleField([
                'name'          => 'inventoryCount',
                'type'          =>  Type::int(),
                'description'   => '库存',
            ]),
            new SimpleField([
                'name'          => 'inventoryCountLock',
                'type'          =>  Type::int(),
                'description'   => '占用库存',
            ]),
            new SimpleField([
                'name'          => 'isOnline',
                'type'          =>  Type::boolean(),
                'description'   => '是否上架',
            ]),
            new SimpleField([
                'name'          => 'sort',
                'type'          =>  Type::int(),
                'description'   => '显示顺序',
            ]),
            new SimpleField([
                'name'          => 'description',
                'type'          =>  Type::string(),
                'description'   => '描述',
            ]),
            new SimpleField([
                'name'          => 'tagPrice',
                'type'          =>  Type::float(),
                'description'   => '吊牌价',
            ]),
        ];
    }
}
