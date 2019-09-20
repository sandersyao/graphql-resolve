<?php


namespace GraphQLResolve;


use GraphQL\Type\Definition\Type;

/**
 * Class TypeRegistry
 * @package GraphQLResolve
 *
 * 注册并管理GraphQL类型（包括输出和输入类型、标量、接口和联合类型）
 */
class TypeRegistry extends AbstractRegistry
{
    /**
     * 获取对象名
     *
     * @param mixed $type 类型对象
     * @return string 对象名
     */
    protected function getKey($type): string
    {
        if (!($type instanceof Type)) {

            throw new \UnexpectedValueException(
                'Unexpected argument $type, must be an instance of ' .
                Type::class . ' or its subclass.'
            );
        }

        return  $type->name;
    }
}
