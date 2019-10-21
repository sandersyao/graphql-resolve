<?php


namespace GraphQLResolve\Tests\Laravel\Queries;


use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use GraphQLResolve\AbstractResolveField;
use GraphQLResolve\Tests\Laravel\Models\OrderGoods;
use GraphQLResolve\TypeRegistry;

class OrderGoodsQuery extends AbstractResolveField
{
    public function __construct(array $config = [])
    {
        $config = array_merge([
            'name'          => 'orderGoods',
            'type'          => Type::listOf(TypeRegistry::get('OrderGoods')),
            'description'   => '订单商品列表',
        ], $config);
        parent::__construct($config);
    }

    public function invoke($parent, array $args, $context, ResolveInfo $resolveInfo)
    {
        $id     = isset($args['order_id'])  ? $args['order_id'] : $parent['id'];
        $fields = array_keys($resolveInfo->getFieldSelection());
        return  OrderGoods::query()
            ->selectTransform([
                'sku'               => 'sku_id',
                'quantity'          => 'quantity',
                'tagPrice'          => 'tag_price',
                'tagAmount'         => 'tag_amount',
                'shouldPayAmount'   => 'should_pay_amount',
                'realPayAmount'     => 'real_pay_amount',
            ], $fields)
            ->where('order_id', $id)
            ->get();
    }
}
