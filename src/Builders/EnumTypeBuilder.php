<?php


namespace GraphQLResolve\Builders;

use GraphQL\Type\Definition\EnumType;

/**
 * 枚举构造器
 *
 * Class EnumTypeBuilder
 * @package GraphQLResolve\Builders
 */
class EnumTypeBuilder extends AbstractBuilder
{
    public function fetch(...$args)
    {
        return new EnumType($this->_options);
    }

    public function getItems(): array
    {
        return [
            'values' => 'required|type:array',
            'name' => 'type:string',
            'description' => 'type:string',
        ];
    }
}