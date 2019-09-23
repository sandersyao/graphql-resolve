<?php


namespace GraphQLResolve\Tests;


use GraphQLResolve\AbstractObjectType;

class Mutation extends AbstractObjectType
{
    /**
     * @var string 描述
     */
    public $description = '根变更';

    /**
     * 字段定义
     *
     * @return array|mixed
     */
    public function fields()
    {
        return  [
            new CreateOrderQuery(),
        ];
    }
}
