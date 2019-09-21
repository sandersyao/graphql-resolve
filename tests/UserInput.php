<?php


namespace GraphQLResolve\Tests;


use GraphQL\Type\Definition\Type;
use GraphQLResolve\AbstractInputObjectType;

class UserInput extends AbstractInputObjectType
{
    public $description = '输入用户类型';

    /**
     * 字段定义
     *
     * @return array|mixed
     */
    public function fields()
    {
        return  [
            'id'    => [
                'type'          => Type::id(),
                'description'   => '测试输入对象',
            ],
        ];
    }
}
