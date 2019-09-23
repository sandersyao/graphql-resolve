<?php


namespace GraphQLResolve\Tests;


use GraphQLResolve\AbstractObjectType;

class Query extends AbstractObjectType
{
    /**
     * @var string 描述
     */
    public $description = '根查询';

    /**
     * @return array|mixed 字段定义
     */
    public function fields()
    {
        return  array_filter([
            new OrdersField(),
            new NodeField(),
            new SearchQuery(),
        ]);
    }
}
