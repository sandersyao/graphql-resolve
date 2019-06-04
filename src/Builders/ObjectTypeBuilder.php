<?php
namespace GraphQLResolve\Builders;

use GraphQL\Type\Definition\ObjectType;

/**
 * 对象类型构建器
 */
class ObjectTypeBuilder extends AbstractBuilder
{
    /**
     * 获取配置项列表
     *
     * @return  array
     */
    public function getItems(): array
    {
        return  [
            'fields'        => 'required|type:array,callable',
            'name'          => 'type:string',
            'description'   => 'type:string',
            'resolve'       => 'type:callable',
            'resolveField'  => 'type:callable',
            'interfaces'    => 'type:array,callable',
            'isTypeOf'      => 'type:callable'
        ];
    }

    /**
     * 获取构建结果
     *
     * @param   mixed   $args[]
     * @return  mixed
     */
    public function fetch(...$args)
    {
        return new ObjectType($this->_options);
    }
}
